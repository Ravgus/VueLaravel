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

Route::get('/', function () {
    return view('chat');
});

Route::post('/messages', function (\Illuminate\Http\Request $request) {
    //event(new \App\Events\Message($request->input('body')));
    event(new \App\Events\PrivateMessage($request->all()));
});

Route::get('/room/{room}', function (\App\Room $room) {
    return view('room', ['room' => $room]);
});

Route::get('/start', 'StartController@index');
Route::get('/start/get-json', 'StartController@getJson');
Route::get('/start/data-chart', 'StartController@chartData');
Route::get('/start/random-chart', 'StartController@chartRandom');
Route::get('/start/socket-chart', 'StartController@newEvent');
Route::get('/start/send-message', 'StartController@sendMessage');
Route::get('/start/send-private-message', 'StartController@sendPrivateMessage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/add_user', function () {
    \App\User::create(['name' => 'user3', 'email' => 'user3@gmail.com', 'password' => bcrypt(123456)]);
});



