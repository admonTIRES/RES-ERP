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

use App\Models\proveedor\altadocumentosModel;
use App\Models\proveedor\catalogodocumentoproveedorModel;

use App\Models\proveedor\altaproveedorModel;


class altadocumentosController extends Controller
{




    public function index(Request $request)
    {
        $rfcProveedor = auth()->user()->RFC_PROVEEDOR;

        $proveedor = altaproveedorModel::where('RFC_ALTA', $rfcProveedor)->first();

        $tipoProveedor = $proveedor ? $proveedor->TIPO_PERSONA_ALTA : null;
        $tipoPersonaOpcion = $proveedor ? $proveedor->TIPO_PERSONA_OPCION : null;

        $documetoscatalogo = catalogodocumentoproveedorModel::where('ACTIVO', 1)
            ->where(function ($query) use ($tipoProveedor) {
                $query->where('TIPO_PERSONA', $tipoProveedor)
                    ->orWhere('TIPO_PERSONA', 3); 
            })
            ->where(function ($query) use ($tipoPersonaOpcion) {
                $query->where('TIPO_PERSONA_OPCION', $tipoPersonaOpcion)
                    ->orWhere('TIPO_PERSONA_OPCION', 3); 
            })
            ->get();

            
        return view('compras.proveedores.altadocumentosoporte', compact('documetoscatalogo', 'tipoProveedor', 'tipoPersonaOpcion'));
    }




    public function documentosRegistrados()
    {
        $rfc = Auth::user()->RFC_PROVEEDOR;

        $documentos = DB::table('formulario_altadocumentoproveedores')
            ->where('RFC_PROVEEDOR', $rfc)
            ->where('ACTIVO', 1)
            ->pluck('TIPO_DOCUMENTO_PROVEEDOR'); 

        return response()->json($documentos); 
    }

    // public function Tabladocumentosproveedores()
    // {
    //     try {
    //         $userRFC = Auth::user()->RFC_PROVEEDOR;

    //         $tabla = altadocumentosModel::where('RFC_PROVEEDOR', $userRFC)->get();

    //         foreach ($tabla as $value) {
    //             if ($value->ACTIVO == 0) {
    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '"><span class="slider round"></span></label>';
    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
    //                 $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
    //             } else {
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" checked><span class="slider round"></span></label>';
    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
    //                 $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
    //             }
    //         }

    //         return response()->json([
    //             'data' => $tabla,
    //             'msj' => 'Información consultada correctamente'
    //         ]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'msj' => 'Error ' . $e->getMessage(),
    //             'data' => 0
    //         ]);
    //     }
    // }


