<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogsController;
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
    return view('public.p_homePage');
})->name('p_homePage');
Route::get('/about', function () {
    return view('public.p_about');
})->name('p_about');

Route::get('/results', function () {
    return view('public.p_results');
})->name('p_results');



Route::group(['middleware' => 'auth'], function() {

        Route::group([
            'prefix' => 'admin',
            'middleware' => 'is_admin',
            'as' => 'admin.',
        ], function() {
            Route::get('dashboard', function () { return view('admin.a_home'); })->name('dashboard');
            Route::get('users', [UsersController::class, 'getData'])->name('a_users');
            Route::get('websites', function () { return view('admin.a_websites'); })->name('a_websites');
            Route::get('logs', [LogsController::class, 'getData'])->name('a_logs');
        });



        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
