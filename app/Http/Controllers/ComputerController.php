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
    public function index()
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/computers');

        // Extrae los datos asegurando compatibilidad y previniendo errores si es null
        $computers = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('computers.index', compact('computers'));
    }

    /**
     * Mostrar el formulario para registrar un nuevo computador.
     */
    public function create()
    {
        return view('computers.create');
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

        if ($response->successful()) {
            return redirect()->route('computer.index')->with('success', 'Computador creado correctamente.');
        }

        return back()->withErrors('Error al registrar el computador en la API.')->withInput();
    }

    /**
     * Mostrar los detalles de un computador específico consumiendo la API.
     */
    public function show($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/computers/' . $id);

        $computer = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('computers.show', compact('computer'));
    }

    /**
     * Mostrar el formulario para editar un computador existente.
     */
    public function edit($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/computers/' . $id);

        $computer = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('computers.edit', compact('computer'));
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

        if ($response->successful()) {
            return redirect()->route('computer.index')->with('success', 'Computador actualizado correctamente.');
        }

        return back()->withErrors('Error al actualizar el computador en la API.')->withInput();
    }

    /**
     * Eliminar un computador de la API.
     */
    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        $response = Http::delete($url . '/computers/' . $id);

        return redirect()->route('computer.index')->with('success', 'Computador eliminado correctamente.');
    }
}
