<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class DocumentResultController extends Controller
{
    
    public function index($id)
    {
        $text = "";
        // $path = storage_path('app/public/documents/'.$fileName);
        // $text = (new Pdf('D:\poppler-24.07.0\Library\bin\pdftotext.exe'))
        //     ->setPdf($path)
        //     ->text();

        // dd($text);
        $document = Document::find($id);

        $fileName = $document->name;
        $content = $document->content;

        $text = $content;
        // $text = cleanText($content);
        // dd($text);

        return view('documents.index', 
            [
                'fileName' => $fileName,
                'text' => $text,
                'id' => $id
            ]);
    }
     
}
// Función para limpiar caracteres extraños del texto
// function cleanText($text) {
//     $text = str_replace(['“', '”'], '', $text);

//     $text = preg_replace('/\s+/', ' ', $text);

//     $text = str_replace("\f", '', $text);

//     $text = trim($text);

//     $text = preg_replace('/\s+/', ' ', $text);  

//     return $text;
// }  
