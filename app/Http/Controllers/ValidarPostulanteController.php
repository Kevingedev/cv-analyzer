<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Hability;
use App\Models\Position;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ValidarPostulanteController extends Controller
{
    //
    public function index($id){



        return view('validar_postulante');
    }

    public function approve($id)
    {
        $document = Document::findOrFail($id);

        //dd($document);
        $document->approved = '1';
        $document->save();

        // Redirige a la vista home
        //all-documents
        return redirect()->route('documents')->with('success', 'Documento Aprobado con éxito');
    }

    public function getPredictionFromPython($id){
        $document = Document::find($id);
        $text = $this->limpiarTexto($document->content);

        //dd($text);

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
        $output =trim($process->getOutput());
        
        //$outputJson = json_encode($output);
        //dd($outputJson);
        //return $outputJson;
        // Decodificar el JSON de la salida
        $result = json_decode($output, true);

        //return $result;

        $habilities = Hability::where('position_id', '=', $document->position_id)->get();

        //dd($habilities[0]->name);
        //$matches = [];
        //$counter = 0;
        //$minWordMatches = 2; // Número mínimo de palabras que deben coincidir

        /* foreach ($habilities as $hability) {
            
            foreach ($result['coincidencias'] as $coincidencia) {
                 */
                /* if (
                    stripos($coincidencia, $hability) !== false || 
                    stripos($hability, $coincidencia !== false)) {


                        if (!in_array($hability, $matches)) {
                            $matches[] = $hability; 
                        }
                    break;
                } */
                 

                /* $habilityWords = explode(' ', strtolower($hability));
                $coincidenciaWords = explode(' ', strtolower($coincidencia));

                $commonWords = array_intersect($habilityWords, $coincidenciaWords);

                if (count($commonWords) >= $minWordMatches) {
                    if (!in_array($hability, $matches)) {
                        $matches[] = $hability;
                    }
                    break;
                } */

            /* } 

        } */
        
        $coincidencias = $result['coincidencias'];

        $matches = Hability::where(function ($query)
        use ($coincidencias){
            foreach ($coincidencias as $coincidencia) {

                if ($coincidencia == 'c')  $coincidencia = 'c++'; 
                
                $query->orWhere('name', 'like', "%$coincidencia%");
            }
        })->where('position_id', $document->position_id)->get();



        $position = Position::find($document->position_id);

        $result_prediction = false;
        if ($position->name == $result['prediccion']) {
            $result_prediction = true;
        }

        $approvalPercentage = $this->approval_percentage(count($matches), count($habilities));

        //dd($matches);
        //return $result;
        // Retornar la vista con los resultados
        return view('validar_postulante', [
            // 'fileName' => $document->name,
            // 'text' => $text,
            'prediction' => $result['prediccion'],
            'position' => $position->name,
            'result' => $result_prediction,
            'matches' => $matches,
            'approvalPercentage' => $approvalPercentage,
            'id' => $id
        ]);

    }

    function limpiarTexto($texto) {
        // Eliminar caracteres no alfanuméricos, excepto ciertos signos de puntuación y espacios, manteniendo la codificación UTF-8
        $textoLimpio = preg_replace('/[^\p{L}\p{N}@.,()\-:;¡!¿?\s]+/u', '', $texto);

        // Eliminar múltiples espacios consecutivos
        $textoLimpio = preg_replace('/\s+/', ' ', $textoLimpio);

        // Eliminar espacios en blanco al inicio y al final del texto
        $textoLimpio = trim($textoLimpio);

        return $textoLimpio;
    }

    function approval_percentage($totalMatches, $totalHabilities){

        if ($totalMatches > 0 && $totalHabilities > 0) {
            $approvalPercentage =  (($totalMatches / $totalHabilities)*100);
        }else{
            $approvalPercentage = 0;
        }

        return $approvalPercentage;

    }

    
}
