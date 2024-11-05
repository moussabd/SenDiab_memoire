<?php

use App\Models\User;
use App\Models\Patient;
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

test('it gets patient monitorings', function () {
    $patient = Patient::factory()->create();
    $monitorings = Monitoring::factory()
        ->count(2)
        ->create([
            'patient_id' => $patient->id,
        ]);

    $response = $this->getJson(
        route('api.patients.monitorings.index', $patient)
    );

    $response->assertOk()->assertSee($monitorings[0]->created_at);
});

test('it stores the patient monitorings', function () {
    $patient = Patient::factory()->create();
    $data = Monitoring::factory()
        ->make([
            'patient_id' => $patient->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.patients.monitorings.store', $patient),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);
    unset($data['deleted_at']);

    $this->assertDatabaseHas('monitoring', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $monitoring = Monitoring::latest('id')->first();

    $this->assertEquals($patient->id, $monitoring->patient_id);
});
