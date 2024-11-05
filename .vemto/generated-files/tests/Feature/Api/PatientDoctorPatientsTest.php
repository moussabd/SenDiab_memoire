<?php

use App\Models\User;
use App\Models\Patient;
use Laravel\Sanctum\Sanctum;
use App\Models\DoctorPatient;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets patient doctor_patients', function () {
    $patient = Patient::factory()->create();
    $doctorPatients = DoctorPatient::factory()
        ->count(2)
        ->create([
            'patient_id' => $patient->id,
        ]);

    $response = $this->getJson(
        route('api.patients.doctor-patients.index', $patient)
    );

    $response->assertOk()->assertSee($doctorPatients[0]->created_at);
});

test('it stores the patient doctor_patients', function () {
    $patient = Patient::factory()->create();
    $data = DoctorPatient::factory()
        ->make([
            'patient_id' => $patient->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.patients.doctor-patients.store', $patient),
        $data
    );

    unset($data['doctor_id']);
    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('doctor_patient', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $doctorPatient = DoctorPatient::latest('id')->first();

    $this->assertEquals($patient->id, $doctorPatient->patient_id);
});
