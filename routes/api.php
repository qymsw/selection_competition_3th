<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('/test',[AdminController::class,'test']);
        Route::post('/login',[AdminController::class,'login']);
        Route::post('/logout',[AdminController::class,'logout']);
        Route::get('/size',[AdminController::class,'getAllSizes']);
        Route::patch('/size/{size_id}',[AdminController::class,'upDateSize']);
        Route::get('/frame',[AdminController::class,'getAllFrames']);
        Route::patch('/frame/{frame_id}',[AdminController::class,'updateFrame']);
        Route::get('/order',[AdminController::class,'getAllOrders']);
        Route::post('/order/cancel/{order_id}',[AdminController::class,'cancelOrder']);
        Route::post('/order/complete/{order_id}',[AdminController::class,'completeOrder']);
        Route::get('/user',[AdminController::class,'getAllUsers']);
        Route::post('/user/reset/{user_id}',[AdminController::class,'resetUser']);
        Route::delete('/user/{user_id}',[AdminController::class,'deleteUser']);
        Route::post('/cart/reset/{user_id}',[AdminController::class,'resetCart']);
        Route::get('/admin',[AdminController::class,'getAllAdmin']);
        Route::post('/admin',[AdminController::class,'createAdmin']);
        Route::post('/admin/reset/{admin_id}',[AdminController::class,'resetAdmin']);
        Route::delete('/admin/{admin_id}',[AdminController::class,'deleteAdmin']);
    });
    Route::prefix('client')->group(function(){
        Route::post('/login',[UserController::class,'login']);
        Route::post('/register',[UserController::class,'register']);
        Route::post('/logout',[UserController::class,'logout']);
        Route::post('/user/reset',[UserController::class,'resetUser']);
        Route::get('/size',[UserController::class,'getAllSize']);
        Route::post('/photo',[UserController::class,'uploadPhoto']);
        Route::delete('/photo/{photo_id}',[UserController::class,'deletePhoto']);
        Route::post('/photo/frame/{photo_id}/{frame_id}',[UserController::class,'setFrameForPhoto']);
        Route::get('/frame',[UserController::class,'getAllFrame']);
        Route::get('/cart',[UserController::class,'getCart']);
        Route::post('/cart',[UserController::class,'addPhotosToCart']);
        Route::delete('/cart/photo/{photo_id}',[UserController::class,'deletePhotoFromCart']);
        Route::get('/order',[UserController::class,'getOrder']);
        Route::post('/order',[UserController::class,'createOrder']);
        Route::post('/order/cancel/{order_id}',[UserController::class,'cancelOrder']);
    });
});