<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\Searched_WebsitesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentsController;
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
Route::get('about', [CommentsController::class, 'getLatestThreeComments'])->name('p_about');

Route::get('leaderboard', [Searched_WebsitesController::class, 'getLeaderboardData'])->name('p_leaderboard');

//Route::get('/results', function () {
//    return view('public.p_results');
//})->name('p_results');


Route::any('/results', [Searched_WebsitesController::class, 'analyzeWebsite']);

Route::any('/results/{id}', [Searched_WebsitesController::class, 'getAnalyzedWebsitesData'])->name('p_results');

Route::group(['middleware' => 'auth'], function() {

        Route::group([
            'prefix' => 'admin',
            'middleware' => 'is_admin',
            'as' => 'admin.',
        ], function() {
            Route::get('dashboard', [HomeController::class, 'adminHome'])->name('dashboard');
            Route::get('users', [UsersController::class, 'getData'])->name('a_users');
            Route::get('webiste', [Searched_WebsitesController::class, 'getData'])->name('a_websites');
            Route::get('logs', [LogsController::class, 'getData'])->name('a_logs');
            Route::get('comments', [CommentsController::class, 'getData'])->name('a_comments');
            Route::delete('comments/remove', [CommentsController::class, 'removeComment'])->name('comment.remove');
            Route::delete('website/remove', [Searched_WebsitesController::class, 'removeWebsitesResults'])->name('website.remove');
            Route::patch('users/ban', [UsersController::class, 'ban'])->name('users.ban');
            Route::patch('users/admin', [UsersController::class, 'setAdmin'])->name('users.admin');
            Route::any('/comments-aprove/{id}', [CommentsController::class, 'commentAprove'])->name('comments-aprove');
        });


        Route::patch('/results', [CommentsController::class, 'addComment'])->name('comment.add');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';


// VAJAG safixot route kad noposto comment tad lai nescrapo velreiz to pašu url