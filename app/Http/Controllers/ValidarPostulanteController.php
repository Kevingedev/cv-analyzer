<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ValidarPostulanteController extends Controller
{
    //
    public function index($id){



        return view('validar_postulante');
    }

    public function getPredictionFromPython($id){
        $document = Document::find($id);
        $text = $document->content;

        // Ruta a script de python
        $pythonScriptPath = storage_path('../python_scripts/validar_curriculum.py');
        $pythonExecutable = 'python';

        // Crear el comando que ejecutara el script de python

        $process = new Process([$pythonExecutable, $pythonScriptPath, $text]);
        $process->run();

        // Verificar si el script se ejecutó correctamente
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        // Obtener la salida del script de Python
        $output = $process->getOutput();
        
        // Decodificar el JSON de la salida
        $result = json_decode($output, true);


        // Retornar la vista con los resultados
        return view('validar_postulante', [
            // 'fileName' => $document->name,
            // 'text' => $text,
            'prediction' => $result['prediccion'],
            'matches' => $result['coincidencias'],
            'id' => $id
        ]);

    }
}
