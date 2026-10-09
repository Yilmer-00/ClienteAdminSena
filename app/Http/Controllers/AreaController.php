<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
{

    //Método privado para manejar llamadas HTTP repetitivas (GET)

    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }


    //Mostrar una lista de todas las áreas consumiendo la API.

    public function index()
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/areas');

        // Extrae los datos de forma segura (si viene envuelto en 'data' o directo)
        $areas = is_array($response) && isset($response['data']) ? $response['data'] : ($response ?? []);

        return view('areas.index', compact('areas'));
    }


    //Mostrar el formulario para registrar una nueva área.

    public function create()
    {
        return view('areas.create');
    }


    //Almacenar una nueva área enviándola a la API.

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::post($url . '/areas', [
            'name' => $request->name,
        ]);

        if ($response->successful()) {
            return redirect()->route('area.index')->with('success', 'areas creada correctamente.');
        }

        return redirect()->route('area.index')->with('success', 'Área creada correctamente.');
    }


    //Mostrar los detalles de un área específica consumiendo la API.

    public function show($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/areas/' . $id);

        $area = is_array($response) && isset($response['data']) ? $response['data'] : $response;

        return view('areas.show', compact('area'));
    }


    //Mostrar el formulario para editar un área existente.

    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/areas/' . $id);

        $area = is_array($response) && isset($response['data']) ? $response['data'] : $response;

        return view('areas.edit', compact('area'));
    }


    //Actualizar un área existente en la API.

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::put($url . '/areas/' . $id, [
            'name' => $request->name,
        ]);

        if ($response->successful()) {
            return redirect()->route('area.index')->with('success', 'Área actualizada correctamente.');
        }

        return back()->withErrors('Error al actualizar el área en la API.')->withInput();
    }


    //Eliminar un área de la API.

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::delete($url . '/areas/' . $id);

        return redirect()->route('area.index')->with('success', 'Área eliminada correctamente.');
    }
}
