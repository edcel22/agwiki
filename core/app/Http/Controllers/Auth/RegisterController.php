<?php
namespace App\Http\Controllers\Auth;

use App\General;
use App\Trx;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Follow;
use Illuminate\Http\Request;
use App\Interest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Traits\MauticApiTrait;

class RegisterController extends Controller
{
    use RegistersUsers;
    use MauticApiTrait;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function registerViaReferral($username)
    {
        $interest = Interest::all()->sortBy('name');
        $user = User::where('username', $username)->first();
        if (!$user) return redirect()->back();
        return view('auth.register', compact('user','interest'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request)));
        return redirect()->back()->with('message', 'Successfully created a new account.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ], [
            'tap.required' => 'You must agree with our Terms And Policy.'
        ]);
    }

    protected function create(Request $request)
    {
        try {
            $gnl = General::first();
            
            if(User::where('email', $request->email)->first()) {
                return redirect('/login')->with('message', 'User is already registered, please login');
            }

            // Handle Mautic Integration
            try {
                $email = $request->email;
                
                // Get or create contact
                $url = 'https://mautic.agwiki.com/api/contacts?search=' . urlencode($email);
                $response = $this->makeApiRequest($url);
                $contact = json_decode($response, true);
                
                if(isset($contact['contacts']) && !empty($contact['contacts'])) {
                    $contact_id = array_keys($contact['contacts'])[0];
                } else {
                    // Create new contact
                    $createUrl = 'https://mautic.agwiki.com/api/contacts/new';
                    $createResponse = $this->makeApiRequest($createUrl, 'POST', [
                        'email' => $email,
                        'overwriteWithBlank' => true
                    ]);
                    $createContact = json_decode($createResponse, true);
                    
                    if(isset($createContact['contact']['id'])) {
                        $contact_id = $createContact['contact']['id'];
                    }
                }

                if(isset($contact_id)) {
                    // Add to segments
                    $segments = [
                        8,  // master
                        3,  // non registered
                        6,  // no groups
                        7   // no topics
                    ];

                    foreach($segments as $segment) {
                        $segmentUrl = "https://mautic.agwiki.com/api/segments/{$segment}/contact/{$contact_id}/add";
                        $this->makeApiRequest($segmentUrl, 'POST');
                    }
                }
            } catch(\Exception $e) {
                \Log::error('Mautic API Error: ' . $e->getMessage());
                // Continue execution even if Mautic fails
            }

            // Create user
            $email_hash = explode('@', $request->email);
            $code = str_random(8);
            $placeHoldername = $email_hash[0].'-'.rand(1, 999);
            
            if($request->field_name == '') {
                $user = User::create([
                    'name' => $placeHoldername,
                    'email' => $request->email,
                    'password' => isset($request->password) ? Hash::make($request->password) : Hash::make("AD1234"),
                    'username' => $placeHoldername,
                    'emailv' => 1,
                    'vercode' => $code,
                    'smsv' => $gnl->smsver
                ]);
            } else {
                return redirect('/login')->with('message', 'Invalid Request');
            }

            // Send admin notification
            $data = array(
                'to' => "rpkrotz@agwiki.com",
                'newuser' => $request->email
            );
            
            Mail::send('emails.notifyadmin', $data, function($message) use ($data) {
                $message->from('no-reply@agwiki.com', "Agwiki")
                        ->subject("User Signup " . $data['newuser'])
                        ->to([$data['to']]);
            });

            Auth::login($user);

            return session('link') !== null 
                ? redirect(session('link'))->with('message', 'Successfully created a new account. Please fill out all details')
                : redirect('feed')->with('message', 'Successfully created a new account. Please fill out all details');

        } catch(\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during registration');
        }
    }

    protected function registered(Request $request, $user)
    {
        $follow = Follow::where(['by' => $user->id, 'followed' => 9])->first();
        
        if(!$follow) {
            $follow = Follow::create([
                'by' => $user->id,
                'followed' => 9
            ]);
        }

        $ip = $request->ip();
        $r = file_get_contents('https://ip-api.com/json/' . $ip);
        $info = json_decode($r);

        if ($info->status && $info->status == 'success') {
            $user->country = $info->countryCode;
            $user->city = $info->city;
            $user->state = $info->region;
            $user->zip = $info->zip;
            $user->save();
        }
    }
}