<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    private function apiUrl(): string
    {
        return rtrim((string) config('services.api.url'), '/');
    }

    private function fetchDataFromApi($url)
    {
        $response = Http::acceptJson()->get($url);
        return $response->json();
    }

    public function index()
    {
        $url = $this->apiUrl();

        if ($url === '') {
            return view('computers.index', [
                'computers' => [],
                'apiError' => 'No está configurada la URL del servidor de datos.',
            ]);
        }

        $response = Http::acceptJson()->get($url . '/computers');
        $payload = $response->json();
        $computers = is_array($payload) ? ($payload['data'] ?? $payload) : [];
        $apiError = null;

        if (!$response->successful()) {
            $computers = [];
            $apiError = 'No fue posible cargar los computadores. Verifica la conexión con el servidor de datos.';
        } elseif (!is_array($computers) || !array_is_list($computers)) {
            $computers = [];
            $apiError = 'El servidor devolvió un listado de computadores con un formato no válido.';
        }

        return view('computers.index', compact('computers', 'apiError'));
    }

    public function create()
    {
        return view('computers.create');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'urlFoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $url = $this->apiUrl();

        if ($url === '') {
            return back()
                ->withErrors(['api' => 'No está configurada la URL del servidor de datos.'])
                ->withInput();
        }

        $httpRequest = Http::acceptJson();
        if ($request->hasFile('urlFoto')) {
            $file = $request->file('urlFoto');
            $httpRequest->attach(
                'urlFoto',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        $response = $httpRequest->post($url . '/computers', [
            'number' => $validated['number'],
            'brand' => $validated['brand'],
        ]);

        if (!$response->successful()) {
            return back()
                ->withErrors(['api' => 'No se pudo registrar el computador en el servidor de datos. Verifica la información e inténtalo de nuevo.'])
                ->withInput();
        }

        return redirect()
            ->route('computer.index')
            ->with('success', 'Computador creado correctamente.');
    }

    public function show($id)
    {
        $url = $this->apiUrl();

        $response = $this->fetchDataFromApi($url . '/computers/' . $id);
        $computer = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('computers.show', compact('computer'));
    }



    public function edit($id)
    {
        return view('computers.create');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'number'  => 'required',
            'brand'   => 'required',
            'urlFoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $url = $this->apiUrl();
        $httpRequest = Http::asMultipart();

        if ($request->hasFile('urlFoto')) {
            $file = $request->file('urlFoto');
            $httpRequest->attach(
                'urlFoto',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        $response = $httpRequest->put($url . '/computers/' . $id, [
            'number' => $request->number,
            'brand'  => $request->brand,
        ]);

        return redirect()->route('computer.index');
    }

    public function destroy($id)
    {
        $url = $this->apiUrl();

        Http::delete($url . '/computers/' . $id);

        return redirect()->route('computer.index');
    }
}
