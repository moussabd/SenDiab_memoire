<?php

namespace App\Http\Controllers\Api;

use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MonitoringResource;
use App\Http\Resources\MonitoringCollection;
use App\Http\Requests\MonitoringStoreRequest;
use App\Http\Requests\MonitoringUpdateRequest;

class MonitoringController extends Controller
{
    public function index(Request $request): MonitoringCollection
    {
        $search = $request->get('search', '');

        $monitorings = $this->getSearchQuery($search)
            ->latest()
            ->paginate();

        return new MonitoringCollection($monitorings);
    }

    public function store(MonitoringStoreRequest $request): MonitoringResource
    {
        $validated = $request->validated();

        $monitoring = Monitoring::create($validated);

        return new MonitoringResource($monitoring);
    }

    public function show(
        Request $request,
        Monitoring $monitoring
    ): MonitoringResource {
        return new MonitoringResource($monitoring);
    }

    public function update(
        MonitoringUpdateRequest $request,
        Monitoring $monitoring
    ): MonitoringResource {
        $validated = $request->validated();

        $monitoring->update($validated);

        return new MonitoringResource($monitoring);
    }

    public function destroy(Request $request, Monitoring $monitoring): Response
    {
        $monitoring->delete();

        return response()->noContent();
    }

    public function getSearchQuery(string $search)
    {
        return Monitoring::query();
    }
}
