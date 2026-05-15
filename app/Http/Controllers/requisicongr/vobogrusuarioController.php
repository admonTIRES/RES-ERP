<?php

namespace App\Http\Controllers\requisicongr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use DB;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;
use App\Models\inventario\inventarioModel;
use App\Models\inventario\catalogotipoinventarioModel;



class vobogrusuarioController extends Controller
{
    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP', 'NOMBRE_PROVEEDORTEMP')->get();

        $tipoinventario = catalogotipoinventarioModel::where('ACTIVO', 1)->get();
        $inventario = inventarioModel::where('ACTIVO', 1)->get();


        return view('compras.recepciongr.vobousuariogr', compact('proveedoresOficiales', 'proveedoresTemporales', 'tipoinventario', 'inventario'));
    }



    public function TablaVoBoGRusuarios()
    {
        try {
            $usuarioId = auth()->id();

          
            $rows = DB::table('formulario_bitacoragr as gr')
                ->join('formulario_bitacoragr_detalle as d', 'd.ID_GR', '=', 'gr.ID_GR')
                ->where('gr.USUARIO_ID', $usuarioId)
                ->where('gr.MANDAR_USUARIO_VOBO', 'Sí')
                ->whereNull('gr.VO_BO_USUARIO')
                ->where(function ($q) {

                    $q->whereNull('d.BIENS_PARCIAL') 
                        ->orWhere('d.BIENS_PARCIAL', '!=', 'Sí')

                        ->orWhere(function ($sub) {
                            $sub->where('d.BIENS_PARCIAL', 'Sí')
                                ->whereNotNull('d.CANTIDAD_ACEPTADA')
                                ->whereNotNull('d.CANTIDAD_ENTRA_ALMACEN')
                                ->where('d.CANTIDAD_ACEPTADA', '!=', '')
                                ->where('d.CANTIDAD_ENTRA_ALMACEN', '!=', '');
                        });
                })

                ->select(
                    'gr.ID_GR',
                    'gr.NO_RECEPCION',
                    DB::raw('COUNT(d.ID_DETALLE) as TOTAL_PRODUCTOS')
                )
                ->groupBy('gr.ID_GR', 'gr.NO_RECEPCION')
                ->get();

                
            foreach ($rows as $value) {
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR" data-id="' . $value->ID_GR . '"><i class="bi bi-pencil-square"></i></button>';
            }

            return response()->json(['data' => $rows]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function ConsultarProductosVoBo($idGR)
    {
        try {

            $cabecera = DB::table('formulario_bitacoragr')
                ->where('ID_GR', $idGR)
                ->select('ID_GR', 'NO_RECEPCION')
                ->first();

            if (!$cabecera) {
                return response()->json([
                    'ok' => false,
                    'msg' => 'No se encontró la recepción'
                ]);
            }

            $detalle = DB::table('formulario_bitacoragr_detalle')
                ->where('ID_GR', $idGR)
                ->where(function ($q) {

                    $q->whereNull('BIENS_PARCIAL')
                        ->orWhere('BIENS_PARCIAL', '!=', 'Sí')

                        ->orWhere(function ($sub) {
                            $sub->where('BIENS_PARCIAL', 'Sí')
                                ->where('CANTIDAD_ACEPTADA', '>', 0)
                                ->where('CANTIDAD_ENTRA_ALMACEN', '>', 0);
                        });
                })
                ->select(
                    'ID_DETALLE',
                    'DESCRIPCION',
                    'CANTIDAD_ACEPTADA',
                    'CANTIDAD_ACEPTADA_USUARIO',
                    'CUMPLE_ESPECIFICADO_USUARIO',
                    'COMENTARIO_CUMPLE_USUARIO',
                    'ESTADO_BS_USUARIO',
                    'COMENTARIO_ESTADO_USUARIO',
                    'VOBO_USUARIO_PRODUCTO'
                )
                ->get();

            return response()->json([
                'ok' => true,
                'cabecera' => $cabecera,
                'detalle' => $detalle
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'ok' => false,
                'msg' => $e->getMessage()
            ], 500);
        }
    }




    public function guardarVoBoUsuario(Request $request)
    {
        DB::beginTransaction();
        try {
            $idGR = $request->ID_GR;

            DB::table('formulario_bitacoragr')
                ->where('ID_GR', $idGR)
                ->update([
                    'FECHA_VOUSUARIO' => $request->FECHA_VOUSUARIO,
                    'VO_BO_USUARIO'   => $request->VO_BO_USUARIO,
                    'UPDATED_AT'      => now(),
                ]);

            if ($request->has('CUMPLE_ESPECIFICADO_USUARIO')) {
                foreach ($request->CUMPLE_ESPECIFICADO_USUARIO as $idDetalle => $cumpleUsuario) {
                    DB::table('formulario_bitacoragr_detalle')
                        ->where('ID_DETALLE', $idDetalle)
                        ->update([
                            'CUMPLE_ESPECIFICADO_USUARIO' => $cumpleUsuario ?? null,
                            'COMENTARIO_CUMPLE_USUARIO'   => $request->COMENTARIO_CUMPLE_USUARIO[$idDetalle] ?? null,
                            'ESTADO_BS_USUARIO'           => $request->ESTADO_BS_USUARIO[$idDetalle] ?? null,
                            'COMENTARIO_ESTADO_USUARIO'   => $request->COMENTARIO_ESTADO_USUARIO[$idDetalle] ?? null,
                            'VOBO_USUARIO_PRODUCTO'       => $request->VOBO_USUARIO_PRODUCTO[$idDetalle] ?? null,
                            'COMENTARIO_VO_RECHAZO'       => $request->COMENTARIO_VO_RECHAZO[$idDetalle] ?? null,
                            'UPDATED_AT'                  => now(),
                        ]);
                }
            }


            DB::commit();
            return response()->json(['ok' => true, 'msg' => 'Vo.Bo guardado correctamente']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'ok' => false,
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
