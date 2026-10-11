<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
{

    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        return $response->json();
    }


    public function index()
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/courses');

        // Extraer los cursos de forma segura.
        $courses = is_array($response)
            ? ($response['data'] ?? $response)
            : [];

        return view('course.index', compact('courses'));
    }


    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi(
            $url . '/courses/' . $id
        );

        $course = is_array($response)
            ? ($response['data'] ?? $response)
            : [];

        return view('course.show', compact('course'));
    }


    public function create()
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $areasResponse = $this->fetchDataFromApi(
            $url . '/areas'
        );

        $areas = is_array($areasResponse)
            ? ($areasResponse['data'] ?? $areasResponse)
            : [];

        $centersResponse = $this->fetchDataFromApi(
            $url . '/training-centers'
        );

        $trainigCenters = is_array($centersResponse)
            ? ($centersResponse['data'] ?? $centersResponse)
            : [];

        return view(
            'course.create',
            compact('areas', 'trainigCenters')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'course_number'      => 'required',
            'day'                => 'required',
            'area_id'            => 'required|integer',
            'training_center_id' => 'required|integer',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $url = env('URL_SERVER_API');

        $data = [
            'course_number'      => $request->input('course_number'),
            'day'                => $request->input('day'),
            'area_id'            => $request->input('area_id'),
            'training_center_id' => $request->input('training_center_id'),
        ];

        $http = Http::asMultipart();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $http = $http->attach(
                'image',
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName()
            );
        }

        $response = $http->post(
            $url . '/courses',
            array_merge(
                array_map(
                    fn($key, $value) => [
                        'name' => $key,
                        'contents' => (string) $value,
                    ],
                    array_keys($data),
                    array_values($data)
                ),
                []
            )
        );

        if ($response->successful()) {
            return redirect()
                ->route('course.index')
                ->with('success', 'Curso registrado correctamente.');
        }

        return back()
            ->withErrors([
                'api' => 'Error al registrar el curso en la API: '
                    . $response->body(),
            ])
            ->withInput();
    }


    public function edit($id)
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $courseResponse = $this->fetchDataFromApi(
            $url . '/courses/' . $id
        );

        $course = is_array($courseResponse)
            ? ($courseResponse['data'] ?? $courseResponse)
            : [];

        $areasResponse = $this->fetchDataFromApi(
            $url . '/areas'
        );

        $areas = is_array($areasResponse)
            ? ($areasResponse['data'] ?? $areasResponse)
            : [];

        $centersResponse = $this->fetchDataFromApi(
            $url . '/training-centers'
        );

        $trainigCenters = is_array($centersResponse)
            ? ($centersResponse['data'] ?? $centersResponse)
            : [];

        return view(
            'course.edit',
            compact('course', 'areas', 'trainigCenters')
        );
    }


  
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_number'      => 'required',
            'day'                => 'required',
            'area_id'            => 'required|integer',
            'training_center_id' => 'required|integer',
        ]);

        $url = env('URL_SERVER_API');

        $data = [
            'course_number'      => $request->input('course_number'),
            'day'                => $request->input('day'),
            'area_id'            => $request->input('area_id'),
            'training_center_id' => $request->input('training_center_id'),
            '_method'            => 'PUT',
        ];

        $http = Http::asMultipart();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $http = $http->attach(
                'image',
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName()
            );
        }

        $multipartData = [];

        foreach ($data as $key => $value) {
            $multipartData[] = [
                'name' => $key,
                'contents' => (string) $value,
            ];
        }

        $response = $http->post(
            $url . '/courses/' . $id,
            $multipartData
        );

        if ($response->successful()) {
            return redirect()
                ->route('course.index')
                ->with('success', 'Curso actualizado correctamente.');
        }

        return back()
            ->withErrors([
                'api' => 'Error al actualizar el curso en la API: '
                    . $response->body(),
            ])
            ->withInput();
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::delete(
            $url . '/courses/' . $id
        );

        if ($response->successful()) {
            return redirect()
                ->route('course.index')
                ->with('success', 'Curso eliminado correctamente.');
        }

        return back()->withErrors([
            'api' => 'No fue posible eliminar el curso desde la API.',
        ]);
    }
}
