<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
{
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }

    public function index()
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/areas');
        $areas = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255',]);
        $url = env('URL_SERVER_API');

        Http::post($url . '/areas', ['name' => $request->name,]);

        return redirect()->route('area.index');
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/areas/' . $id);
        $area = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('areas.show', compact('area'));
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/areas/' . $id);
        $area = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255',]);
        $url = env('URL_SERVER_API');
        Http::put($url . '/areas/' . $id, ['name' => $request->name,]);

        return redirect()->route('area.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        Http::delete($url . '/areas/' . $id);
        return redirect()->route('area.index');
    }
}
