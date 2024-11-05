<?php

use App\Models\User;
use App\Models\Doctor;
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

test('it gets doctor doctor_patients', function () {
    $doctor = Doctor::factory()->create();
    $doctorPatients = DoctorPatient::factory()
        ->count(2)
        ->create([
            'doctor_id' => $doctor->id,
        ]);

    $response = $this->getJson(
        route('api.doctors.doctor-patients.index', $doctor)
    );

    $response->assertOk()->assertSee($doctorPatients[0]->created_at);
});

test('it stores the doctor doctor_patients', function () {
    $doctor = Doctor::factory()->create();
    $data = DoctorPatient::factory()
        ->make([
            'doctor_id' => $doctor->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.doctors.doctor-patients.store', $doctor),
        $data
    );

    unset($data['doctor_id']);
    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('doctor_patient', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $doctorPatient = DoctorPatient::latest('id')->first();

    $this->assertEquals($doctor->id, $doctorPatient->doctor_id);
});
