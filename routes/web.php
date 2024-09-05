<?php

use App\Http\Controllers\DocumentContrller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload', [DocumentContrller::class, 'store'])->name('upload');

Route::get('/documents/{fileName}', [DocumentContrller::class, 'index'])->name('documents.index');


