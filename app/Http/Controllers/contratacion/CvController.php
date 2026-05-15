<?php

namespace App\Http\Controllers\contratacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;


use App\Models\contratacion\cvModel;



use DB;

class CvController extends Controller
{




    public function Tablacvs(Request $request)
    {
        try {
            $curp = $request->get('curp');

            $tabla = cvModel::where('CURP', $curp)->get();




            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" ><i class="bi bi-eye"></i></button>';
                } else {

                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_BIO = '<button class="btn btn-info btn-custom rounded-pill  CV_BIO"> <i class="bi bi-arrow-down"></i></button>';
                    $value->BTN_CV = '<button class="btn btn-info btn-custom rounded-pill CV_GENERAL"> <i class="bi bi-arrow-down"></i></button>';
                    $value->BTN_PERSONAL = '<button class="btn btn-info btn-custom rounded-pill  CV_GENERAL"> <i class="bi bi-arrow-down"></i></button>';
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

    public function mostrarFotoCV($cv_id)
    {
        $foto = cvModel::findOrFail($cv_id);
        return Storage::response($foto->FOTO_CV);
    }






    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $curp = $request->CURP;

            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_CV_CONTRATACION == 0) {
                        DB::statement('ALTER TABLE cv_contratacion AUTO_INCREMENT=1;');
                        $data = $request->except(['FOTO_CV', 'DOCUMENTO_CEDULA_CV', 'DOCUMENTO_VALCEDULA_CV', 'formacion','documento','experiencia','continua']);
                        $cv = cvModel::create($data);

                        if ($request->hasFile('FOTO_CV')) {
                            $imagen = $request->file('FOTO_CV');
                            $rutaCarpeta = "reclutamiento/$curp/documentos CV/foto_usuario";
                            $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                            $rutaCompleta = $imagen->storeAs($rutaCarpeta, $nombreArchivo);
                            $cv->FOTO_CV = $rutaCompleta;
                            $cv->save();
                        }

                        if ($request->hasFile('DOCUMENTO_CEDULA_CV')) {
                            $documentoCedula = $request->file('DOCUMENTO_CEDULA_CV');
                            $rutaCarpeta = "reclutamiento/$curp/documentos CV/Documentos Cedula/Cedula";
                            $nombreArchivo = 'cedula_' . uniqid() . '.' . $documentoCedula->getClientOriginalExtension();
                            $rutaCompleta = $documentoCedula->storeAs($rutaCarpeta, $nombreArchivo);
                            $cv->DOCUMENTO_CEDULA_CV = $rutaCompleta;
                            $cv->save();
                        }

                        if ($request->hasFile('DOCUMENTO_VALCEDULA_CV')) {
                            $documentoValCedula = $request->file('DOCUMENTO_VALCEDULA_CV');
                            $rutaCarpeta = "reclutamiento/$curp/documentos CV/Documentos Cedula/Validacion Cedula";
                            $nombreArchivo = 'validacion_cedula_' . uniqid() . '.' . $documentoValCedula->getClientOriginalExtension();
                            $rutaCompleta = $documentoValCedula->storeAs($rutaCarpeta, $nombreArchivo);
                            $cv->DOCUMENTO_VALCEDULA_CV = $rutaCompleta;
                            $cv->save();
                        }
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $cv = cvModel::where('ID_CV_CONTRATACION', $request->ID_CV_CONTRATACION)
                                ->update(['ACTIVO' => $request->ELIMINAR == 1 ? 0 : 1]);
                            $mensaje = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                            DB::commit();
                            return response()->json(['code' => 1, 'cv' => $mensaje]);
                        }

                        $cv = cvModel::find($request->ID_CV_CONTRATACION);
                        $cv->update($request->except(['FOTO_CV', 'DOCUMENTO_CEDULA_CV', 'DOCUMENTO_VALCEDULA_CV','formacion','documento','experiencia','continua']));

                        if ($request->hasFile('FOTO_CV')) {
                            if ($cv->FOTO_CV && Storage::exists($cv->FOTO_CV)) {
                                Storage::delete($cv->FOTO_CV);
                            }
                            $imagen = $request->file('FOTO_CV');
                            $rutaCarpeta = "reclutamiento/$curp/documentos CV/foto_usuario";
                            $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                            $rutaCompleta = $imagen->storeAs($rutaCarpeta, $nombreArchivo);
                            $cv->FOTO_CV = $rutaCompleta;
                            $cv->save();
                        }

                        if ($request->hasFile('DOCUMENTO_CEDULA_CV')) {
                            if ($cv->DOCUMENTO_CEDULA_CV && Storage::exists($cv->DOCUMENTO_CEDULA_CV)) {
                                Storage::delete($cv->DOCUMENTO_CEDULA_CV);
                            }
                            $documentoCedula = $request->file('DOCUMENTO_CEDULA_CV');
                            $rutaCarpeta = "reclutamiento/$curp/documentos CV/Documentos Cedula/Cedula";
                            $nombreArchivo = 'cedula_' . uniqid() . '.' . $documentoCedula->getClientOriginalExtension();
                            $rutaCompleta = $documentoCedula->storeAs($rutaCarpeta, $nombreArchivo);
                            $cv->DOCUMENTO_CEDULA_CV = $rutaCompleta;
                            $cv->save();
                        }

                        if ($request->hasFile('DOCUMENTO_VALCEDULA_CV')) {
                            if ($cv->DOCUMENTO_VALCEDULA_CV && Storage::exists($cv->DOCUMENTO_VALCEDULA_CV)) {
                                Storage::delete($cv->DOCUMENTO_VALCEDULA_CV);
                            }
                            $documentoValCedula = $request->file('DOCUMENTO_VALCEDULA_CV');
                            $rutaCarpeta = "reclutamiento/$curp/documentos CV/Documentos Cedula/Validacion Cedula";
                            $nombreArchivo = 'validacion_cedula_' . uniqid() . '.' . $documentoValCedula->getClientOriginalExtension();
                            $rutaCompleta = $documentoValCedula->storeAs($rutaCarpeta, $nombreArchivo);
                            $cv->DOCUMENTO_VALCEDULA_CV = $rutaCompleta;
                            $cv->save();
                        }
                    }

                    DB::commit();
                    return response()->json(['code' => 1, 'cv' => $cv]);
                    break;

                default:
                    return response()->json(['code' => 0, 'msj' => 'API no encontrada']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['code' => 0, 'msj' => 'Error al guardar el CV', 'error' => $e->getMessage()]);
        }
    }








}
