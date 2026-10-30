<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TrainigCenterController extends Controller
{
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }

    public function index()
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/training-centers');
        $trainigCenters = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('training-centers.index', compact('trainigCenters'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/training-centers/' . $id);
        $trainingCenter = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('training-centers.show', compact('trainingCenter'));
    }

    public function create()
    {
        return view('training-centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');

        Http::post($url . '/training-centers', [
            'name'     => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('trainig-center.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/training-centers/' . $id);
        $trainigCenter = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('training-centers.edit', compact('trainigCenter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');

        Http::put($url . '/training-centers/' . $id, [
            'name'     => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('trainig-center.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url . '/training-centers/' . $id);

        return redirect()->route('trainig-center.index');
    }
}
