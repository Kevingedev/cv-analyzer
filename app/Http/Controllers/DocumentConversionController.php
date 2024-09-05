<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;

class DocumentConversionController extends Controller
{
    public function convertToPdf($filePath, $pdfOutputPath)
    {
        // Configurar PHPWord para usar TCPDF como renderizador de PDF
        Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
        Settings::setPdfRendererPath(base_path('vendor/tecnickcom/tcpdf'));

        // Cargar el archivo Word
        $phpWord = IOFactory::load($filePath);

        // Crear un objeto de escritura PDF
        $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');

        // Guardar el archivo PDF con la ruta especificada
        $pdfWriter->save($pdfOutputPath);

        return $pdfOutputPath;
    }
}

//



