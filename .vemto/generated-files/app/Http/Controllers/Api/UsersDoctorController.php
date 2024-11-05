<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorCollection;

class UsersDoctorController extends Controller
{
    public function index(Request $request, User $user): DoctorCollection
    {
        $search = $request->get('search', '');

        $doctors = $this->getSearchQuery($search, $user)
            ->latest()
            ->paginate();

        return new DoctorCollection($doctors);
    }

    public function store(Request $request, User $user): DoctorResource
    {
        $validated = $request->validate([
            'matricule' => [
                'required',
                'string',
                Rule::unique('doctor', 'matricule'),
            ],
            'speciality' => ['nullable', 'string'],
            'num_ordre' => [
                'required',
                'string',
                Rule::unique('doctor', 'num_ordre'),
            ],
            'entity_id' => ['required'],
        ]);

        $doctor = $user->doctors()->create($validated);

        return new DoctorResource($doctor);
    }

    public function getSearchQuery(string $search, User $user)
    {
        return $user->doctors()->where('matricule', 'like', "%{$search}%");
    }
}
