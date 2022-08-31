<?php

use App\Events\Playground;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/app', function(){
    return view('app');

});

Route::get('/reset-password/{token}', function($token){
    return view('auth.password-reset',[
        'token' => $token
    ]);
})
    ->middleware(['guest:'.config('fortify.guard')])
    ->name('password.reset');

if(App::environment('local'))
{
    Route::get('/play', function (){
        // return view('mail.welcome-mail');

        $user = \App\Models\User::factory()->make();

        \Illuminate\Support\Facades\Mail::to($user)
        ->send(new WelcomeMail($user));

        return null;
    });
}

Route::get('/playground', function(){
    event(new Playground);
    return null;
});
