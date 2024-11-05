<?php

namespace App\Http\Controllers\Api;

use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\MonitoringResource;
use App\Http\Resources\MonitoringCollection;

class ParametersMonitoringController extends Controller
{
    public function index(
        Request $request,
        Parameter $parameter
    ): MonitoringCollection {
        $search = $request->get('search', '');

        $monitorings = $this->getSearchQuery($search, $parameter)
            ->latest()
            ->paginate();

        return new MonitoringCollection($monitorings);
    }

    public function store(
        Request $request,
        Parameter $parameter
    ): MonitoringResource {
        $validated = $request->validate([]);

        $monitoring = $parameter->monitorings()->create($validated);

        return new MonitoringResource($monitoring);
    }

    public function getSearchQuery(string $search, Parameter $parameter)
    {
        return $parameter->monitorings();
    }
}
