<?php

use App\Models\User;
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

test('it gets entities list', function () {
    $entities = Entity::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.entities.index'));

    $response->assertOk()->assertSee($entities[0]->name);
});

test('it stores the entity', function () {
    $data = Entity::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.entities.store'), $data);

    unset($data['name']);
    unset($data['address']);
    unset($data['type']);
    unset($data['telephone']);
    unset($data['email']);
    unset($data['created_at']);
    unset($data['updated_at']);
    unset($data['deleted_at']);

    $this->assertDatabaseHas('entity', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the entity', function () {
    $entity = Entity::factory()->create();

    $data = [
        'name' => fake()->name(),
        'address' => fake()->address(),
        'type' => fake()->word(),
        'telephone' => fake()->text(255),
        'email' => fake()
            ->unique()
            ->safeEmail(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
        'deleted_at' => fake()->dateTime(),
    ];

    $response = $this->putJson(route('api.entities.update', $entity), $data);

    unset($data['name']);
    unset($data['address']);
    unset($data['type']);
    unset($data['telephone']);
    unset($data['email']);
    unset($data['created_at']);
    unset($data['updated_at']);
    unset($data['deleted_at']);

    $data['id'] = $entity->id;

    $this->assertDatabaseHas('entity', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the entity', function () {
    $entity = Entity::factory()->create();

    $response = $this->deleteJson(route('api.entities.destroy', $entity));

    $this->assertSoftDeleted($entity);

    $response->assertNoContent();
});
