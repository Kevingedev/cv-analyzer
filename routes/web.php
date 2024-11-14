<?php

use App\Http\Controllers\AllDocumentController;
use App\Http\Controllers\DocumentContrller;
use App\Http\Controllers\DocumentResultController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ValidarPostulanteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/import-cv', [CvController::class, 'index'])->name('import.cv');

Route::post('/upload', [DocumentContrller::class, 'store'])->name('upload');

Route::get('/documents/{id}', [DocumentResultController::class, 'index'])->name('documents.index');

Route::get('/validate-applicant/{id}', [ValidarPostulanteController::class, 'getPredictionFromPython'])->name('validar.postulante');

Route::post('/validate-applicant/approve/{id}', [ValidarPostulanteController::class, 'approve'])->name('documents.approve');

Route::get('/all-documents', [AllDocumentController::class, 'index'])->name('documents');

