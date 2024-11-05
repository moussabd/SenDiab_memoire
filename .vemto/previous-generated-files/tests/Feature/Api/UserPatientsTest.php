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

test('it gets user patients', function () {
    $user = User::factory()->create();
    $patients = Patient::factory()
        ->count(2)
        ->create([
            'user_id' => $user->id,
        ]);

    $response = $this->getJson(route('api.users.patients.index', $user));

    $response->assertOk()->assertSee($patients[0]->matricule);
});

test('it stores the user patients', function () {
    $user = User::factory()->create();
    $data = Patient::factory()
        ->make([
            'user_id' => $user->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.users.patients.store', $user),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('patient', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $patient = Patient::latest('id')->first();

    $this->assertEquals($user->id, $patient->user_id);
});
