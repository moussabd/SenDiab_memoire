<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorPatientResource;
use App\Http\Resources\DoctorPatientCollection;

class DoctorsDoctorPatientController extends Controller
{
    public function index(
        Request $request,
        Doctor $doctor
    ): DoctorPatientCollection {
        $search = $request->get('search', '');

        $doctorPatients = $this->getSearchQuery($search, $doctor)
            ->latest()
            ->paginate();

        return new DoctorPatientCollection($doctorPatients);
    }

    public function store(
        Request $request,
        Doctor $doctor
    ): DoctorPatientResource {
        $validated = $request->validate([
            'patient_id' => ['required'],
        ]);

        $doctorPatient = $doctor->doctorPatients()->create($validated);

        return new DoctorPatientResource($doctorPatient);
    }

    public function getSearchQuery(string $search, Doctor $doctor)
    {
        return $doctor
            ->doctorPatients()
            ->where('created_at', 'like', "%{$search}%");
    }
}
