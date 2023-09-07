<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/private', function () {
    // return response('Welcome! You are logged in.');
    $user = auth()->user();

    dd($user);
    $name = $user->name ?? 'User';
    $email = $user->email ?? '';

    return response("Hello {$name}! Your email address is {$email}.");
})->middleware('auth');
