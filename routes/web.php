<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\followController;
use App\Http\Controllers\reviewController;

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

Route::get('/admins-only', function(){
    return 'admins only';})->middleware('can:visitAdminPages');

//User Related routes
Route::get('/', [userController::class, 'showCorrectHomepage'])->name('login');
Route::post('/register', [userController::class, 'register'])->middleware('guest');
Route::post('/login', [userController::class, 'login'])->middleware('guest');
Route::post('/logout', [userController::class, 'logout'])->middleware('mustBeLoggedIn');
Route::get('/manage-avatar', [userController::class, 'showAvatarForm'])->middleware('mustBeLoggedIn');;
Route::post('/manage-avatar', [userController::class, 'storeAvatar'])->middleware('mustBeLoggedIn');;

//Review Related routes
Route::get('/write-review', [reviewController::class,'showReviewForm'])->middleware('mustBeLoggedIn');
Route::post('/write-review', [reviewController::class,'saveReview'])->middleware('mustBeLoggedIn');
Route::get('/review/{review}', [reviewController::class,'viewSingleReview'])->middleware('mustBeLoggedIn');
Route::delete('/review/{review}', [reviewController::class,'delete'])->middleware('can:delete,review');
Route::get('/review/{review}/edit',[reviewController::class,'showEditForm'])->middleware('can:update,review');
Route::put('/review/{review}',[reviewController::class,'actuallyUpdate'])->middleware('can:update,review'); 
Route::get('/search/{term}', [reviewController::class,'search']);


//Profile Related routes
Route::get('/profile/{user:username}', [userController::class,'profile'])->middleware('mustBeLoggedIn');
Route::get('/profile/{user:username}/followers', [userController::class,'profileFollowers'])->middleware('mustBeLoggedIn');
Route::get('/profile/{user:username}/following', [userController::class,'profileFollowing'])->middleware('mustBeLoggedIn');

//Follow Related routes
Route::post('/create-follow/{user:username}',[followController::class, 'createFollow'])->middleware('mustBeLoggedIn');
Route::post('/remove-follow/{user:username}',[followController::class, 'removeFollow'])->middleware('mustBeLoggedIn');