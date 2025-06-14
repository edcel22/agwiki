<?php

namespace App\Http\Controllers;
use App\Interest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use App\User;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $interests = Auth::user()->interests()->orderBy('name')->get();
            // die(print_r($interests));
		// dd(json_encode($interests));
        // return response()->json($interests);
        } else {
            return redirect()->route('login');
            $user = User::with('Interests')->where('username', 'ktschomakoff-860')->first();
            // $user = new User();
            $interests = $user->interests;
            // dd($interests[0]['id']);
            // dd($interests);
        }
			
		$passinterest = array();
		
		foreach($interests as $loopinterest)
		{ 
            
                $passinterest[] = $loopinterest->id;
            
		}
        
		
		$alltopics = Interest::whereNotIn('id', $passinterest)->orderBy('name')->get();
		$page_title = 'Topics';
		
		//die($interests);
		return view('topics', compact('alltopics', 'interests','page_title', 'user'));
    }
	// ORIGINAL PROCESS TOPIC
	// public function processTopic(Request $request)
    // {
    //     $user = User::where('username', 'ktschomakoff-860')->first();
    //     $theUser = ''; 

    //     if (Auth::check()) {
    //         $theUser = Auth::user();
    //     } else {
    //         $theUser = $user;  
    //     }
		
	// 	if(\DB::insert('insert into interest_user (user_id, interest_id) values (?, ?)', [$theUser->id, $request->topic_id]))
	// 	{
			
	// 			//mautic///////////////////////

	// 			$email = Auth::user()->email;

	// 			$segment = 7;

	// 			$url = 'https://mautic.agwiki.com/api/contacts?search='.$email;
	// 			//$data = array('key1' => 'value1', 'key2' => 'value2');

	// 			// use key 'http' even if you send the request to https://...
	// 			$options = array(
	// 				'http' => array(
	// 					'header'  => array("Content-type: application/x-www-form-urlencoded",
	// 			"Authorization: Basic " . base64_encode("sitecontrol:flattir3")),
	// 					'content' => '',
	// 					'method' => 'GET',
	// 					"ssl"=>array(
	// 							"verify_peer"=>false,
	// 							"verify_peer_name"=>false,
	// 						)

	// 				),

	// 			);
	// 			$context  = stream_context_create($options);
	// 			$result = file_get_contents($url, false, $context);
	// 			$contact = json_decode($result, true);
	// 			if(isset(array_keys($contact['contacts'])[0]))
	// 			{
	// 				$contact_id = array_keys($contact['contacts'])[0];


	// 				$url = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/remove';
	// 				//$data = array('key1' => 'value1', 'key2' => 'value2');

	// 				// use key 'http' even if you send the request to https://...
	// 				$options = array(
	// 					'http' => array(
	// 						'header'  => array("Content-type: application/x-www-form-urlencoded",
	// 				"Authorization: Basic " . base64_encode("sitecontrol:flattir3")),
	// 						'content' => '',
	// 						'Cache-Control: no-cache' ,
	// 						'method' => 'POST'
	// 					)
	// 				);
	// 				$context  = stream_context_create($options);
	// 				$result = file_get_contents($url, false, $context);
	// 				$dnc_result = json_decode($result, true);

	// 			}

	// 			///////////////////////////////
		
		  
	// 	   return response()->json([
    //         'success' => 1
    //     	]);
	// 	}
	// 	else
	// 	{
	// 		return response()->json([
    //         'success' => 0
    //     	]);	
	// 	}
	// }

    //NEW PROCESS TOPIC
    public function processTopic(Request $request)
{
   try {
       // Get user
       $user = User::where('username', 'ktschomakoff-860')->first();
       $theUser = Auth::check() ? Auth::user() : $user;

       // Insert interest
       if (\DB::insert('insert into interest_user (user_id, interest_id) values (?, ?)', 
           [$theUser->id, $request->topic_id])) {

           // Handle Mautic API integration
           try {
               $email = Auth::user()->email;
               $segment = 7;
               
               // First API call - get contact
               $url = 'https://mautic.agwiki.com/api/contacts?search=' . urlencode($email);
               
               $ch = curl_init($url);
               curl_setopt_array($ch, [
                   CURLOPT_URL => $url,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_SSL_VERIFYPEER => false,
                   CURLOPT_HTTPHEADER => [
                       "Content-type: application/json",
                       "Authorization: Basic " . base64_encode("sitecontrol:flattir3"),
                       "User-Agent: Mozilla/5.0",
                       "Accept: application/json"
                   ]
               ]);

               $response = curl_exec($ch);
               
               if (curl_errno($ch)) {
                   \Log::error("Mautic API contact fetch error: " . curl_error($ch));
               }
               
               curl_close($ch);
               $contact = json_decode($response, true);

               // If contact exists, remove from segment
               if (isset($contact['contacts']) && !empty($contact['contacts'])) {
                   $contact_id = array_keys($contact['contacts'])[0];
                   $removeUrl = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/remove';
                   
                   // Second API call - remove from segment
                   $ch = curl_init();
                   curl_setopt_array($ch, [
                       CURLOPT_URL => $removeUrl,
                       CURLOPT_RETURNTRANSFER => true,
                       CURLOPT_SSL_VERIFYPEER => false,
                       CURLOPT_CUSTOMREQUEST => 'POST',
                       CURLOPT_HTTPHEADER => [
                           "Content-type: application/json",
                           "Authorization: Basic " . base64_encode("sitecontrol:flattir3"),
                           "User-Agent: Mozilla/5.0",
                           "Accept: application/json",
                           "Cache-Control: no-cache"
                       ]
                   ]);

                   $result = curl_exec($ch);
                   
                   if (curl_errno($ch)) {
                       \Log::error("Mautic API segment remove error: " . curl_error($ch));
                   }
                   
                   curl_close($ch);
               }
           } catch (\Exception $e) {
               \Log::error("Mautic API error in processTopic: " . $e->getMessage());
               // Continue execution even if Mautic fails
           }

           return response()->json([
               'success' => 1
           ]);
       }

       return response()->json([
           'success' => 0
       ]);

   } catch (\Exception $e) {
       \Log::error("Process topic error: " . $e->getMessage());
       return response()->json([
           'success' => 0,
           'error' => 'An error occurred while processing the topic'
       ]);
   }
}

	
	public function processTopicRem(Request $request)

    {

        $user = User::where('username', 'ktschomakoff-860')->first();
        $theUser = ''; 

        if (Auth::check()) {
            $theUser = Auth::user();
        } else {
            $theUser = $user;  
        }
		
		if(\DB::delete('delete from interest_user where user_id =? and interest_id=?', [$theUser->id, $request->topic_id]))
		{
		  
		   return response()->json([
            'success' => 1
        	]);
		}
		else
		{
			return response()->json([
            'success' => 0
        	]);	
		}
	}
	
	

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
