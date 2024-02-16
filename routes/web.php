<?php

use App\Http\Controllers\listingController;
use App\Http\Controllers\userController;
use App\Models\listing;
use Illuminate\Http\Request;
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
//index = shpw all listings 
//show = show single listing 
//create = show form to create new listing 
//store = store new listing 
//edit = show form to edit listing 
//update = update listing 
//destroy= delete lisitng 

//All listing
Route::get('/', [listingController::class,'index']);

//show create form 
Route::get('/listings/create',[listingController::class,'create'])->middleware('auth');


//Single listing
Route::get ('/listings/{listing}',[listingController::class,'show']);

//store form 
Route::post('/listings', [listingController::class, 'store'])->middleware('auth');

//Edit the form 
Route::get('/listings/{listing}/edit', [listingController::class , 'edit'])->middleware('auth');

//update to save the edit
Route::put('/listings/{listing}',[listingController::class , 'update'])->middleware('auth');

//Delete the listing 
Route::delete('/listings/{listing}',[listingController::class, 'destroy'])->middleware('auth');
//manage listing 

Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//Register /create From
Route::get('/register', [userController::class,'create'])->middleware('guest');

//create new user 
Route::post('/users',[userController::class, 'store']);

//logout the user 
Route::post('/logout',[userController::class,'logout'])->middleware('auth');
//login form
Route::get('/login',[userController::class, 'login'])->name('login')->middleware('guest');
//login the user
Route::post('/users/authenticate',[userController::class , 'authenticate']);

