<?php

use App\Models\User;
use App\Models\Parameter;
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

test('it gets parameter monitorings', function () {
    $parameter = Parameter::factory()->create();
    $monitorings = Monitoring::factory()
        ->count(2)
        ->create([
            'parameter_id' => $parameter->id,
        ]);

    $response = $this->getJson(
        route('api.parameters.monitorings.index', $parameter)
    );

    $response->assertOk()->assertSee($monitorings[0]->deleted_at);
});

test('it stores the parameter monitorings', function () {
    $parameter = Parameter::factory()->create();
    $data = Monitoring::factory()
        ->make([
            'parameter_id' => $parameter->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.parameters.monitorings.store', $parameter),
        $data
    );

    unset($data['patient_id']);
    unset($data['parameter_id']);
    unset($data['comments_patients']);
    unset($data['dateofsample']);
    unset($data['comments_doctor']);
    unset($data['deleted_at']);
    unset($data['value']);
    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('monitoring', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $monitoring = Monitoring::latest('id')->first();

    $this->assertEquals($parameter->id, $monitoring->parameter_id);
});
