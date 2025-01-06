<?php
namespace App;
use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Post;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];
    protected $dates = ['birthday'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function timeline()
    // {
    //     $followedByThis = Follow::where('by', $this->id)->pluck('followed');

    //     if ($followedByThis->count() > 0) {
    //         // Convert the collection to a comma-separated string of IDs
    //         $followSql = implode(',', $followedByThis->toArray());
    //     }
    
    //     if (isset($_GET['topic'])) {
    //         $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->select('shares.*', 'posts.pinned') // Select pinned column for ordering
    //             ->whereRaw('post_id in (select post_id from interest_post ip inner join posts p on p.id = ip.post_id where ip.interest_id = ' . $_GET['topic'] . ')')
    //             ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
    //             ->orderBy('shares.id', 'DESC')
    //             ->paginate(10);
    //         $shares->setPath('');
    //     } elseif (isset($_GET['rss'])) {
    //         $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->select('shares.*', 'posts.pinned')
    //             ->where('link', 'like', '%' . $_GET['rss'] . '%')
    //             ->orWhere('scrabingcontent', 'like', '%' . $_GET['rss'] . '%')
    //             ->orderBy('posts.pinned', 'DESC')
    //             ->orderBy('shares.id', 'DESC')
    //             ->paginate(10);
    //         $shares->setPath('');
    //     } elseif (isset($_GET['fav'])) {
    //         $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->join('favorites', 'favorites.post_id', '=', 'posts.id')
    //             ->select('shares.*', 'posts.pinned')
    //             ->where('favorites.user_id', Auth::user()->id)
    //             ->orderBy('posts.pinned', 'DESC')
    //             ->orderBy('favorites.id', 'DESC')
    //             ->paginate(10);
    //         $shares->setPath('');
    //     } elseif (isset($_GET['search'])) {
    //         $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->select('shares.*', 'posts.pinned') // Include pinned for ordering
    //             ->where('posts.content', 'like', '%' . $_GET['search'] . '%') // Apply search condition
    //             ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
    //             ->orderBy('shares.id', 'DESC')
    //             ->paginate(10);
    //         $shares->setPath('');
    //     } else {
    //         $start = microtime(true);

    //         $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->select('shares.*', 'posts.pinned') 
    //             ->where('shares.active', 1) // Ensure only active shares are included
    //             // ->whereIn('posts.user_id', $followedByThis) // Filter by followed users
    //             ->orWhereRaw("
    //                 post_id IN (
    //                     SELECT post_id
    //                     FROM interest_post ip
    //                     INNER JOIN interest_user iu ON ip.interest_id = iu.interest_id
    //                     INNER JOIN posts p ON p.id = ip.post_id
    //                     WHERE iu.user_id = ? 
    //                 )
    //             ", [Auth::id()])
    //             ->orWhereRaw("
    //                 post_id IN (
    //                     SELECT post_id
    //                     FROM interest_post ip
    //                     INNER JOIN interest_user iu ON ip.interest_id = iu.interest_id
    //                     INNER JOIN posts p ON p.id = ip.post_id AND p.user_id = 1
    //                     WHERE iu.user_id = ?
    //                 )
    //             ", [Auth::id()])
    //             ->orWhereRaw("
    //                 (post_id NOT IN (
    //                     SELECT post_id
    //                     FROM interest_post ip
    //                     INNER JOIN posts p ON p.id = ip.post_id
    //                 ) AND posts.user_id = 1)
    //             ")
    //             ->orWhere('posts.user_id', Auth::id()) // Include posts by the current user
    //             ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
    //             ->orderBy('shares.created_at', 'DESC') // Secondary ordering by creation datedate
    //         ->paginate(10);

    //         $time = microtime(true) - $start;
    //         $shares->setPath('');
    //     }
    
    //     return $shares;
    // }
    public function timeline()
{
    $followedByThis = Follow::where('by', $this->id)->pluck('followed');

    if ($followedByThis->count() > 0) {
        // Convert the collection to a comma-separated string of IDs
        $followSql = implode(',', $followedByThis->toArray());
    }

    if (isset($_GET['topic'])) {
        $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
            ->select('shares.*', 'posts.pinned') // Select pinned column for ordering
            ->where('shares.active', 1) // Include active filter
            ->whereRaw('post_id in (select post_id from interest_post ip inner join posts p on p.id = ip.post_id where ip.interest_id = ' . $_GET['topic'] . ')')
            ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
            ->orderBy('shares.id', 'DESC')
            ->paginate(10);
        $shares->setPath('');
    } elseif (isset($_GET['rss'])) {
        $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
            ->select('shares.*', 'posts.pinned')
            ->where('shares.active', 1) // Include active filter
            ->where(function ($query) {
                $query->where('link', 'like', '%' . $_GET['rss'] . '%')
                      ->orWhere('scrabingcontent', 'like', '%' . $_GET['rss'] . '%');
            })
            ->orderBy('posts.pinned', 'DESC')
            ->orderBy('shares.id', 'DESC')
            ->paginate(10);
        $shares->setPath('');
    } elseif (isset($_GET['fav'])) {
        $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
            ->join('favorites', 'favorites.post_id', '=', 'posts.id')
            ->select('shares.*', 'posts.pinned')
            ->where('shares.active', 1) // Include active filter
            ->where('favorites.user_id', Auth::user()->id)
            ->orderBy('posts.pinned', 'DESC')
            ->orderBy('favorites.id', 'DESC')
            ->paginate(10);
        $shares->setPath('');
    } elseif (isset($_GET['search'])) {
        $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
            ->select('shares.*', 'posts.pinned') // Include pinned for ordering
            ->where('shares.active', 1) // Include active filter
            ->where('posts.content', 'like', '%' . $_GET['search'] . '%') // Apply search condition
            ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
            ->orderBy('shares.id', 'DESC')
            ->paginate(10);
        $shares->setPath('');
    } else {
        $start = microtime(true);

        $shares = Share::join('posts', 'shares.post_id', '=', 'posts.id')
            ->select('shares.*', 'posts.pinned') 
            ->where('shares.active', 1) // Ensure only active shares are included
            ->where(function ($query) use ($followedByThis) {
                $query->whereIn('posts.user_id', $followedByThis)
                      ->orWhereRaw("
                        post_id IN (
                            SELECT post_id
                            FROM interest_post ip
                            INNER JOIN interest_user iu ON ip.interest_id = iu.interest_id
                            INNER JOIN posts p ON p.id = ip.post_id
                            WHERE iu.user_id = ? 
                        )
                    ", [Auth::id()])
                      ->orWhereRaw("
                        post_id IN (
                            SELECT post_id
                            FROM interest_post ip
                            INNER JOIN interest_user iu ON ip.interest_id = iu.interest_id
                            INNER JOIN posts p ON p.id = ip.post_id AND p.user_id = 1
                            WHERE iu.user_id = ?
                        )
                    ", [Auth::id()])
                      ->orWhereRaw("
                        (post_id NOT IN (
                            SELECT post_id
                            FROM interest_post ip
                            INNER JOIN posts p ON p.id = ip.post_id
                        ) AND posts.user_id = 1)
                    ")
                      ->orWhere('posts.user_id', Auth::id()); // Include posts by the current user
            })
            ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
            ->orderBy('shares.created_at', 'DESC') // Secondary ordering by creation date
            ->paginate(10);

        $time = microtime(true) - $start;
        $shares->setPath('');
    }

    return $shares;
}

    // public function nonuserTimeline()
    // {
    //     $user = User::where('username', 'ktschomakoff-860')->first();

    //     if ($followed_by_this = Follow::where('by', $this->id)->pluck('followed')) {
    //         $follow_sql = '';
    //         foreach ($followed_by_this as $follow_id) {
    //             @$follow_sql .= ',' . $follow_id;
    //         }
    //         $follow_sql = substr($follow_sql, -1); // Convert followed IDs into a comma-separated string
    //     }

    //     if (isset($_GET['topic'])) {
    //         $shares = Share::distinct('shares.post_id')
    //             ->join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->whereRaw('post_id in (select post_id from interest_post ip inner join posts p on p.id = ip.post_id where ip.interest_id = ' . $_GET['topic'] . ')')
    //             ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
    //             ->orderBy('id', 'DESC')
    //             ->paginate(10); // Ensure pagination works properly for topic feed
    //         $shares->setPath('');
    //     } elseif (isset($_GET['rss'])) {
    //         $shares = Share::distinct('shares.post_id')
    //             ->join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->where('link', 'like', '%' . $_GET['rss'] . '%')
    //             ->orWhere('scrabingcontent', 'like', '%' . $_GET['rss'] . '%')
    //             ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
    //             ->orderBy('shares.id', 'DESC')
    //             ->paginate(10);
    //         $shares->setPath('');
    //     } elseif (isset($_GET['fav'])) {
    //         $shares = Share::distinct('shares.post_id')
    //             ->join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->join('favorites', 'favorites.post_id', '=', 'posts.id')
    //             ->where('favorites.user_id', $user->id)
    //             ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
    //             ->orderBy('favorites.id', 'DESC')
    //             ->paginate(10);
    //         $shares->setPath('');
    //     } elseif (isset($_GET['search'])) {
    //         $shares = Share::distinct('shares.post_id')
    //             ->join('posts', 'shares.post_id', '=', 'posts.id')
    //             ->where('content', 'like', '%' . $_GET['search'] . '%')
    //             ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
    //             ->orderBy('shares.id', 'DESC')
    //             ->paginate(10);
    //         $shares->setPath('');
    //     } else {
    //         $start = microtime(true); // Keep the original line
    //         $shares = Share::distinct('shares.post_id')
    //             ->join('posts', function ($join) {
    //                 $join->on('posts.id', '=', 'shares.post_id');
    //                 $join->where('shares.active', '=', 1);
    //             })
    //             ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
    //             ->orderBy('shares.id', 'DESC')
    //             ->paginate(10);
    //         $time = microtime(true) - $start; // Keep the original line
    //         $shares->setPath(''); // Keep the original line
    //     }

    //     return $shares;
    // }

    public function nonuserTimeline()
{
    $user = User::where('username', 'ktschomakoff-860')->first();

    if ($followed_by_this = Follow::where('by', $this->id)->pluck('followed')) {
        $follow_sql = '';
        foreach ($followed_by_this as $follow_id) {
            @$follow_sql .= ',' . $follow_id;
        }
        $follow_sql = substr($follow_sql, -1); // Convert followed IDs into a comma-separated string
    }

    if (isset($_GET['topic'])) {
        $shares = Share::distinct('shares.post_id')
            ->join('posts', 'shares.post_id', '=', 'posts.id')
            ->where('shares.active', 1) // Include active filter
            ->whereRaw('post_id in (select post_id from interest_post ip inner join posts p on p.id = ip.post_id where ip.interest_id = ' . $_GET['topic'] . ')')
            ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
            ->orderBy('id', 'DESC')
            ->paginate(10); // Ensure pagination works properly for topic feed
        $shares->setPath('');
    } elseif (isset($_GET['rss'])) {
        $shares = Share::distinct('shares.post_id')
            ->join('posts', 'shares.post_id', '=', 'posts.id')
            ->where('shares.active', 1) // Include active filter
            ->where(function ($query) {
                $query->where('link', 'like', '%' . $_GET['rss'] . '%')
                      ->orWhere('scrabingcontent', 'like', '%' . $_GET['rss'] . '%');
            })
            ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
            ->orderBy('shares.id', 'DESC')
            ->paginate(10);
        $shares->setPath('');
    } elseif (isset($_GET['fav'])) {
        $shares = Share::distinct('shares.post_id')
            ->join('posts', 'shares.post_id', '=', 'posts.id')
            ->join('favorites', 'favorites.post_id', '=', 'posts.id')
            ->where('shares.active', 1) // Include active filter
            ->where('favorites.user_id', $user->id)
            ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
            ->orderBy('favorites.id', 'DESC')
            ->paginate(10);
        $shares->setPath('');
    } elseif (isset($_GET['search'])) {
        $shares = Share::distinct('shares.post_id')
            ->join('posts', 'shares.post_id', '=', 'posts.id')
            ->where('shares.active', 1) // Include active filter
            ->where('content', 'like', '%' . $_GET['search'] . '%')
            ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
            ->orderBy('shares.id', 'DESC')
            ->paginate(10);
        $shares->setPath('');
    } else {
        $start = microtime(true); // Keep the original line
        $shares = Share::distinct('shares.post_id')
            ->join('posts', 'shares.post_id', '=', 'posts.id')
            ->where('shares.active', 1) // Include active filter
            ->orderBy('posts.pinned', 'DESC') // Prioritize pinned posts
            ->orderBy('shares.id', 'DESC')
            ->paginate(10);
        $time = microtime(true) - $start; // Keep the original line
        $shares->setPath(''); // Keep the original line
    }

    return $shares;
}

    public static function getfollowandmutual($poststatus) {
        $Mutualfollow=array();
        if($poststatus=='2'){
        $mutualfollowers= DB::select('SELECT `by` from follows where `by` IN( SELECT followed FROM `follows` WHERE `by` IN ('.Auth::user()->id.') ) and followed IN ('.Auth::user()->id.')');
      
        if(count($mutualfollowers) > 0) 
        {
          foreach($mutualfollowers as $value)
          {
             $Mutualfollow[]=$value->by;
          }
         }
        }
        return $Mutualfollow; 
      }
  
    public  function isFollowedMe()

    {
		

        $follow = Follow::where(['by' => Auth::user()->id, 'followed' => $this->id])->first();

        if ($follow) return true;

        return false;

    }
	
	public static  function StaticisFollowedMe($id)

    {
		

        $follow = Follow::with('user')->join('users','users.id', '=','follows.by')->where(['by' => $id]);

       
        return $follow ;

    }
	
	public static  function StaticisFollowingMe($id )

    {
		

        $follow = Follow::with('user2')->join('users','users.id', '=','follows.followed')->where(['followed' => $id]);

       
        return $follow ;

    }

    public function isBlockedByMe($user_id)

    {

        $block = Block::where(['by_id' => $this->id, 'blocked_id' => $user_id])->first();

        if ($block) return true;

        return false;

    }

    public function posts()

    {

        return $this->hasMany(Post::class);

    }

    public function postCount()

    {

        return $this->posts()->count();

    }

    public function views()

    {

        return $this->hasMany(View::class);

    }

    public function viewCount()

    {

        return $this->views()->count();

    }

    public function comments()

    {

        return $this->hasMany(Comment::class);

    }

    public function commentCount()

    {

        return $this->comments()->count();

    }

    public function earned()

    {

        $trxs = Trx::where('user_id', $this->id)->where('type', '+')->sum('amount');
        
        return $trxs;

    }

    public function followers()

    {

        $followers = Follow::where('followed', $this->id)->get();

        $users = [];

        foreach ($followers as $follower) {
            $fo = self::find($follower->by);

            if ($fo) $users[] = $fo;
        }

        return $users;

    }
	
	public static function Staticfollowers($id)

    {

        $followers = Follow::where('followed', $id)->count();

       
        return $followers;

    }
	
	
	public static function Staticfollowing($id)

    {

        $followings = Follow::where('by', $id)->count();

       

        return $followings;

    }


    public function following()

    {

        $followings = Follow::where('by', $this->id)->get();

        $users = [];

        foreach ($followings as $followed) {
            $fo = self::find($followed->followed);

            if ($fo) $users[] = $fo;
        }

        return $users;

    }
	
	
	
	public static function jobs()
    {
		return job_desc::get();
	}
	
	public static function job($id)
    {
       // return $this->hasOne('App\job_desc','id','workplace');
	   //die('the id '.$id);
		///die(job_desc::where(['id' => $id])->first());
		return job_desc::where(['id' => $id])->first();
		//if ($job) return true;

        //return false;
    }

    public function notifications()

    {

        return $this->hasMany(Notify::class, 'to_id');

    }
	
	public static function StaticgetLatestNotifications($id)

    {

        return Notify::where('to_id', $id)->where('by_id','!=',$id)->orderBy('id', 'DESC')->get();//

    }
	
	public static function  StaticunreadNotificationsCount($id)
    
    {
        
        return Notify::where('to_id', $id)->where('by_id','!=',$id)->where('status', 0)->count();
        
    }
	

    public function getLatestNotifications()

    {

        return Notify::where('to_id', $this->id)->orderBy('id', 'DESC')->get();

    }

    public function unreadNotif()

    {

        return Notify::where('to_id', $this->id)->where('status', 0)->count();

    }
	
	public static function  StaticunreadMessageCount($id)
    
    {
        
        return Message::where('to', $id)->where('status', 0)->count();
        
    }
    
    public function  unreadMessageCount()
    
    {
        
        return Message::where('to', $this->id)->where('status', 0)->count();
        
    }
	
	public function interests(){
    	return $this->belongsToMany('App\Interest')->withPivot('user_id');
	}
	
	
	public static function StaticunreadMessages($id)
    
    {
		
    
        $convarsation_ids = Message::where('to', $id)->orWhere('from', $id)->distinct('from','to')->orderBy('id', 'DESC')->get(['id','from','to', 'content','created_at']);
        
        $mmss = [];
        
        foreach($convarsation_ids as $msgs){
            
            if($msgs->to != $id){
                $mmss[] = $msgs->to;
            }
                
            if($msgs->from != $id){
                $mmss[] = $msgs->from;
            }
        }
        
        $chats = array_unique($mmss);
        $ccc = [];
        foreach($chats as $bal){
        // $ccc[] = Message::where('to', $bal)->where('from',  $id)->orderBy('id','DESC')->first();
        $ccc[] = Message::where('from', $bal)->where('to',  $id)->orderBy('id','DESC')->first();
    
        }

       // return $ccc;
        return Message::where('to', $id)->distinct('from')->orderBy('id', 'DESC')->limit(10)->get(['from','content','created_at','status']);
        
    }
	
	

    
    public function unreadMessages()
    
    {
    
        $convarsation_ids = Message::where('to', $this->id)->orWhere('from', $this->id)->distinct('from','to')->orderBy('id', 'DESC')->get(['id','from','to']);
        
        $mmss = [];
        
        foreach($convarsation_ids as $msgs){
            
            if($msgs->to != $this->id){
                $mmss[] = $msgs->to;
            }
                
            if($msgs->from != $this->id){
                $mmss[] = $msgs->from;
            }
        }
        
        $chats = array_unique($mmss);
        $ccc = [];
        foreach($chats as $bal){
        // $ccc[] = Message::where('to', $bal)->where('from',  $this->id)->orderBy('id','DESC')->first();
        $ccc[] = Message::where('from', $bal)->where('to',  $this->id)->orderBy('id','DESC')->first();
    
        }

       // return $ccc;
        return Message::where('to', $this->id)->distinct('from')->orderBy('id', 'DESC')->get(['from']);
        
    }

    public function getAvatarAttribute($avatar)

    {

        $path = 'assets/front/img/' . $avatar;

        if (! file_exists($path)) {

            if ($this->gender == 'MALE') {
                return 'male.png';
            } else {
                return 'female.png';
            }

        }

        return $avatar;

    }
    
    public function getCoverAttribute($cover)

    {

        $path = 'assets/front/img/' . $cover;

        if (! file_exists($path)) {

            return 'banner.jpg';

        }

        return $cover;

    }

    public function isFriend()

    {

        if (Auth::user()->id == 9) return true;

        $myFollow = Follow::where('by', $this->id)->where('followed', Auth::user()->id)->first();
        $partFollow = Follow::where('by', Auth::user()->id)->where('followed', $this->id)->first();

        if ($myFollow && $partFollow) return true;

        return false;

    }
}
