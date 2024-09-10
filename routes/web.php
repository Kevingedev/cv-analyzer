<?php

use App\Http\Controllers\DocumentContrller;
use App\Http\Controllers\DocumentResultController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload', [DocumentContrller::class, 'store'])->name('upload');

Route::get('/documents/{fileName}', [DocumentResultController::class, 'index'])->name('documents.index');


