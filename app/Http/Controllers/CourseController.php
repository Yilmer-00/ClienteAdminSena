<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CourseController extends Controller
{
    private function apiUrl(string $path = ''): string
    {
        $baseUrl = rtrim((string) config('services.api.url'), '/');

        if ($baseUrl === '') {
            throw new RuntimeException('Configura URL_SERVER_API para conectar con la API.');
        }

        return $baseUrl . '/' . ltrim($path, '/');
    }

    private function fetchDataFromApi(string $path)
    {
        return Http::acceptJson()
            ->timeout(10)
            ->get($this->apiUrl($path))
            ->throw()
            ->json();
    }

    private function apiErrorMessage(Response $response, string $action): string
    {
        $message = $response->json('message');

        if (is_string($message) && $message !== '') {
            return $message;
        }

        return "Error al {$action} el curso en la API (HTTP {$response->status()}).";
    }

    public function index()
    {
        $response = $this->fetchDataFromApi('/courses');

        $courses = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('courses.index', compact('courses'));
    }

    public function show($id)
    {
        $response = $this->fetchDataFromApi('/courses/' . $id);

        $course = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('courses.show', compact('course'));
    }

    public function create()
    {
        $areasRes = $this->fetchDataFromApi('/areas');
        $areas = is_array($areasRes) ? ($areasRes['data'] ?? $areasRes) : [];

        $trainigCentersRes = $this->fetchDataFromApi('/training-centers');
        $trainig_centers = is_array($trainigCentersRes) ? ($trainigCentersRes['data'] ?? $trainigCentersRes) : [];

        return view('courses.create', compact('areas', 'trainig_centers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_number'      => 'required',
            'day'                => 'required',
            'area_id'            => 'required',
            'training_center_id' => 'required',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $httpRequest = Http::acceptJson()->timeout(10);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $httpRequest->attach(
                'image',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        $response = $httpRequest->post($this->apiUrl('/courses'), [
            'course_number'      => $request->course_number,
            'day'                => $request->day,
            'area_id'            => $request->area_id,
            'training_center_id' => $request->training_center_id,
        ]);

        if ($response->successful()) {
            return redirect()->route('course.index')->with('success', 'Curso registrado correctamente.');
        }

        return back()->withErrors($this->apiErrorMessage($response, 'registrar'))->withInput();
    }

    public function edit($id)
    {
        $courseRes = $this->fetchDataFromApi('/courses/' . $id);
        $course = is_array($courseRes) ? ($courseRes['data'] ?? $courseRes) : [];

        $areasRes = $this->fetchDataFromApi('/areas');
        $areas = is_array($areasRes) ? ($areasRes['data'] ?? $areasRes) : [];

        $trainigCentersRes = $this->fetchDataFromApi('/training-centers');
        $trainig_centers = is_array($trainigCentersRes) ? ($trainigCentersRes['data'] ?? $trainigCentersRes) : [];

        return view('courses.edit', compact('course', 'areas', 'trainig_centers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_number'      => 'required',
            'day'                => 'required',
            'area_id'            => 'required',
            'training_center_id' => 'required',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $httpRequest = Http::acceptJson()->timeout(10);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $httpRequest->attach(
                'image',
                file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            );
        }

        $response = $httpRequest->post($this->apiUrl('/courses/' . $id), [
            '_method'            => 'PUT',
            'course_number'      => $request->course_number,
            'day'                => $request->day,
            'area_id'            => $request->area_id,
            'training_center_id' => $request->training_center_id,
        ]);

        if ($response->successful()) {
            return redirect()->route('course.index')->with('success', 'Curso actualizado correctamente.');
        }

        return back()->withErrors($this->apiErrorMessage($response, 'actualizar'))->withInput();
    }

    public function destroy($id)
    {
        $response = Http::acceptJson()
            ->timeout(10)
            ->delete($this->apiUrl('/courses/' . $id));

        if (! $response->successful()) {
            return redirect()->route('course.index')
                ->withErrors($this->apiErrorMessage($response, 'eliminar'));
        }

        return redirect()->route('course.index')->with('success', 'Curso eliminado correctamente.');
    }
}
