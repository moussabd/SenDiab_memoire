<?php

namespace App\Http\Controllers\Api;

use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\EntityResource;
use App\Http\Resources\EntityCollection;
use App\Http\Requests\EntityStoreRequest;
use App\Http\Requests\EntityUpdateRequest;

class EntityController extends Controller
{
    public function index(Request $request): EntityCollection
    {
        $search = $request->get('search', '');

        $entities = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new EntityCollection($entities);
    }

    public function store(EntityStoreRequest $request): EntityResource
    {
        $validated = $request->validated();

        $entity = Entity::create($validated);

        return new EntityResource($entity);
    }

    public function show(Request $request, Entity $entity): EntityResource
    {
        return new EntityResource($entity);
    }

    public function update(
        EntityUpdateRequest $request,
        Entity $entity
    ): EntityResource {
        $validated = $request->validated();

        $entity->update($validated);

        return new EntityResource($entity);
    }

    public function destroy(Request $request, Entity $entity): Response
    {
        $entity->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Entity::query();
    }
}
