<?php

use App\Models\User;
use App\Models\Patient;
use App\Models\Parameter;
use App\Models\Monitoring;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets monitorings list', function () {
    $monitorings = Monitoring::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.monitorings.index'));

    $response->assertOk()->assertSee($monitorings[0]->deleted_at);
});

test('it stores the monitoring', function () {
    $data = Monitoring::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.monitorings.store'), $data);

    unset($data['patient_id']);
    unset($data['parameter_id']);
    unset($data['comments_patients']);
    unset($data['dateofsample']);
    unset($data['comments_doctor']);
    unset($data['deleted_at']);
    unset($data['value']);
    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('monitoring', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the monitoring', function () {
    $monitoring = Monitoring::factory()->create();

    $patient = Patient::factory()->create();
    $parameter = Parameter::factory()->create();

    $data = [
        'comments_patients' => fake()->word(),
        'dateofsample' => fake()->date(),
        'comments_doctor' => fake()->word(),
        'deleted_at' => fake()->dateTime(),
        'value' => fake()->randomNumber(2),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
        'patient_id' => $patient->id,
        'parameter_id' => $parameter->id,
    ];

    $response = $this->putJson(
        route('api.monitorings.update', $monitoring),
        $data
    );

    unset($data['patient_id']);
    unset($data['parameter_id']);
    unset($data['comments_patients']);
    unset($data['dateofsample']);
    unset($data['comments_doctor']);
    unset($data['deleted_at']);
    unset($data['value']);
    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $monitoring->id;

    $this->assertDatabaseHas('monitoring', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the monitoring', function () {
    $monitoring = Monitoring::factory()->create();

    $response = $this->deleteJson(
        route('api.monitorings.destroy', $monitoring)
    );

    $this->assertSoftDeleted($monitoring);

    $response->assertNoContent();
});
