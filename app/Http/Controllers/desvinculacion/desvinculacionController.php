<?php

namespace App\Http\Controllers\desvinculacion;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use DB;


use App\Models\contratacion\contratacionModel;
use App\Models\desvinculacion\desvinculacioModel;


class desvinculacionController extends Controller
{
    public function index()
    {
        $contratacion = contratacionModel::orderBy('CURP', 'ASC')->get();

        return view('RH.desvinculacion.desvinculacion', compact('contratacion'));
    }


    public function Tabladesvinculacion()
    {
        try {

            $tabla = desvinculacioModel::select(
                'formulario_desvinculacion.*',
                DB::raw("CONCAT(formulario_contratacion.NOMBRE_COLABORADOR, ' ', formulario_contratacion.PRIMER_APELLIDO, ' ', formulario_contratacion.SEGUNDO_APELLIDO) AS NOMBRE_COLABORADOR")
            )
            ->leftJoin('formulario_contratacion', 'formulario_desvinculacion.CURP', '=', 'formulario_contratacion.CURP')
            ->get();
    
            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DESVINCULACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_BAJA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentobaja" data-id="' . $value->ID_FORMULARIO_DESVINCULACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_CONVENIO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoconvenio" data-id="' . $value->ID_FORMULARIO_DESVINCULACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_ADEUDO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoadeudo" data-id="' . $value->ID_FORMULARIO_DESVINCULACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';

                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DESVINCULACION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_BAJA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentobaja" data-id="' . $value->ID_FORMULARIO_DESVINCULACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_CONVENIO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoconvenio" data-id="' . $value->ID_FORMULARIO_DESVINCULACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_ADEUDO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-documentoadeudo" data-id="' . $value->ID_FORMULARIO_DESVINCULACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';

                }
            }
    
            // Respuesta
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


    /// VER DOCUMENTOS


    public function mostrardocumentobaja($id)
{
    $archivo = desvinculacioModel::findOrFail($id)->DOCUMENTO_BAJA;
    return Storage::response($archivo);
}


public function mostrardocumenconvenio($id)
{
    $archivo = desvinculacioModel::findOrFail($id)->DOCUMENTO_CONVENIO;
    return Storage::response($archivo);
}


public function mostrardocumenadeudo($id)
{
    $archivo = desvinculacioModel::findOrFail($id)->DOCUMENTO_ADEUDO;
    return Storage::response($archivo);
}


public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
             

                case 1:
                    $curp = $request->CURP;

