<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseTeacherController extends Controller
{
    private function apiUrl()
    {
        return rtrim(env('URL_SERVER_API'), '/');
    }

    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);
        return $response->json() ?? [];
    }

    private function getOptions()
    {
        $response = $this->fetchDataFromApi($this->apiUrl() . '/course-teachers/options');
        return $response['data'] ?? $response;
    }

    public function index()
    {
        $response = $this->fetchDataFromApi($this->apiUrl() . '/course-teachers');
        $courseTeachers = $response['data'] ?? $response;

        return view('course_teacher.index', compact('courseTeachers'));
    }

    public function show($id)
    {
        $response = $this->fetchDataFromApi($this->apiUrl() . '/course-teachers/' . $id);
        $courseTeacher = $response['data'] ?? $response;

        return view('course_teacher.show', compact('courseTeacher'));
    }

    public function create()
    {
        $options = $this->getOptions();
        $courses = $options['courses'] ?? [];
        $teachers = $options['teachers'] ?? [];

        return view('course_teacher.create', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        Http::post($this->apiUrl() . '/course-teachers', $request->except('_token'));

        return redirect()->route('course_teacher.index');
    }

    public function edit($id)
    {
        $teacherResponse = $this->fetchDataFromApi($this->apiUrl() . '/course-teachers/' . $id);
        $options = $this->getOptions();

        $courseTeacher = $teacherResponse['data'] ?? $teacherResponse;
        $courses = $options['courses'] ?? [];
        $teachers = $options['teachers'] ?? [];

        return view('course_teacher.edit', compact('courseTeacher', 'courses', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        Http::put(
            $this->apiUrl() . '/course-teachers/' . $id,
            $request->except(['_token', '_method'])
        );

        return redirect()->route('course_teacher.index');
    }

    public function destroy($id)
    {
        Http::delete($this->apiUrl() . '/course-teachers/' . $id);

        return redirect()->route('course_teacher.index');
    }
}
