<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FornecedorController;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('fornecedores', [FornecedorController::class, 'index']);
    Route::post('fornecedores', [FornecedorController::class, 'store']);
});
