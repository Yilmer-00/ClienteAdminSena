<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TeacherController extends Controller
{
    private function apiUrl()
    {
        return rtrim((string) config('services.api.url'), '/');
    }

    private function fetchDataFromApi($url)
    {
        $response = Http::acceptJson()->get($url);
        return $response->json() ?? [];
    }

    public function index()
    {
        $response = $this->fetchDataFromApi($this->apiUrl() . '/teachers');
        $teachers = $response['data'] ?? $response;

        return view('teacher.index', compact('teachers'));
    }

    public function show($id)
    {
        $response = $this->fetchDataFromApi($this->apiUrl() . '/teachers/' . $id);
        $teacher = $response['data'] ?? $response;

        return view('teacher.show', compact('teacher'));
    }

    public function create()
    {
        $areasResponse = $this->fetchDataFromApi($this->apiUrl() . '/areas');
        $centersResponse = $this->fetchDataFromApi($this->apiUrl() . '/training-centers');

        $areas = $areasResponse['data'] ?? $areasResponse;
        $trainigCenters = $centersResponse['data'] ?? $centersResponse;

        return view('teacher.create', compact('areas', 'trainigCenters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'area_id'           => 'required|integer',
            'trainig_center_id' => 'required|integer',
        ]);

        Http::acceptJson()->post($this->apiUrl() . '/teachers', $validated);

        return redirect()->route('teacher.index');
    }

    public function edit($id)
    {
        $teacherResponse = $this->fetchDataFromApi($this->apiUrl() . '/teachers/' . $id);
        $areasResponse = $this->fetchDataFromApi($this->apiUrl() . '/areas');
        $centersResponse = $this->fetchDataFromApi($this->apiUrl() . '/training-centers');

        $teacher = $teacherResponse['data'] ?? $teacherResponse;
        $teacher['trainig_center_id'] = $teacher['trainig_center_id'] ?? $teacher['training_center_id'] ?? '';
        $areas = $areasResponse['data'] ?? $areasResponse;
        $trainigCenters = $centersResponse['data'] ?? $centersResponse;

        return view('teacher.edit', compact('teacher', 'areas', 'trainigCenters'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'area_id'           => 'required|integer',
            'trainig_center_id' => 'required|integer',
        ]);

        Http::acceptJson()->put($this->apiUrl() . '/teachers/' . $id, $validated);

        return redirect()->route('teacher.index');
    }

    public function destroy($id)
    {
        Http::delete($this->apiUrl() . '/teachers/' . $id);

        return redirect()->route('teacher.index');
    }
}
