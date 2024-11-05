<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\MonitoringResource;
use App\Http\Resources\MonitoringCollection;

class PatientsMonitoringController extends Controller
{
    public function index(
        Request $request,
        Patient $patient
    ): MonitoringCollection {
        $search = $request->get('search', '');

        $monitorings = $this->getSearchQuery($search, $patient)
            ->latest()
            ->paginate();

        return new MonitoringCollection($monitorings);
    }

    public function store(
        Request $request,
        Patient $patient
    ): MonitoringResource {
        $validated = $request->validate([
            'parameter_id' => ['required'],
            'comments' => ['nullable'],
            'value' => ['nullable'],
        ]);

        $monitoring = $patient->monitorings()->create($validated);

        return new MonitoringResource($monitoring);
    }

    public function getSearchQuery(string $search, Patient $patient)
    {
        return $patient
            ->monitorings()
            ->where('created_at', 'like', "%{$search}%");
    }
}
