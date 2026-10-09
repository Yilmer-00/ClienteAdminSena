<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApprenticeController extends Controller
{
    /**
     * Método privado para manejar llamadas HTTP repetitivas (GET)
     */
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }

    /**
     * Mostrar el listado de todos los aprendices.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/apprentices');

        // Extrae los datos de forma segura previniendo errores si la API retorna null
        $apprentices = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('apprentice.index', compact('apprentices'));
    }

    /**
     * Mostrar los detalles de un aprendiz específico.
     */
    public function show($id)
    {
        $url = env('URL_SERVER_API');
        $response = $this->fetchDataFromApi($url . '/apprentices/' . $id);

        $apprentice = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('apprentice.show', compact('apprentice'));
    }

    /**
     * Mostrar el formulario de creación cargando cursos y computadores.
     */
    public function create()
    {
        $url = env('URL_SERVER_API');

        // Consultamos las tablas foráneas de forma segura para los <select>
        $coursesRes = $this->fetchDataFromApi($url . '/courses');
        $courses = is_array($coursesRes) ? ($coursesRes['data'] ?? $coursesRes) : [];

        $computersRes = $this->fetchDataFromApi($url . '/computers');
        $computers = is_array($computersRes) ? ($computersRes['data'] ?? $computersRes) : [];

        return view('apprentice.create', compact('courses', 'computers'));
    }

    /**
     * Almacenar un nuevo aprendiz enviándolo a la API.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'cell_number' => 'required|string',
            'course_id' => 'required',
            'computer_id' => 'required',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::post($url . '/apprentices', $request->all());

        if ($response->successful()) {
            return redirect()->route('apprentice.index')->with('success', 'Aprendiz registrado correctamente.');
        }

        return back()->withErrors('Error al registrar el aprendiz en la API.')->withInput();
    }

    /**
     * Mostrar el formulario de edición con sus datos y las foráneas.
     */
    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        // Obtenemos el aprendiz a editar
        $apprenticeRes = $this->fetchDataFromApi($url . '/apprentices/' . $id);
        $apprentice = is_array($apprenticeRes) ? ($apprenticeRes['data'] ?? $apprenticeRes) : [];

        // Obtenemos cursos y computadores para mantener los selects operativos
        $coursesRes = $this->fetchDataFromApi($url . '/courses');
        $courses = is_array($coursesRes) ? ($coursesRes['data'] ?? $coursesRes) : [];

        $computersRes = $this->fetchDataFromApi($url . '/computers');
        $computers = is_array($computersRes) ? ($computersRes['data'] ?? $computersRes) : [];

        return view('apprentice.edit', compact('apprentice', 'courses', 'computers'));
    }

    /**
     * Actualizar un aprendiz existente en la API.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'cell_number' => 'required|string',
            'course_id' => 'required',
            'computer_id' => 'required',
        ]);

        $url = env('URL_SERVER_API');
        $response = Http::put($url . '/apprentices/' . $id, $request->all());

        if ($response->successful()) {
            return redirect()->route('apprentice.index')->with('success', 'Aprendiz actualizado correctamente.');
        }

        return back()->withErrors('Error al actualizar el aprendiz en la API.')->withInput();
    }

    /**
     * Eliminar un aprendiz de la API.
     */
    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        Http::delete($url . '/apprentices/' . $id);

        return redirect()->route('apprentice.index')->with('success', 'Aprendiz eliminado correctamente.');
    }
}
