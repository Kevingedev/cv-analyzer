<?php

use App\Http\Controllers\DocumentContrller;
use App\Http\Controllers\DocumentResultController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ValidarPostulanteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/upload', [DocumentContrller::class, 'store'])->name('upload');

Route::get('/documents/{id}', [DocumentResultController::class, 'index'])->name('documents.index');

Route::get('/validar-postulante/{id}', [ValidarPostulanteController::class, 'index'])->name('validar.postulante');

