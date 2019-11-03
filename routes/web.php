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
Route::view('contact-us', 'contact');

// Group for admin
Route::prefix('admin')->group(function () {
    // In plaats van 404 bij admin wordt doorgewezen naar admin/records
    Route::redirect('/', 'records');
    Route::get('records', 'Admin\RecordController@index');
});
