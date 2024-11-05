<?php

use App\Models\User;
use App\Models\Entity;
use App\Models\Doctor;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets entity doctors', function () {
    $entity = Entity::factory()->create();
    $doctors = Doctor::factory()
        ->count(2)
        ->create([
            'entity_id' => $entity->id,
        ]);

    $response = $this->getJson(route('api.entities.doctors.index', $entity));

    $response->assertOk()->assertSee($doctors[0]->matricule);
});

test('it stores the entity doctors', function () {
    $entity = Entity::factory()->create();
    $data = Doctor::factory()
        ->make([
            'entity_id' => $entity->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.entities.doctors.store', $entity),
        $data
    );

    unset($data['matricule']);
    unset($data['speciality']);
    unset($data['num_ordre']);
    unset($data['user_id']);
    unset($data['entity_id']);
    unset($data['created_at']);
    unset($data['updated_at']);
    unset($data['deleted_at']);

    $this->assertDatabaseHas('doctor', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $doctor = Doctor::latest('id')->first();

    $this->assertEquals($entity->id, $doctor->entity_id);
});
