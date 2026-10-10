<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    public function test_course_creation_sends_the_training_center_id_to_the_api(): void
    {
        config(['services.api.url' => 'http://api.example.test/v1']);

        Http::fake([
            'http://api.example.test/v1/courses' => Http::response(['message' => 'Created'], 201),
        ]);

        $response = $this->from('/courses/create')->post(route('course.store'), [
            'course_number' => '101',
            'day' => 'Monday',
            'area_id' => '2',
            'training_center_id' => '3',
        ]);

        $response->assertRedirect(route('course.index'));

        Http::assertSent(fn (ClientRequest $request) => $request->url() === 'http://api.example.test/v1/courses'
            && $request['training_center_id'] === '3');
    }

    public function test_course_creation_shows_api_errors_without_stopping_the_application(): void
    {
        config(['services.api.url' => 'http://api.example.test/v1']);

        Http::fake([
            'http://api.example.test/v1/courses' => Http::response(['message' => 'Course route not found'], 404),
        ]);

        $response = $this->from('/courses/create')->post(route('course.store'), [
            'course_number' => '101',
            'day' => 'Monday',
            'area_id' => '2',
            'training_center_id' => '3',
        ]);

        $response->assertRedirect('/courses/create');
        $response->assertSessionHasErrors();
    }
}
