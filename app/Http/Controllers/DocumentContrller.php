<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class DocumentContrller extends Controller
{

    

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'position_id' => 'required|exists:positions,id',
        ], [
            'document.required' => 'Sube un documento primero.',
            'document.file' => 'Solo puedes agregar Documentos.',
            'document.mimes' => 'El archivo debe ser de tipo: pdf, doc, docx.',
            'document.max' => 'El archivo no puede exceder los 10MB.',
            'position_id.required' => 'Selecciona un Puesto de trabajo.',
        ]);

        
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Obtiene el nombre del archivo sin extensión
            $extension = $file->getClientOriginalExtension(); // Obtiene la extensión del archivo
            $filePath = $file->storeAs('documents', $fileName . '.' . $extension, 'public'); // Guarda el archivo con el nombre original
        
            $position_id = $request->input('position_id');

            if (in_array($extension, ['doc', 'docx'])) {
                try {
                    // Uso de Controlador para convertir WORD a PDF
                    $conversionController = new DocumentConversionController();
                    $pdfFileName = $fileName . '.pdf'; // Nombre del archivo PDF con el nombre original
                    $pdfPath = $conversionController->convertToPdf(storage_path('app/public/' . $filePath), storage_path('app/public/documents/' . $pdfFileName));
        
                    // Eliminar el archivo de word
                    unlink(storage_path('app/public/' . $filePath));

                    // $position_id = $request->input('position_id');
                    // dd($position_id);

                    Document::create([
                        'position_id' => $position_id,
                        'name' => $filePath,
                    ]);
        
                    return redirect()->route('documents.index', ['fileName' => $pdfFileName])
                                     ->with('success', 'Documento Word convertido a PDF con éxito');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al convertir el documento: ' . $e->getMessage());
                }
            }

            $file_name = $fileName . '.' . $extension;
            $path = storage_path('app/public/documents/'.$file_name); //guardando lel documento y obteniendo la ruta
            $text = (new Pdf('D:\poppler-24.07.0\Library\bin\pdftotext.exe')) //Obteniendo el texto de documento
            ->setPdf($path)
            ->text();
            $new_document = Document::create([
                'position_id' => $position_id, //posicion de trabajo
                'name' => $file_name, // ruta del documento guardado 
                'content' => $text, // Contenido del documento
            ]);
            // Si es archivo PDF solo hacer esto:
            return redirect()->route('documents.index', ['id' => $new_document->id])
                             ->with('success', 'Documento subido con éxito');
        }
        return back()->with('error', 'No se pudo subir el documento');

    }
}
