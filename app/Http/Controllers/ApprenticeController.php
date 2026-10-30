<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApprenticeController extends Controller
{
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json();
    }

    public function index()
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/apprentices');
        $apprentices = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('apprentice.index', compact('apprentices'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $response = $this->fetchDataFromApi($url . '/apprentices/' . $id);
        $apprentice = is_array($response) ? ($response['data'] ?? $response) : [];

        return view('apprentice.show', compact('apprentice'));
    }

    public function create()
    {
        $url = env('URL_SERVER_API');

        $coursesRes = $this->fetchDataFromApi($url . '/courses');
        $courses = is_array($coursesRes) ? ($coursesRes['data'] ?? $coursesRes) : [];

        $computersRes = $this->fetchDataFromApi($url . '/computers');
        $computers = is_array($computersRes) ? ($computersRes['data'] ?? $computersRes) : [];

        return view('apprentice.create', compact('courses', 'computers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'cell_number' => 'required|string',
            'course_id'   => 'required',
            'computer_id' => 'required',
        ]);

        $url = env('URL_SERVER_API');

        Http::post($url . '/apprentices', $request->all());

        return redirect()->route('apprentice.index');
    }

    public function edit($id)
    {
        $url = env('URL_SERVER_API');

        $apprenticeRes = $this->fetchDataFromApi($url . '/apprentices/' . $id);
        $apprentice = is_array($apprenticeRes) ? ($apprenticeRes['data'] ?? $apprenticeRes) : [];

        $coursesRes = $this->fetchDataFromApi($url . '/courses');
        $courses = is_array($coursesRes) ? ($coursesRes['data'] ?? $coursesRes) : [];

        $computersRes = $this->fetchDataFromApi($url . '/computers');
        $computers = is_array($computersRes) ? ($computersRes['data'] ?? $computersRes) : [];

        return view('apprentice.edit', compact('apprentice', 'courses', 'computers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'cell_number' => 'required|string',
            'course_id'   => 'required',
            'computer_id' => 'required',
        ]);

        $url = env('URL_SERVER_API');

        Http::put($url . '/apprentices/' . $id, $request->all());

        return redirect()->route('apprentice.index');
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');

        Http::delete($url . '/apprentices/' . $id);

        return redirect()->route('apprentice.index');
    }
}
