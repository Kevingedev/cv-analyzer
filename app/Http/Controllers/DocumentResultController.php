<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class DocumentResultController extends Controller
{
    
    public function index($fileName)
    {
        $path = storage_path('app/public/documents/'.$fileName);
        $text = (new Pdf('C:\poppler-24.07.0\Library\bin\pdftotext.exe'))
            ->setPdf($path)
            ->text();

        // dd($text);
        return view('documents.index', 
            [
                'fileName' => $fileName,
                'text' => $text
            ]);
    }
}
