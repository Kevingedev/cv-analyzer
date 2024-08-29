<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentContrller extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filePath = $file->store('documents', 'public');

            // Aquí puedes hacer lo que necesites con el archivo, como guardar la ruta en la base de datos
            return back()->with('success', 'Documento subido con éxito');
        }

        return back()->with('error', 'No se pudo subir el documento');
    }
}
