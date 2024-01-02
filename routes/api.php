<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Admin0Controller;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', [AuthController::class, 'Register']);
Route::post('/login', [AuthController::class, 'Login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/forgetpassword', [AuthController::class, 'forgetpassword']);
    Route::post('/resetpassword', [AuthController::class, 'resetpassword']);
    Route::post('/search', [AuthController::class, 'search']);
    Route::post('/logout', [AuthController::class, 'Logout']);
    Route::post('/show', [AuthController::class, 'show']);
    Route::post('/order', [OrderController::class, 'addproduct']);
    Route::get('/getProduct', [AuthController::class, 'getProduct']);
    Route::get('/getCategories', [AuthController::class, 'getCategories']);
    Route::get('/getOrderDetailsid', [AuthController::class, 'getOrderDetailsid']);
    Route::post('/RefreshToken', [AuthController::class, 'RefreshToken']);
    Route::post('/showpayementid', [AuthController::class, 'showpayementid']);



});



// ...............................................................................


    Route::post('/admin/login', [Admin0Controller::class, 'Login']);
    Route::post('/admin/register', [Admin0Controller::class, 'register']);
    Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/admin/logout', [Admin0Controller::class, 'Logout']);
    Route::post('/admin/InsertProduct', [Admin0Controller::class, 'InsertProduct']);
    Route::post('/admin/InsertCategories', [Admin0Controller::class, 'InsertCategories']);
    Route::get('/admin/getProduct', [Admin0Controller::class, 'getProduct']);
    Route::get('/admin/getCategories', [Admin0Controller::class, 'getCategories']);
    Route::get('/admin/getOrderDetails', [Admin0Controller::class, 'getOrderDetails']);
    Route::post('/admin/status', [Admin0Controller::class, 'stauts']);
    Route::post('/admin/payment_status', [Admin0Controller::class, 'paid']);
    Route::get('/admin/expiration', [Admin0Controller::class, 'expiration']);
    Route::get('/admin/all_expiration', [Admin0Controller::class, 'all_expiration']);
    Route::get('/admin/delet_expiration', [Admin0Controller::class, 'deleteExpiration']);
    Route::get('/admin/notification', [Admin0Controller::class, 'notification']);
    Route::post('/admin/showpayement', [Admin0Controller::class, 'showpayement']);


});
