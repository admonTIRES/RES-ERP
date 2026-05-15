<?php

namespace App\Http\Controllers\ordentrabajo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use DB;





class pdfotController extends Controller
{
    public function descargarOT($id)
    {
        $ot = DB::table('formulario_ordentrabajo')
            ->where('ID_FORMULARIO_ORDEN', $id)
            ->first();

        if (!$ot) {
            abort(404);
        }

        $ofertaIds = json_decode($ot->OFERTA_ID, true) ?? [];

        $cotizaciones = DB::table('formulario_ofertas')
            ->whereIn('ID_FORMULARIO_OFERTAS', $ofertaIds)
            ->pluck('NO_OFERTA')
            ->toArray();

        $cotizacionesTexto = implode(', ', $cotizaciones);

        $servicios = json_decode($ot->SERVICIOS_JSON ?? '[]', true);

        $data = [
            'ot' => $ot,
            'cotizaciones' => $cotizacionesTexto,
            'servicios' => $servicios
        ];

        return Pdf::loadView('pdf.ot_pdf', $data)
            ->setOptions([
                'isPhpEnabled'      => true,
                'isRemoteEnabled'  => true,  
                'chroot'           => public_path() 
            ])
            ->download('OT_' . $ot->NO_ORDEN_CONFIRMACION . '.pdf');
    }
}
