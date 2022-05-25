<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ChangePasswordController;

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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/quotation/create', [QuotationController::class, 'store']);
    Route::get('/quotation/list', [QuotationController::class, 'index']);
    Route::post('/quotation/update/{id}', [QuotationController::class, 'update']);
    Route::post('/item/create', [ItemController::class, 'store']);
    Route::get('/item/list', [ItemController::class, 'index']);
    Route::post('/customer/create', [CustomerController::class, 'store']);
    Route::get('/customer/list', [CustomerController::class, 'index']);
    Route::get('/customer/tally', [CustomerController::class, 'tallyCustomer']);
    Route::post('/change-password', [ChangePasswordController::class, 'store']);
    Route::get('/fetch', [AuthController::class, 'fetch']);
});




