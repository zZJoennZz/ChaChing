<?php

use App\Http\Controllers\api\BorrowTransferController;
use App\Http\Controllers\api\BranchController;
use App\Http\Controllers\api\ClusterController;
use App\Http\Controllers\api\DisposalController;
use App\Http\Controllers\api\MemberController;
use App\Http\Controllers\api\MiscController;
use App\Http\Controllers\api\PassportAuthController;
use App\Http\Controllers\api\PositionController;
use App\Http\Controllers\api\RDSController;
use App\Http\Controllers\api\RDSRecordController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('register', [PassportAuthController::class, 'register']);
        Route::post('logout', [PassportAuthController::class, 'logout']);
        Route::post('check_token', [PassportAuthController::class, 'is_valid']);

        Route::post('get-unsync', [MemberController::class, 'get_unsync']);
    });

    Route::middleware('guest')->group(function () {
        Route::post('login', [PassportAuthController::class, 'login']);
        Route::post('forgot-password', [PassportAuthController::class, 'forgot_password']);
    });
});
