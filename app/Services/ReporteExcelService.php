<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteExcelService
{
    // ✅ TODAS LAS VENTAS
    public function ventas()
    {
        $ventas = DB::table('ventas')
            ->join('users', 'ventas.user_id', '=', 'users.id')
            ->select(
                'ventas.id',
                'users.name as usuario',
                'ventas.total',
                'ventas.created_at'
            )
            ->orderByDesc('ventas.created_at')
            ->get();

        return $this->generarExcel($ventas, 'ventas_totales.xlsx');
    }

    // ✅ VENTAS POR FECHA 
    public function ventasPorFecha($inicio, $fin)
{
    $inicio = \Carbon\Carbon::parse($inicio)->startOfDay();
    $fin    = \Carbon\Carbon::parse($fin)->endOfDay();

    $ventas = DB::table('ventas')
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->whereBetween('ventas.created_at', [$inicio, $fin])
        ->select(
            'ventas.id',
            'users.name as usuario',
            'ventas.total',
            'ventas.created_at'
        )
        ->orderByDesc('ventas.created_at')
        ->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 🟢 ENCABEZADOS
    $sheet->fromArray([
        ['ID', 'Usuario', 'Total', 'Fecha']
    ]);

    $row = 2;
    $totalGeneral = 0;

    foreach ($ventas as $venta) {
        $sheet->fromArray([
            $venta->id,
            $venta->usuario,
            $venta->total,
            $venta->created_at
        ], null, "A{$row}");

        // 🔥 SUMAMOS EL TOTAL
        $totalGeneral += $venta->total;

        $row++;
    }

    // 🟣 FILA DEL TOTAL GENERAL
    $sheet->setCellValue("B{$row}", 'TOTAL');
    $sheet->setCellValue("C{$row}", $totalGeneral);

    // ✨ ESTILO BÁSICO
    $sheet->getStyle("B{$row}:C{$row}")->getFont()->setBold(true);

    return $this->download(
        $spreadsheet,
        'ventas_'.$inicio->toDateString().'_'.$fin->toDateString().'.xlsx'
    );
}

    // 🧠 MÉTODO REUTILIZABLE (LIMPIO)
    protected function generarExcel($ventas, $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->fromArray([
            ['ID', 'Usuario', 'Total', 'Fecha']
        ]);

        $row = 2;
        foreach ($ventas as $venta) {
            $sheet->fromArray([
                $venta->id,
                $venta->usuario,
                $venta->total,
                $venta->created_at,
            ], null, "A{$row}");
            $row++;
        }

        return $this->download($spreadsheet, $filename);
    }

    protected function download($spreadsheet, $filename)
    {
        $path = storage_path("app/{$filename}");

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
