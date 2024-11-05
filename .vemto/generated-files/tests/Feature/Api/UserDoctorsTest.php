<?php

use App\Models\User;
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

test('it gets user doctors', function () {
    $user = User::factory()->create();
    $doctors = Doctor::factory()
        ->count(2)
        ->create([
            'user_id' => $user->id,
        ]);

    $response = $this->getJson(route('api.users.doctors.index', $user));

    $response->assertOk()->assertSee($doctors[0]->matricule);
});

test('it stores the user doctors', function () {
    $user = User::factory()->create();
    $data = Doctor::factory()
        ->make([
            'user_id' => $user->id,
        ])
        ->toArray();

    $response = $this->postJson(route('api.users.doctors.store', $user), $data);

    unset($data['created_at']);
    unset($data['updated_at']);
    unset($data['deleted_at']);

    $this->assertDatabaseHas('doctor', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $doctor = Doctor::latest('id')->first();

    $this->assertEquals($user->id, $doctor->user_id);
});
