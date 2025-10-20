<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DocumentController::class, 'index'])->name('home');
Route::get('/gerar/{tipo}', [DocumentController::class, 'create'])->name('document.create');
Route::post('/gerar/{tipo}', [DocumentController::class, 'generate'])->name('document.generate');


Route::post('/pagar', [PaymentController::class, 'create'])->name('payment.create');
Route::get('/pagamento/sucesso', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/pagamento/falha', [PaymentController::class, 'failure'])->name('payment.failure');
Route::get('/pagamento/pendente', [PaymentController::class, 'pending'])->name('payment.pending');

