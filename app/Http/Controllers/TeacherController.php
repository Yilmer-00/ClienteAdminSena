<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TeacherController extends Controller
{
    // Dirección base de la API
    private function apiUrl()
    {
        return rtrim((string) config('services.api.url'), '/');
    }

    // Método para consultar información de la API
    private function fetchDataFromApi($url)
    {
        $response = Http::acceptJson()->get($url);

        if ($response->failed()) {
            return [
                'success' => false,
                'status' => $response->status(),
                'message' => $response->json('message')
                    ?? $response->body(),
                'errors' => $response->json('errors') ?? [],
                'data' => [],
            ];
        }

        return $response->json() ?? [];
    }

    // Listar docentes
    public function index()
    {
        $response = $this->fetchDataFromApi(
            $this->apiUrl() . '/teachers'
        );

        if (!($response['success'] ?? false)) {
            return back()->withErrors([
                'api' => 'No se pudieron recuperar los docentes.'
            ]);
        }

        $teachers = $response['data'] ?? [];

        return view('teacher.index', compact('teachers'));
    }

    // Mostrar información de un docente
    public function show($id)
    {
        $response = $this->fetchDataFromApi(
            $this->apiUrl() . '/teachers/' . $id
        );

        if (!($response['success'] ?? false)) {
            return back()->withErrors([
                'api' => 'No se pudo recuperar la información del docente.'
            ]);
        }

        $teacher = $response['data'] ?? [];

        return view('teacher.show', compact('teacher'));
    }

    // Mostrar formulario de registro
    public function create()
    {
        $areasResponse = $this->fetchDataFromApi(
            $this->apiUrl() . '/areas'
        );

        $centersResponse = $this->fetchDataFromApi(
            $this->apiUrl() . '/training-centers'
        );

        if (
            !($areasResponse['success'] ?? false) ||
            !($centersResponse['success'] ?? false)
        ) {
            return back()->withErrors([
                'api' => 'No se pudieron recuperar las áreas y centros de formación.'
            ]);
        }

        $areas = $areasResponse['data'] ?? [];
        $trainigCenters = $centersResponse['data'] ?? [];

        return view(
            'teacher.create',
            compact('areas', 'trainigCenters')
        );
    }

    // Registrar docente

    // Registrar docente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'area_id' => 'required|integer',
            'trainig_center_id' => 'required|integer',
        ]);

        $response = Http::acceptJson()->post(
            $this->apiUrl() . '/teachers',
            $validated
        );

        if (
            $response->successful() &&
            ($response->json('success') ?? false)
        ) {
            return redirect()
                ->route('teacher.index')
                ->with('success', 'Instructor registrado correctamente.');
        }

        $errors = $response->json('errors') ?? [];

        return back()
            ->withErrors(
                !empty($errors)
                    ? $errors
                    : [
                        'api' => $response->json('message')
                            ?? $response->body()
                    ]
            )
            ->withInput();
    }


    // Mostrar formulario de edición
    public function edit($id)
    {
        $teacherResponse = $this->fetchDataFromApi(
            $this->apiUrl() . '/teachers/' . $id
        );

        $areasResponse = $this->fetchDataFromApi(
            $this->apiUrl() . '/areas'
        );

        $centersResponse = $this->fetchDataFromApi(
            $this->apiUrl() . '/training-centers'
        );

        if (
            !($teacherResponse['success'] ?? false) ||
            !($areasResponse['success'] ?? false) ||
            !($centersResponse['success'] ?? false)
        ) {
            return back()->withErrors([
                'api' => 'No se pudo recuperar la información para editar.'
            ]);
        }

        $teacher = $teacherResponse['data'];
        $teacher['trainig_center_id'] = $teacher['trainig_center_id']
            ?? $teacher['training_center_id']
            ?? '';
        $areas = $areasResponse['data'];
        $trainigCenters = $centersResponse['data'];

        return view('teacher.edit', compact(
            'teacher',
            'areas',
            'trainigCenters'
        ));
    }


    // Actualizar docente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'area_id' => 'required|integer',
            'trainig_center_id' => 'required|integer',
        ]);

        $response = Http::acceptJson()->put(
            $this->apiUrl() . '/teachers/' . $id,
            $validated
        );

        if (
            $response->successful() &&
            ($response->json('success') ?? false)
        ) {
            return redirect()
                ->route('teacher.show', $id)
                ->with('success', 'Docente actualizado correctamente.');
        }

        $errors = $response->json('errors') ?? [];

        return back()
            ->withErrors(
                !empty($errors)
                    ? $errors
                    : [
                        'api' => $response->json('message')
                            ?? $response->body()
                    ]
            )
            ->withInput();
    }


    // Eliminar docente
    public function destroy($id)
    {
        $response = Http::delete(
            $this->apiUrl() . '/teachers/' . $id
        );

        if ($response->successful()) {
            return redirect()
                ->route('teacher.index')
                ->with('success', 'Docente eliminado correctamente.');
        }

        return back()->withErrors([
            'api' => 'No fue posible eliminar el docente: ' .
                ($response->json('message') ?? $response->body())
        ]);
    }
}
