<?php

namespace App\Http\Controllers\proveedor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB; 

use App\Models\proveedor\directorioModel;
use App\Models\proveedor\altaproveedorModel;

class altaproveedorController extends Controller
{
    public function obtenerDatosProveedor()
    {
        $rfcProveedor = Auth::user()->RFC_PROVEEDOR;

        $formulario = altaproveedorModel::where('RFC_ALTA', $rfcProveedor)->first();

        if ($formulario) {
            return response()->json([

                'ID_FORMULARIO_ALTA' => $formulario->ID_FORMULARIO_ALTA,

                'TIPO_PERSONA_ALTA' => $formulario->TIPO_PERSONA_ALTA,
                'RAZON_SOCIAL_ALTA' => $formulario->RAZON_SOCIAL_ALTA,
                'RFC_ALTA' => $formulario->RFC_ALTA,
                'ACTVIDAD_COMERCIAL' => $formulario->ACTVIDAD_COMERCIAL,
                'CODIGO_POSTAL' => $formulario->CODIGO_POSTAL,
                'TIPO_VIALIDAD_EMPRESA' => $formulario->TIPO_VIALIDAD_EMPRESA,
                'NOMBRE_VIALIDAD_EMPRESA' => $formulario->NOMBRE_VIALIDAD_EMPRESA,
                'NUMERO_EXTERIOR_EMPRESA' => $formulario->NUMERO_EXTERIOR_EMPRESA,
                'NUMERO_INTERIOR_EMPRESA' => $formulario->NUMERO_INTERIOR_EMPRESA,
                'NOMBRE_COLONIA_EMPRESA' => $formulario->NOMBRE_COLONIA_EMPRESA,
                'NOMBRE_LOCALIDAD_EMPRESA' => $formulario->NOMBRE_LOCALIDAD_EMPRESA,
                'NOMBRE_MUNICIPIO_EMPRESA' => $formulario->NOMBRE_MUNICIPIO_EMPRESA,
                'NOMBRE_ENTIDAD_EMPRESA' => $formulario->NOMBRE_ENTIDAD_EMPRESA,
                'PAIS_EMPRESA' => $formulario->PAIS_EMPRESA,
                'ENTRE_CALLE_EMPRESA' => $formulario->ENTRE_CALLE_EMPRESA,
                'ENTRE_CALLE2_EMPRESA' => $formulario->ENTRE_CALLE2_EMPRESA,
                'DOMICILIO_EXTRANJERO' => $formulario->DOMICILIO_EXTRANJERO,
                'CODIGO_EXTRANJERO' => $formulario->CODIGO_EXTRANJERO,
                'CIUDAD_EXTRANJERO' => $formulario->CIUDAD_EXTRANJERO,
                'ESTADO_EXTRANJERO' => $formulario->ESTADO_EXTRANJERO,
                'PAIS_EXTRANJERO' => $formulario->PAIS_EXTRANJERO,
                'DEPARTAMENTO_EXTRANJERO' => $formulario->DEPARTAMENTO_EXTRANJERO,
                'REPRESENTANTE_LEGAL_ALTA' => $formulario->REPRESENTANTE_LEGAL_ALTA,
                'REGIMEN_ALTA' => $formulario->REGIMEN_ALTA,
                'CORREO_DIRECTORIO' => $formulario->CORREO_DIRECTORIO,
                'TELEFONO_OFICINA_ALTA' => $formulario->TELEFONO_OFICINA_ALTA,
                'PAGINA_WEB_ALTA' => $formulario->PAGINA_WEB_ALTA,
                'ACTIVIDAD_ECONOMICA' => $formulario->ACTIVIDAD_ECONOMICA,
                'CUAL_ACTVIDAD_ECONOMICA' => $formulario->CUAL_ACTVIDAD_ECONOMICA,
                'DESCUENTOS_ACTIVIDAD_ECONOMICA' => $formulario->DESCUENTOS_ACTIVIDAD_ECONOMICA,
                'CUAL_DESCUENTOS_ECONOMICA' => $formulario->CUAL_DESCUENTOS_ECONOMICA,
                'DIAS_CREDITO_ALTA' => $formulario->DIAS_CREDITO_ALTA,
                'TERMINOS_IMPORTANCIAS_ALTA' => $formulario->TERMINOS_IMPORTANCIAS_ALTA,
                'VINCULO_FAMILIAR' => $formulario->VINCULO_FAMILIAR,
                'DESCRIPCION_VINCULO' => $formulario->DESCRIPCION_VINCULO,
                'SERVICIOS_PEMEX' => $formulario->SERVICIOS_PEMEX,
                'NUMERO_PROVEEDOR' => $formulario->NUMERO_PROVEEDOR,
                'BENEFICIOS_PERSONA' => $formulario->BENEFICIOS_PERSONA,
                'NOMBRE_PERSONA' => $formulario->NOMBRE_PERSONA,

                'TIPO_PERSONA_OPCION' => $formulario->TIPO_PERSONA_OPCION

                

            ]);
        }

        $proveedor = directorioModel::where('RFC_PROVEEDOR', $rfcProveedor)->first();

        if (!$proveedor) {
            return response()->json(['error' => 'No se encontraron datos'], 404);
        }

        return response()->json([
            'TIPO_PERSONA_ALTA' => $proveedor->TIPO_PERSONA,
            'RAZON_SOCIAL_ALTA' => $proveedor->RAZON_SOCIAL,
            'RFC_ALTA' => $proveedor->RFC_PROVEEDOR,
            'ACTVIDAD_COMERCIAL' => $proveedor->GIRO_PROVEEDOR,
            'CODIGO_POSTAL' => $proveedor->CODIGO_POSTAL,
            'TIPO_VIALIDAD_EMPRESA' => $proveedor->TIPO_VIALIDAD_EMPRESA,
            'NOMBRE_VIALIDAD_EMPRESA' => $proveedor->NOMBRE_VIALIDAD_EMPRESA,
            'NUMERO_EXTERIOR_EMPRESA' => $proveedor->NUMERO_EXTERIOR_EMPRESA,
            'NUMERO_INTERIOR_EMPRESA' => $proveedor->NUMERO_INTERIOR_EMPRESA,
            'NOMBRE_COLONIA_EMPRESA' => $proveedor->NOMBRE_COLONIA_EMPRESA,
            'NOMBRE_LOCALIDAD_EMPRESA' => $proveedor->NOMBRE_LOCALIDAD_EMPRESA,
            'NOMBRE_MUNICIPIO_EMPRESA' => $proveedor->NOMBRE_MUNICIPIO_EMPRESA,
            'NOMBRE_ENTIDAD_EMPRESA' => $proveedor->NOMBRE_ENTIDAD_EMPRESA,
            'PAIS_EMPRESA' => $proveedor->PAIS_EMPRESA,
            'ENTRE_CALLE_EMPRESA' => $proveedor->ENTRE_CALLE_EMPRESA,
            'ENTRE_CALLE2_EMPRESA' => $proveedor->ENTRE_CALLE2_EMPRESA,
            'DOMICILIO_EXTRANJERO' => $proveedor->DOMICILIO_EXTRANJERO,
            'CODIGO_EXTRANJERO' => $proveedor->CODIGO_EXTRANJERO,
            'CIUDAD_EXTRANJERO' => $proveedor->CIUDAD_EXTRANJERO,
            'ESTADO_EXTRANJERO' => $proveedor->ESTADO_EXTRANJERO,
            'PAIS_EXTRANJERO' => $proveedor->PAIS_EXTRANJERO,

            'CORREO_DIRECTORIO' => $proveedor->CORREO_DIRECTORIO,

            'DEPARTAMENTO_EXTRANJERO' => $proveedor->DEPARTAMENTO_EXTRANJERO
        ]);
    }






