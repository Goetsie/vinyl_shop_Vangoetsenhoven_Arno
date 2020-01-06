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

//Route::get('/', function () {
//    //return view('welcome');
//    return 'The Vinyl Shop';
//});

// Generate errors on selfmade page
Route::get('mysillypage', function () {
    return abort('404');
    // abort with error 403 (custom error message)
    // return abort('403', 'My Silly Error');
});

Auth::routes();

Route::get('logout', 'Auth\LoginController@logout');

//Route::get('/home', 'HomeController@index')->name('home');

Route::view('/', 'home');

Route::get('shop', 'ShopController@index');
Route::get('shop/{id}', 'ShopController@show');
// Route naar de alternative shop page
Route::get('shop_alt', 'ShopController@alternate');

//Route::get('contact-us', function () {
//    //return 'Contact info';
//    return view('contact');
//});

// Dit is een andere manier (korter, niet altijd bruikbaar) om het vorige opteroepen.
//Route::view('contact-us', 'contact');

Route::get('contact-us', 'ContactUsController@show');
Route::post('contact-us', 'ContactUsController@sendEmail');


Route::get('contact-us', function () {
    $me = ['name' => env('MAIL_FROM_NAME')];
    return view('contact', $me);
});

// Email verification TEST
//Auth::routes(['verify' => true]);
//
//Route::get('profile', function () {
//    // Only verified users may enter...
//    Route::get('contact-us', 'ContactUsController@show');
//    Route::post('contact-us', 'ContactUsController@sendEmail');
//    Route::get('shop', 'ShopController@index');
//    Route::get('vertest', function () {
//        return'your email has been verified';
//    });
//})->middleware('verified');

// Group for authenticated & admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // In plaats van 404 bij admin wordt doorgewezen naar admin/records
    Route::redirect('/', 'records');
    // Route specific for the qryGenres function/querry with all the genres in JSON format (before recource route!)
    Route::get('genres/qryGenres', 'Admin\GenreController@qryGenres');
    Route::resource('genres', 'Admin\GenreController');
    Route::resource('users', 'Admin\UserController');
    Route::resource('users2', 'Admin\User2Controller', ['parameters' => ['users2' => 'user']]);
    Route::resource('records', 'Admin\RecordController');
});


Route::redirect('user', '/user/profile');
// Group for authenticated users(also admins than)
Route::middleware(['auth'])->prefix('user')->group(function () {
    // get the form
    Route::get('profile', 'User\ProfileController@edit');
    // uodate profile
    Route::post('profile', 'User\ProfileController@update');
    // Password routes
    Route::get('password', 'User\PasswordController@edit');
    Route::post('password', 'User\PasswordController@update');

});




