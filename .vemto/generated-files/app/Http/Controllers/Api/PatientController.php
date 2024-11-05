<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientCollection;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Requests\PatientUpdateRequest;

class PatientController extends Controller
{
    public function index(Request $request): PatientCollection
    {
        $search = $request->get('search', '');

        $patients = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new PatientCollection($patients);
    }

    public function store(PatientStoreRequest $request): PatientResource
    {
        $validated = $request->validated();

        $patient = Patient::create($validated);

        return new PatientResource($patient);
    }

    public function show(Request $request, Patient $patient): PatientResource
    {
        return new PatientResource($patient);
    }

    public function update(
        PatientUpdateRequest $request,
        Patient $patient
    ): PatientResource {
        $validated = $request->validated();

        $patient->update($validated);

        return new PatientResource($patient);
    }

    public function destroy(Request $request, Patient $patient): Response
    {
        $patient->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Patient::query()->where('matricule', 'like', "%{$search}%");
    }
}
