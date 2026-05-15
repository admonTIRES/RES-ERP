<?php

namespace App\Http\Controllers\ofertas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\solicitudes\solicitudesModel;

use App\Models\ofertas\ofertasModel;



class ofertasController extends Controller
{
    public function index()
    {
        $solicitudesAceptadas = solicitudesModel::select(
            'ID_FORMULARIO_SOLICITUDES',
            'NO_SOLICITUD',
            'NOMBRE_COMERCIAL_SOLICITUD',
            'FECHA_SOLICITUD'
        )
        ->where('ESTATUS_SOLICITUD', 'like', '%Aceptada%')
        ->get();
    
        $idsAsociados = ofertasModel::pluck('SOLICITUD_ID')->toArray();
    
        $solicitudes = $solicitudesAceptadas->filter(function ($solicitud) use ($idsAsociados) {
            return !in_array($solicitud->ID_FORMULARIO_SOLICITUDES, $idsAsociados);
        });
    
        return view('ventas.ofertas.ofertas', compact('solicitudes'));
    }


    
    public function Tablaofertas()
    {
        try {
            $fechaInicio = Carbon::now('America/Mexico_City')->startOfYear()->toDateString();
            $fechaFin    = Carbon::now('America/Mexico_City')->endOfYear()->toDateString();

            $tabla = ofertasModel::select(
                'formulario_ofertas.*',
                'formulario_solicitudes.NO_SOLICITUD',
                'formulario_solicitudes.NOMBRE_COMERCIAL_SOLICITUD',
                'formulario_ofertas.SOLICITUD_ID'
            )
                ->leftJoin(
                    'formulario_solicitudes',
                    'formulario_ofertas.SOLICITUD_ID',
                    '=',
                    'formulario_solicitudes.ID_FORMULARIO_SOLICITUDES'
                )
                ->whereRaw('formulario_ofertas.ID_FORMULARIO_OFERTAS IN (
                SELECT MAX(ID_FORMULARIO_OFERTAS)
                FROM formulario_ofertas
                GROUP BY SUBSTRING_INDEX(NO_OFERTA, "-Rev", 1)
            )')

                ->whereBetween(
                    DB::raw('DATE(formulario_ofertas.FECHA_OFERTA)'),
                    [$fechaInicio, $fechaFin]
                )

                ->get();


            $solicitudesAceptadas = solicitudesModel::select(
                'ID_FORMULARIO_SOLICITUDES',
                'NO_SOLICITUD',
                'NOMBRE_COMERCIAL_SOLICITUD'
            )
            ->where('ESTATUS_SOLICITUD', 'like', '%Aceptada%')
            ->get();
    
            $idsAsociados = ofertasModel::pluck('SOLICITUD_ID')->toArray();
    
            foreach ($tabla as $value) {
                $solicitudesDisponibles = $solicitudesAceptadas->filter(function ($solicitud) use ($idsAsociados, $value) {
                    return !in_array($solicitud->ID_FORMULARIO_SOLICITUDES, $idsAsociados) ||
                        $solicitud->ID_FORMULARIO_SOLICITUDES == $value->SOLICITUD_ID;
                });
    
                $value->SOLICITUDES = $solicitudesDisponibles->values();
    
                $baseOferta = preg_replace('/-Rev\d+$/', '', $value->NO_OFERTA);
    
                $revisiones = ofertasModel::select(
                    'formulario_ofertas.*',  
                    'formulario_solicitudes.NO_SOLICITUD',
                    'formulario_solicitudes.NOMBRE_COMERCIAL_SOLICITUD'
                )
                ->leftJoin(
                    'formulario_solicitudes',
                    'formulario_ofertas.SOLICITUD_ID',
                    '=',
                    'formulario_solicitudes.ID_FORMULARIO_SOLICITUDES'
                )
                ->where(function ($query) use ($baseOferta) {
                    $query->where('NO_OFERTA', $baseOferta)
                          ->orWhere('NO_OFERTA', 'LIKE', $baseOferta . '-Rev%');
                })
                ->where('REVISION_OFERTA', '<', $value->REVISION_OFERTA)
                ->orderBy('REVISION_OFERTA', 'asc')
                ->get();
    
                foreach ($revisiones as $rev) {
                    $rev->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-cotizacion" data-id="' . $rev->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

                    $value->BTN_TERMINOS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-terminos" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';

                    $rev->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR" data-id="' . $rev->ID_FORMULARIO_OFERTAS . '"><i class="bi bi-pencil-square"></i></button>';

                    $rev->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    
                    $rev->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $rev->ID_FORMULARIO_OFERTAS . '" checked><span class="slider round"></span></label>';
                }
    
                $value->REVISIONES = $revisiones->isEmpty() ? [] : $revisiones;
    
                if ($value->ACTIVO == 0) {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_OFERTAS . '"><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-cotizacion" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_TERMINOS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-terminos" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR" data-id="' . $value->ID_FORMULARIO_OFERTAS . '"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_CORREO = '<button type="button" class="btn btn-info btn-custom rounded-pill CORREO"><i class="bi bi-envelope-arrow-up-fill"></i></button>';
                    $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-cotizacion" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_TERMINOS = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-terminos" data-id="' . $value->ID_FORMULARIO_OFERTAS . '" title="Ver documento"><i class="bi bi-filetype-pdf"></i></button>';
                }
            }
    
            return response()->json([
                'data' => $tabla,
                'msj' => 'Última revisión consultada correctamente'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'msj' => 'Error ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }
    

    public function mostrarcotizacion($id)
    {
        $archivo = ofertasModel::findOrFail($id)->COTIZACION_DOCUMENTO;
        return Storage::response($archivo);
    }


    public function mostrarterminos($id)
    {
        $archivo = ofertasModel::findOrFail($id)->TERMINOS_DOCUMENTO;
        return Storage::response($archivo);
    }

    public function actualizarEstatusOferta(Request $request)
    {
        try {
            $request->validate([
                'ID_FORMULARIO_OFERTAS' => 'required|exists:formulario_ofertas,ID_FORMULARIO_OFERTAS',
                'ESTATUS_OFERTA' => 'required|string|in:Aceptada,Revisión,Rechazada',
                'MOTIVO_RECHAZO' => 'nullable|string|max:255'
            ]);

            $oferta = ofertasModel::find($request->ID_FORMULARIO_OFERTAS);

            $oferta->ESTATUS_OFERTA = $request->ESTATUS_OFERTA;
            $oferta->MOTIVO_RECHAZO = $request->ESTATUS_OFERTA === 'Rechazada' ? $request->MOTIVO_RECHAZO : null;
            $oferta->save();

            return response()->json([
                'success' => true,
                'message' => 'Estatus actualizado correctamente.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estatus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_OFERTAS == 0) {
                        $anioActual = date('Y');
                        $ultimoDigitoAnio = substr($anioActual, -2);

                        $ultimoRegistro = ofertasModel::where('NO_OFERTA', 'LIKE', "RES-COT-$ultimoDigitoAnio-%")
                            ->orderByRaw("CAST(SUBSTRING_INDEX(NO_OFERTA, '-', -1) AS UNSIGNED) DESC")
                            ->first();

                        if ($ultimoRegistro) {
                            preg_match('/RES-COT-\d{2}-(\d{3})/', $ultimoRegistro->NO_OFERTA, $matches);
                            $numeroIncremental = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
                        } else {
                            $numeroIncremental = 1;
                        }

                        $noOferta = 'RES-COT-' . $ultimoDigitoAnio . '-' . str_pad($numeroIncremental, 3, '0', STR_PAD_LEFT);

                        $request->merge([
                            'NO_OFERTA' => $noOferta,
                            'REVISION_OFERTA' => 0,
                            'MOTIVO_REVISION_OFERTA' => 'Revisión inicial'
                        ]);

                        $data = $request->except(['observacion', 'COTIZACION_DOCUMENTO', 'TERMINOS_DOCUMENTO']);
                        $oferta = ofertasModel::create($data);

                        if ($request->hasFile('COTIZACION_DOCUMENTO')) {
                            $documento = $request->file('COTIZACION_DOCUMENTO');
                            $idOferta = $oferta->ID_FORMULARIO_OFERTAS;
                            $nombreArchivo = $documento->getClientOriginalName(); 
                            $rutaCarpeta = 'ventas/ofertas/' . $idOferta;
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $oferta->COTIZACION_DOCUMENTO = $rutaCompleta;
                            $oferta->save();
                        }

                        if ($request->hasFile('TERMINOS_DOCUMENTO')) {
                            $documento = $request->file('TERMINOS_DOCUMENTO');
                            $idOferta = $oferta->ID_FORMULARIO_OFERTAS;
                            $nombreArchivo = $documento->getClientOriginalName();
                            $rutaCarpeta = 'ventas/ofertas/' . $idOferta . '/Terminos';
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $oferta->TERMINOS_DOCUMENTO = $rutaCompleta;
                            $oferta->save();
                        }

                        $response['code'] = 1;
                        $response['oferta'] = 'Creada';
                    } else {
                        $oferta = ofertasModel::find($request->ID_FORMULARIO_OFERTAS);

                        if ($oferta) {
                            $oferta->update($request->except('COTIZACION_DOCUMENTO', 'TERMINOS_DOCUMENTO'));

                            if ($request->hasFile('COTIZACION_DOCUMENTO')) {
                                if ($oferta->COTIZACION_DOCUMENTO && Storage::exists($oferta->COTIZACION_DOCUMENTO)) {
                                    Storage::delete($oferta->COTIZACION_DOCUMENTO);
                                }

                                $documento = $request->file('COTIZACION_DOCUMENTO');
                                $idOferta = $oferta->ID_FORMULARIO_OFERTAS;
                                $nombreArchivo = $documento->getClientOriginalName(); 
                                $rutaCarpeta = 'ventas/ofertas/' . $idOferta;
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $oferta->COTIZACION_DOCUMENTO = $rutaCompleta;
                                $oferta->save();
                            }

                            if ($request->hasFile('TERMINOS_DOCUMENTO')) {
                                if ($oferta->TERMINOS_DOCUMENTO && Storage::exists($oferta->TERMINOS_DOCUMENTO)) {
                                    Storage::delete($oferta->TERMINOS_DOCUMENTO);
                                }

                                $documento = $request->file('TERMINOS_DOCUMENTO');
                                $idOferta = $oferta->ID_FORMULARIO_OFERTAS;
                                $nombreArchivo = $documento->getClientOriginalName();
                                $rutaCarpeta = 'ventas/ofertas/' . $idOferta . '/Terminos';
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $oferta->TERMINOS_DOCUMENTO = $rutaCompleta;
                                $oferta->save();
                            }

                            $response['code'] = 1;
                            $response['oferta'] = 'Actualizada';
                        } else {
                            $response['code'] = 0;
                            $response['error'] = 'No se encontró la oferta';
                        }
                    }

                    return response()->json($response);



                case 2:
                    $ofertaOriginal = ofertasModel::find($request->ID_FORMULARIO_OFERTAS);

                    if ($ofertaOriginal) {
                        $noOfertaBase = explode('-Rev', $ofertaOriginal->NO_OFERTA)[0];

                        $ultimaRevision = ofertasModel::where('NO_OFERTA', 'LIKE', "$noOfertaBase%")
                        ->orderBy('REVISION_OFERTA', 'desc')
                        ->first();

                        $revisionNumero = $ultimaRevision ? $ultimaRevision->REVISION_OFERTA + 1 : 1;
                        $noOfertaConRevision = $noOfertaBase . '-Rev' . $revisionNumero;

                        $nuevaOferta = $ofertaOriginal->replicate();
                        $nuevaOferta->NO_OFERTA = $noOfertaConRevision;
                        $nuevaOferta->REVISION_OFERTA = $revisionNumero;
                        $nuevaOferta->MOTIVO_REVISION_OFERTA = $request->MOTIVO_REVISION_OFERTA;

                        $nuevaOferta->save();

                        $response['code'] = 1;
                        $response['oferta'] = $nuevaOferta;
                    } else {
                        $response['code'] = 0;
                        $response['message'] = 'Oferta no encontrada';
                    }
                    return response()->json($response);

                default:
                    return response()->json(['code' => 1, 'msj' => 'API no encontrada']);


            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar la oferta', 'message' => $e->getMessage()]);
        }
    }




}
