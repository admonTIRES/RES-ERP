<?php

namespace App\Http\Controllers\pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use DB;


class pdfController extends Controller
{
    public function descargarPDF($id)
    {
        $requisicion = DB::table('formulario_requisiconmaterial')->where('ID_FORMULARIO_MR', $id)->first();

        if (!$requisicion) {
            abort(404);
        }

        $materiales = collect(json_decode($requisicion->MATERIALES_JSON, true))
            ->filter(fn($item) => $item['CHECK_VO'] === 'SI' && $item['CHECK_MATERIAL'] === 'SI')
            ->values();

        $data = [
            'no_mr' => $requisicion->NO_MR,
            'fecha' => $requisicion->FECHA_APRUEBA_MR,
            'materiales' => $materiales,
        ];

        $pdf = Pdf::loadView('pdf.requisicion_materiales_pdf', $data)
            ->setPaper('letter', 'portrait');

        return $pdf->download("MR_{$requisicion->NO_MR}.pdf");
    }

   
}
