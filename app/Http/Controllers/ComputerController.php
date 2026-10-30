<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ComputerController extends Controller
{
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }

    public function index()
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/computers');
        $computers = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('computers.index', compact('computers'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/computers/' . $id);
        $computer = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('computers.show', compact('computer'));
    }

    public function create()
    {
        return view('computers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number'  => 'required',
            'brand'   => 'required',
            'urlFoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $url = env('URL_SERVER_API');
        $httpRequest = Http::asMultipart();

        if ($request->hasFile('urlFoto')) {
            $file = $request->file('urlFoto');
            $httpRequest->attach(
                'urlFoto',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        $httpRequest->post($url . '/computers', [
            'number' => $request->number,
            'brand'  => $request->brand,
        ]);

        return redirect()->route('computer.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/computers/' . $id);
        $computer = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('computers.edit', compact('computer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'number'  => 'required',
            'brand'   => 'required',
            'urlFoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $url = env('URL_SERVER_API');
        $httpRequest = Http::asMultipart();
        $httpRequest->attach('_method', 'PUT');

        if ($request->hasFile('urlFoto')) {
            $file = $request->file('urlFoto');
            $httpRequest->attach(
                'urlFoto',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        $httpRequest->post($url . '/computers/' . $id, [
            'number' => $request->number,
            'brand'  => $request->brand,
        ]);

        return redirect()->route('computer.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url . '/computers/' . $id);

        return redirect()->route('computer.index');
    }
}
