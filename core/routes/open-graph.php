<?php

/*
|--------------------------------------------------------------------------
| Open Graph Routes (No Middleware)
|--------------------------------------------------------------------------
|
| These routes are for social media crawlers and bypass ALL middleware
| including authentication, CSRF, sessions, etc.
|
*/

Route::get('og/{post}', 'OpenGraphController@show')->name('openGraph');
