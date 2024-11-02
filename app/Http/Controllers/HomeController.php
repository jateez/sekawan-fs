<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function dashboard()
    {
        $vehicles = Vehicle::with(['gasConsumptions', 'services', 'usages'])->get();

        return Inertia::render('Dashboard', [
            'vehicles' => $vehicles->map(function ($vehicle) {
                return [
                    'id' => $vehicle->id,
                    'model' => $vehicle->model,
                    'latest_gas_consumption' => $vehicle->gasConsumptions->last(),
                    'next_service_date' => optional($vehicle->services->last())->next_service_date,
                    'total_usage' => $vehicle->usages->sum(fn($usage) => $usage->end_odometer - $usage->start_odometer),
                    'status' => $vehicle->status,
                    'type' => $vehicle->type,
                ];
            }),
        ]);
    }
}
