<?php

// 1 - Threads
// 1.1 - Show all
Route::get('threads', ['middleware' => 'auth', 'uses' => 'ThreadsController@index']);
// 1.2 - Show create form
Route::get('threads/create', ['middleware' => 'auth', 'uses' => 'ThreadsController@create']);
// 1.3 - Store in database
Route::post('threads', ['middleware' => 'auth', 'uses' => 'ThreadsController@store']);
// 1.4 - Show specific
Route::get('threads/{id}/{slug}', ['as' => 'threads.show', 'uses' => 'ThreadsController@show']);
// 1.5 - Show edit form
Route::get('threads/{id}/{slug}/edit', ['as' => 'threads.edit', 'uses' => 'ThreadsController@edit']);
// 1.6 - Update database
Route::put('threads/{id}/{slug}', ['as' => 'threads.update', 'uses' => 'ThreadsController@update']);
Route::patch('threads/{id}/{slug}', ['middleware' => 'auth', 'uses' => 'ThreadsController@update']);
// 1.7 - Delete from database
Route::delete('threads/{id}/{slug}', ['as' => 'threads.destroy', 'uses' => 'ThreadsController@destroy']);

// 2 - Posts
// 2.1 - Show all
Route::get('threads/{id}/{slug}/posts', 'PostsController@index');
// 2.2 - Show create form
Route::get('threads/{id}/{slug}/posts/create', 'PostsController@create');
// 2.3 - Store in database
Route::post('threads/{id}/{slug}/posts', 'PostsController@store');
// 2.4 - Show specific
Route::get('threads/{id}/{slug}/posts/{post}', ['as' => 'posts.show', 'uses' => 'PostsController@show']);
// 2.5 - Show edit form
Route::get('threads/{id}/{slug}/posts/{post}/edit', ['as' => 'posts.edit', 'uses' => 'PostsController@edit']);
// 2.6 - Update database
Route::put('threads/{id}/{slug}/posts/{post}', ['as' => 'posts.update', 'uses' => 'PostsController@update']);
Route::patch('threads/{id}/{slug}/posts/{post}', 'PostsController@update');
// 2.7 - Delete from database
Route::delete('threads/{id}/{slug}/posts/{post}', ['as' => 'posts.destroy', 'uses' => 'PostsController@destroy']);

// 3.1 - Login form
Route::get('auth/login', 'Auth\AuthController@showLogin');
// 3.2 - Facebook login
Route::get('auth/facebook', 'Auth\AuthController@login');
// 3.3 - Logout
Route::get('auth/logout', 'Auth\AuthController@logout');

// 5 - Home
Route::get('/', 'PagesController@home');
Route::get('home', 'PagesController@home');

Route::get('test', function(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    $response = $fb->get('/me/friends', \Session::get('fb_user_access_token'));
    dd($response);
});

// 6 - Temp
// Route::get('update-covers-and-backdrops', function () {
//     set_time_limit(0);
//     $data = [];
//     $i = 0;
//     $movies = App\Movie::all();
//     foreach($movies as $movie) {
//         foreach($movie->externalIds as $external_id) {
//             if($external_id->name == 'tmdb') {
//                 $url = 'http://api.themoviedb.org/3/' . $movie->category . '/' . $external_id->external_id . '?api_key=' . env('TMDB_API_KEY');
//                 $response = App\Movie::callCurl($url);
//                 $data[$movie->id] = $response;
//                 Log::info('Getting data for movie with ID [' . $movie->id . '] and TMDb ID [' . $external_id->external_id . ']');
//                 Log::info('Response', ['response' => $response]);
//                 $movie->poster_path = $data[$movie->id]->poster_path;
//                 $movie->backdrop_path = $data[$movie->id]->backdrop_path;
//                 $movie->save();
//             }
//         }
//         $i++;
//         if($i % 20 === 0) {
//             sleep(15);
//         }
//     }
//     echo 'Finished!';
// });
