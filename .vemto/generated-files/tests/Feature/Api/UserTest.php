<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets users list', function () {
    $users = User::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.users.index'));

    $response->assertOk()->assertSee($users[0]->email);
});

test('it stores the user', function () {
    $data = User::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.users.store'), $data);

    unset($data['email_verified_at']);
    unset($data['current_team_id']);
    unset($data['profile_photo_path']);
    unset($data['age']);
    unset($data['phone_number']);
    unset($data['created_at']);
    unset($data['date_of_birth']);
    unset($data['place_of_birth']);
    unset($data['firstname']);
    unset($data['two_factor_confirmed_at']);
    unset($data['lastname']);
    unset($data['deleted_at']);
    unset($data['cni']);
    unset($data['address']);
    unset($data['civility']);
    unset($data['gender']);
    unset($data['updated_at']);
    unset($data['profile_photo_url']);
    unset($data['email']);

    $this->assertDatabaseHas('users', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the user', function () {
    $user = User::factory()->create();

    $data = [
        'email' => fake()
            ->unique()
            ->safeEmail(),
    ];

    $response = $this->putJson(route('api.users.update', $user), $data);

    unset($data['email_verified_at']);
    unset($data['current_team_id']);
    unset($data['profile_photo_path']);
    unset($data['age']);
    unset($data['phone_number']);
    unset($data['created_at']);
    unset($data['date_of_birth']);
    unset($data['place_of_birth']);
    unset($data['firstname']);
    unset($data['two_factor_confirmed_at']);
    unset($data['lastname']);
    unset($data['deleted_at']);
    unset($data['cni']);
    unset($data['address']);
    unset($data['civility']);
    unset($data['gender']);
    unset($data['updated_at']);
    unset($data['profile_photo_url']);
    unset($data['email']);

    $data['id'] = $user->id;

    $this->assertDatabaseHas('users', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the user', function () {
    $user = User::factory()->create();

    $response = $this->deleteJson(route('api.users.destroy', $user));

    $this->assertSoftDeleted($user);

    $response->assertNoContent();
});
