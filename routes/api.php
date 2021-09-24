<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

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

Route::post('/admin/register', [AdminAuthController::class, 'register']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

Route::post('/customer/register', [CustomerController::class, 'customerRegister']);
Route::post('/customer/login', [CustomerController::class, 'login']);
Route::post('/customer/logout', [CustomerController::class, 'logout']);




Route::group(['prefix' => 'admin','middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
	Route::get('/customers', [CustomerController::class, 'getCustomers']);
	Route::get('/customers/average', [CustomerController::class, 'getCustomersAverage']);		
});

Route::group(['prefix' => 'customer','middleware' => ['assign.guard:customers','jwt.auth']],function ()
{

});