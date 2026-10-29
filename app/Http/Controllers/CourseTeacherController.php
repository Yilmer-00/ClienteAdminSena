<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseTeacherController extends Controller
{
    // Dirección base de la API
    private function apiUrl()
    {
        return rtrim(env('URL_SERVER_API'), '/');
    }

    // Consultar información de la API
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        if ($response->failed()) {
            return [
                'success' => false,
                'status' => $response->status(),
                'message' => $response->body(),
                'data' => [],
            ];
        }

        return $response->json() ?? [];
    }

    // Listar asignaciones curso-docente
    public function index()
    {
        $response = $this->fetchDataFromApi(
            $this->apiUrl() . '/course-teachers'
        );

        if (!($response['success'] ?? false)) {
            return back()->withErrors([
                'api' => 'No se pudieron recuperar las asignaciones curso-docente.'
            ]);
        }

        $courseTeachers = $response['data'] ?? [];

        return view(
            'course_teacher.index',
            compact('courseTeachers')
        );
    }

    // Mostrar detalles de una asignación
    public function show($id)
    {
        $response = $this->fetchDataFromApi(
            $this->apiUrl() . '/course-teachers/' . $id
        );

        if (!($response['success'] ?? false)) {
            return back()->withErrors([
                'api' => 'No se pudo recuperar la información de la asignación.'
            ]);
        }

        $courseTeacher = $response['data'] ?? [];

        return view(
            'course_teacher.show',
            compact('courseTeacher')
        );
    }

    // Consultar cursos y docentes para los formularios
    private function getOptions()
    {
        $response = $this->fetchDataFromApi(
            $this->apiUrl() . '/course-teachers/options'
        );

        if (!($response['success'] ?? false)) {
            return null;
        }

        return $response['data'] ?? [];
    }

    // Mostrar formulario de registro
    public function create()
    {
        $options = $this->getOptions();

        if ($options === null) {
            return back()->withErrors([
                'api' => 'No se pudieron recuperar los cursos y docentes.'
            ]);
        }

        $courses = $options['courses'] ?? [];
        $teachers = $options['teachers'] ?? [];

        return view(
            'course_teacher.create',
            compact('courses', 'teachers')
        );
    }

    // Registrar asignación
    public function store(Request $request)
    {
        $response = Http::post(
            $this->apiUrl() . '/course-teachers',
            $request->except('_token')
        );

        if (
            $response->successful() &&
            ($response->json('success') ?? true)
        ) {

            return redirect()
                ->route('course_teacher.index')
                ->with('success', 'Asignación registrada correctamente.');
        }

        return back()
            ->withErrors([
                'api' => 'Error al registrar la asignación: ' .
                    ($response->json('message') ?? $response->body())
            ])
            ->withInput();
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        // Consultar asignación
        $teacherResponse = $this->fetchDataFromApi(
            $this->apiUrl() . '/course-teachers/' . $id
        );

        // Consultar opciones
        $options = $this->getOptions();

        if (
            !($teacherResponse['success'] ?? false) ||
            $options === null
        ) {
            return back()->withErrors([
                'api' => 'No se pudo recuperar toda la información necesaria para editar la asignación.'
            ]);
        }

        $courseTeacher = $teacherResponse['data'] ?? [];

        $courses = $options['courses'] ?? [];
        $teachers = $options['teachers'] ?? [];

        return view(
            'course_teacher.edit',
            compact('courseTeacher', 'courses', 'teachers')
        );
    }

    // Actualizar asignación
    public function update(Request $request, $id)
    {
        $response = Http::put(
            $this->apiUrl() . '/course-teachers/' . $id,
            $request->except(['_token', '_method'])
        );

        if (
            $response->successful() &&
            ($response->json('success') ?? true)
        ) {

            return redirect()
                ->route('course_teacher.index')
                ->with('success', 'Asignación actualizada correctamente.');
        }

        return back()
            ->withErrors([
                'api' => 'Error al actualizar la asignación: ' .
                    ($response->json('message') ?? $response->body())
            ])
            ->withInput();
    }

    // Eliminar asignación
    public function destroy($id)
    {
        $response = Http::delete(
            $this->apiUrl() . '/course-teachers/' . $id
        );

        if ($response->successful()) {
            return redirect()
                ->route('course_teacher.index')
                ->with('success', 'Asignación eliminada correctamente.');
        }

        return back()->withErrors([
            'api' => 'No fue posible eliminar la asignación: ' .
                ($response->json('message') ?? $response->body())
        ]);
    }
}
