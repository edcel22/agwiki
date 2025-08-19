<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test-ses', function () {
    try {
        Mail::raw('This is a test email from Laravel using Amazon SES', function ($message) {
            $message->to('agwiki.com')
                    ->subject('Test Email from AgWiki');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
});

Route::get('/mail-test', function () {
    try {
        \Mail::raw('This is a test email via Postmark API at ' . now(), function ($message) {
            $message->to('edcel.estadola.dev@gmail.com');
            $message->subject('Postmark API Test');
        });
        
        return 'Mail sent successfully via Postmark API!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

#check php info for debugging the dependencies
Route::get('/gd-test', function () {
    if (function_exists('gd_info')) {
        return response()->json([
            'status' => 'success',
            'message' => 'GD Library is enabled.',
            'info' => gd_info(),
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'GD Library is not enabled.',
        ]);
    }
});

#KT
Route::get('/', function () {
     return redirect()->route('feed');
    // return Redirect::to('https://beta2.agwiki.com/feed');
	//include public_path().'/redirect.php';
});

Route::get('/email-test', function() {
    return "Email test route is working!";
});

Route::get('/mail-config-test', function() {
    echo "<h2>Mail Configuration Test</h2>";
    echo "<p>Mail Driver: " . config('mail.driver') . "</p>";
    echo "<p>Mail Host: " . config('mail.host') . "</p>";
    echo "<p>Mail Port: " . config('mail.port') . "</p>";
    echo "<p>Mail Username: " . config('mail.username') . "</p>";
    echo "<p>Mail From Address: " . config('mail.from.address') . "</p>";
    echo "<p>Mail From Name: " . config('mail.from.name') . "</p>";
    
    try {
        echo "<h3>Testing Mail Sending...</h3>";
        \Illuminate\Support\Facades\Mail::raw('Test email from AgWiki', function($message) {
            $message->to('edcel.estadola.dev@gmail.com')
                   ->from('team@agwiki.com', 'Agwiki Team')
                   ->subject('Mail Configuration Test');
        });
        echo "<p style='color: green;'>✅ Email sent successfully!</p>";
    } catch (\Exception $e) {
        echo "<p style='color: red;'>❌ Email error: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
});

Route::get('/urlpreview', function()
{
    include public_path().'/urlpreview.php';
})->name('urlpreview');



Route::get('sendnewsletter', 'FrontController@sendNewsletter')->name('sendnewsletter');
Route::get('cleanShares', 'FrontController@cleanShares')->name('cleanShares');
Route::get('/ajaxpage', 'HomeController@ajaxpage')->name('ajaxpage');

#Route::get('csv_importer.php', function () {
#    return 'csv_importer';
#});


Route::get('/terms', 'FrontController@terms')->name('terms');
Route::get('/privacy', 'FrontController@privacy')->name('privacy');
/******************************************************Cron Routes*******************************************************************************/

Route::get('cron/birthday', 'FrontController@birthday');

/******************************************************Cron Routes*******************************************************************************/

//social login routes
#KT
// Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
// Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

///////////////////////////////////

Route::resource('/interest', 'InterestController');

Route::resource('/rss_feed', 'RssFeedsController');
//Route::get('rss_feed/feedtopic', 'RssFeedsController@feedtopic');

Route::get('interests/{slug?}', 'InterestController@index')->name('user.interests');


/******************************************************Groups






Routes*******************************************************************************/


Route::get('unsubscribe/{unsubscribe}', 'UsersController@unsubscribeNewsletter')->name('unsubscribeNewsletter');


Route::get('groups/{slug?}', 'GroupController@groups')->name('user.groups');
Route::get('groups/{slug}/members/{status}', 'GroupController@groupMembers')->name('user.group.members');
Route::post('groups/{slug}/pin/{post}', 'GroupController@groupPin')->name('user.group.pin');
Route::post('groups/{member}/role/{role}', 'GroupController@groupRole')->name('user.group.role');
Route::post('groups/{slug}/user/{username}/action/{action}', 'GroupController@groupUserAction')->name('user.group.action');
Route::get('add-group', 'GroupController@addGroup')->name('user.group.new');
Route::post('add-group', 'GroupController@storeGroup')->name('user.group.store');
Route::get('edit-group/{slug}', 'GroupController@editGroup')->name('user.group.edit');
Route::post('edit-group/{slug}', 'GroupController@updateGroup')->name('user.group.update');

Route::post('groups/{slug}/follow', 'GroupController@groupFollow')->name('user.group.follow');

Route::get('groups/{slug}/invite', 'GroupController@invite')->name('user.group.invite');
Route::post('groups/{slug}/invite', 'GroupController@inviteStore')->name('user.group.invite.send');
Route::post('groups/{slug}/suggestion', 'GroupController@suggestUser')->name('user.group.suggestion');

/******************************************************Groups Routes*******************************************************************************/

Route::get('tools/url/info', 'FrontController@scrapper')->name('tools.url.info');

Route::get('/home', 'HomeController@index')->name('front');
Route::get('/oldhome', 'HomeController@oldhome')->name('front');
#feed
Route::get('/feed', 'HomeController@feed')->name('feed');

Route::get('/list-segments', 'GroupController@listSegments');
#KT
Route::get('/non-userfeed', 'HomeController@nonuserfeed')->name('nonuserfeed');
Route::get('/all', 'HomeController@allPosts')->name('all');

// Route::get('/weather', 'HomeController@weather')->name('weather');
// Route::get('/commodities', 'HomeController@commodities')->name('commodities');
// Route::get('/commodities', 'CommoditiesController@index')->name('commodities');
// Route::get('/commodities/fetch-data', 'CommoditiesController@fetch')->name('commodities.fetch');
Route::get('/menupage', 'HomeController@menupage')->name('menu');

Route::get('search', 'HomeController@search')->name('search');
Route::get('tag/{tag}', 'HomeController@tag')->name('tag');

Route::get('social/{post}/share/{platform}', 'HomeController@socialShare')->name('social.share');

// Special route for social media crawlers to access post content
Route::get('crawler/post/{post}', 'HomeController@crawlerPost')->name('crawler.post');

//Route::get('tap', 'FrontController@tap')->name('tap');
//Route::get('pp', 'FrontController@pp')->name('pp');
Route::get('links', 'HomeController@links')->name('links');

Route::get('message/{username?}', 'HomeController@message')->name('message');
Route::post('message/store', 'HomeController@messageStore')->name('user.message.store');
Route::get('notify-messages', 'HomeController@messagesNotify')->name('user.message.notify');
Route::post('message/update', 'HomeController@messageUpdate')->name('user.message.update');
Route::post('comment/update/{post}', 'HomeController@commentUpdate')->name('user.comment.update');
Route::post('typing/update', 'HomeController@typingUpdate')->name('user.typing.update');
Route::post('typing/check', 'HomeController@typingCheck')->name('user.typing.check');

Route::get('notify/post/{notify}', 'HomeController@processNotify')->name('user.post.notify');

Route::get('verify/request', 'HomeController@verifyRequest')->name('user.verify.request');

Route::get('category/posts/{title}/{category}', 'HomeController@postByCategory')->name('category.posts');

Route::get('notifications', 'HomeController@notifications')->name('user.notification');

Route::post('updateNotifyStatus', 'HomeController@updateNotifyStatus')->name('user.updateNotifyStatus');
Route::post('updateNotifyStatusAll', 'HomeController@updateNotifyStatusAll')->name('user.updateNotifyStatusAll');


//Route::get('invite', 'HomeController@invite')->name('user.invite');
//Route::post('invite-send', 'HomeController@inviteSendViaEmail')->name('user.invite.email');
// Route::get('groups', 'HomeController@groups')->name('user.groups');
Route::post('groupremtopic', 'GroupController@processTopicRem')->name('group.remtopic');

Route::post('file-store', 'HomeController@fileStore')->name('file.store');
Route::post('file-delete', 'HomeController@fileDelete')->name('user.file.delete');
Route::post('image/store', 'HomeController@imageStore')->name('user.image.store');
Route::post('image/crop', 'HomeController@imageCrop')->name('user.image.crop');

Route::get('profile/{username?}', 'FrontController@profile')->name('profile');
Route::get('profile_old/{username?}', 'FrontController@profile_old')->name('profile_old');
Route::get('profile-edit', 'HomeController@profile')->name('user.profile.edit');
Route::post('profile-edit', 'HomeController@profileUpdate')->name('user.profile.update');

Route::get('change-password', 'HomeController@passwordChange')->name('user.password.change');
Route::put('change-password', 'HomeController@passwordUpdate')->name('user.password.update');

Route::get('follower/{username}', 'FrontController@follower')->name('user.profile.follower');
Route::get('following', 'HomeController@following')->name('user.profile.following');
Route::get('peoples', 'HomeController@peoples')->name('peoples');
Route::get('posts/new', 'HomeController@newPost')->name('user.post.new');
Route::post('posts/new', 'HomeController@newPostStore')->name('user.post.store');
Route::post('posts/delete', 'HomeController@postDelete')->name('user.post.delete');
Route::post('shares/delete', 'HomeController@shareDelete')->name('user.share.delete');
Route::post('comments/delete', 'HomeController@commentDelete')->name('user.comment.delete');
Route::get('posts/edit/{post}', 'HomeController@editPost')->name('user.post.edit');
Route::post('posts/edit/{post}', 'HomeController@editPostUpdate')->name('user.post.update');
Route::post('comment', 'HomeController@commentStore')->name('user.comment.store');
Route::post('like', 'HomeController@processLike')->name('user.like');
Route::post('dislike', 'HomeController@processDislike')->name('user.dislike');
Route::post('favorite', 'HomeController@processFavorite')->name('user.favorite');

Route::post('topic', 'InterestController@processTopic')->name('user.topic');
Route::post('remtopic', 'InterestController@processTopicRem')->name('user.remtopic');

Route::post('follow/{username}', 'HomeController@processFollow')->name('user.follow');
Route::post('block/{username}', 'HomeController@processBlock')->name('user.block');
Route::post('share', 'HomeController@processShare')->name('user.share');
Route::get('post/{post}', 'HomeController@postSingle')->name('user.post.single');
Route::get('report/{post}/post', 'HomeController@postReport')->name('user.post.report');
Route::post('report/{post}/post', 'HomeController@postReportStore')->name('user.post.report.store');

Route::post('category/store', 'HomeController@newCategoryStore')->name('user.cat.store');

Route::get('view/like/{post}', 'HomeController@viewLike')->name('view.like');
Route::get('view/share/{post}', 'HomeController@viewShare')->name('view.share');

Route::get('/authorization', 'FrontController@authorization')->name('authorization');
Route::get('/sendemailver', 'FrontController@sendemailver')->name('sendemailver');
Route::get('/emailverify', 'FrontController@emailverify')->name('emailverify');
Route::post('/emailverify', 'FrontController@emailverify')->name('emailverify');
Route::get('/sendsmsver', 'FrontController@sendsmsver')->name('sendsmsver');
Route::post('/smsverify', 'FrontController@smsverify')->name('smsverify');
Auth::routes();
Route::get('register/{username}', 'Auth\RegisterController@registerViaReferral')->name('referral');
Route::post('registeruser', 'FrontController@registeruser')->name('registeruser');

Route::post('register', 'Auth\RegisterController@create')->name('register');

//Forgot Password
Route::post('/forgot-pass', 'FrontController@forgotPass')->name('forgot.pass');
Route::get('/reset/{token}', 'FrontController@resetLink')->name('reset.passlink');
Route::post('/reset/password', 'FrontController@passwordReset')->name('reset.passw');
Route::get('/test-forgot-password', function() {
    try {
        $email = 'edcel.estadola.dev@gmail.com';
        echo "Sending test email to: $email<br>";
        
        \Illuminate\Support\Facades\Mail::raw('Test email content', function($message) use ($email) {
            $message->to($email)
                   ->from('no-reply@agwiki.com', 'AGWIKI')
                   ->subject('Test Email ' . date('Y-m-d H:i:s'));
        });
        
        echo "Mail sent successfully!<br>";
        return "Email sent to $email. Please check your inbox.";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
        echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
        return "Error sending email: " . $e->getMessage();
    }
});

/// change by dinesh start ///

    // user.urllink.data //
	Route::get('user-urldata','HomeController@GeturllinkData')->name('user.urllink.data');
    Route::post('user-urldata','HomeController@GeturllinkData')->name('user.urllink.data');
    Route::get('photos/{username}', 'FrontController@UserPhotos')->name('user.profile.photos');
    Route::get('videos/{username}', 'FrontController@UserVideos')->name('user.profile.videos');
    /// image album ///
    Route::post('CreateAlbum', 'FrontController@UserCreateAlbum')->name('user.create.album');
    Route::get('PhotoAlbums/{username}', 'FrontController@GetUserAlbums')->name('user.photo.album');
    Route::get('PhotoAlbum/{albumid}/{username}', 'FrontController@GetAlbumData')->name('user.single.album');
    Route::post('albums/delete', 'FrontController@AlbumDelete')->name('user.album.delete');

    // video album //
     Route::get('VideoAlbums/{username}', 'FrontController@GetUserVideoAlbums')->name('user.video.album');
     Route::get('videoAlbum/{albumid}/{username}', 'FrontController@GetVideoAlbumData')->name('user.videosingle.album');

/// change by dinesh end ///

Route::get('/test-email-send', function() {
    try {
        echo "Testing email sending...<br>";
        
        \Illuminate\Support\Facades\Mail::raw('This is a test email from AgWiki at ' . now(), function($message) {
            $message->to('edcel.estadola.dev@gmail.com')
                   ->from('team@agwiki.com', 'Agwiki Team')
                   ->subject('Test Email from AgWiki');
        });
        
        echo "Email sent successfully!";
    } catch (\Exception $e) {
        echo "Error sending email: " . $e->getMessage() . "<br>";
        echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
    }
})->name('test.email');

Route::get('/test-email-config', function() {
    try {
        echo "<h2>Email Configuration Test</h2><br>";
        
        // Check environment variables
        echo "<h3>Environment Variables:</h3>";
        echo "MAIL_DRIVER: " . env('MAIL_DRIVER', 'NOT SET') . "<br>";
        echo "MAIL_MAILER: " . env('MAIL_MAILER', 'NOT SET') . "<br>";
        echo "MAIL_HOST: " . env('MAIL_HOST', 'NOT SET') . "<br>";
        echo "MAIL_PORT: " . env('MAIL_PORT', 'NOT SET') . "<br>";
        echo "MAIL_USERNAME: " . env('MAIL_USERNAME', 'NOT SET') . "<br>";
        echo "MAIL_PASSWORD: " . (env('MAIL_PASSWORD') ? 'SET' : 'NOT SET') . "<br>";
        echo "MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION', 'NOT SET') . "<br>";
        echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'NOT SET') . "<br>";
        echo "MAIL_FROM_NAME: " . env('MAIL_FROM_NAME', 'NOT SET') . "<br><br>";
        
        // Check database tables
        echo "<h3>Database Tables:</h3>";
        try {
            $gnl = \App\General::first();
            if ($gnl) {
                echo "General table: OK (ID: {$gnl->id})<br>";
                echo "Title: " . ($gnl->title ?: 'NOT SET') . "<br>";
                echo "Email notifications enabled: " . ($gnl->emailnotf ? 'YES' : 'NO') . "<br>";
            } else {
                echo "General table: EMPTY or NOT FOUND<br>";
            }
        } catch (\Exception $e) {
            echo "General table error: " . $e->getMessage() . "<br>";
        }
        
        try {
            $temp = \App\Etemplate::first();
            if ($temp) {
                echo "Etemplate table: OK (ID: {$temp->id})<br>";
                echo "Sender: " . ($temp->esender ?: 'NOT SET') . "<br>";
                echo "Message template: " . (strlen($temp->emessage) > 0 ? 'SET (' . strlen($temp->emessage) . ' chars)' : 'NOT SET') . "<br>";
            } else {
                echo "Etemplate table: EMPTY or NOT FOUND<br>";
            }
        } catch (\Exception $e) {
            echo "Etemplate table error: " . $e->getMessage() . "<br>";
        }
        
        // Test send_email function
        echo "<h3>Testing send_email function:</h3>";
        try {
            send_email('edcel.estadola.dev@gmail.com', 'Test User', 'Test Subject', 'This is a test message');
            echo "send_email function: SUCCESS<br>";
        } catch (\Exception $e) {
            echo "send_email function: FAILED - " . $e->getMessage() . "<br>";
        }
        
        echo "<br>Test completed!";
        
    } catch (\Exception $e) {
        echo "Error in test: " . $e->getMessage() . "<br>";
        echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
    }
})->name('test.email.config');

Route::get('/debug-db', function() {
    try {
        echo "<h2>Database Debug</h2><br>";
        
        // Check if we can connect to database
        echo "<h3>Database Connection:</h3>";
        try {
            \DB::connection()->getPdo();
            echo "Database connection: OK<br>";
        } catch (Exception $e) {
            echo "Database connection: FAILED - " . $e->getMessage() . "<br>";
            return;
        }
        
        // Check generals table
        echo "<h3>Generals Table:</h3>";
        try {
            $count = \DB::table('generals')->count();
            echo "Total records: {$count}<br>";
            
            if ($count > 0) {
                $gnl = \DB::table('generals')->first();
                echo "First record ID: {$gnl->id}<br>";
                echo "Title: " . ($gnl->title ?: 'NULL') . "<br>";
                echo "Email notifications: " . ($gnl->emailnotf ?: 'NULL') . "<br>";
            } else {
                echo "Table is empty!<br>";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
        
        // Check etemplates table
        echo "<h3>Etemplates Table:</h3>";
        try {
            $count = \DB::table('etemplates')->count();
            echo "Total records: {$count}<br>";
            
            if ($count > 0) {
                $temp = \DB::table('etemplates')->first();
                echo "First record ID: {$temp->id}<br>";
                echo "Sender: " . ($temp->esender ?: 'NULL') . "<br>";
                echo "Message template length: " . strlen($temp->emessage) . " chars<br>";
            } else {
                echo "Table is empty!<br>";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
        
        // Check users table
        echo "<h3>Users Table:</h3>";
        try {
            $count = \DB::table('users')->count();
            echo "Total users: {$count}<br>";
            
            if ($count > 0) {
                $user = \DB::table('users')->latest()->first();
                echo "Latest user: {$user->email} (created: {$user->created_at})<br>";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
        
        echo "<br>Debug completed!";
        
    } catch (\Exception $e) {
        echo "Error in debug: " . $e->getMessage() . "<br>";
        echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
    }
})->name('debug.db');

Route::get('/fix-db', function() {
    try {
        echo "<h2>Fixing Database Tables</h2><br>";
        
        // Check and fix generals table
        echo "<h3>Generals Table:</h3>";
        try {
            $count = \DB::table('generals')->count();
            if ($count == 0) {
                \DB::table('generals')->insert([
                    'title' => 'AgWiki',
                    'emailnotf' => 1,
                    'smsnotf' => 1,
                    'emailver' => 1,
                    'smsver' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                echo "Generals table populated with default data<br>";
            } else {
                echo "Generals table already has data<br>";
            }
        } catch (\Exception $e) {
            echo "Error with generals table: " . $e->getMessage() . "<br>";
        }
        
        // Check and fix etemplates table
        echo "<h3>Etemplates Table:</h3>";
        try {
            $count = \DB::table('etemplates')->count();
            if ($count == 0) {
                \DB::table('etemplates')->insert([
                    'esender' => 'team@agwiki.com',
                    'emessage' => '<p>Hello {{name}},</p><p>{{message}}</p><p>Best regards,<br>AgWiki Team</p>',
                    'smsapi' => '',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                echo "Etemplates table populated with default data<br>";
            } else {
                echo "Etemplates table already has data<br>";
            }
        } catch (\Exception $e) {
            echo "Error with etemplates table: " . $e->getMessage() . "<br>";
        }
        
        echo "<br>Database fix completed!<br>";
        echo "<a href='/debug-db'>Check database status again</a><br>";
        echo "<a href='/test-email-config'>Test email configuration</a><br>";
        
    } catch (\Exception $e) {
        echo "Error in fix: " . $e->getMessage() . "<br>";
        echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
    }
})->name('fix.db');

Route::group(['prefix' => 'admin'], function () {
    #KT
    Route::get('/','AdminLoginController@index')->name('admin.loginForm');
    Route::post('/', 'AdminLoginController@authenticate')->name('admin.login');

    

});


// Route::middleware(['redirect.to.login'])->group(function () {
//     // Define routes that need redirection to login here
    
//     Route::get('group', 'AdminController@group')->name('group');
    
  
// });

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::get('/Dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    //Post Management

    Route::get('posts', 'AdminController@posts')->name('post.index');
    Route::get('post/{post}', 'AdminController@postSingle')->name('post.single');
    Route::post('post-delete', 'AdminController@postDelete')->name('admin.post.delete');
    Route::post('post-cancel', 'AdminController@postCancel')->name('admin.post.cancel');
    
    Route::post('admin/post/pin', 'AdminController@pinPost')->name('admin.post.pin');
    Route::post('admin/post/unpin', 'AdminController@unpinPost')->name('admin.post.unpin');
    Route::get('admin/posts/data', 'AdminController@getPostsData')->name('admin.posts.data');

	Route::get('rss', 'AdminController@rss')->name('rss');
	Route::post('rss-delete', 'AdminController@postRSSDelete')->name('admin.rss.delete');
	Route::get('rss-add', 'AdminController@postRSSAdd')->name('admin.rss.add');
	Route::post('rss-store', 'AdminController@postRSSStore')->name('admin.rss.store');
	Route::get('rss/{post}', 'AdminController@postRSSEdit')->name('admin.rss.edit');


	Route::get('ads', 'AdminController@ads')->name('ads');
	Route::post('ads-delete', 'AdminController@postAdsDelete')->name('admin.ads.delete');
	Route::get('ads-add', 'AdminController@postAdsAdd')->name('admin.ads.add');
	Route::post('ads-store', 'AdminController@postAdsStore')->name('admin.ads.store');
	Route::get('ads/{post}', 'AdminController@postAdsEdit')->name('admin.ads.edit');

	Route::get('topic', 'AdminController@topic')->name('topic');
	Route::post('topic-delete', 'AdminController@topicDelete')->name('admin.topic.delete');
	Route::get('topic-add', 'AdminController@topicAdd')->name('admin.topic.add');
	Route::post('topic-store', 'AdminController@topicStore')->name('admin.topic.store');
	Route::get('topic/{post}', 'AdminController@topicEdit')->name('admin.topic.edit');


	Route::get('group', 'AdminController@group')->name('group');
	Route::post('group-delete', 'AdminController@groupDelete')->name('admin.group.delete');
	Route::get('group-add', 'AdminController@groupAdd')->name('admin.group.add');
	Route::post('group-store', 'AdminController@groupStore')->name('admin.group.store');
	Route::get('group/{post}', 'AdminController@groupEdit')->name('admin.group.edit');

    Route::get('/GeneralSetting', 'GeneralSettingController@GenSetting')->name('admin.GenSetting');
    Route::post('/GeneralSetting', 'GeneralSettingController@UpdateGenSetting')->name('admin.UpdateGenSetting');

    Route::get('gnl-settings/terms-and-policy', 'GeneralSettingController@tp')->name('gnl.tp');
    Route::put('gnl-settings/terms-and-policy', 'GeneralSettingController@tpUpdate')->name('gnl.tp.update');
    Route::get('gnl-settings/privacy-policy', 'GeneralSettingController@pp')->name('gnl.pp');
    Route::put('gnl-settings/privacy-policy', 'GeneralSettingController@ppUpdate')->name('gnl.pp.update');

    //Email Template
    Route::get('/template', 'EtemplateController@index')->name('template');
    Route::post('/template-update', 'EtemplateController@update')->name('template.update');

    //Sms Api
    Route::get('/sms-api', 'EtemplateController@smsApi')->name('sms.api');
    Route::post('/sms-update', 'EtemplateController@smsUpdate')->name('sms.update');

    Route::get('logo','GeneralSettingController@logo')->name('logo.index');
    Route::post('logo', 'GeneralSettingController@updateLogo')->name('logo.update');

    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
    Route::get('/password-change', 'AdminController@changePass')->name('admin.pass');
    Route::post('/password-change', 'AdminController@changePassUpdate')->name('admin.pass.update');

    //User Management
    Route::get('/users', 'UsersController@index')->name('users');
    Route::post('/user-search', 'UsersController@userSearch')->name('search.users');
    Route::get('/user/{user}', 'UsersController@single')->name('user.single');
    Route::get('/user-banned', 'UsersController@banusers')->name('user.ban');
    Route::get('login-logs/{user?}', 'UsersController@loginLogs')->name('user.login-logs');
    Route::get('/users/superuser', 'UsersController@superUser')->name('users.super');
    Route::put('/users/superuser', 'UsersController@updateSuperUser')->name('users.super.update');

	Route::post('/users/delete', 'UsersController@userDelete')->name('admin.user.delete');

    // User Request
    Route::get('user/profile-verify/request', 'UsersController@profileVerifyRequest')->name('verify.request');
    Route::post('user/profile-verify/request', 'UsersController@profileVerifyRequestAction')->name('verify.request.action');
    Route::post('user/profile-verify/cancel', 'UsersController@profileVerifyRequestCancel')->name('verify.request.cancel');
    Route::get('user/profile-verify/all', 'UsersController@profileVerifiedUsers')->name('verify.all');

    Route::get('/mail/{user}', 'UsersController@email')->name('email');
    Route::post('/sendmail', 'UsersController@sendemail')->name('send.email');
    Route::put('/user/pass-change/{user}', 'UsersController@userPasschange')->name('user.passchange');
    Route::put('/user/status/{user}', 'UsersController@statupdate')->name('user.status');
    Route::get('/broadcast', 'UsersController@broadcast')->name('broadcast');
    Route::post('/broadcast/email', 'UsersController@broadcastemail')->name('broadcast.email');
	
	Route::get('/newsletter', 'UsersController@newsletter')->name('newsletter');
    Route::post('/broadcast/newsletter', 'UsersController@broadcastNewsletter')->name('broadcast.newsletter');

});
