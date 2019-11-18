<!-- Moet niet gesloten worden als alleen maar php in bestand staat-->
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

// Group for admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // In plaats van 404 bij admin wordt doorgewezen naar admin/records
    Route::redirect('/', 'records');
    Route::get('records', 'Admin\RecordController@index');
});

Route::get('contact-us', function () {
    $me = ['name' => env('MAIL_FROM_NAME')];
    return view('contact', $me);
});



