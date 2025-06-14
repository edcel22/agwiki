<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupMember;
use App\Post;
use App\User;
use App\Notify;
use App\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use DB;

class GroupController extends Controller
{

    public function __construct()

    {

        // $this->middleware(['auth', 'ckstatus'])->except(['groups']);

         // Navigate to login if user goes to /groups/*
         $this->middleware(function ($request, $next) {
            if ($request->is('groups*') && !Auth::check()) {
                return redirect()->route('login');
            }
            return $next($request);
        });

    }
	
	
	public function processTopicRem(Request $request)

    {
		
		$user = Auth::user();

        $member = GroupMember::where('group_id', $request->group_id)->where('role', '!=', 4)->where('user_id', $user->id)->first();
		
		if($member)
		{
			if(\DB::delete('delete from group_interest where group_id =? and interest_id=?', [$request->group_id, $request->topic_id]))
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
	}
	

    public function groups($slug = null)

    {
        if(Auth::check()){
            $user = Auth::user();
        } else {
            $user = User::where('username', 'ktschomakoff-860')->first();
        }
  
        if ($slug) {

            $group = Group::where('slug', $slug)->first();

            if ($group) {

                $member = GroupMember::where('group_id', $group->id)->where('user_id', $user->id)->first();

                if ($member && $member->status == 2) return redirect()->back();
			
				$_SESSION['passGroupID'] = $group->id;
				$groups = GroupMember::where('user_id', $user->id)->orderBy('id', 'DESC')->get();
                $page_title = $group->name;
                //$shares = Post::
				/*with(array('shares'=> function($query)
				{
					 $query->where('shares.group_id', $_SESSION['passGroupID']);
					 $query->with('user');
					 
				}))*/
				
				DB::enableQueryLog();
				$shares = Post::select('shares.*','shares.user_id as shareuser', 'posts.*')
				->leftjoin('shares',  function($join)
				{
					$join->on('shares.post_id', '=', 'posts.id');
    			//	$join->on('shares.user_id','=','posts.user_id');
					//$join->on('shares.group_id','=','posts.group_id');
					$join->on('shares.group_id','=',DB::raw($_SESSION['passGroupID']));
					$join->on('shares.user_id','!=',DB::raw("1"));
					//$join->where('shares.group_id','=', $_SESSION['passGroupID']);
					//$join->on('shares.user_id','!=',1);
				})
				->where('posts.group_id', $group->id)
				->orWhereRaw('posts.id in (select shares.post_id from shares where shares.group_id ='.$group->id.' and shares.user_id != 1)')
				->orderBy('shares.id', 'DESC')->paginate(5);
				//->where('posts.group_id', $group->id)->orderBy('shares.id', 'DESC')->paginate(5);
				
				//die($shares->toSql());
				
				//orWhereRaw('posts.id in (select shares.post_id from shares where shares.group_id ='.$group->id.' and shares.user_id != 1)')->
				
				// Your query here
				$queries = DB::getQueryLog();
				//print_r($queries);
				$interest = Interest::all();
                return view('group.single', compact('page_title', 'group', 'shares','groups','interest', 'user'));

            }

            return redirect()->route('front')->withErrors('Not Found');

        }

        $page_title = 'Groups';

		$allGroups = Group::orderBy('name', 'asc')->get();

        if(Auth::check()){
            $groups = GroupMember::where('user_id', $user->id)->where('status', '!=', 2)->paginate();
        }
        return view('group.all', compact('page_title', 'groups','allGroups', 'user'));

    
    }

    public function groupMembers($slug, $status)

    {

        $group = Group::where('slug', $slug)->first();

        if (! $group) return redirect()->route('front')->withErrors('Not Found');

        if ($status == 'active') {

            $page_title = 'Members Of ' . $group->name;

            $adminAndModerators = GroupMember::where('group_id', $group->id)->where('role', '!=', 4)->where('status', 1)->get();
            $members = GroupMember::where('group_id', $group->id)->where('role', 4)->where('status', 1)->paginate();

            return view('group.members', compact('page_title', 'group', 'adminAndModerators', 'members', 'status'));

        } elseif ($status == 'pending') {

            if ($group->isCreator() || $group->isAdmin() || $group->isModerator()) {
                $members = GroupMember::where('group_id', $group->id)->where('status', 4)->paginate();
                $page_title = 'Pending Join Request';

                return view('group.members', compact('page_title', 'group', 'members', 'status'));
            }

            return redirect()->back();

        }

        return redirect()->back();

    }

    public function addGroup()

    {

        $page_title = 'New Group';
		$interest = Interest::all();
        return view('group.new', compact('page_title','interest'));

    }

    //ORIGNAL
    // public function storeGroup(Request $request)
    // {
	// 	//print_r($request->interest);

    //     $request->validate([
    //        // 'cover' => 'required|image',
    //         'name' => 'required',
    //         'acceptance' => 'required|in:0,1',
    //         'type' => 'required|in:0,1'
    //     ]);

    //     $param = $request->except(['_token','interest']);

    //     if ($request->hasFile('cover')) {
    //         $file = $request->file('cover');
    //         $cover = $file->hashName();
    //         $im = Image::make($file);
			
	// 		$im->orientate();
	// 		$im->save('assets/front/img/' . $cover);

    //         $param['cover'] = $cover;
    //     }

    //     $group = Group::create($param);
	// 	$group->topics()->attach($request->interest);
    //     if ($group) {

    //         $group->slug = str_slug($group->name . ' ' . $group->id);
	// 		//
    //         $group->save();
			
			

    //         $group->members()->create([
    //             'user_id' => Auth::user()->id,
    //             'role' => 1
    //         ]);
			
			
	// 		//mautic///////////////////////
		
		
	// 			$email = Auth::user()->email;


	// 			$segment = 6;

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

	// 		///////////////////////////////

    //         return redirect()->route('user.groups', $group->slug)->withSuccess('Group Created Successfully');
    //     }

    //     return redirect()->back()->withErrors('Unexpected Error! Please try again');
    // }
    private function makeApiRequest($url, $method = 'GET')
    {
        $ch = curl_init();
        
        $headers = [
            'Authorization: Basic ' . base64_encode("sitecontrol:flattir3"),
            'Accept: application/json',
            'Content-Type: application/json'
        ];
    
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        \Log::info("API Request", [
            'url' => $url,
            'method' => $method,
            'httpCode' => $httpCode,
            'response' => $response
        ]);
    
        if (curl_errno($ch)) {
            \Log::error("Curl error", ['error' => curl_error($ch)]);
            throw new \Exception("API request failed: " . curl_error($ch));
        }
        
        curl_close($ch);
        return $response;
    }

    //NEW STOREGROUP
    public function storeGroup(Request $request)
    {
    try {
        // Validate request
        $request->validate([
            'name' => 'required',
            'acceptance' => 'required|in:0,1',
            'type' => 'required|in:0,1'
        ]);

        $param = $request->except(['_token','interest']);

        // Handle cover image upload
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $cover = $file->hashName();
            $im = Image::make($file);
            
            $im->orientate();
            $im->save('assets/front/img/' . $cover);

            $param['cover'] = $cover;
        }

        // Create group and attach topics
        $group = Group::create($param);
        $group->topics()->attach($request->interest);

        if ($group) {
            // Set slug and save
            $group->slug = str_slug($group->name . ' ' . $group->id);
            $group->save();

            // Create group member
            $group->members()->create([
                'user_id' => Auth::user()->id,
                'role' => 1
            ]);

            // Handle Mautic API integration
            $email = Auth::user()->email;
            $segment = 6;
            
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
            if(isset($contact['contacts']) && !empty($contact['contacts'])) {
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

            return redirect()
                ->route('user.groups', $group->slug)
                ->withSuccess('Group Created Successfully');
        }

        return redirect()
            ->back()
            ->withErrors('Unexpected Error! Please try again');

    } catch (\Exception $e) {
        \Log::error("Store group error: " . $e->getMessage());
        return redirect()
            ->back()
            ->withErrors('An error occurred while creating the group');
    }
    }

    // ORIGINAL GROUP FOLLOW
    // public function groupFollow(Request $request, $slug)

    // {
    //     $email = Auth::user()->email;
    //     $segment = 6;
    //     $url = 'https://mautic.agwiki.com/api/contacts?search=' . $email;

    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         "Content-type: application/x-www-form-urlencoded",
    //         "Authorization: Basic " . base64_encode("sitecontrol:flattir3"),
    //         "User-Agent: Mozilla/5.0",
    //         "Accept: application/json",
    //     ]);

    //     $response = curl_exec($ch);

    //     if (curl_errno($ch)) {
    //         return response()->json(['error' => 'Curl error: ' . curl_error($ch)], 500);
    //     }

    //     curl_close($ch);
    //     $contact = json_decode($response, true);

	// 				if(isset(array_keys($contact['contacts'])[0]))
	// 				{
	// 					$contact_id = array_keys($contact['contacts'])[0];


	// 					$url = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/remove';
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

	// 			///////////////////////////////

		

    //     $group = Group::where('slug', $slug)->first();

    //     if (! $group) return redirect()->route('front')->withErrors('Not Found');

    //     $user = Auth::user();

    //     $member = GroupMember::where('group_id', $group->id)->where('user_id', $user->id)->first();
		
		

    //     if (! $member) {
    //         // new member

    //         if ($group->acceptance == 0) {

    //             $member = $group->members()->create([
    //                 'user_id' => $user->id,
    //                 'role' => 4,
    //                 'status' => 1
    //             ]);
				
				
	// 			/*$adminAndModerators = GroupMember::where('group_id', $group->id)->where('role', '!=', 4)->where('status', 1)->get();
				
	// 			//die(print_r($adminAndModerators));
				
	// 			foreach($adminAndModerators as $adminuser)
	// 			{
				
	// 				$notify = Notify::create([
	// 					'group_id' => $group->id,
	// 					'to_id' => $adminuser->user_id,
	// 					'type' => 'group_request',
	// 					'by_id' => $user->id,
	// 					'status' => '0'
	// 				]);	
	// 			}*/
				
				
				
				
				
				
				
    //             return redirect()->route('user.groups', $group->slug)->withSuccess('Joined Successfully');

    //         } else {

    //             $member = $group->members()->create([
    //                 'user_id' => $user->id,
    //                 'role' => 4,
    //                 'status' => 4
    //             ]);
				
				
	// 			$adminAndModerators = GroupMember::where('group_id', $group->id)->where('role', '!=', 4)->where('status', 1)->get();
				
	// 			//die(print_r($adminAndModerators));
				
	// 			foreach($adminAndModerators as $adminuser)
	// 			{
				
	// 				$notify = Notify::create([
	// 					'group_id' => $group->id,
	// 					'to_id' => $adminuser->user_id,
	// 					'type' => 'group_request',
	// 					'by_id' => $user->id,
	// 					'status' => '0'
	// 				]);	
	// 			}
				
    //             return redirect()->route('user.groups', $group->slug)->withSuccess('Your join request is pending');
				
				
				
				
				

    //         }

    //     } else {

    //         if ($member->status == 3) {
    //             // he is invited

    //             if ($group->acceptance == 0) {

    //                 $member->status = 1;
    //                 $member->save();
    //                 return redirect()->route('user.groups', $group->slug)->withSuccess('Joined Successfully');

    //             } else {

    //                 $member->status = 4;
    //                 $member->save();
    //                 return redirect()->route('user.groups', $group->slug)->withSuccess('Your join request is pending');

    //             }

    //         } elseif ($member->status == 4 || $member->status == 1) {
    //             // cancel join request or leave group

    //             if ($member->role == 1) {

    //                 $group->delete();
    //                 return redirect()->route('user.groups')->withSuccess('Group Deleted Successfully');

    //             }

    //             $member->delete();
    //             return redirect()->route('user.groups', $group->slug);

    //         } else {

    //             return redirect()->route('user.groups')->withErrors('Not Found');

    //         }

    //     }

    //     return redirect()->route('front')->withErrors('Unexpected Error');

    // }
    
    // NEW GROUP FOLLOW
    public function groupFollow(Request $request, $slug)
    {
    try {
        // Mautic API call for contact fetch
        $email = Auth::user()->email;
        $segment = 6;
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
            \Log::error("Mautic API error: " . curl_error($ch));
        }
        
        curl_close($ch);
        $contact = json_decode($response, true);

        // If contact exists, remove from segment
        if(isset($contact['contacts']) && !empty($contact['contacts'])) {
            $contact_id = array_keys($contact['contacts'])[0];
            $removeUrl = 'https://mautic.agwiki.com/api/segments/'.$segment.'/contact/'.$contact_id.'/remove';
            
            // Second curl request to remove from segment
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
                \Log::error("Mautic segment remove error: " . curl_error($ch));
            }
            
            curl_close($ch);
        }

        // Original group follow logic
        $group = Group::where('slug', $slug)->first();
        if (!$group) {
            return redirect()->route('front')->withErrors('Not Found');
        }

        $user = Auth::user();
        $member = GroupMember::where('group_id', $group->id)
                            ->where('user_id', $user->id)
                            ->first();

        if (!$member) {
            // New member logic
            if ($group->acceptance == 0) {
                $member = $group->members()->create([
                    'user_id' => $user->id,
                    'role' => 4,
                    'status' => 1
                ]);
                
                return redirect()->route('user.groups', $group->slug)
                                ->withSuccess('Joined Successfully');
            } else {
                $member = $group->members()->create([
                    'user_id' => $user->id,
                    'role' => 4,
                    'status' => 4
                ]);

                $adminAndModerators = GroupMember::where('group_id', $group->id)
                                                ->where('role', '!=', 4)
                                                ->where('status', 1)
                                                ->get();

                foreach($adminAndModerators as $adminuser) {
                    Notify::create([
                        'group_id' => $group->id,
                        'to_id' => $adminuser->user_id,
                        'type' => 'group_request',
                        'by_id' => $user->id,
                        'status' => '0'
                    ]);
                }

                return redirect()->route('user.groups', $group->slug)
                                ->withSuccess('Your join request is pending');
            }
        } else {
            // Existing member logic
            if ($member->status == 3) {
                if ($group->acceptance == 0) {
                    $member->status = 1;
                    $member->save();
                    return redirect()->route('user.groups', $group->slug)
                                    ->withSuccess('Joined Successfully');
                } else {
                    $member->status = 4;
                    $member->save();
                    return redirect()->route('user.groups', $group->slug)
                                    ->withSuccess('Your join request is pending');
                }
            } elseif ($member->status == 4 || $member->status == 1) {
                if ($member->role == 1) {
                    $group->delete();
                    return redirect()->route('user.groups')
                                    ->withSuccess('Group Deleted Successfully');
                }

                $member->delete();
                return redirect()->route('user.groups', $group->slug);
            } else {
                return redirect()->route('user.groups')->withErrors('Not Found');
            }
        }

        return redirect()->route('front')->withErrors('Unexpected Error');

    } catch (\Exception $e) {
        \Log::error("Group follow error: " . $e->getMessage());
        return redirect()->route('front')->withErrors('An error occurred');
    }
    }

    public function groupUserAction($slug, $username, $action)

    {

        $group = Group::where('slug', $slug)->first();
        $user = User::where('username', $username)->first();

        if (! $group || ! $user) return redirect()->back();

        if ($group->isCreator() || $group->isAdmin() || $group->isModerator()) {

            $member = GroupMember::where('group_id', $group->id)->where('user_id', $user->id)->first();

            if (! $member) return redirect()->back()->withErrors('Not Found');

            if ($action == 'approve' && $member->status == 4) {
                $member->status = 1;
                $member->save();
				
				
				
				$adminAndModerators = GroupMember::where('group_id', $group->id)->where('role', '!=', 4)->where('status', 1)->get();
				
				//die(print_r($adminAndModerators));
				
				foreach($adminAndModerators as $adminuser)
				{
				
				$notify = Notify::create([
						'group_id' => $group->id,
						'to_id' => $member->user_id,//$adminuser->user_id,
						'type' => 'group_accepted',
						'by_id' =>$adminuser->user_id,
						'status' => '0'
					]);	
				
				}
				
                return redirect()->back()->withSuccess('Request Approved Successfully');
            } elseif ($action == 'reject' && $member->status == 4) {
                $member->delete();
                return redirect()->back()->withSuccess('Request Rejected Successfully');
            } elseif ($action == 'ban' && $member->status != 2) {
                $member->status = 2;
                $member->save();
                return redirect()->back()->withSuccess('Member Banned Successfully');
            } elseif ($action == 'unlock' && $member->status == 2) {
                $member->status = 1;
                $member->save();
                return redirect()->back()->withSuccess('Member Unlocked Successfully');
            } else {
                return redirect()->back();
            }

        }

        return redirect()->back();

    }

    public function groupPin(Request $request, $slug, Post $post)

    {

        $group = Group::where('slug', $slug)->first();

        if (! $group || ! $post) return redirect()->back()->withErrors('Not Found');

        if ($post->group_id != $group->id) return redirect()->back()->withErrors('Bad Request');

        if ($group->isCreator() || $group->isAdmin()) {

            $group->pin = $post->id;
            $group->save();

        }

        return redirect()->back();

    }

    public function groupRole(Request $request, GroupMember $member, $role)

    {

        if (! $member || ! $member->group) return redirect()->back();

        if ($member->group->isCreator() || $member->group->isAdmin()) {

            if ($role == 'remove' && $member->role != 1) {

                $member->delete();
                return redirect()->route('user.groups', $member->group->slug)->withSuccess('Member Removed Successfully');

            }

            if ($role == 'moderator' && $member->role != 1) {

                $member->role = 3;
                $member->save();
                return redirect()->route('user.groups', $member->group->slug)->withSuccess('Member Updated Successfully');

            }

            if ($role == 'admin' && $member->role != 1) {

                $member->role = 2;
                $member->save();
                return redirect()->route('user.groups', $member->group->slug)->withSuccess('Member Updated Successfully');

            }

        }

        if ($member->group->isCreator() || $member->group->isAdmin() || $member->group->isModerator()) {

            if ($role == 'remove' && $member->role == 4) {

                $member->delete();
                return redirect()->route('user.groups', $member->group->slug)->withSuccess('Member Removed Successfully');

            }

        }

    }

    public function editGroup($slug)

    {

        $group = Group::where('slug', $slug)->first();

        if (! $group) return redirect()->back()->withErrors('Not Found');

        $page_title = 'Edit - ' . $group->name;
		
		$interest = Interest::all();

        return view('group.edit', compact('group', 'page_title','interest'));

    }

    public function updateGroup(Request $request, $slug)

    {

        $group = Group::where('slug', $slug)->first();

        if (! $group) return redirect()->back()->withErrors('Not Found');

        $request->validate([
            'cover' => 'nullable|image',
            'name' => 'required',
            'acceptance' => 'required|in:0,1',
            'type' => 'required|in:0,1'
        ]);

        $param = $request->except(['_token','interest']);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $cover = $file->hashName();
            //Image::make($file)->resize(885, 315)->save('assets/front/img/' . $cover);
			$im = Image::make($file);
			
			$im->orientate();
			$im->save('assets/front/img/' . $cover);

            $param['cover'] = $cover;
            @unlink('assets/front/img/' . $group->cover);
        }

        $group->update($param);
		$group->topics()->attach($request->interest);

        return redirect()->back()->withSuccess('Group Updated Successfully');

    }

    public function invite($slug)

    {

        $group = Group::where('slug', $slug)->first();

        if ($group->isCreator() || $group->isAdmin() || $this->isModerator() || $this->isMember()) {

            $page_title = 'Invite People';

            return view('group.invite', compact('page_title', 'group'));

        }

        return redirect()->back()->withErrors('Not Found');

    }

    public function suggestUser(Request $request, $slug)

    {

        $request->validate([
            'key' => 'required',
            'selected' => 'array'
        ]);

        $key = $request->key;

        $group = Group::where('slug', $slug)->first();

        if (! $group) return response('', 419);

        $memberIDS = $group->members()->pluck('user_id');

        $users = User::where(function ($query) use ($key) {
            $query->where('username', 'LIKE', "%$key%")->orWhere('name', 'LIKE', "%$key%");
        })->where('status', 1)->whereNotIn('id', $memberIDS)->whereNotIn('id', $request->selected)->get(['id', 'name', 'avatar']);

        return response()->json($users);

    }

    public function inviteStore(Request $request, $slug)

    {

        $request->validate([
           'selected' => 'required|array',
           'selected.*' => 'required|numeric'
        ]);

        $group = Group::where('slug', $slug)->first();

        if (! $group) return redirect()->back()->withErrors('Not Found');

        $users = User::whereIn('id', $request->selected)->where('status', 1)->pluck('id');

        $members = GroupMember::where('group_id', $group->id)->whereIn('user_id', $users)->pluck('user_id');

        $unknowns = array_diff($users->toArray(), $members->toArray());

        $unknownUsers = User::whereIn('id', $unknowns)->where('status', 1)->get();

        $mem = [];
        $notf = [];
        foreach ($unknownUsers as $user) {
            $mem[] = [
                'user_id' => $user->id,
                'status' => 3
            ];
            $notf[] = [
                'to_id' => $user->id,
                'type' => 'group_invite',
                'by_id' => Auth::user()->id
            ];
        }
        $group->members()->createMany($mem);
        $group->notifies()->createMany($notf);

        return redirect()->route('feed')->withSuccess('Invitation Send Successfully');

    }
}
