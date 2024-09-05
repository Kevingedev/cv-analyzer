<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentContrller extends Controller
{

    public function index($fileName)
    {
        return view('documents.index', ['fileName' => $fileName]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'document.required' => 'Sube un documento primero.',
            'document.file' => 'Solo puedes agregar Documentos.',
            'document.mimes' => 'El archivo debe ser de tipo: pdf, doc, docx.',
            'document.max' => 'El archivo no puede exceder los 10MB.',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Obtiene el nombre del archivo sin extensión
            $extension = $file->getClientOriginalExtension(); // Obtiene la extensión del archivo
            $filePath = $file->storeAs('documents', $fileName . '.' . $extension, 'public'); // Guarda el archivo con el nombre original
        
            if (in_array($extension, ['doc', 'docx'])) {
                try {
                    // Uso de Controlador para convertir WORD a PDF
                    $conversionController = new DocumentConversionController();
                    $pdfFileName = $fileName . '.pdf'; // Nombre del archivo PDF con el nombre original
                    $pdfPath = $conversionController->convertToPdf(storage_path('app/public/' . $filePath), storage_path('app/public/documents/' . $pdfFileName));
        
                    // Eliminar el archivo de word
                    unlink(storage_path('app/public/' . $filePath));
        
                    return redirect()->route('documents.index', ['fileName' => $pdfFileName])
                                     ->with('success', 'Documento Word convertido a PDF con éxito');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al convertir el documento: ' . $e->getMessage());
                }
            }
            
            // Si es archivo PDF solo hacer esto:
            return redirect()->route('documents.index', ['fileName' => $fileName . '.' . $extension])
                             ->with('success', 'Documento subido con éxito');
        }
        return back()->with('error', 'No se pudo subir el documento');

    }
}