    public function solicitarValidacion()
    {
        $rfc = Auth::user()->RFC_PROVEEDOR;

        $mensajes = [];

        $tieneContactos = DB::table('formulario_altacontactoproveedor')
            ->where('RFC_PROVEEDOR', $rfc)
            ->exists();

        if (!$tieneContactos) {
            $mensajes[] = 'Falta agregar contactos.';
        }

        $tieneCuentas = DB::table('formulario_altacuentaproveedor')
            ->where('RFC_PROVEEDOR', $rfc)
            ->exists();

        if (!$tieneCuentas) {
            $mensajes[] = 'Falta agregar cuentas bancarias.';
        }

        $tieneReferencias = DB::table('formulario_altareferenciasproveedor')
            ->where('RFC_PROVEEDOR', $rfc)
            ->exists();

        if (!$tieneReferencias) {
            $mensajes[] = 'Faltan agregar referencias comerciales.';
        }

        $proveedor = DB::table('formulario_altaproveedor')->where('RFC_ALTA', $rfc)->first();

        $tipoPersona = $proveedor->TIPO_PERSONA_ALTA ?? null;
        $tipoPersonaOpcion = $proveedor->TIPO_PERSONA_OPCION ?? null;

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

        if (!empty($mensajes)) {
            return response()->json([
                'status' => 'incompleto',
                'faltantes' => $mensajes
            ]);
        }

        DB::table('formulario_altaproveedor')
            ->where('RFC_ALTA', $rfc)
            ->update(['VERIFICACION_SOLICITADA' => 1]);

        return response()->json([
            'status' => 'ok',
            'message' => 'La solicitud de validación fue enviada correctamente.'
        ]);
    }



    public function verificarBloqueoPorVerificacion()
    {
        $rfc = Auth::user()->RFC_PROVEEDOR;

        $verificacion = DB::table('formulario_altaproveedor')
            ->where('RFC_ALTA', $rfc)
            ->value('VERIFICACION_SOLICITADA');

        return response()->json([
            'bloqueado' => $verificacion == 1
        ]);
    }


    public function verificarcontratoproveedor()
    {
        $rfc = Auth::user()->RFC_PROVEEDOR;

        $contrato = DB::table('formulario_altaproveedor')
            ->where('RFC_ALTA', $rfc)
            ->value('PROVEEDOR_CONTRATO');

        return response()->json([
            'tienecontrato' => $contrato == 1
        ]);
    }

    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_ALTA == 0) {
                        DB::statement('ALTER TABLE formulario_altaproveedor AUTO_INCREMENT=1;');
                        $altas = altaproveedorModel::create($request->all());
                    } else {

                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $altas = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['alta'] = 'Desactivada';
                            } else {
                                $altas = altaproveedorModel::where('ID_FORMULARIO_ALTA', $request['ID_FORMULARIO_ALTA'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['alta'] = 'Activada';
                            }
                        } else {
                            $altas = altaproveedorModel::find($request->ID_FORMULARIO_ALTA);
                            $altas->update($request->all());
                            $response['code'] = 1;
                            $response['alta'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['alta']  = $altas;
                    return response()->json($response);
                    break;
                default:
                    $response['code']  = 1;
                    $response['msj']  = 'Api no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json('Error al guardar');
        }
    }
}
