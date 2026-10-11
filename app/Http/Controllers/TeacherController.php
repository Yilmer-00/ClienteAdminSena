<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TeacherController extends Controller
{
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        return $response->json();
    }


    public function index()
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/teachers');

        // Extraer los cursos de forma segura.
        $teachers = is_array($response)
            ? ($response['data'] ?? $response)
            : [];

        return view('teacher.index', compact('teachers'));
    }


    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi(
            $url . '/teachers/' . $id
        );

        $teacher = is_array($response)
            ? ($response['data'] ?? $response)
            : [];

        return view('teacher.show', compact('teacher'));
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
            'teacher.create',
            compact('areas', 'trainigCenters')
        );
    }




    public function store(Request $request)
    {
        // Validamos los datos recibidos del formulario web
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'area_id' => 'required|integer',
            'trainig_center_id' => 'required|integer',
        ]);

        // Dirección base de tu API
        $url = rtrim(env('URL_SERVER_API'), '/');

        // Enviamos los datos a la API
        $response = Http::post($url . '/teachers', $validated);

        // Si la API registra el instructor
        if ($response->successful()) {
            return redirect()
                ->route('teacher.index')
                ->with('success', 'Instructor registrado correctamente.');
        }

        // Si la API responde con un error, mostramos su información
        $mensaje = $response->json('message')
            ?? 'No fue posible registrar el instructor.';

        return back()
            ->withErrors([
                'api' => $mensaje . ' Código HTTP: ' . $response->status(),
            ])
            ->withInput();
    }




    public function edit($id)
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $teacherResponse = $this->fetchDataFromApi(
            $url . '/teachers/' . $id
        );

        $teacher = is_array($teacherResponse)
            ? ($teacherResponse['data'] ?? $teacherResponse)
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
            'teacher.edit',
            compact('teacher', 'areas', 'trainigCenters')
        );
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required',
            'email'                => 'required',
            'area_id'            => 'required|integer',
            'training_center_id' => 'required|integer',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $url = env('URL_SERVER_API');

        $data = [
            'name'      => $request->input('name'),
            'email'                => $request->input('email'),
            'area_id'            => $request->input('area_id'),
            'training_center_id' => $request->input('training_center_id'),
            '_method'            => 'PUT',
        ];

        $http = Http::asMultipart();

        $multipartData = [];

        foreach ($data as $key => $value) {
            $multipartData[] = [
                'name' => $key,
                'contents' => (string) $value,
            ];
        }

        $response = $http->post(
            $url . '/teachers/' . $id,
            $multipartData
        );

        if ($response->successful()) {
            return redirect()
                ->route('teacher.index')
                ->with('success', 'Docente actualizado correctamente.');
        }

        return back()
            ->withErrors([
                'api' => 'Error al actualizar el docente en la API: '
                    . $response->body(),
            ])
            ->withInput();
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        $response = Http::delete(
            $url . '/teachers/' . $id
        );

        if ($response->successful()) {
            return redirect()
                ->route('teacher.index')
                ->with('success', 'Docente eliminado correctamente.');
        }

        return back()->withErrors([
            'api' => 'No fue posible eliminar el docente desde la API.',
        ]);
    }
}
