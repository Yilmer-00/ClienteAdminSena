<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrainigCenterController extends Controller
{
    /**
     * Método privado para manejar llamadas HTTP repetitivas (GET)
     */
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }

    /**
     * Mostrar una lista de todos los centros de formación consumiendo la API.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/training-centers');

        // Si la respuesta es nula o no es arreglo, retorna un arreglo vacío para evitar errores
        $trainigCenters = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('training-centers.index', compact('trainigCenters'));
    }

    /**
     * Mostrar el formulario para registrar un nuevo centro de formación.
     */
    public function create()
    {
        return view('training-centers.create');
    }

    /**
     * Almacenar un nuevo centro de formación enviándolo a la API.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::post($url . '/training-centers', [
            'name' => $request->name,
            'location' => $request->location,
        ]);

        if ($response->successful()) {
            return redirect()->route('trainig-center.index')->with('success', 'Centro de formación creado correctamente.');
        }

        return back()->withErrors('Error al registrar el centro de formación en la API.')->withInput();
    }

    /**
     * Mostrar los detalles de un centro de formación específico consumiendo la API.
     */
    public function show($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/training-centers/' . $id);

        $trainigCenter = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('training-centers.show', compact('trainigCenter'));
    }

    /**
     * Mostrar el formulario para editar un centro de formación existente.
     */
    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/training-centers/' . $id);

        $trainigCenter = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('training-centers.edit', compact('trainigCenter'));
    }

    /**
     * Actualizar un centro de formación existente en la API.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::put($url . '/training-centers/' . $id, [
            'name' => $request->name,
            'location' => $request->location,
        ]);

        if ($response->successful()) {
            return redirect()->route('trainig-center.index')->with('success', 'Centro de formación actualizado correctamente.');
        }

        return back()->withErrors('Error al actualizar el centro de formación en la API.')->withInput();
    }

    /**
     * Eliminar un centro de formación de la API.
     */
    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::delete($url . '/training-centers/' . $id);

        return redirect()->route('trainig-center.index')->with('success', 'Centro de formación eliminado correctamente.');
    }
}
