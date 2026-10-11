<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CourseTeacherController extends Controller
{
    // Método privado para manejar llamadas HTTP repetitivas
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }

    // Listar todas las asignaciones curso-docente

    public function index()
    {
        $url = rtrim(env('URL_SERVER_API'), '/');

        $response = Http::get($url . '/course-teachers');

        // Comprobar si la API respondió correctamente
        if ($response->failed()) {
            dd([
                'error' => 'La API no pudo devolver las asignaciones.',
                'status' => $response->status(),
                'respuesta' => $response->body(),
            ]);
        }

        // Obtener el JSON de la API
        $result = $response->json();

        // Extraer la lista de asignaciones
        $courseTeachers = $result['data'] ?? [];

        return view(
            'course_teacher.index',
            compact('courseTeachers')
        );
    }


    // Mostrar los detalles de una asignación
    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $courseTeacher = $this->fetchDataFromApi(
            $url . '/course-teachers/' . $id
        );

        return view(
            'course_teacher.show',
            compact('courseTeacher')
        );
    }

    // Mostrar el formulario de registro con cursos y docentes
    public function create()
    {
        $url = env('URL_SERVER_API');

        $options = $this->fetchDataFromApi(
            $url . '/course-teachers/options'
        );

        $courses = $options['data']['courses'] ?? [];
        $teachers = $options['data']['teachers'] ?? [];

        return view(
            'course_teacher.create',
            compact('courses', 'teachers')
        );
    }

    // Registrar una nueva asignación
    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        Http::post(
            $url . '/course-teachers',
            $request->all()
        );

        return redirect()->route('course_teacher.index');
    }

    // Mostrar el formulario de edición
    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $courseTeacher = $this->fetchDataFromApi(
            $url . '/course-teachers/' . $id
        );

        $options = $this->fetchDataFromApi(
            $url . '/course-teachers/options'
        );

        $courses = $options['data']['courses'] ?? [];
        $teachers = $options['data']['teachers'] ?? [];

        return view(
            'course_teacher.edit',
            compact('courseTeacher', 'courses', 'teachers')
        );
    }

    // Actualizar una asignación
    public function update(Request $request, $id)
    {
        $url = env('URL_SERVER_API');

        Http::put(
            $url . '/course-teachers/' . $id,
            $request->all()
        );

        return redirect()->route('course_teacher.index');
    }

    // Eliminar una asignación
    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete(
            $url . '/course-teachers/' . $id
        );

        return redirect()->route('course_teacher.index');
    }
}