                    if ($request->ID_FORMULARIO_DESVINCULACION == 0) {
                        DB::statement('ALTER TABLE formulario_desvinculacion AUTO_INCREMENT=1;');
                        $basicos = desvinculacioModel::create($request->except(['DOCUMENTO_ADEUDO', 'DOCUMENTO_BAJA', 'DOCUMENTO_CONVENIO']));

                        if ($request->hasFile('DOCUMENTO_ADEUDO')) {
                            $rutaAdeudo = 'reclutamiento/' . $curp . '/Documentos de desvinculacion/' . $basicos->ID_FORMULARIO_DESVINCULACION . '/ADEUDO';
                            $nombreArchivo = $request->file('DOCUMENTO_ADEUDO')->getClientOriginalName();
                            $pathAdeudo = $request->file('DOCUMENTO_ADEUDO')->storeAs($rutaAdeudo, $nombreArchivo);
                            $basicos->DOCUMENTO_ADEUDO = $pathAdeudo;
                        }

                        if ($request->hasFile('DOCUMENTO_BAJA')) {
                            $rutaBaja = 'reclutamiento/' . $curp . '/Documentos de desvinculacion/' . $basicos->ID_FORMULARIO_DESVINCULACION . '/BAJA';
                            $nombreArchivo = $request->file('DOCUMENTO_BAJA')->getClientOriginalName();
                            $pathBaja = $request->file('DOCUMENTO_BAJA')->storeAs($rutaBaja, $nombreArchivo);
                            $basicos->DOCUMENTO_BAJA = $pathBaja;
                        }

                        if ($request->hasFile('DOCUMENTO_CONVENIO')) {
                            $rutaConvenio = 'reclutamiento/' . $curp . '/Documentos de desvinculacion/' . $basicos->ID_FORMULARIO_DESVINCULACION . '/CONVENIO';
                            $nombreArchivo = $request->file('DOCUMENTO_CONVENIO')->getClientOriginalName();
                            $pathConvenio = $request->file('DOCUMENTO_CONVENIO')->storeAs($rutaConvenio, $nombreArchivo);
                            $basicos->DOCUMENTO_CONVENIO = $pathConvenio;
                        }

                        $basicos->save();

                        contratacionModel::where('CURP', $curp)->update(['ACTIVO' => 0]);
                    } else {
                        $basicos = desvinculacioModel::find($request->ID_FORMULARIO_DESVINCULACION);

                        if ($request->hasFile('DOCUMENTO_ADEUDO')) {
                            if ($basicos->DOCUMENTO_ADEUDO && Storage::exists($basicos->DOCUMENTO_ADEUDO)) {
                                Storage::delete($basicos->DOCUMENTO_ADEUDO);
                            }
                            $rutaAdeudo = 'reclutamiento/' . $curp . '/Documentos de desvinculacion/' . $basicos->ID_FORMULARIO_DESVINCULACION . '/ADEUDO';
                            $nombreArchivo = $request->file('DOCUMENTO_ADEUDO')->getClientOriginalName();
                            $pathAdeudo = $request->file('DOCUMENTO_ADEUDO')->storeAs($rutaAdeudo, $nombreArchivo);
                            $basicos->DOCUMENTO_ADEUDO = $pathAdeudo;
                        }

                        if ($request->hasFile('DOCUMENTO_BAJA')) {
                            if ($basicos->DOCUMENTO_BAJA && Storage::exists($basicos->DOCUMENTO_BAJA)) {
                                Storage::delete($basicos->DOCUMENTO_BAJA);
                            }
                            $rutaBaja = 'reclutamiento/' . $curp . '/Documentos de desvinculacion/' . $basicos->ID_FORMULARIO_DESVINCULACION . '/BAJA';
                            $nombreArchivo = $request->file('DOCUMENTO_BAJA')->getClientOriginalName();
                            $pathBaja = $request->file('DOCUMENTO_BAJA')->storeAs($rutaBaja, $nombreArchivo);
                            $basicos->DOCUMENTO_BAJA = $pathBaja;
                        }

                        if ($request->hasFile('DOCUMENTO_CONVENIO')) {
                            if ($basicos->DOCUMENTO_CONVENIO && Storage::exists($basicos->DOCUMENTO_CONVENIO)) {
                                Storage::delete($basicos->DOCUMENTO_CONVENIO);
                            }
                            $rutaConvenio = 'reclutamiento/' . $curp . '/Documentos de desvinculacion/' . $basicos->ID_FORMULARIO_DESVINCULACION . '/CONVENIO';
                            $nombreArchivo = $request->file('DOCUMENTO_CONVENIO')->getClientOriginalName();
                            $pathConvenio = $request->file('DOCUMENTO_CONVENIO')->storeAs($rutaConvenio, $nombreArchivo);
                            $basicos->DOCUMENTO_CONVENIO = $pathConvenio;
                        }

                        $basicos->update($request->except(['DOCUMENTO_ADEUDO', 'DOCUMENTO_BAJA', 'DOCUMENTO_CONVENIO']));
                        $basicos->save();
                    }

                    $response['code']  = 1;
                    $response['basico']  = $basicos;
                    return response()->json($response);
                    break;


                    default:
                $response['code']  = 1;
                $response['msj']  = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json('Error al guardar la competencia');
    }
}




    
}
