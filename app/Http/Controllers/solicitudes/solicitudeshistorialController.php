<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\solicitudes\solicitudesModel;
use App\Models\solicitudes\verificacionsolicitudModel;


use App\Models\solicitudes\catalogomediocontactoModel;
use App\Models\solicitudes\catalonecesidadModel;
use App\Models\solicitudes\catalogiroempresaModel;
use App\Models\solicitudes\catalogolineanegociosModel;
use App\Models\solicitudes\catalogotiposervicioModel;

use App\Models\proveedor\catalogotituloproveedorModel;
use App\Models\cliente\clienteModel;

class solicitudeshistorialController extends Controller
{
    public function index()
    {


        $medios = catalogomediocontactoModel::where('ACTIVO', 1)->get();
        $necesidades = catalonecesidadModel::where('ACTIVO', 1)->get();
        $giros = catalogiroempresaModel::where('ACTIVO', 1)->get();

        $lineas = catalogolineanegociosModel::where('ACTIVO', 1)->get();
        $tipos = catalogotiposervicioModel::where('ACTIVO', 1)->get();

        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();


        $clientes = clienteModel::where('ACTIVO', 1)->get();


        return view('ventas.solicitudes.solicitudeshistorial', compact('medios', 'necesidades', 'giros', 'lineas', 'tipos', 'titulosCuenta', 'clientes'));
    }



    public function Tablasolicitudeshistorial(Request $request)
    {
        try {

            $query = solicitudesModel::query();

            if ($request->filled('FECHA_INICIO') && $request->filled('FECHA_FIN')) {
                $query->whereBetween(
                    DB::raw('DATE(FECHA_CREACION_SOLICITUD)'),
                    [$request->FECHA_INICIO, $request->FECHA_FIN]
                );
            }

            $tabla = $query->get();

            $rows = [];
            foreach ($tabla as $value) {

                $verificaciones = verificacionsolicitudModel::where(
                    'SOLICITUD_ID',
                    $value->ID_FORMULARIO_SOLICITUDES
                )->get();

                $verificacionesAgrupadas = $verificaciones->map(function ($verificacion) {
                    return [
                        'VERIFICADO_EN' => $verificacion->VERIFICADO_EN,
                        'EVIDENCIA_VERIFICACION' => $verificacion->EVIDENCIA_VERIFICACION,
                        'BTN_DOCUMENTO' =>
                        '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacion"
                            data-id="' . $verificacion->ID_VERIFICACION_SOLICITUD . '"
                            title="Ver evidencia">
                            <i class="bi bi-filetype-pdf"></i>
                        </button>'
                    ];
                });

                $rows[] = array_merge($value->toArray(), [
                    'SOLICITAR_VERIFICACION' => $value->SOLICITAR_VERIFICACION,
                    'PROCEDE_COTIZAR' => $value->PROCEDE_COTIZAR,
                    'MOTIVO_COTIZACION' => $value->MOTIVO_COTIZACION,
                    'VERIFICACIONES' => $verificacionesAgrupadas,
                    'BTN_EDITAR' => '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled>
                                    <i class="bi bi-ban"></i>
                                 </button>',
                    'BTN_VISUALIZAR' => '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                                        <i class="bi bi-eye"></i>
                                     </button>',
                    'BTN_ELIMINAR' => '<label class="switch">
                                    <input type="checkbox" class="ELIMINAR"
                                        data-id="' . $value->ID_FORMULARIO_SOLICITUDES . '"' .
                        ($value->ACTIVO ? ' checked' : '') . '>
                                    <span class="slider round"></span>
                                  </label>',
                    'BTN_CORREO' => ($value->ACTIVO == 0)
                        ? '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" disabled>
                            <i class="bi bi-ban"></i>
                       </button>'
                        : '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO">
                            <i class="bi bi-envelope-arrow-up-fill"></i>
                       </button>',
                ]);
            }

            return response()->json([
                'data' => $rows,
                'msj' => 'Información consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => 0
            ]);
        }
    }

    
    }
