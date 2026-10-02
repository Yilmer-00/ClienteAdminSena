<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
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
     * Mostrar una lista de todas las áreas consumiendo la API.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');
        $areas = $this->fetchDataFromApi($url . '/areas');

        return response()->json([
            'success' => true,
            'data' => $areas
        ], 200);
    }

    /**
     * Almacenar una nueva área enviándola a la API.
     */
    public function store(Request $request)
    {
        // Validamos que el nombre sea obligatorio
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::post($url . '/areas', [
            'name' => $request->name,
        ]);

        return response()->json($response->json(), $response->status());
    }

    /**
     * Mostrar los detalles de un área específica consumiendo la API.
     */
    public function show($id)
    {
        $url = env('URL_SERVER_API');
        $area = $this->fetchDataFromApi($url . '/areas/' . $id);

        return response()->json([
            'success' => true,
            'data' => $area
        ], 200);
    }

    /**
     * Actualizar un área existente en la API.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::put($url . '/areas/' . $id, [
            'name' => $request->name,
        ]);

        return response()->json($response->json(), $response->status());
    }

    /**
     * Eliminar un área de la API.
     */
    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::delete($url . '/areas/' . $id);

        return response()->json($response->json(), $response->status());
    }
}