    public function Tabladocumentosproveedores()
    {
        try {

            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $periodoActivo = DB::table('fecha_actualizaciondocsproveedor')
                ->where('ACTIVO', 1)
                ->whereDate('FECHA_INICIO', '<=', now())
                ->whereDate('FECHA_FIN', '>=', now())
                ->exists();

            $tabla = altadocumentosModel::where('RFC_PROVEEDOR', $userRFC)->get();

            foreach ($tabla as $value) {

                $catalogo = DB::table('catalogo_documentosproveedor')
                    ->where('ID_CATALOGO_DOCUMENTOSPROVEEDOR', $value->TIPO_DOCUMENTO_PROVEEDOR)
                    ->first();

                // BOTON ACTUALIZAR
                if ($catalogo && $catalogo->ACTUALIZAR_DOCUMENTOS == 1 && $periodoActivo) {

                    $value->BTN_ACTUALIZAR = '
                        <button class="btn btn-info btn-custom rounded-pill ACTUALIZAR_DOC"
                        data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '"
                        data-tipo="' . $value->TIPO_DOCUMENTO_PROVEEDOR . '">
                       <i class="bi bi-arrow-up-square-fill"></i>
                        </button>';
                } else {
                    $value->BTN_ACTUALIZAR = '';
                }

                if ($value->ACTIVO == 0) {

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';

                    $value->BTN_ELIMINAR = '<label class="switch">
                <input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '">
                <span class="slider round"></span></label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled>
                <i class="bi bi-ban"></i></button>';
                } else {

                    $value->BTN_ELIMINAR = '<label class="switch">
                <input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '" checked>
                <span class="slider round"></span></label>';

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR">
                <i class="bi bi-pencil-square"></i></button>';

                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                <i class="bi bi-eye"></i></button>';
                }

                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentosoporte"
                data-id="' . $value->ID_FORMULARIO_DOCUMENTOSPROVEEDOR . '">
                <i class="bi bi-filetype-pdf"></i>
            </button>';
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



   public function mostrardocumentosoporteproveedor($id)
    {
        $archivo = altadocumentosModel::findOrFail($id)->DOCUMENTO_SOPORTE;
        return Storage::response($archivo);
    }


    //// ACTUALIZACION DOCUMENTOS 

    public function verificarPeriodoActualizacion()
    {
        $periodo = DB::table('fecha_actualizaciondocsproveedor')
            ->where('ACTIVO', 1)
            ->whereDate('FECHA_INICIO', '<=', now())
            ->whereDate('FECHA_FIN', '>=', now())
            ->exists();

        return response()->json([
            'periodoActivo' => $periodo
        ]);
    }


    public function actualizarDocumentoProveedor(Request $request)
    {
        try {

            $rfc = Auth::user()->RFC_PROVEEDOR;

            $periodo = DB::table('fecha_actualizaciondocsproveedor')
                ->where('ACTIVO', 1)
                ->whereDate('FECHA_INICIO', '<=', now())
                ->whereDate('FECHA_FIN', '>=', now())
                ->first();

            if (!$periodo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'El periodo de actualización no está activo'
                ]);
            }

            $catalogo = DB::table('catalogo_documentosproveedor')
                ->where('ID_CATALOGO_DOCUMENTOSPROVEEDOR', $request->TIPO_DOCUMENTO_PROVEEDOR)
                ->where('ACTUALIZAR_DOCUMENTOS', 1)
                ->first();

            if (!$catalogo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Este documento no requiere actualización'
                ]);
            }

            $yaExiste = DB::table('actualizacion_documentosproveedor')
                ->where('RFC_PROVEEDOR', $rfc)
                ->where('ID_CATALOGO_DOCUMENTO', $request->TIPO_DOCUMENTO_PROVEEDOR)
                ->whereBetween('FECHA_SOLICITUD', [
                    $periodo->FECHA_INICIO,
                    $periodo->FECHA_FIN
                ])
                ->where(function ($q) {

                    $q->whereNull('VOBO_RH')

                        ->orWhere(function ($sub) {
                            $sub->where('VOBO_RH', 1)
                                ->where(function ($final) {
                                    $final->whereNull('AUTORIZACION_FINAL')
                                        ->orWhere('AUTORIZACION_FINAL', '!=', 2);
                                });
                        });
                })
                ->exists();
            if ($yaExiste) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Este documento ya fue enviado y está en proceso de revisión'
                ]);
            }

            if ($request->hasFile('DOCUMENTO_SOPORTE')) {

                $file = $request->file('DOCUMENTO_SOPORTE');

                $folder = "proveedores/" . $rfc . "/actualizacion_documentos";

                $fileName = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs($folder, $fileName);

                DB::table('actualizacion_documentosproveedor')->insert([
                    'RFC_PROVEEDOR' => $rfc,
                    'ID_DOCUMENTO_PROVEEDOR' => $request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR,
                    'ID_CATALOGO_DOCUMENTO' => $request->TIPO_DOCUMENTO_PROVEEDOR,
                    'DOCUMENTO_NUEVO' => $path,
                    'ESTATUS' => 1,
                    'FECHA_SOLICITUD' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Documento enviado para revisión'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altadocumentoproveedores AUTO_INCREMENT=1;');

                        $requestData = $request->all();
                        $requestData['RFC_PROVEEDOR'] = Auth::user()->RFC_PROVEEDOR;

                        $cuentas = altadocumentosModel::create($requestData);

                        $rfc = Auth::user()->RFC_PROVEEDOR;
                        if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                            $file = $request->file('DOCUMENTO_SOPORTE');
                            $folderPath = "proveedores/{$rfc}/Documento de soporte/{$cuentas->ID_FORMULARIO_DOCUMENTOSPROVEEDOR}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);

                            $cuentas->DOCUMENTO_SOPORTE = $filePath;
                            $cuentas->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $cuentas = altadocumentosModel::where('ID_FORMULARIO_DOCUMENTOSPROVEEDOR', $request['ID_FORMULARIO_DOCUMENTOSPROVEEDOR'])
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cuenta'] = 'Desactivada';
                            } else {
                                $cuentas = altadocumentosModel::where('ID_FORMULARIO_DOCUMENTOSPROVEEDOR', $request['ID_FORMULARIO_DOCUMENTOSPROVEEDOR'])
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cuenta'] = 'Activada';
                            }
                        } else {
                            $cuentas = altadocumentosModel::find($request->ID_FORMULARIO_DOCUMENTOSPROVEEDOR);
                            $cuentas->update($request->except('RFC_PROVEEDOR'));

                            $rfc = Auth::user()->RFC_PROVEEDOR;
                            if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                                if ($cuentas->DOCUMENTO_SOPORTE && Storage::exists($cuentas->DOCUMENTO_SOPORTE)) {
                                    Storage::delete($cuentas->DOCUMENTO_SOPORTE);
                                }

                                $file = $request->file('DOCUMENTO_SOPORTE');
                                $folderPath = "proveedores/{$rfc}/Documento de soporte/{$cuentas->ID_FORMULARIO_DOCUMENTOSPROVEEDOR}";
                                $fileName = $file->getClientOriginalName();
                                $filePath = $file->storeAs($folderPath, $fileName);

                                $cuentas->DOCUMENTO_SOPORTE = $filePath;
                                $cuentas->save();
                            }

                            $response['code'] = 1;
                            $response['cuenta'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }

                    $response['code']  = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);
                    break;

                default:
                    $response['code']  = 1;
                    $response['msj']  = 'API no encontrada';
                    return response()->json($response);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar'], 500);
        }
    }
}
