<?php

use App\Models\User;
use App\Models\Doctor;
use App\Models\Entity;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets doctors list', function () {
    $doctors = Doctor::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.doctors.index'));

    $response->assertOk()->assertSee($doctors[0]->matricule);
});

test('it stores the doctor', function () {
    $data = Doctor::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.doctors.store'), $data);

    unset($data['created_at']);
    unset($data['updated_at']);
    unset($data['deleted_at']);

    $this->assertDatabaseHas('doctor', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the doctor', function () {
    $doctor = Doctor::factory()->create();

    $user = User::factory()->create();
    $entity = Entity::factory()->create();

    $data = [
        'matricule' => fake()->word(),
        'speciality' => fake()->word(),
        'num_ordre' => fake()->word(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
        'deleted_at' => fake()->dateTime(),
        'user_id' => $user->id,
        'entity_id' => $entity->id,
    ];

    $response = $this->putJson(route('api.doctors.update', $doctor), $data);

    unset($data['created_at']);
    unset($data['updated_at']);
    unset($data['deleted_at']);

    $data['id'] = $doctor->id;

    $this->assertDatabaseHas('doctor', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the doctor', function () {
    $doctor = Doctor::factory()->create();

    $response = $this->deleteJson(route('api.doctors.destroy', $doctor));

    $this->assertSoftDeleted($doctor);

    $response->assertNoContent();
});
