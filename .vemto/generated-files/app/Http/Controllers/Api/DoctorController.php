<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorCollection;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;

class DoctorController extends Controller
{
    public function index(Request $request): DoctorCollection
    {
        $search = $request->get('search', '');

        $doctors = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new DoctorCollection($doctors);
    }

    public function store(DoctorStoreRequest $request): DoctorResource
    {
        $validated = $request->validated();

        $doctor = Doctor::create($validated);

        return new DoctorResource($doctor);
    }

    public function show(Request $request, Doctor $doctor): DoctorResource
    {
        return new DoctorResource($doctor);
    }

    public function update(
        DoctorUpdateRequest $request,
        Doctor $doctor
    ): DoctorResource {
        $validated = $request->validated();

        $doctor->update($validated);

        return new DoctorResource($doctor);
    }

    public function destroy(Request $request, Doctor $doctor): Response
    {
        $doctor->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Doctor::query()->where('matricule', 'like', "%{$search}%");
    }
}
