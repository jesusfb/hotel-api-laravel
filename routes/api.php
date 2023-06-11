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

// Route::group(['middleware' => ['jwt.verify']], function () {

Route::group(['middleware' => ['jwt.verify']], function () {

    Route::group(['middleware' => ['api.admin']], function () {

        // Admin-Feedback
        Route::get('/getFeedback', [TransaksiController::class, 'getFeedback']);
        Route::get('/selectFeedback/{id}', [TransaksiController::class, 'selectFeedback']);
        Route::get('/countFeedback', [TransaksiController::class, 'countFeedback']);

        // Admin-User
        Route::get('/getuser', [UserController::class, 'getuser']);
        Route::post('/createuser', [UserController::class, 'createuser']);
        Route::get('/getuser/{id}', [UserController::class, 'getsatuuser']);
        Route::post('/updateuser/{id}', [UserController::class, 'updateuser']);
        Route::delete('/deleteuser/{id}', [UserController::class, 'deleteuser']);

    });

    Route::group(['middleware' => ['api.resepsionis']], function () {
        Route::get('/history', [TransaksiController::class, 'history']);
        Route::get('/notconfirmed', [TransaksiController::class, 'notconfirmed']);
    });
});

//USER
Route::post('/feedback', [TransaksiController::class, 'feedback']);

//KAMAR
Route::get('/getkamar', [KamarController::class, 'getkamar']);
Route::get('/filterKamar/{person}', [KamarController::class, 'filterKamar']);
Route::get('/getkamar/{id}', [KamarController::class, 'kamarbyid']);
Route::post('/createkamar', [KamarController::class, 'createkamar']);
Route::put('/updatekamar/{id}', [KamarController::class, 'updatekamar']);
Route::delete('/deletekamar/{id}', [KamarController::class, 'deletekamar']);

Route::post('/uploadFoto/{id}', [KamarController::class, 'uploadFoto']);
//TRANSAKSI
Route::get('/gettransaksi', [TransaksiController::class, 'gettransaksi']);
Route::get('/cekbooking/{id}', [TransaksiController::class, 'cekbooking']);

Route::get('/gettransaksi/{id}', [TransaksiController::class, 'pilihtransaksibynama']);
Route::get('/gettransaksibyid/{id}', [TransaksiController::class, 'pilihtransaksibyid']);
Route::post('/createtransaksi', [TransaksiController::class, 'createtransaksi']);
Route::put('/updatetransaksi/{id}', [TransaksiController::class, 'updatetransaksi']);
Route::put('/konfirmasi/{id}', [TransaksiController::class, 'konfirmasi']);
Route::delete('/deletetransaksi/{id}', [TransaksiController::class, 'deletetransaksi']);
Route::delete('/deletetransaksi', [TransaksiController::class, 'deletealltransaksi']);
// RESEPSIONIS
Route::get('/confirmed', [TransaksiController::class, 'confirmed']);
Route::get('/ongoing', [TransaksiController::class, 'ongoing']);
Route::get('/dibersihkan', [TransaksiController::class, 'dibersihkan']);

// Route::get('/cekbooking', [TransaksiController::class, 'cekbooking']);

Route::put('/checkin/{id}', [TransaksiController::class, 'checkin']);
Route::put('/checkout/{id}/{id_kamar}', [TransaksiController::class, 'checkout']);
Route::put('kamar_done/{id}/{id_kamar}', [TransaksiController::class, 'kamardone']);
// });
