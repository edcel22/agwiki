<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\UserLogin;
use App\User;
use Carbon\Carbon;
use App\Follow;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Socialite;
use App\Traits\MauticApiTrait;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use MauticApiTrait;
	//use Auth;
	
	
	
	/**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    // public function handleProviderCallback($provider)
    // {
				// 		$userSocial = Socialite::driver($provider)->user();		
				// 		$users = User::where(['email' => $userSocial->getEmail()])->first();
					
					
				// 			if($users){
				// 				Auth::login($users);
				// 				return redirect('/');
				// 			}else{
				// 				$email_hash = explode('@',$userSocial->getEmail());
				// 				$code = str_random(8);
				// 				$user = User::create([
				// 					'name'          => $userSocial->getName(),
				// 					'email'         => ($userSocial->getEmail()!='')?$userSocial->getEmail():$code."@somedomain.com",
				// 					'username'         => $email_hash[0].'-'.rand(1, 999),//$userSocial->getEmail(),
				// 					'avatar'         => $userSocial->getAvatar(),
				// 					'password' =>	Hash::make($userSocial->getId().$userSocial->getName()),
				// 					'provider_id'   => $userSocial->getId(),
				// 					'provider'      => $provider,
				// 					'vercode' => $code ,
				// 					'status'		=> 1
				// 				]);
				// 				$users = User::where(['email' => $userSocial->getEmail()])->first();
				// 				Auth::login($users);
				// 				$email = $userSocial->getEmail();
				// 				$segment = 8;//master
				// 				$url = 'https://mautic.agwiki.com/api/contacts?search='.$email;
				// 				$options = array(
				// 					'http' => array(
				// 						'header'  => array("Content-type: application/x-www-form-urlencoded",
				// 				"Authorization: Basic " . base64_encode("sitecontrol:flattir3")),
				// 						'content' => '',
				// 						'method' => 'GET',
				// 						"ssl"=>array(
				// 								"verify_peer"=>false,
				// 								"verify_peer_name"=>false,
				// 							)

				// 					),

				// 				);
				// 				$context  = stream_context_create($options);
				// 				$result = file_get_contents($url, false, $context);
				// 				$contact = json_decode($result, true);
				// 				if(isset(array_keys($contact['contacts'])[0]))
				// 				{
				// 					$contact_id = array_keys($contact['contacts'])[0];
				// 				}
				// 				else{

				// 					//die($email);

				// 					$url = 'https://mautic.agwiki.com/api/contacts/new';




				// 					$options = array(
				// 						'http' => array(
				// 							'header'  => array("Content-type: application/x-www-form-urlencoded",
				// 					"Authorization: Basic " . base64_encode("sitecontrol:flattir3")),
				// 							'content' =>http_build_query(array('email'=>$email,'overwriteWithBlank' => true)),
				// 							'Cache-Control: no-cache' ,
				// 							'method' => 'POST'
				// 						)
				// 					);
				// 					$context  = stream_context_create($options);

				// 					$result = file_get_contents($url, false, $context);
				// 					$contact = json_decode($result, true);

				// 					//die(print_r($contact));

				// 					if(isset($contact['contact']['id']))
				// 					{
				// 						$contact_id = $contact['contact']['id'];
				// 					}

				// 				}

				// 				if(isset($contact_id))
				// 				{

				// 					//print_r($contact_id);

				// 					$url = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/add';
				// 					//$data = array('key1' => 'value1', 'key2' => 'value2');

				// 					// use key 'http' even if you send the request to https://...
				// 					$options = array(
				// 						'http' => array(
				// 							'header'  => array("Content-type: application/x-www-form-urlencoded",
				// 					"Authorization: Basic " . base64_encode("sitecontrol:flattir3")),
				// 							'content' => '',
				// 							'Cache-Control: no-cache' ,
				// 							'method' => 'POST'
				// 						)
				// 					);
				// 					$context  = stream_context_create($options);
				// 					$result = file_get_contents($url, false, $context);
				// 					$dnc_result = json_decode($result, true);

				// 					//print_r($contact);

				// 					$segment = 3;//non registred list
				// 					$url = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/add';
				// 					//$data = array('key1' => 'value1', 'key2' => 'value2');

				// 					// use key 'http' even if you send the request to https://...
				// 					$options = array(
				// 						'http' => array(
				// 							'header'  => array("Content-type: application/x-www-form-urlencoded",
				// 					"Authorization: Basic " . base64_encode("sitecontrol:flattir3")),
				// 							'content' => '',
				// 							'Cache-Control: no-cache' ,
				// 							'method' => 'POST'
				// 						)
				// 					);
				// 					$context  = stream_context_create($options);
				// 					$result = file_get_contents($url, false, $context);
				// 					$dnc_result = json_decode($result, true);



				// 					$segment = 6;//no groups
				// 					$url = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/add';
				// 					//$data = array('key1' => 'value1', 'key2' => 'value2');

				// 					// use key 'http' even if you send the request to https://...
				// 					$options = array(
				// 						'http' => array(
				// 							'header'  => array("Content-type: application/x-www-form-urlencoded",
				// 					"Authorization: Basic " . base64_encode("sitecontrol:flattir3")),
				// 							'content' => '',
				// 							'Cache-Control: no-cache' ,
				// 							'method' => 'POST'
				// 						)
				// 					);
				// 					$context  = stream_context_create($options);
				// 					$result = file_get_contents($url, false, $context);
				// 					$dnc_result = json_decode($result, true);



				// 					$segment = 7;//no topics
				// 					$url = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/add';
				// 					//$data = array('key1' => 'value1', 'key2' => 'value2');

				// 					// use key 'http' even if you send the request to https://...
				// 					$options = array(
				// 						'http' => array(
				// 							'header'  => array("Content-type: application/x-www-form-urlencoded",
				// 					"Authorization: Basic " . base64_encode("sitecontrol:flattir3")),
				// 							'content' => '',
				// 							'Cache-Control: no-cache' ,
				// 							'method' => 'POST'
				// 						)
				// 					);
				// 					$context  = stream_context_create($options);
				// 					$result = file_get_contents($url, false, $context);
				// 					$dnc_result = json_decode($result, true);


				// 				}

				// 				if(session('link')!==null)
				// 					return redirect(session('link'))->with('message', 'Successfully created a new account. Please fill out all details');
				// 				else
				// 					return redirect('feed')->with('message', 'Successfully created a new account. Please fill out all details');
				// 			}
    // }
					
				public function handleProviderCallback($provider)
{
    try {
        $userSocial = Socialite::driver($provider)->user();        
        $users = User::where(['email' => $userSocial->getEmail()])->first();
        
        if($users){
            Auth::login($users);
            return redirect('/');
        } else {
            $email_hash = explode('@',$userSocial->getEmail());
            $code = str_random(8);
            
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => ($userSocial->getEmail()!='')?$userSocial->getEmail():$code."@somedomain.com",
                'username'         => $email_hash[0].'-'.rand(1, 999),
                'avatar'         => $userSocial->getAvatar(),
                'password' =>    Hash::make($userSocial->getId().$userSocial->getName()),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
                'vercode' => $code ,
                'status'        => 1
            ]);
            
            $users = User::where(['email' => $userSocial->getEmail()])->first();
            Auth::login($users);

            try {
                // Get contact
                $email = $userSocial->getEmail();
                $url = 'https://mautic.agwiki.com/api/contacts?search=' . urlencode($email);
                $response = $this->makeApiRequest($url);
                $contact = json_decode($response, true);

                if(isset($contact['contacts']) && !empty($contact['contacts'])) {
                    $contact_id = array_keys($contact['contacts'])[0];
                } else {
                    // Create new contact
                    $createUrl = 'https://mautic.agwiki.com/api/contacts/new';
                    $data = [
                        'email' => $email,
                        'overwriteWithBlank' => true
                    ];
                    $createResponse = $this->makeApiRequest($createUrl, 'POST', $data);
                    $createContact = json_decode($createResponse, true);

                    if(isset($createContact['contact']['id'])) {
                        $contact_id = $createContact['contact']['id'];
                    }
                }

                if(isset($contact_id)) {
                    // Add to segments
                    $segments = [
                        8,  // master
                        3,  // non registered list
                        6,  // no groups
                        7   // no topics
                    ];

                    foreach($segments as $segment) {
                        $segmentUrl = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/add';
                        $this->makeApiRequest($segmentUrl, 'POST');
                    }
                }
            } catch(\Exception $e) {
                \Log::error('Mautic API Error: ' . $e->getMessage());
                // Continue execution even if Mautic fails
            }

            if(session('link')!==null)
                return redirect(session('link'))->with('message', 'Successfully created a new account. Please fill out all details');
            else
                return redirect('feed')->with('message', 'Successfully created a new account. Please fill out all details');
        }
    } catch(\Exception $e) {
        \Log::error('Social login error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred during login');
    }
}

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = '/feed';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }
	
	
	public function login(Request $request)
	{
		$this->validate($request, [
			'username'    => 'required',
			'password' => 'required',
		]);
	
		$login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL ) 
			? 'email' 
			: 'email';//username
	
		$request->merge([
			$login_type => $request->input('username')
		]);
	
		if (Auth::attempt($request->only($login_type, 'password'),1)) {//$login_type
			//return redirect()->intended($this->redirectPath());
			return redirect('/feed');
		}
	
		return redirect()->back()
			->withInput()
			->withErrors([
				'login' => 'These credentials do not match our records.',
			]);
	} 
	
	public function showLoginForm()
	{
		session(['link' => url()->previous()]);
		//die(session('link'));
		return view('auth.login');
	}
	
	protected function redirectTo()
	{
		//if (\Session::has('userRequest')) {
		//	return route('request');
		//}
		//return redirect()->intended(session('link'));
		//return $this->redirectTo; // or any route you want.
		if(session('link')!==null)
			return session('link');
		else
			return 'feed';
	}


	
	

    public function authenticated(Request $request, $user)
    {

        if($user->status == 0){
            $this->guard()->logout();
            session()->flash('alert','Sorry Your Account is Blocked Now!');
            return redirect('/login');
        }
        
        $follow = Follow::where(['by' => $user->id, 'followed' => 9])->first();
        
        if(! $follow) {
            $follow = Follow::create([
                'by' => $user->id,
                'followed' => 9
            ]);
        }
    }
}
