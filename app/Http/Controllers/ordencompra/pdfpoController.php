<?php

namespace App\Http\Controllers\ordencompra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use DB;
use App\Models\ordencompra\poModel;
use App\Models\proveedor\directorioModel;

use App\Models\proveedor\altaproveedorModel;

use Illuminate\Support\Facades\Mail;
class pdfpoController extends Controller
{

    public function generarPDFPO($id)
    {
        $orden = poModel::find($id);

        if (!$orden) {
            return response()->json(['error' => 'Orden no encontrada'], 404);
        }

        $proveedor = directorioModel::where('RFC_PROVEEDOR', $orden->PROVEEDOR_SELECCIONADO)->first();


        $proveedor1 = altaproveedorModel::where('RFC_ALTA', $orden->PROVEEDOR_SELECCIONADO)->first();


        $usuarioSolicito = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $orden->USUARIO_ID)
            ->first();

        $usuarioAprobo = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $orden->APROBO_ID)
            ->first();

        return Pdf::loadView('pdf.po_pdf', compact('orden', 'proveedor', 'usuarioSolicito', 'usuarioAprobo', 'proveedor1'))
            ->download("PO_{$orden->NO_PO}.pdf");
    }



    public function enviarCorreoPO(Request $request)
    {
        try {

            $id = $request->id;

            
            $po = DB::table('formulario_ordencompra')
                ->where('ID_FORMULARIO_PO', $id)
                ->first();

            if (!$po) {
                return response()->json([
                    'success' => false,
                    'message' => 'PO no encontrada'
                ]);
            }

            $yaEnviado = DB::table('po_correos_enviados')
                ->where('po_id', $id)
                ->exists();

            if ($yaEnviado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este correo ya fue enviado anteriormente'
                ]);
            }

            $proveedor = DB::table('formulario_altaproveedor')
                ->where('RFC_ALTA', $po->PROVEEDOR_SELECCIONADO)
                ->first();

            if (!$proveedor || !$proveedor->CORREO_DIRECTORIO) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proveedor sin correo'
                ]);
            }

            $data = [
                'no_po' => $po->NO_PO,
                'fecha' => $po->FECHA_EMISION
            ];

            Mail::send('emails.envioPO', $data, function ($message) use ($proveedor) {
                $message->to($proveedor->CORREO_DIRECTORIO)
                    ->subject('Orden de compra pendiente');
            });

            DB::table('po_correos_enviados')->insert([
                'po_id' => $id,
                'fecha_envio' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Correo enviado correctamente'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }



}
