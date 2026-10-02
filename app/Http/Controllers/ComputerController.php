<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComputerController extends Controller
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
     * Mostrar una lista de todos los computadores consumiendo la API.
     */
    public function index() // Ejemplo: env('URL_SERVER_API') . '/computers'
    {
        $url = env('URL_SERVER_API');
        $computers = $this->fetchDataFromApi($url . '/computers');

        return response()->json([
            'success' => true,
            'data' => $computers
        ], 200);
    }

    /**
     * Almacenar un nuevo computador enviándolo a la API (incluyendo la subida de imagen).
     */
    public function store(Request $request)
    {
        // 1. Validar los datos y la imagen
        $request->validate([
            'number' => 'required',
            'brand' => 'required',
            'urlFoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $url = env('URL_SERVER_API');
        $httpRequest = Http::asMultipart();

        // 2. Adjuntar archivo si se envió uno
        if ($request->hasFile('urlFoto')) {
            $file = $request->file('urlFoto');
            $httpRequest->attach(
                'urlFoto',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        // 3. Enviar solicitud POST a la API externa
        $response = $httpRequest->post($url . '/computers', [
            'number' => $request->number,
            'brand' => $request->brand,
        ]);

        return response()->json($response->json(), $response->status());
    }

    /**
     * Mostrar los detalles de un computador específico consumiendo la API.
     */
    public function show($id)
    {
        $url = env('URL_SERVER_API');
        $computer = $this->fetchDataFromApi($url . '/computers/' . $id);

        return response()->json([
            'success' => true,
            'data' => $computer
        ], 200);
    }

    /**
     * Actualizar un computador existente en la API.
     */
    public function update(Request $request, $id)
    {
        // Validar datos
        $request->validate([
            'number' => 'required',
            'brand' => 'required',
            'urlFoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $url = env('URL_SERVER_API');
        $httpRequest = Http::asMultipart();

        // Si el usuario subió una nueva foto
        if ($request->hasFile('urlFoto')) {
            $file = $request->file('urlFoto');
            $httpRequest->attach(
                'urlFoto',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        // Enviar solicitud PUT a la API externa
        $response = $httpRequest->put($url . '/computers/' . $id, [
            'number' => $request->number,
            'brand' => $request->brand,
        ]);

        return response()->json($response->json(), $response->status());
    }

    /**
     * Eliminar un computador de la API.
     */
    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::delete($url . '/computers/' . $id);

        return response()->json($response->json(), $response->status());
    }
}
