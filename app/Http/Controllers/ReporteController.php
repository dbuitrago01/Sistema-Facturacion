<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReporteExcelService;

class ReporteController extends Controller
{
    protected $excel;

    public function __construct(ReporteExcelService $excel)
    {
        $this->excel = $excel;
    }

    public function index()
    {
        return view('reportes.reporte');
    }

    public function ventas()
    {
        return $this->excel->ventas();
    }

    public function ventasPorFecha(Request $request)
    {
        $request->validate([
            'inicio' => 'required|date',
            'fin'    => 'required|date|after_or_equal:inicio',
        ]);

        return $this->excel->ventasPorFecha(
            $request->inicio,
            $request->fin
        );
    }
}
