<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// ثبت نام کاربر
Route::post('/register',[PassportAuthController::class,'register']);

//ورود کاربر
Route::post('/login',[PassportAuthController::class,'login']);

//ثبت اکانت که شامل اطلاعات حساب بانکی فرد می باشد
Route::post('/account/register',[AccountController::class,'register'])->middleware('auth:api');

//نمایش اطلاعات یک اکانت برای یوزر
Route::get('/account/find',[AccountController::class,'account'])->middleware('auth:api');

//انتقال پول از اکانت یوزر برای یک یوزر دیگر و برای هر یوزر یک اکانت در نظر گرفته شده است
Route::post('/transfer',[TransactionController::class,'transfer'])->middleware('auth:api');

//تمام تراکنش های یک کاربر را بر می گرداند
Route::get('/transactions',[TransactionController::class,'transactions'])->middleware('auth:api');


