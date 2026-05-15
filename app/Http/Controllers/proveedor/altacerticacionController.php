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

use App\Models\proveedor\altacertificacionModel;

class altacerticacionController extends Controller
{



    public function Tablacertificacionproveedores()
    {
        try {
            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = altacertificacionModel::where('RFC_PROVEEDOR', $userRFC)->get();

            foreach ($tabla as $value) {
                $value->BTN_EDITAR = '';
                $value->BTN_ELIMINAR = '';
                $value->BTN_VISUALIZAR = '';
                $value->BTN_DOCUMENTO = 'N/A';

                $btnVisualizar = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $btnEditar = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $btnEditarDisabled = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $btnEliminarChecked = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" checked><span class="slider round"></span></label>';
                $btnEliminarUnchecked = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '"><span class="slider round"></span></label>';

                $btnCertificacion = $value->DOCUMENTO_CERTIFICACION
                    ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-certificación" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver certificación"><i class="bi bi-filetype-pdf"></i></button>'
                    : '';

                $btnAcreditacion = $value->DOCUMENTO_ACREDITACION
                    ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-acreditacion" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver acreditación"><i class="bi bi-filetype-pdf"></i></button>'
                    : '';

                $btnAutorizacion = $value->DOCUMENTO_AUTORIZACION
                    ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-autorizacion" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver autorización"><i class="bi bi-filetype-pdf"></i></button>'
                    : '';

                $btnMembresia = $value->DOCUMENTO_MEMBRESIA
                    ? '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-membresia" data-id="' . $value->ID_FORMULARIO_CERTIFICACIONPROVEEDOR . '" title="Ver membresía"><i class="bi bi-filetype-pdf"></i></button>'
                    : '';

                switch ($value->TIPO_DOCUMENTO) {
                    case 'Certificación':
                        $value->BTN_DOCUMENTO = $btnCertificacion ?: 'N/A';
                        break;
                    case 'Acreditación':
                        $botones = [];
                        if ($btnAcreditacion) {
                            $botones[] = '<div class="text-center"><small>Acreditación</small><br>' . $btnAcreditacion . '</div>';
                        }
                        if ($btnAutorizacion) {
                            $botones[] = '<div class="text-center"><small>Autorización</small><br>' . $btnAutorizacion . '</div>';
                        }
                        $value->BTN_DOCUMENTO = count($botones) ? implode('&nbsp;&nbsp;', $botones) : 'N/A';
                        break;

                    case 'Membresía':
                        $value->BTN_DOCUMENTO = $btnMembresia ?: 'N/A';
                        break;
                    default:
                        $value->BTN_DOCUMENTO = 'N/A';
                        break;
                }

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = $btnVisualizar;
                    $value->BTN_ELIMINAR = $btnEliminarUnchecked;
                    $value->BTN_EDITAR = $btnEditarDisabled;
                } else {
                    $value->BTN_VISUALIZAR = $btnVisualizar;
                    $value->BTN_ELIMINAR = $btnEliminarChecked;
                    $value->BTN_EDITAR = $btnEditar;
                }
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


    public function mostrarcertificacion($id)
    {
        $archivo = altacertificacionModel::findOrFail($id)->DOCUMENTO_CERTIFICACION;
        return Storage::response($archivo);
    }

    

    public function mostraracreditacion($id)
    {
        $archivo = altacertificacionModel::findOrFail($id)->DOCUMENTO_ACREDITACION;
        return Storage::response($archivo);
    }

    public function mostrarautorizacion($id)
    {
        $archivo = altacertificacionModel::findOrFail($id)->DOCUMENTO_AUTORIZACION;
        return Storage::response($archivo);
    }

    public function mostrarmembresia($id)
    {
        $archivo = altacertificacionModel::findOrFail($id)->DOCUMENTO_MEMBRESIA;
        return Storage::response($archivo);
    }


    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    $rfc = Auth::user()->RFC_PROVEEDOR;

                    $requestData = collect($request->except([
                        'DOCUMENTO_CERTIFICACION',
                        'DOCUMENTO_ACREDITACION',
                        'DOCUMENTO_AUTORIZACION',
                        'DOCUMENTO_MEMBRESIA'
                    ]))->toArray();

                    $requestData['RFC_PROVEEDOR'] = $rfc;

                    if ($request->ID_FORMULARIO_CERTIFICACIONPROVEEDOR == 0) {
                        DB::statement('ALTER TABLE formulario_altacertificacionproveedor AUTO_INCREMENT=1;');

                        $yaExiste = altacertificacionModel::where('RFC_PROVEEDOR', $rfc)
                            ->whereNotNull('DOCUMENTO_ACREDITACION')
                            ->first();

                        if ($yaExiste && $request->hasFile('DOCUMENTO_AUTORIZACION') && !$request->hasFile('DOCUMENTO_ACREDITACION')) {
                            $cuentas = $yaExiste;
                        } else {
                            $cuentas = altacertificacionModel::create($requestData);
                            $cuentas->refresh();
                        }

                        $cuentas = $this->guardarArchivos($request, $cuentas, $rfc);
                    } else {
                        $cuentas = altacertificacionModel::find($request->ID_FORMULARIO_CERTIFICACIONPROVEEDOR);

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            return response()->json([
                                'code' => 1,
                                'cuenta' => $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada'
                            ]);
                        }

                        $cuentas = $this->guardarArchivos($request, $cuentas, $rfc);

                        $cuentas->update($requestData);

                        return response()->json([
                            'code' => 1,
                            'cuenta' => 'Actualizada'
                        ]);
                    }

                    return response()->json([
                        'code' => 1,
                        'cuenta' => $cuentas
                    ]);

                default:
                    return response()->json([
                        'code' => 1,
                        'msj' => 'API no encontrada'
                    ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al guardar: ' . $e->getMessage()
            ], 500);
        }
    }





    private function guardarArchivos(Request $request, $cuentas, $rfc)
    {
        $documentos = [
            'DOCUMENTO_CERTIFICACION' => 'certificacion',
            'DOCUMENTO_ACREDITACION' => 'acreditacion',
            'DOCUMENTO_AUTORIZACION' => 'autorizacion',
            'DOCUMENTO_MEMBRESIA' => 'membresia',
        ];

        foreach ($documentos as $input => $carpeta) {
            if ($request->hasFile($input)) {
                if ($cuentas->$input && Storage::exists($cuentas->$input)) {
                    Storage::delete($cuentas->$input);
                }

                $file = $request->file($input);
                $folderPath = "proveedores/{$rfc}/{$cuentas->ID_FORMULARIO_CERTIFICACIONPROVEEDOR}/{$carpeta}";
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs($folderPath, $fileName);

                $cuentas->$input = $filePath;
            }
        }

        $cuentas->save();
        return $cuentas;
    }


}
