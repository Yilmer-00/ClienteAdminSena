<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ComputerControllerTest extends TestCase
{
    public function test_computer_creation_sends_data_to_the_api_and_shows_success(): void
    {
        config(['services.api.url' => 'http://api.example.test/v1']);

        Http::fake([
            'http://api.example.test/v1/computers' => Http::response(['success' => true], 201),
        ]);

        $response = $this->from(route('computer.create'))->post(route('computer.store'), [
            'number' => 'COMP-012',
            'brand' => 'Lenovo',
            'urlFoto' => UploadedFile::fake()->createWithContent(
                'computer.png',
                base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII=')
            ),
        ]);

        $response->assertRedirect(route('computer.index'));
        $response->assertSessionHas('success', 'Computador creado correctamente.');

        Http::assertSent(fn (ClientRequest $request) => $request->method() === 'POST'
            && $request->url() === 'http://api.example.test/v1/computers'
            && $request->isMultipart()
            && str_contains($request->body(), 'name="number"')
            && str_contains($request->body(), 'COMP-012')
            && str_contains($request->body(), 'name="brand"')
            && str_contains($request->body(), 'Lenovo')
            && $request->hasFile('urlFoto', null, 'computer.png'));
    }

    public function test_computer_creation_shows_api_errors(): void
    {
        config(['services.api.url' => 'http://api.example.test/v1']);

        Http::fake([
            'http://api.example.test/v1/computers' => Http::response(['message' => 'Creation failed'], 422),
        ]);

        $response = $this->from(route('computer.create'))->post(route('computer.store'), [
            'number' => 'COMP-012',
            'brand' => 'Lenovo',
        ]);

        $response->assertRedirect(route('computer.create'));
        $response->assertSessionHasErrors('api');
    }

    public function test_computer_index_displays_records_from_the_api(): void
    {
        config(['services.api.url' => 'http://api.example.test/v1']);

        Http::fake([
            'http://api.example.test/v1/computers' => Http::response([
                'success' => true,
                'data' => [[
                    'id' => 12,
                    'number' => 'COMP-012',
                    'brand' => 'Lenovo',
                    'urlFoto' => 'computers/comp-012.jpg',
                ]],
            ]),
        ]);

        $this->get(route('computer.index'))
            ->assertOk()
            ->assertSee('COMP-012')
            ->assertSee('Lenovo')
            ->assertSee('http://api.example.test/storage/computers/comp-012.jpg');
    }

    public function test_computer_index_reports_api_errors(): void
    {
        config(['services.api.url' => 'http://api.example.test/v1']);

        Http::fake([
            'http://api.example.test/v1/computers' => Http::response([], 500),
        ]);

        $this->get(route('computer.index'))
            ->assertOk()
            ->assertSee('No fue posible cargar los computadores.');
    }
}
