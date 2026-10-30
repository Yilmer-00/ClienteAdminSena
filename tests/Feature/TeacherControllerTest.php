<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TeacherControllerTest extends TestCase
{
    public function test_teacher_edit_form_selects_the_center_returned_by_the_api(): void
    {
        config(['services.api.url' => 'http://api.example.test/v1']);

        Http::fake([
            'http://api.example.test/v1/teachers/7' => Http::response([
                'success' => true,
                'data' => [
                    'id' => 7,
                    'name' => 'Ana Instructor',
                    'email' => 'ana@example.test',
                    'area_id' => 2,
                    'training_center_id' => 3,
                ],
            ]),
            'http://api.example.test/v1/areas' => Http::response([
                'success' => true,
                'data' => [['id' => 2, 'name' => 'Tecnología']],
            ]),
            'http://api.example.test/v1/training-centers' => Http::response([
                'success' => true,
                'data' => [['id' => 3, 'name' => 'Centro Norte']],
            ]),
        ]);

        $this->get(route('teacher.edit', 7))
            ->assertOk()
            ->assertSeeInOrder([
                'name="trainig_center_id"',
                'value="3"',
                'selected',
                'Centro Norte',
            ], false);
    }

    public function test_teacher_update_sends_form_data_and_shows_the_updated_teacher(): void
    {
        config(['services.api.url' => 'http://api.example.test/v1']);

        Http::fake([
            'http://api.example.test/v1/teachers/7' => Http::sequence()
                ->push(['success' => true])
                ->push([
                    'success' => true,
                    'data' => [
                        'id' => 7,
                        'name' => 'Ana Instructor Actualizada',
                        'email' => 'ana.actualizada@example.test',
                        'area' => ['name' => 'Tecnología'],
                        'trainig_center' => ['name' => 'Centro Norte'],
                    ],
                ]),
        ]);

        $response = $this->put(route('teacher.update', 7), [
            'name' => 'Ana Instructor Actualizada',
            'email' => 'ana.actualizada@example.test',
            'area_id' => '2',
            'trainig_center_id' => '3',
        ]);

        $response->assertRedirect(route('teacher.show', 7));

        Http::assertSent(fn (ClientRequest $request) => $request->method() === 'PUT'
            && $request->url() === 'http://api.example.test/v1/teachers/7'
            && $request->hasHeader('Content-Type', 'application/x-www-form-urlencoded')
            && $request['trainig_center_id'] === '3'
            && $request['area_id'] === '2');

        $this->get(route('teacher.show', 7))
            ->assertOk()
            ->assertSee('Ana Instructor Actualizada')
            ->assertSee('ana.actualizada@example.test')
            ->assertSee('Centro Norte')
            ->assertSee('Docente actualizado correctamente.');
    }
}
