<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientCollection;

class UsersPatientController extends Controller
{
    public function index(Request $request, User $user): PatientCollection
    {
        $search = $request->get('search', '');

        $patients = $this->getSearchQuery($search, $user)
            ->latest()
            ->paginate();

        return new PatientCollection($patients);
    }

    public function store(Request $request, User $user): PatientResource
    {
        $validated = $request->validate([
            'matricule' => [
                'required',
                'string',
                Rule::unique('patient', 'matricule'),
            ],
            'medical_histroy' => ['nullable'],
        ]);

        $patient = $user->patients()->create($validated);

        return new PatientResource($patient);
    }

    public function getSearchQuery(string $search, User $user)
    {
        return $user->patients()->where('matricule', 'like', "%{$search}%");
    }
}
