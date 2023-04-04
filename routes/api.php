<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\TransaksiController;
// use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login',[AuthController::class,'login']);

Route::group(['middleware' => ['jwt.verify']], function () {

    //USER
    Route::get('/getuser', [UserController::class, 'getuser']);
    Route::get('/getuser/{id}', [UserController::class, 'getsatuuser']);
    Route::post('/createuser', [UserController::class, 'createuser']);
    Route::put('/updateuser/{id}', [UserController::class, 'updateuser']);
    Route::delete('/deleteuser/{id}', [UserController::class, 'deleteuser']);

    //KELAS
    Route::get('/getkamar', [KamarController::class, 'getkamar']);
    Route::get('/getkamar/{id}', [KamarController::class, 'kamarbyid']);
    Route::post('/createkamar', [KamarController::class, 'createkamar']);
    Route::put('/updatekamar/{id}', [KamarController::class, 'updatekamar']);
    Route::delete('/deletekamar/{id}', [KamarController::class, 'deletekamar']);

    //TRANSAKSI
    Route::get('/gettransaksi', [TransaksiController::class, 'gettransaksi']);
    Route::get('/gettransaksi/{id}', [TransaksiController::class, 'pilihtransaksi']);
    Route::post('/createtransaksi', [TransaksiController::class, 'createtransaksi']);
    Route::put('/updatetransaksi/{id}', [TransaksiController::class, 'updatetransaksi']);
    Route::delete('/deletetransaksi/{id}', [TransaksiController::class, 'deletetransaksi']);

});
