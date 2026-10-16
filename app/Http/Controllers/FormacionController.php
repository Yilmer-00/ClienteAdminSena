<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class FormacionController extends Controller
{

    //Método privado para manejar llamadas HTTP repetitivas

    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }


    //Muestra la lista de formaciones consumiendo la API.

    public function index()
    {
        $url = env('URL_SERVER_API');

        $formaciones = $this->fetchDataFromApi($url . '/formaciones');

        return view('formaciones.index', compact('formaciones'));
    }


    //Muestra el formulario de creación cargando las áreas y centros de formación desde la API.

    public function create()
    {
        $url = env('URL_SERVER_API');

        $areas = $this->fetchDataFromApi($url . '/areas');
        $trainingCenters = $this->fetchDataFromApi($url . '/training-centers');

        // Cambia 'formaciones.create' por 'formaciones.store' si guardaste el archivo con ese nombre
        return view('formaciones.store', compact('areas', 'trainingCenters'));
    }


    //Almacena una nueva formación enviando los datos por POST a la API.

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        Http::post($url . '/formaciones', $request->all());

        return redirect()->route('formaciones.index')->with('success', '¡Formación creada con éxito!');
    }


    // Muestra los datos necesarios para evaluar aspirantes de una formación específica.

    public function evaluarAspirantes($id)
    {
        $url = env('URL_SERVER_API');

        $formacion = $this->fetchDataFromApi($url . '/formaciones/' . $id . '/evaluar');

        return view('formaciones.evaluar', compact('formacion'));
    }


    //Aprueba a un aspirante actualizando su estado mediante la API.

    public function aprobarAspirante($id)
    {
        $url = env('URL_SERVER_API');

        Http::put($url . '/apprentices/' . $id . '/aprobar', [
            'estado' => 'inscrito'
        ]);

        return back();
    }


    //Rechaza a un aspirante actualizando su estado mediante la API.

    public function rechazarAspirante($id)
    {
        $url = env('URL_SERVER_API');

        Http::put($url . '/apprentices/' . $id . '/rechazar', [
            'estado' => 'rechazado'
        ]);

        return back();
    }
}
