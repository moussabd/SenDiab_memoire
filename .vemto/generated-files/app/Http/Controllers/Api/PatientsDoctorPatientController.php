<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorPatientResource;
use App\Http\Resources\DoctorPatientCollection;

class PatientsDoctorPatientController extends Controller
{
    public function index(
        Request $request,
        Patient $patient
    ): DoctorPatientCollection {
        $search = $request->get('search', '');

        $doctorPatients = $this->getSearchQuery($search, $patient)
            ->latest()
            ->paginate();

        return new DoctorPatientCollection($doctorPatients);
    }

    public function store(
        Request $request,
        Patient $patient
    ): DoctorPatientResource {
        $validated = $request->validate([]);

        $doctorPatient = $patient->doctorPatients()->create($validated);

        return new DoctorPatientResource($doctorPatient);
    }

    public function getSearchQuery(string $search, Patient $patient)
    {
        return $patient
            ->doctorPatients()
            ->where('created_at', 'like', "%{$search}%");
    }
}
