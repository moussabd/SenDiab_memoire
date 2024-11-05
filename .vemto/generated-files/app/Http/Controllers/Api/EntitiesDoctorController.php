<?php

namespace App\Http\Controllers\Api;

use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorCollection;

class EntitiesDoctorController extends Controller
{
    public function index(Request $request, Entity $entity): DoctorCollection
    {
        $search = $request->get('search', '');

        $doctors = $this->getSearchQuery($search, $entity)
            ->latest()
            ->paginate();

        return new DoctorCollection($doctors);
    }

    public function store(Request $request, Entity $entity): DoctorResource
    {
        $validated = $request->validate([]);

        $doctor = $entity->doctors()->create($validated);

        return new DoctorResource($doctor);
    }

    public function getSearchQuery(string $search, Entity $entity)
    {
        return $entity->doctors()->where('matricule', 'like', "%{$search}%");
    }
}
