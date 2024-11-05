<?php

namespace App\Http\Controllers\Api;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParameterResource;
use App\Http\Resources\ParameterCollection;
use App\Http\Requests\ParameterStoreRequest;
use App\Http\Requests\ParameterUpdateRequest;

class ParameterController extends Controller
{
    public function index(Request $request): ParameterCollection
    {
        $search = $request->get('search', '');

        $parameters = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new ParameterCollection($parameters);
    }

    public function store(ParameterStoreRequest $request): ParameterResource
    {
        $validated = $request->validated();

        $parameter = Parameter::create($validated);

        return new ParameterResource($parameter);
    }

    public function show(
        Request $request,
        Parameter $parameter
    ): ParameterResource {
        return new ParameterResource($parameter);
    }

    public function update(
        ParameterUpdateRequest $request,
        Parameter $parameter
    ): ParameterResource {
        $validated = $request->validated();

        $parameter->update($validated);

        return new ParameterResource($parameter);
    }

    public function destroy(Request $request, Parameter $parameter): Response
    {
        $parameter->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Parameter::query();
    }
}
