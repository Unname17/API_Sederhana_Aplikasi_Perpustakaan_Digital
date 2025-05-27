
<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BookAuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\UserController;



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //Akun
    // Route::controller(UserController::class)->group(function(){
    //     Route::get('/user', 'index');
    //     Route::post('/user/store', 'store');
    //     Route::patch('/user/{id}/update', 'update');
    //     Route::get('/user/{id}','show');
    //     Route::delete('/user/{id}', 'destroy');
    // });

    Route::apiResource('user', UserController::class);
    Route::apiResource('author', AuthorsController::class);
    Route::apiResource('book', BooksController::class);
    Route::apiResource('loans', LoansController::class);
    Route::apiResource('bookDetails', BookAuthorsController::class);


});




