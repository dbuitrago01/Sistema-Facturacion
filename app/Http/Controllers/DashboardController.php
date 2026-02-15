<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('panel.index');
    }

    public function data()
    {
        return response()->json([
            'kpis'          => $this->service->hoy(),
            'ultimasVentas' => $this->service->ultimasVentas(),
            'stockBajo'     => $this->service->stockBajo(),
        ]);
    }
}
