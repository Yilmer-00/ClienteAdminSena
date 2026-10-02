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
        $trainigCenters = $this->fetchDataFromApi($url . '/training-centers');

        return response()->json([
            'success' => true,
            'data' => $trainigCenters
        ], 200);
    }

    /**
     * Almacenar un nuevo centro de formación enviándolo a la API.
     */
    public function store(Request $request)
    {
        // Validar los datos que llegan
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::post($url . '/training-centers', [
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return response()->json($response->json(), $response->status());
    }

    /**
     * Mostrar los detalles de un centro de formación específico consumiendo la API.
     */
    public function show($id)
    {
        $url = env('URL_SERVER_API');
        $trainigCenter = $this->fetchDataFromApi($url . '/training-centers/' . $id);

        return response()->json([
            'success' => true,
            'data' => $trainigCenter
        ], 200);
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

        return response()->json($response->json(), $response->status());
    }

    /**
     * Eliminar un centro de formación de la API.
     */
    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::delete($url . '/training-centers/' . $id);

        return response()->json($response->json(), $response->status());
    }
}
