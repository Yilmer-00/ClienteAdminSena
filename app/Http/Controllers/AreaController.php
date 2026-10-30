<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
{
    private function apiUrl()
    {
        return rtrim(env('URL_SERVER_API'), '/');
    }

    private function fetchDataFromApi($url)
    {
        $response = Http::acceptJson()->get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json();
    }

    // Mostrar todas las áreas
    public function index()
    {
        $response = $this->fetchDataFromApi(
            $this->apiUrl() . '/areas'
        );

        $areas = $response['data'] ?? [];

        return view('areas.index', compact('areas'));
    }

    // Formulario para crear
    public function create()
    {
        return view('areas.create');
    }

    // Guardar área
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $url = env('URL_SERVER_API');

        $file = $request->file('imagen');

        $response = Http::attach('imagen', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
            ->post(env('URL_SERVER_API') . '/areas', ['name' => $request->name,]);

        return redirect()->route('area.index');
    }

    // Mostrar un área
    public function show($id)
    {
        $response = $this->fetchDataFromApi(
            $this->apiUrl() . '/areas/' . $id
        );

        $area = $response['data'] ?? [];

        return view('areas.show', compact('area'));
    }

    // Formulario para editar
    public function edit($id)
    {
        $response = $this->fetchDataFromApi(
            $this->apiUrl() . '/areas/' . $id
        );

        $area = $response['data'] ?? [];

        if (empty($area)) {
            return redirect()
                ->route('area.index')
                ->withErrors(['error' => 'Área no encontrada.']);
        }

        return view('areas.edit', compact('area'));
    }

    // Actualizar área
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $response = Http::acceptJson()->put(
            $this->apiUrl() . '/areas/' . $id,
            [
                'name' => $request->name,
            ]
        );

        if ($response->failed()) {
            return back()
                ->withErrors([
                    'error' => $response->json('message')
                        ?? $response->body()
                ])
                ->withInput();
        }

        return redirect()
            ->route('area.index')
            ->with('success', 'Área actualizada correctamente.');
    }

    // Eliminar área
    public function destroy($id)
    {
        $response = Http::acceptJson()->delete(
            $this->apiUrl() . '/areas/' . $id
        );

        if ($response->failed()) {
            return back()->withErrors([
                'error' => $response->json('message')
                    ?? $response->body()
            ]);
        }

        return redirect()
            ->route('area.index')
            ->with('success', 'Área eliminada correctamente.');
    }
}
