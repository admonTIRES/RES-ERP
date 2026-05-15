<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


use App\Models\proveedor\altacontactos;
use App\Models\proveedor\catalogofuncionesproveedorModel;
use App\Models\proveedor\catalogotituloproveedorModel;
use App\Models\proveedor\catalogodocumentoproveedorModel;
use App\Models\proveedor\catalogoverificacionproveedorModel;


use App\Models\proveedor\altacertificacionModel;
use App\Models\proveedor\altacuentaModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\altareferenciasModel;
use App\Models\proveedor\altadocumentosModel;

use App\Models\proveedor\asignacionproveedorModel;

use DB;


class listaproveedorcriticoController extends Controller
{
    public function index()
    {
        $funcionesCuenta = catalogofuncionesproveedorModel::all();
        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();
        $documetoscatalogo = catalogodocumentoproveedorModel::where('ACTIVO', 1)->get();
        $verificacioncatalogo = catalogoverificacionproveedorModel::where('ACTIVO', 1)
            ->orderBy('NOMBRE_VERIFICACION')
            ->get();


        return view('compras.listaproveedor.listaproveedorescriticos', compact('funcionesCuenta', 'titulosCuenta', 'documetoscatalogo', 'verificacioncatalogo'));
    }



    public function Tablalistaproveedorescriticos()
    {
        try {
            $tabla = altaproveedorModel::select('*')
                ->where('PROVEEDOR_CRITICO', 1)
                ->where('ACTIVO', 1)
                ->get();
            foreach ($tabla as $value) {


                if ($value->ACTIVO == 0) {

                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ALTA . '"><span class="slider round"></span></label>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_ALTA . '" checked><span class="slider round"></span></label>';
                }



                if ((int) $value->VERIFICACION_SOLICITADA === 1) {
                    $value->ESTATUS_DATOS = '<span class="badge bg-success">Completo</span>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '';
                    continue;
                }


                $mensajes = [];
                $rfc = $value->RFC_ALTA;
                $tipoPersona = $value->TIPO_PERSONA_ALTA;
                $tipoPersonaOpcion = $value->TIPO_PERSONA_OPCION;

                if (!DB::table('formulario_altacontactoproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Falta agregar contactos.';
                }

                if (!DB::table('formulario_altacuentaproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Falta agregar cuentas bancarias.';
                }

                if (!DB::table('formulario_altareferenciasproveedor')->where('RFC_PROVEEDOR', $rfc)->exists()) {
                    $mensajes[] = 'Faltan agregar referencias comerciales.';
                }

                $documentosObligatorios = DB::table('catalogo_documentosproveedor')
                    ->where('ACTIVO', 1)
                    ->where('TIPO_DOCUMENTO', 1)
                    ->where(function ($q) use ($tipoPersona) {
                        $q->where('TIPO_PERSONA', $tipoPersona)
                            ->orWhere('TIPO_PERSONA', 3);
                    })
                    ->where(function ($q) use ($tipoPersonaOpcion) {
                        $q->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
                            ->orWhere('TIPO_PERSONA_OPCION', 3);
                    })
                    ->get();

                $documentosSubidos = DB::table('formulario_altadocumentoproveedores')
                    ->where('RFC_PROVEEDOR', $rfc)
                    ->pluck('TIPO_DOCUMENTO_PROVEEDOR')
                    ->toArray();

                foreach ($documentosObligatorios as $doc) {
                    if (!in_array($doc->ID_CATALOGO_DOCUMENTOSPROVEEDOR, $documentosSubidos)) {
                        $mensajes[] = 'Falta el documento: ' . $doc->NOMBRE_DOCUMENTO;
                    }
                }

                $value->ESTATUS_DATOS = empty($mensajes)
                    ? '<span class="badge bg-success">Completo</span>'
                    : implode('<br>', array_map(fn($msg) => "<span class='text-danger'>$msg</span>", $mensajes));

                $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';

                $value->BTN_CORREO = empty($mensajes)
                    ? ''
                    : '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO" data-id="' . $value->ID_FORMULARIO_ALTA . '"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
            }

            return response()->json([
                'data' => $tabla,
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
