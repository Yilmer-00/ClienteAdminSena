<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
{
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        if (!$response->successful()) {
            return [];
        }

        $data = $response->json();

        return is_array($data) ? $data : [];
    }

    private function extractData($response)
    {
        return is_array($response)
            ? ($response['data'] ?? $response)
            : [];
    }

    public function index()
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $response = $this->fetchDataFromApi($url . '/courses');
        $courses = $this->extractData($response);

        return view('course.index', compact('courses'));
    }

    public function show($id)
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $response = $this->fetchDataFromApi($url . '/courses/' . $id);
        $course = $this->extractData($response);

        return view('course.show', compact('course'));
    }

    public function create()
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $areasResponse = $this->fetchDataFromApi($url . '/areas');
        $areas = $this->extractData($areasResponse);

        $centersResponse = $this->fetchDataFromApi($url . '/training-centers');
        $trainigCenters = $this->extractData($centersResponse);

        return view('course.create', compact('areas', 'trainigCenters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_number' => 'required',
            'day' => 'required',
            'area_id' => 'required',
            'training_center_id' => 'required',
        ]);

        $url = rtrim(env('URL_SERVER_API'), '/') . '/courses';

        $response = Http::asForm()->post($url, [
            'course_number' => $request->course_number,
            'day' => $request->day,
            'area_id' => $request->area_id,
            'trainig_center_id' => $request->training_center_id,
        ]);

        if ($response->successful() && $response->json('success')) {
            return redirect()
                ->route('course.index')
                ->with('success', 'Curso registrado correctamente.');
        }

        return back()
            ->withInput()
            ->withErrors([
                'api' => 'Error al registrar el curso: ' .
                    $response->body()
            ]);
    }

    public function edit($id)
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $courseResponse = $this->fetchDataFromApi(
            $url . '/courses/' . $id
        );

        $course = $this->extractData($courseResponse);

        if (empty($course)) {
            return redirect()
                ->route('course.index')
                ->withErrors(['api' => 'No se encontró el curso solicitado.']);
        }

        $course['training_center_id'] = $course['trainig_center_id'] ?? '';

        $areasResponse = $this->fetchDataFromApi($url . '/areas');
        $areas = $this->extractData($areasResponse);

        $centersResponse = $this->fetchDataFromApi(
            $url . '/training-centers'
        );

        $trainigCenters = $this->extractData($centersResponse);

        return view(
            'course.edit',
            compact('course', 'areas', 'trainigCenters')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_number' => 'required',
            'day' => 'required',
            'area_id' => 'required|integer',
            'training_center_id' => 'required|integer',
        ]);

        $url = rtrim(env('URL_SERVER_API'), '/');

        $response = Http::asForm()->put(
            $url . '/courses/' . $id,
            [
                'course_number' => $request->input('course_number'),
                'day' => $request->input('day'),
                'area_id' => $request->input('area_id'),
                'trainig_center_id' => $request->input('training_center_id'),
            ]
        );

        if ($response->successful()) {
            return redirect()
                ->route('course.index')
                ->with('success', 'Curso actualizado correctamente.');
        }

        return back()
            ->withErrors([
                'api' => 'Error al actualizar el curso: ' . $response->body(),
            ])
            ->withInput();
    }

    public function destroy($id)
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $response = Http::delete($url . '/courses/' . $id);

        if ($response->successful()) {
            return redirect()
                ->route('course.index')
                ->with('success', 'Curso eliminado correctamente.');
        }

        return back()->withErrors([
            'api' => 'No fue posible eliminar el curso desde la API: '
                . $response->body(),
        ]);
    }
}
