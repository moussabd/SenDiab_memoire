<?php

use App\Models\User;
use App\Models\Patient;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets patients list', function () {
    $patients = Patient::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.patients.index'));

    $response->assertOk()->assertSee($patients[0]->matricule);
});

test('it stores the patient', function () {
    $data = Patient::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.patients.store'), $data);

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('patient', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the patient', function () {
    $patient = Patient::factory()->create();

    $user = User::factory()->create();

    $data = [
        'matricule' => fake()->word(),
        'medical_histroy' => fake()->word(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
        'deleted_at' => fake()->dateTime(),
        'user_id' => $user->id,
    ];

    $response = $this->putJson(route('api.patients.update', $patient), $data);

    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $patient->id;

    $this->assertDatabaseHas('patient', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the patient', function () {
    $patient = Patient::factory()->create();

    $response = $this->deleteJson(route('api.patients.destroy', $patient));

    $this->assertSoftDeleted($patient);

    $response->assertNoContent();
});
