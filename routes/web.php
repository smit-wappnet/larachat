<?php

use App\Models\Message;
use App\Events\SendMessage;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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


// Guest User
Route::get('/home', [AuthController::class, 'signin_view'])->middleware('guest')->name("welcome");
Route::get('/', [AuthController::class, 'signin_view'])->middleware('guest')->name("welcome");


Route::get('/signin', [AuthController::class, 'signin_view'])->middleware('guest')->name("auth.signin");
Route::post('/signin', [AuthController::class, 'signin'])->middleware('guest');

Route::get('/signup', [AuthController::class, 'signup_view'])->middleware('guest')->name("auth.signup");
Route::post('/signup', [AuthController::class, 'signup'])->middleware('guest');

Route::get('/forgot-password', [AuthController::class, 'forgot_password_view'])->middleware('guest')->name('auth.forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgot_password'])->middleware('guest');

Route::get('/reset-password/{token}', [AuthController::class, 'reset_password_view'])->middleware('guest')->name('password.reset');
Route::post('/reset-password/{token}', [AuthController::class, 'reset_password'])->middleware('guest')->name("auth.reset-password");


Route::get('/dashboard', [AuthController::class, 'dashboard'])->name("dashboard")->middleware('auth');

Route::post('/send', function (Request $request) {

    $message = new Message();
    $user = Auth::user();
    $message->mfrom = $user->id;
    $message->mto = $request->mto;
    $message->message = $request->message;
    $message->save();
    event(
        new SendMessage($message)
    );
    $arr = $message->toArray();
    $arr['tid'] = $request->tid;
    return $arr;
});


Route::get('/user/{user}', function (User $user) {
    $uid = Auth::user()->id;
    $cid = $user->id;
    $messages = Message::where('mfrom', $uid)->where('mto', $cid)->orWhere('mfrom', $cid)->where('mto', $uid)->get();
    return ["user" => $user, "messages" => $messages];
});
