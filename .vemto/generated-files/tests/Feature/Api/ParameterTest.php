<?php

use App\Models\User;
use App\Models\Parameter;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets parameters list', function () {
    $parameters = Parameter::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.parameters.index'));

    $response->assertOk()->assertSee($parameters[0]->name);
});

test('it stores the parameter', function () {
    $data = Parameter::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.parameters.store'), $data);

    unset($data['name']);
    unset($data['max_value']);
    unset($data['min_value']);
    unset($data['unity']);
    unset($data['notification_min']);
    unset($data['notification_max']);
    unset($data['deleted_at']);
    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('parameter', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the parameter', function () {
    $parameter = Parameter::factory()->create();

    $data = [
        'name' => fake()->name(),
        'max_value' => fake()->randomNumber(2),
        'min_value' => fake()->randomNumber(2),
        'unity' => fake()->text(255),
        'notification_min' => fake()->word(),
        'notification_max' => fake()->word(),
        'deleted_at' => fake()->dateTime(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
    ];

    $response = $this->putJson(
        route('api.parameters.update', $parameter),
        $data
    );

    unset($data['name']);
    unset($data['max_value']);
    unset($data['min_value']);
    unset($data['unity']);
    unset($data['notification_min']);
    unset($data['notification_max']);
    unset($data['deleted_at']);
    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $parameter->id;

    $this->assertDatabaseHas('parameter', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the parameter', function () {
    $parameter = Parameter::factory()->create();

    $response = $this->deleteJson(route('api.parameters.destroy', $parameter));

    $this->assertSoftDeleted($parameter);

    $response->assertNoContent();
});
