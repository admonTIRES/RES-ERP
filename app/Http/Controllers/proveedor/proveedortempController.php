<?php

namespace App\Http\Controllers\proveedor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Models\proveedor\proveedortempModel;

use DB;



class proveedortempController extends Controller
{
 

    public function Tablaproveedortemporal()
    {
        try {
            $tabla = proveedortempModel::get();
            $fecha_actual = date('Y-m-d'); 

            foreach ($tabla as $value) {

                
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_PROVEEDORTEMP . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-requierecontrato" data-id="' . $value->ID_FORMULARIO_PROVEEDORTEMP . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_PROVEEDORTEMP . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-requierecontrato" data-id="' . $value->ID_FORMULARIO_PROVEEDORTEMP . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                }

               
                if ($value->REQUIERE_CONTRATO == 1) {

                    if ($value->INDETERMINADO_CONTRATO == 1) {
                        $value->FECHA_CONTRATO = '
                        <div>
                            <strong>' . $value->FECHAI_CONTRATO . '</strong><br>
                            <span class="badge bg-success text-light">Indeterminado</span>
                        </div>';
                    }
                    elseif (!empty($value->FECHAI_CONTRATO) && !empty($value->FECHAF_CONTRATO)) {

                        $fechaInicio = strtotime($value->FECHAI_CONTRATO);
                        $fechaFin = strtotime($value->FECHAF_CONTRATO);
                        $hoy = strtotime($fecha_actual);

                        $total_dias = ($fechaFin - $fechaInicio) / 86400;
                        $restantes = ($fechaFin - $hoy) / 86400;

                        if ($hoy > $fechaFin) {
                            $restantes = 0;
                        }

                        $transcurrido = $total_dias > 0 ? (($total_dias - $restantes) / $total_dias) * 100 : 100;

                        if ($hoy > $fechaFin) {
                            $color = 'danger';
                            $texto = 'Vencido';
                        } elseif ($transcurrido < 60) {
                            $color = 'success';
                            $texto = 'Vigente';
                        } elseif ($transcurrido < 80) {
                            $color = 'warning';
                            $texto = 'Revisar';
                        } else {
                            $color = 'danger';
                            $texto = 'Próximo a vencer';
                        }

                        $dias_restantes = max(0, floor($restantes));

                        $value->FECHA_CONTRATO = '
                        <div>
                            <strong>' . $value->FECHAI_CONTRATO . ' - ' . $value->FECHAF_CONTRATO . '</strong><br>
                            <span class="badge bg-' . $color . ' text-light">' . $texto . ' (' . $dias_restantes . ' días restantes)</span>
                        </div>';
                    }
                    else {
                        $value->FECHA_CONTRATO = '<span class="badge bg-secondary">Sin fecha </span>';
                    }
                }
                else {
                    $value->FECHA_CONTRATO = '<span class="badge bg-secondary">N/A</span>';
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




    public function mostrarequierecontrato($id)
    {
        $archivo = proveedortempModel::findOrFail($id)->DOCUMENTO_SOPORTE;
        return Storage::response($archivo);
    }


    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_PROVEEDORTEMP == 0) {
                        DB::statement('ALTER TABLE formulario_proveedortemp AUTO_INCREMENT=1;');
                        $temporales = proveedortempModel::create($request->all());
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                $temporales = proveedortempModel::where('ID_FORMULARIO_PROVEEDORTEMP', $request['ID_FORMULARIO_PROVEEDORTEMP'])->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['temporal'] = 'Desactivada';
                            } else {
                                $temporales = proveedortempModel::where('ID_FORMULARIO_PROVEEDORTEMP', $request['ID_FORMULARIO_PROVEEDORTEMP'])->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['temporal'] = 'Activada';
                            }
                        } else {
                            $temporales = proveedortempModel::find($request->ID_FORMULARIO_PROVEEDORTEMP);
                            $temporales->update($request->all());
                            $response['code'] = 1;
                            $response['temporal'] = 'Actualizada';
                        }
                        return response()->json($response);
                    }
                    $response['code']  = 1;
                    $response['temporal']  = $temporales;
                    return response()->json($response);
                    break;



                case 2:
                    if ($request->ID_FORMULARIO_PROVEEDORTEMP == 0) {
                        DB::statement('ALTER TABLE formulario_proveedortemp AUTO_INCREMENT=1;');

                        $data = $request->except(['direcciones', 'DOCUMENTO_SOPORTE']);
                        $data['DIRECCIONES_JSON'] = is_string($request->DIRECCIONES_JSON) ? $request->DIRECCIONES_JSON : json_encode($request->DIRECCIONES_JSON ?? []);

                        $temporales = proveedortempModel::create($data);

                        if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                            $documento = $request->file('DOCUMENTO_SOPORTE');
                            $idTemporal = $temporales->ID_FORMULARIO_PROVEEDORTEMP;

                            $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $documento->getClientOriginalName());
                            $rutaCarpeta = 'proveedorestemporales/' . $idTemporal;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $temporales->DOCUMENTO_SOPORTE = $rutaCompleta;
                            $temporales->save();
                        }

                        $response['code'] = 1;
                        $response['temporal'] = $temporales;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                proveedortempModel::where('ID_FORMULARIO_PROVEEDORTEMP', $request->ID_FORMULARIO_PROVEEDORTEMP)
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['temporal'] = 'Desactivada';
                            } else {
                                proveedortempModel::where('ID_FORMULARIO_PROVEEDORTEMP', $request->ID_FORMULARIO_PROVEEDORTEMP)
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['temporal'] = 'Activada';
                            }
                        } else {
                            $temporales = proveedortempModel::find($request->ID_FORMULARIO_PROVEEDORTEMP);

                            $data = $request->except(['direcciones', 'DOCUMENTO_SOPORTE']);
                            $data['DIRECCIONES_JSON'] = is_string($request->DIRECCIONES_JSON) ? $request->DIRECCIONES_JSON : json_encode($request->DIRECCIONES_JSON ?? []);

                            $temporales->update($data);

                            if ($request->hasFile('DOCUMENTO_SOPORTE')) {
                                if ($temporales->DOCUMENTO_SOPORTE && Storage::exists($temporales->DOCUMENTO_SOPORTE)) {
                                    Storage::delete($temporales->DOCUMENTO_SOPORTE);
                                }

                                $documento = $request->file('DOCUMENTO_SOPORTE');
                                $idTemporal = $temporales->ID_FORMULARIO_PROVEEDORTEMP;

                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $documento->getClientOriginalName());
                                $rutaCarpeta = 'proveedorestemporales/' . $idTemporal;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $temporales->DOCUMENTO_SOPORTE = $rutaCompleta;
                                $temporales->save();
                            }

                            $response['code'] = 1;
                            $response['temporal'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }




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
