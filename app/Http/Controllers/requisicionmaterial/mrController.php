<?php

namespace App\Http\Controllers\requisicionmaterial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;


use App\Models\requisicionmaterial\mrModel;
use App\Models\organizacion\catalogocategoriaModel;

use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\proveedortempModel;



// BITACORA


use App\Models\HojaTrabajo;


class mrController extends Controller
{




    public function index()
    {
        $proveedoresOficiales = altaproveedorModel::select('RAZON_SOCIAL_ALTA', 'RFC_ALTA')->get();
        $proveedoresTemporales = proveedortempModel::select('RAZON_PROVEEDORTEMP', 'RFC_PROVEEDORTEMP','NOMBRE_PROVEEDORTEMP')->get();

        return view('compras.requisicionesmaterial.bitacora', compact('proveedoresOficiales', 'proveedoresTemporales'));
    }


    public function Tablamr()
    {
        try {
            $userid = Auth::user()->ID_USUARIO;

            $tabla = mrModel::where('USUARIO_ID', $userid)->get();

            foreach ($tabla as $value) {



                if ($value->DAR_BUENO == 1) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->DAR_BUENO == 0) {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">En revisión</span>';
                } elseif ($value->DAR_BUENO == 1) {
                    $value->ESTADO_REVISION = '<span class="badge bg-success">✔</span>';
                } elseif ($value->DAR_BUENO == 2) {
                    $value->ESTADO_REVISION = '<span class="badge bg-danger">✖</span>';
                } else {
                    $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
                }

                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->ESTATUS = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
                    $value->ESTATUS = '<span class="badge bg-danger">Rechazado</span>';
                } else {
                    $value->ESTATUS = '<span class="badge bg-secondary">Sin estatus</span>';
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



    public function Tablarequsicionaprobada()
    {
        try {
            $tabla = mrModel::where('DAR_BUENO', 1)
                ->where(function ($query) {
                    $query->whereNull('ESTADO_APROBACION')
                        ->orWhereNotIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada']);
                })
                ->where(function ($query) {
                    $query->whereNull('JEFEINMEDIATO_ID')
                        ->orWhere('JEFEINMEDIATO_ID', '!=', Auth::id()); 
                })
                ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->DAR_BUENO == 0) {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">En revisión</span>';
                } elseif ($value->DAR_BUENO == 1) {
                    $value->ESTADO_REVISION = '<span class="badge bg-success">✔</span>';
                } elseif ($value->DAR_BUENO == 2) {
                    $value->ESTADO_REVISION = '<span class="badge bg-danger">✖</span>';
                } else {
                    $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
                }

                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->ESTATUS = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
                    $value->ESTATUS = '<span class="badge bg-danger">Rechazado</span>';
                } else {
                    $value->ESTATUS = '<span class="badge bg-secondary">Aprobar</span>';
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


    public function obtenerAreaSolicitante()
    {
        $usuario = auth()->user();

        $rol = $usuario->roles()
            ->whereNotIn('NOMBRE_ROL', ['Superusuario', 'Administrador'])
            ->first();

        if (!$rol) {
            return response()->json(['area' => null]);
        }

        $categoria = CatalogocategoriaModel::where('NOMBRE_CATEGORIA', $rol->NOMBRE_ROL)->first();
        if (!$categoria) {
            return response()->json(['area' => null]);
        }

        $area = DB::table('areas as a')
            ->leftJoin('lideres_categorias as lc', 'lc.AREA_ID', '=', 'a.ID_AREA')
            ->leftJoin('areas_lideres as al', 'al.AREA_ID', '=', 'a.ID_AREA')
            ->where(function ($query) use ($categoria) {
                $query->where('lc.CATEGORIA_ID', $categoria->ID_CATALOGO_CATEGORIA)
                    ->orWhere('al.LIDER_ID', $categoria->ID_CATALOGO_CATEGORIA);
            })
            ->select('a.NOMBRE')
            ->first();

        return response()->json([
            'area' => $area ? $area->NOMBRE : null
        ]);
    }


    public function guardarYDarVistoBueno(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:formulario_requisiconmaterial,ID_FORMULARIO_MR',
            'prioridad' => 'required|string',
            'observaciones' => 'nullable|string',
            'fecha_visto' => 'required|date',
            'visto_bueno' => 'required|string',
            'materiales_json' => 'required',
        ]);

        $formulario = mrModel::find($request->id);
        $formulario->PRIORIDAD_MR = $request->prioridad;
        $formulario->OBSERVACIONES_MR = $request->observaciones;
        $formulario->FECHA_VISTO_MR = $request->fecha_visto;
        $formulario->VISTO_BUENO = $request->visto_bueno;
        $formulario->DAR_BUENO = 1;
        $formulario->JEFEINMEDIATO_ID = Auth::id();

        $formulario->MATERIALES_JSON = is_string($request->materiales_json)
            ? $request->materiales_json
            : json_encode($request->materiales_json, JSON_UNESCAPED_UNICODE);

        $formulario->save();

        return response()->json([
            'success' => true,
            'message' => 'Formulario actualizado con visto bueno.'
        ]);
    }

    public function rechazar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:formulario_requisiconmaterial,ID_FORMULARIO_MR',
            'motivo' => 'required|string|max:1000',
            'prioridad' => 'required|string',
            'observaciones' => 'nullable|string',
            'fecha_visto' => 'required|date',
            'visto_bueno' => 'required|string',
            'materiales_json' => 'required',
        ]);

        $formulario = mrModel::find($request->id);
        $formulario->PRIORIDAD_MR = $request->prioridad;
        $formulario->OBSERVACIONES_MR = $request->observaciones;
        $formulario->FECHA_VISTO_MR = $request->fecha_visto;
        $formulario->VISTO_BUENO = $request->visto_bueno;
        $formulario->DAR_BUENO = 2;
        $formulario->MOTIVO_RECHAZO_JEFE = $request->motivo;

      
        $formulario->MATERIALES_JSON = is_string($request->materiales_json)
            ? $request->materiales_json
            : json_encode($request->materiales_json, JSON_UNESCAPED_UNICODE);

        $formulario->save();

        return response()->json([
            'success' => true,
            'message' => 'Formulario rechazado correctamente.'
        ]);
    }





    public function Tablarequisicion()
    {
        try {
            $usuario = Auth::user();
            $idUsuario = $usuario->ID_USUARIO;

            $roles = $usuario->roles()->pluck('NOMBRE_ROL')->toArray();

            $esDirector = in_array('Director', $roles);

            $categoriasLideradas = DB::table('lideres_categorias as lc')
                ->join('catalogo_categorias as cc', 'cc.ID_CATALOGO_CATEGORIA', '=', 'lc.LIDER_ID')
                ->whereIn('cc.NOMBRE_CATEGORIA', $roles)
                ->pluck('lc.CATEGORIA_ID')
                ->toArray();

            $usuariosACargo = DB::table('asignar_rol')
                ->whereIn('NOMBRE_ROL', function ($query) use ($categoriasLideradas) {
                    $query->select('NOMBRE_CATEGORIA')
                        ->from('catalogo_categorias')
                        ->whereIn('ID_CATALOGO_CATEGORIA', $categoriasLideradas);
                })
                ->pluck('USUARIO_ID')
                ->toArray();

            if ($esDirector) {
                $usuariosSinLider = DB::table('asignar_rol as ar')
                    ->leftJoin('catalogo_categorias as cc', 'cc.NOMBRE_CATEGORIA', '=', 'ar.NOMBRE_ROL')
                    ->leftJoin('lideres_categorias as lc', 'lc.CATEGORIA_ID', '=', 'cc.ID_CATALOGO_CATEGORIA')
                    ->whereNull('lc.LIDER_ID')
                    ->pluck('ar.USUARIO_ID')
                    ->toArray();

                $usuariosACargo = array_merge($usuariosACargo, $usuariosSinLider);
            }

            $usuariosACargo = array_unique($usuariosACargo);

            if (empty($usuariosACargo)) {
                return response()->json([
                    'data' => [],
                    'msj' => 'No tiene registros a su cargo.'
                ]);
            }

            $tabla = mrModel::whereIn('USUARIO_ID', $usuariosACargo)
            ->where('DAR_BUENO', 0)
            ->get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->DAR_BUENO == 0) {
                    $value->ESTADO_REVISION = '<span class="badge bg-warning text-dark">Revisar</span>';
                } elseif ($value->DAR_BUENO == 1) {
                    $value->ESTADO_REVISION = '<span class="badge bg-success">✔</span>';
                } elseif ($value->DAR_BUENO == 2) {
                    $value->ESTADO_REVISION = '<span class="badge bg-danger">✖</span>';
                } else {
                    $value->ESTADO_REVISION = '<span class="badge bg-secondary">Sin estado</span>';
                }

                if ($value->ESTADO_APROBACION == 'Aprobada') {
                    $value->ESTATUS = '<span class="badge bg-success">Aprobado</span>';
                } elseif ($value->ESTADO_APROBACION == 'Rechazada') {
                    $value->ESTATUS = '<span class="badge bg-danger">Rechazado</span>';
                } else {
                    $value->ESTATUS = '<span class="badge bg-secondary">Sin estatus</span>';
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



    /////////////////////////////////////////////////////////// BITACORA REQUISICION //////////////////////////////////////////////////////////////



    // public function Tablabitacora()
    // {
    //     try {
    //         $tabla = mrModel::where('ESTADO_APROBACION', 'Aprobada')->get();

    //         foreach ($tabla as $value) {
    //             $no_mr = $value->NO_MR;

    //             $bitacoras = DB::table('formulario_bitacoragr')
    //                 ->where('NO_MR', $no_mr)
    //                 ->select('NO_RECEPCION', 'FECHA_ENTREGA_GR')
    //                 ->get();

    //             if ($bitacoras->count() > 0) {
    //                 $value->NO_GR = $bitacoras
    //                     ->map(fn($item) => '• ' . $item->NO_RECEPCION)
    //                     ->implode('<br>');

    //                 $value->FECHA_GR = $bitacoras
    //                     ->map(fn($item) => '• ' . $item->FECHA_ENTREGA_GR)
    //                     ->implode('<br>');
    //             } else {
    //                 $value->NO_GR = '—';
    //                 $value->FECHA_GR = '—';
    //             }
    //             $hojas = DB::table('hoja_trabajo')->where('NO_MR', $no_mr)->get();
    //             $total = $hojas->count();

    //             if ($total === 0) {
    //                 $value->ESTADO_FINAL = 'Sin datos';
    //                 $value->COLOR = null;
    //                 $value->DISABLED_SELECT = true;
    //             } else {
    //                 $aprobadas = $hojas->whereIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada'])->count();
    //                 $requiere_po = $hojas->where('REQUIERE_PO', 'Sí')->count();
    //                 $po_aprobada_o_rechazada = false;

    //                 foreach ($hojas as $hoja) {
    //                     $hoja_id = $hoja->id;
    //                     $po_relacionadas = DB::table('formulario_ordencompra')
    //                         ->whereJsonContains('HOJA_ID', (string)$hoja_id)
    //                         ->whereIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada'])
    //                         ->count();

    //                     if ($po_relacionadas > 0) {
    //                         $po_aprobada_o_rechazada = true;
    //                         break;
    //                     }
    //                 }

    //                 if ($aprobadas === $total && ($requiere_po === 0 || $po_aprobada_o_rechazada)) {
    //                     $value->ESTADO_FINAL = 'Finalizada';
    //                     $value->COLOR = '#d4edda';
    //                     $value->DISABLED_SELECT = false;
    //                 } else {
    //                     $value->ESTADO_FINAL = 'En proceso';
    //                     $value->COLOR = '#fff3cd';
    //                     $value->DISABLED_SELECT = false;
    //                 }
    //             }


    //             if ($value->ACTIVO == 0) {
    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-eye"></i></button>';
    //             } else {
    //                 $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
    //                 $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
    //                 $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
    //             }

    //             $value->BTN_NO_MR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
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





    public function Tablabitacora()
    {
        try {

          

            $fechaInicio = Carbon::now('America/Mexico_City')->startOfYear()->toDateString();
            $fechaFin    = Carbon::now('America/Mexico_City')->endOfYear()->toDateString();


            $tabla = mrModel::whereIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada'])
                ->where(function ($query) use ($fechaInicio, $fechaFin) {

                    $query->where(function ($q) use ($fechaInicio, $fechaFin) {
                        $q->where('ESTADO_APROBACION', 'Rechazada')
                            ->whereBetween('FECHA_SOLICITUD_MR', [$fechaInicio, $fechaFin]);
                    })

                  
                        ->orWhere(function ($q) use ($fechaInicio, $fechaFin) {

                            $q->where(function ($x) use ($fechaInicio, $fechaFin) {
                                $x->where('ESTADO_APROBACION', 'Aprobada')
                                    ->whereBetween('FECHA_SOLICITUD_MR', [$fechaInicio, $fechaFin]);
                            })

                                ->orWhere(function ($x) use ($fechaInicio, $fechaFin) {
                                    $x->where('ESTADO_APROBACION', 'Aprobada')
                                        ->whereNotBetween('FECHA_SOLICITUD_MR', [$fechaInicio, $fechaFin])
                                        ->where(function ($y) {


                                            $y->whereNotExists(function ($sub) {
                                                $sub->select(DB::raw(1))
                                                    ->from('hoja_trabajo')
                                                    ->whereColumn(
                                                        'hoja_trabajo.NO_MR',
                                                        'formulario_requisiconmaterial.NO_MR'
                                                    );
                                            })

                                                ->orWhereExists(function ($sub) {
                                                    $sub->select(DB::raw(1))
                                                        ->from('hoja_trabajo')
                                                        ->whereColumn(
                                                            'hoja_trabajo.NO_MR',
                                                            'formulario_requisiconmaterial.NO_MR'
                                                        )
                                                        ->where(function ($w) {
                                                            $w->whereNull('ESTADO_APROBACION')
                                                                ->orWhere('ESTADO_APROBACION', '!=', 'Rechazada');
                                                        });
                                                });
                                        })

                                        ->whereNotExists(function ($sub) {
                                            $sub->select(DB::raw(1))
                                                ->from('formulario_bitacoragr')
                                                ->whereColumn(
                                                    'formulario_bitacoragr.NO_MR',
                                                    'formulario_requisiconmaterial.NO_MR'
                                                );
                                        });
                                });
                        });
                })
                ->get();



            foreach ($tabla as $value) {
                $no_mr = $value->NO_MR;

                $bitacoras = DB::table('formulario_bitacoragr')
                    ->where('NO_MR', $no_mr)
                    ->select('NO_RECEPCION', 'FECHA_ENTREGA_GR')
                    ->get();

                if ($bitacoras->count() > 0) {
                    $value->NO_GR = $bitacoras
                        ->map(fn($item) => '• ' . $item->NO_RECEPCION)
                        ->implode('<br>');

                    $value->FECHA_GR = $bitacoras
                        ->map(fn($item) => '• ' . $item->FECHA_ENTREGA_GR)
                        ->implode('<br>');
                } else {
                    $value->NO_GR = '—';
                    $value->FECHA_GR = '—';
                }





                $hojas = DB::table('hoja_trabajo')->where('NO_MR', $no_mr)->get();
                $total = $hojas->count();

                if ($total === 0) {
                    $value->ESTADO_FINAL = 'Sin datos';
                    $value->COLOR = null;
                    $value->DISABLED_SELECT = true;
                } else {

                $estados = $hojas->pluck('ESTADO_APROBACION');
                $aprobados = $estados->filter(fn($e) => $e === 'Aprobada')->count();
                $rechazados = $estados->filter(fn($e) => $e === 'Rechazada')->count();

                $requiere_po = $hojas->where('REQUIERE_PO', 'Sí')->count();
                $po_aprobada_o_rechazada = false;

                foreach ($hojas as $hoja) {
                    $hoja_id = $hoja->id;
                    $po_relacionadas = DB::table('formulario_ordencompra')
                        ->whereJsonContains('HOJA_ID', (string)$hoja_id)
                        ->whereIn('ESTADO_APROBACION', ['Aprobada', 'Rechazada'])
                        ->count();

                    if ($po_relacionadas > 0) {
                        $po_aprobada_o_rechazada = true;
                        break;
                    }
                }

                if ($rechazados == $total) {

                    $value->ESTADO_FINAL = 'Finalizada';
                } else {

                    if ($aprobados > 0 && $rechazados <= $total) {

                        if ($requiere_po > 0 && !$po_aprobada_o_rechazada) {
                            $value->ESTADO_FINAL = 'En proceso';
                        } else {
                            $value->ESTADO_FINAL = 'Finalizada';
                        }
                    } else {
                        $value->ESTADO_FINAL = 'En proceso';
                    }
                }



                if ($value->ESTADO_FINAL === 'En proceso') {
                    $value->COLOR = '#fff3cd'; 
                }
                elseif ($rechazados == $total) {
                    $value->COLOR = '#f8d7da'; 
                }
                elseif ($aprobados == $total) {
                    $value->COLOR = '#d4edda'; 
                }
                elseif ($aprobados > 0 && $rechazados > 0) {
                    $value->COLOR = '#d4edda';
                }
                else {
                    $value->COLOR = '#fff3cd'; 
                }


                    $value->DISABLED_SELECT = false;
                }



                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-eye"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_MR . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill EDITAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                }

                if ($value->ESTADO_APROBACION === 'Rechazada') {
                    $value->BTN_NO_MR = '
                        <button type="button" class="btn btn-secondary btn-custom rounded-pill" disabled>
                            <i class="bi bi-ban"></i>
                        </button>
                    ';
                } else {

                    $value->BTN_NO_MR = '
                        <button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR">
                            <i class="bi bi-eye"></i>
                        </button>
                    ';
                }


                if ($value->ESTADO_APROBACION === 'Rechazada') {
                    $value->COLOR = '#f8d7da'; 
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





    public function guardarHOJAS(Request $request)
    {
        $esUnico = $request->input('ES_UNICO');
        $no_mr = $request->input('NO_MR');
        $ids = $request->input('id');

        // Campos comunes
        $proveedor_q1 = $request->input('PROVEEDOR_Q1');
        $subtotal_q1 = $request->input('SUBTOTAL_Q1');
        $iva_q1 = $request->input('IVA_Q1');
        $importe_q1 = $request->input('IMPORTE_Q1');
        $observaciones_q1 = $request->input('OBSERVACIONES_Q1');
        $fecha_q1 = $request->input('FECHA_COTIZACION_Q1');
        $proveedor_q2 = $request->input('PROVEEDOR_Q2');
        $subtotal_q2 = $request->input('SUBTOTAL_Q2');
        $iva_q2 = $request->input('IVA_Q2');
        $importe_q2 = $request->input('IMPORTE_Q2');
        $observaciones_q2 = $request->input('OBSERVACIONES_Q2');
        $fecha_q2 = $request->input('FECHA_COTIZACION_Q2');
        $proveedor_q3 = $request->input('PROVEEDOR_Q3');
        $subtotal_q3 = $request->input('SUBTOTAL_Q3');
        $iva_q3 = $request->input('IVA_Q3');
        $importe_q3 = $request->input('IMPORTE_Q3');
        $observaciones_q3 = $request->input('OBSERVACIONES_Q3');
        $fecha_q3 = $request->input('FECHA_COTIZACION_Q3');
        $proveedor_sugerido = $request->input('PROVEEDOR_SUGERIDO');
        $solicitarverificacion = $request->input('SOLICITAR_VERIFICACION');
        $fechaverificacion = $request->input('FECHA_VERIFICACION');
        $estadoaprobacion = $request->input('ESTADO_APROBACION');
        $motivorechazo = $request->input('MOTIVO_RECHAZO');
        $fechaaprobacion = $request->input('FECHA_APROBACION');
        $forma_adquisicion = $request->input('FORMA_ADQUISICION');
        $proveedor_seleccionado = $request->input('PROVEEDOR_SELECCIONADO');
        $monto_final = $request->input('MONTO_FINAL');
        $forma_pago = $request->input('FORMA_PAGO');
        $requiere_po = $request->input('REQUIERE_PO');
        $requierecomentario = $request->input('REQUIERE_COMENTARIO');
        $comentarioaprobacion = $request->input('COMENTARIO_APROBACION');
        $comentariosolicitud = $request->input('COMENTARIO_SOLICITUD');


        if ($esUnico === 'SI') {
            $materiales_hoja_json = $request->input('MATERIALES_HOJA_JSON')[0] ?? null;
            $id_hoja = $ids[0] ?? null;

            $data = [
                'NO_MR' => $no_mr,
                'PROVEEDOR_Q1' => $proveedor_q1[0] ?? null,
                'SUBTOTAL_Q1' => $subtotal_q1[0] ?? null,
                'IVA_Q1' => $iva_q1[0] ?? null,
                'IMPORTE_Q1' => $importe_q1[0] ?? null,
                'OBSERVACIONES_Q1' => $observaciones_q1[0] ?? null,
                'FECHA_COTIZACION_Q1' => $fecha_q1[0] ?? null,
                'PROVEEDOR_Q2' => $proveedor_q2[0] ?? null,
                'SUBTOTAL_Q2' => $subtotal_q2[0] ?? null,
                'IVA_Q2' => $iva_q2[0] ?? null,
                'IMPORTE_Q2' => $importe_q2[0] ?? null,
                'OBSERVACIONES_Q2' => $observaciones_q2[0] ?? null,
                'FECHA_COTIZACION_Q2' => $fecha_q2[0] ?? null,
                'PROVEEDOR_Q3' => $proveedor_q3[0] ?? null,
                'SUBTOTAL_Q3' => $subtotal_q3[0] ?? null,
                'IVA_Q3' => $iva_q3[0] ?? null,
                'IMPORTE_Q3' => $importe_q3[0] ?? null,
                'OBSERVACIONES_Q3' => $observaciones_q3[0] ?? null,
                'FECHA_COTIZACION_Q3' => $fecha_q3[0] ?? null,
                'PROVEEDOR_SUGERIDO' => $proveedor_sugerido[0] ?? null,
                'SOLICITAR_VERIFICACION' => $solicitarverificacion[0] ?? null,
                'FECHA_VERIFICACION' => $fechaverificacion[0] ?? null,
                'ESTADO_APROBACION' => $estadoaprobacion[0] ?? null,
                'MOTIVO_RECHAZO' => $motivorechazo[0] ?? null,
                'FECHA_APROBACION' => $fechaaprobacion[0] ?? null,
                'FORMA_ADQUISICION' => $forma_adquisicion[0] ?? null,
                'PROVEEDOR_SELECCIONADO' => $proveedor_seleccionado[0] ?? null,
                'MONTO_FINAL' => $monto_final[0] ?? null,
                'FORMA_PAGO' => $forma_pago[0] ?? null,
                'REQUIERE_PO' => $requiere_po[0] ?? null,
                'REQUIERE_COMENTARIO' => $requierecomentario[0] ?? null,
                'COMENTARIO_APROBACION' => $comentarioaprobacion[0] ?? null,
                'COMENTARIO_SOLICITUD' => $comentariosolicitud[0] ?? null,

                'MATERIALES_HOJA_JSON' => $materiales_hoja_json,
            ];

            if ($id_hoja) {
                $hoja = HojaTrabajo::find($id_hoja);
                if ($hoja) {
                    $hoja->update($data);
                } else {
                    $hoja = HojaTrabajo::create($data);
                }
            } else {
                $hoja = HojaTrabajo::create($data);
            }

            $id = $hoja->id;

            foreach (['Q1', 'Q2', 'Q3'] as $q) {
                if ($request->hasFile("DOCUMENTO_{$q}.0")) {
                    $file = $request->file("DOCUMENTO_{$q}")[0];
                    $fileName = $file->getClientOriginalName();
                    $folder = "compras/{$no_mr}/{$id}/{$q}";
                    $path = $file->storeAs($folder, $fileName);
                    $hoja["DOCUMENTO_{$q}"] = $path;
                }
            }

            $hoja->save();

            if (($solicitarverificacion[0] ?? null) === 'Sí' && !$hoja->SOLICITO_ID) {
                $hoja->SOLICITO_ID = auth()->user()->ID_USUARIO;
                $hoja->save();
            }

            if (in_array(($estadoaprobacion[0] ?? null), ['Aprobada', 'Rechazada']) && !$hoja->APROBADO_ID) {
                $hoja->APROBADO_ID = auth()->user()->ID_USUARIO;
                $hoja->save();
            }


            if (($requiere_po[0] ?? null) === 'Sí' && ($estadoaprobacion[0] ?? null) === 'Aprobada') {
                $ordenExistente = DB::table('formulario_ordencompra')
                    ->get()
                    ->first(function ($registro) use ($id) {
                        $hojas = json_decode($registro->HOJA_ID ?? '[]', true);
                        return in_array((string) $id, $hojas);
                    });

                if (!$ordenExistente) {
                    $proveedorSeleccionado = $proveedor_seleccionado[0] ?? null;

                    $posicionQ = null;
                    if ($proveedorSeleccionado === ($proveedor_q1[0] ?? null)) {
                        $posicionQ = 1;
                    } elseif ($proveedorSeleccionado === ($proveedor_q2[0] ?? null)) {
                        $posicionQ = 2;
                    } elseif ($proveedorSeleccionado === ($proveedor_q3[0] ?? null)) {
                        $posicionQ = 3;
                    }

                    $materiales_json = json_decode($materiales_hoja_json ?? '[]', true);
                    $materialesFiltrados = [];

                    foreach ($materiales_json as $m) {
                        $cantidad = $m['CANTIDAD_REAL'] ?? '';
                        $precio = '';

                        if ($posicionQ === 1) {
                            $precio = $m['PRECIO_UNITARIO'] ?? '';
                        } elseif ($posicionQ === 2) {
                            $precio = $m['PRECIO_UNITARIO_Q2'] ?? '';
                        } elseif ($posicionQ === 3) {
                            $precio = $m['PRECIO_UNITARIO_Q3'] ?? '';
                        }

                        $materialesFiltrados[] = [
                            'DESCRIPCION'     => $m['DESCRIPCION'] ?? '',
                            'CANTIDAD_'       => $cantidad,
                            'PRECIO_UNITARIO' => $precio,
                            'UNIDAD_MEDIDA'   => $m['UNIDAD_MEDIDA'] ?? '', 

                        ];
                    }

                    $año = now()->format('y');
                    $ultimo = DB::table('formulario_ordencompra')
                        ->where('NO_PO', 'like', "RES-PO$año-%")
                        ->orderByDesc('ID_FORMULARIO_PO')
                        ->value('NO_PO');

                    $consecutivo = $ultimo ? (int)substr($ultimo, -3) + 1 : 1;
                    $numeroOrden = sprintf("RES-PO%s-%03d", $año, $consecutivo);

                    DB::table('formulario_ordencompra')->insert([
                        'HOJA_ID'                 => json_encode([(string) $id]),
                        'NO_MR'                   => $no_mr,
                        'NO_PO'                   => $numeroOrden,
                        'PROVEEDOR_SELECCIONADO' => $proveedorSeleccionado,
                        'MATERIALES_JSON'        => json_encode($materialesFiltrados, JSON_UNESCAPED_UNICODE),
                        'ACTIVO'                  => 1,
                        'created_at'              => now(),
                        'updated_at'              => now(),
                    ]);
                }
            }


            $proveedores = [
                1 => $proveedor_q1[0] ?? null,
                2 => $proveedor_q2[0] ?? null,
                3 => $proveedor_q3[0] ?? null,
            ];

            $subtotales = [
                1 => $subtotal_q1[0] ?? 0,
                2 => $subtotal_q2[0] ?? 0,
                3 => $subtotal_q3[0] ?? 0,
            ];

            $materiales_json = json_decode($materiales_hoja_json ?? '[]', true);

            $proveedores_detectados = [];
            $materiales_detectados = [];

            foreach ([1, 2, 3] as $q) {
                $prov = $proveedores[$q];
                $subt = $subtotales[$q];

                if ($subt > 10001 && !empty($prov)) {
                    $proveedores_detectados["PROVEEDOR{$q}"] = $prov;

                    $materialesPorProveedor = [];

                    foreach ($materiales_json as $m) {
                        $cantidadCampo = 'CANTIDAD_REAL';
                        $precioCampo   = $q === 1 ? 'PRECIO_UNITARIO' : "PRECIO_UNITARIO_Q{$q}";

                        if (empty($m[$cantidadCampo]) || $m[$cantidadCampo] == 0) {
                            continue;
                        }

                        $materialesPorProveedor[] = [
                            'DESCRIPCION'     => $m['DESCRIPCION'] ?? '',
                            'CANTIDAD_'       => $m[$cantidadCampo],
                            'PRECIO_UNITARIO' => $m[$precioCampo] ?? '',
                            'UNIDAD_MEDIDA'   => $m['UNIDAD_MEDIDA'] ?? '', 
                        ];
                    }

                    $materiales_detectados["MATERIALES_JSON_PROVEEDOR{$q}"] = json_encode($materialesPorProveedor, JSON_UNESCAPED_UNICODE);
                }
            }

            if (!empty($proveedores_detectados)) {
                $proveedores_set = array_values(array_filter($proveedores_detectados));
                sort($proveedores_set, SORT_STRING);

              
                $registroExistente = DB::table('formulario_matrizcomparativa')
                    ->where('NO_MR', $no_mr)
                    ->get()
                    ->filter(function ($registro) use ($id) {
                        $hoja_ids = json_decode($registro->HOJA_ID ?? '[]', true);
                        return in_array((string) $id, $hoja_ids);
                    })
                    ->values()
                    ->first();

                if ($registroExistente) {
                    $proveedores_actuales = [
                        'PROVEEDOR1' => $registroExistente->PROVEEDOR1 ?? null,
                        'PROVEEDOR2' => $registroExistente->PROVEEDOR2 ?? null,
                        'PROVEEDOR3' => $registroExistente->PROVEEDOR3 ?? null,
                    ];

                    $materiales_actuales = [
                        'MATERIALES_JSON_PROVEEDOR1' => $registroExistente->MATERIALES_JSON_PROVEEDOR1 ?? null,
                        'MATERIALES_JSON_PROVEEDOR2' => $registroExistente->MATERIALES_JSON_PROVEEDOR2 ?? null,
                        'MATERIALES_JSON_PROVEEDOR3' => $registroExistente->MATERIALES_JSON_PROVEEDOR3 ?? null,
                    ];

                    $proveedores_finales = array_replace($proveedores_actuales, $proveedores_detectados);
                    $materiales_finales = array_replace($materiales_actuales, $materiales_detectados);

                    DB::table('formulario_matrizcomparativa')
                        ->where('ID_FORMULARIO_MATRIZ', $registroExistente->ID_FORMULARIO_MATRIZ)
                        ->update(array_merge([
                            'updated_at' => now(),
                        ], $proveedores_finales, $materiales_finales));
                } else {
                    HojaTrabajo::where('id', $id)->update(['REQUIERE_MATRIZ' => 'Sí']);

                    DB::table('formulario_matrizcomparativa')->insert(array_merge([
                        'HOJA_ID'    => json_encode([(string) $id], JSON_UNESCAPED_UNICODE),
                        'NO_MR'      => $no_mr,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ], $proveedores_detectados, $materiales_detectados));
                }
            }
            /********** FIN MATRIZ COMPARATIVA PARA PROVEEDOR UNICO *************/
         }
       

        else {
            $descripciones = $request->input('DESCRIPCION');
            $cantidades = $request->input('CANTIDAD');
            $unidades = $request->input('UNIDAD_MEDIDA');
            $cantidadmrq1 = $request->input('CANTIDAD_MRQ1');
            $cantidadrealq1 = $request->input('CANTIDAD_REALQ1');
            $preciounitarioq1 = $request->input('PRECIO_UNITARIOQ1');
            $cantidadmrq2 = $request->input('CANTIDAD_MRQ2');
            $cantidadrealq2 = $request->input('CANTIDAD_REALQ2');
            $preciounitarioq2 = $request->input('PRECIO_UNITARIOQ2');
            $cantidadmrq3 = $request->input('CANTIDAD_MRQ3');
            $cantidadrealq3 = $request->input('CANTIDAD_REALQ3');
            $preciounitarioq3 = $request->input('PRECIO_UNITARIOQ3');

            $total = count($descripciones);

            for ($i = 0; $i < $total; $i++) {
                $data = [
                    'NO_MR' => $no_mr,
                    'DESCRIPCION' => $descripciones[$i] ?? '',
                    'CANTIDAD' => $cantidades[$i] ?? '',
                    'UNIDAD_MEDIDA' => $unidades[$i] ?? '',
                    'CANTIDAD_MRQ1' => $cantidadmrq1[$i] ?? null,
                    'CANTIDAD_REALQ1' => $cantidadrealq1[$i] ?? null,
                    'PRECIO_UNITARIOQ1' => $preciounitarioq1[$i] ?? null,
                    'CANTIDAD_MRQ2' => $cantidadmrq2[$i] ?? null,
                    'CANTIDAD_REALQ2' => $cantidadrealq2[$i] ?? null,
                    'PRECIO_UNITARIOQ2' => $preciounitarioq2[$i] ?? null,
                    'CANTIDAD_MRQ3' => $cantidadmrq3[$i] ?? null,
                    'CANTIDAD_REALQ3' => $cantidadrealq3[$i] ?? null,
                    'PRECIO_UNITARIOQ3' => $preciounitarioq3[$i] ?? null,
                    'PROVEEDOR_Q1' => $proveedor_q1[$i] ?? null,
                    'SUBTOTAL_Q1' => $subtotal_q1[$i] ?? null,
                    'IVA_Q1' => $iva_q1[$i] ?? null,
                    'IMPORTE_Q1' => $importe_q1[$i] ?? null,
                    'OBSERVACIONES_Q1' => $observaciones_q1[$i] ?? null,
                    'FECHA_COTIZACION_Q1' => $fecha_q1[$i] ?? null,
                    'PROVEEDOR_Q2' => $proveedor_q2[$i] ?? null,
                    'SUBTOTAL_Q2' => $subtotal_q2[$i] ?? null,
                    'IVA_Q2' => $iva_q2[$i] ?? null,
                    'IMPORTE_Q2' => $importe_q2[$i] ?? null,
                    'OBSERVACIONES_Q2' => $observaciones_q2[$i] ?? null,
                    'FECHA_COTIZACION_Q2' => $fecha_q2[$i] ?? null,
                    'PROVEEDOR_Q3' => $proveedor_q3[$i] ?? null,
                    'SUBTOTAL_Q3' => $subtotal_q3[$i] ?? null,
                    'IVA_Q3' => $iva_q3[$i] ?? null,
                    'IMPORTE_Q3' => $importe_q3[$i] ?? null,
                    'OBSERVACIONES_Q3' => $observaciones_q3[$i] ?? null,
                    'FECHA_COTIZACION_Q3' => $fecha_q3[$i] ?? null,
                    'PROVEEDOR_SUGERIDO' => $proveedor_sugerido[$i] ?? null,
                    'SOLICITAR_VERIFICACION' => $solicitarverificacion[$i] ?? null,
                    'FECHA_VERIFICACION' => $fechaverificacion[$i] ?? null,
                    'ESTADO_APROBACION' => $estadoaprobacion[$i] ?? null,
                    'MOTIVO_RECHAZO' => $motivorechazo[$i] ?? null,
                    'FECHA_APROBACION' => $fechaaprobacion[$i] ?? null,
                    'FORMA_ADQUISICION' => $forma_adquisicion[$i] ?? null,
                    'PROVEEDOR_SELECCIONADO' => $proveedor_seleccionado[$i] ?? null,
                    'MONTO_FINAL' => $monto_final[$i] ?? null,
                    'FORMA_PAGO' => $forma_pago[$i] ?? null,
                    'REQUIERE_PO' => $requiere_po[$i] ?? null,
                    'REQUIERE_COMENTARIO' => $requierecomentario[$i] ?? null,
                    'COMENTARIO_APROBACION' => $comentarioaprobacion[$i] ?? null,
                    'COMENTARIO_SOLICITUD' => $comentariosolicitud[$i] ?? null,
                ];

                $hoja = !empty($ids[$i]) ? HojaTrabajo::find($ids[$i]) : null;
                if ($hoja) {
                    $hoja->update($data);
                } else {
                    $hoja = HojaTrabajo::create($data);
                }

                $ids[$i] = $hoja->id;

                foreach (['Q1', 'Q2', 'Q3'] as $q) {
                    if ($request->hasFile("DOCUMENTO_{$q}.$i")) {
                        $file = $request->file("DOCUMENTO_{$q}")[$i];
                        $fileName = $file->getClientOriginalName();
                        $folder = "compras/{$no_mr}/{$ids[$i]}/{$q}";
                        $path = $file->storeAs($folder, $fileName);
                        $hoja["DOCUMENTO_{$q}"] = $path;
                    }
                }

                $hoja->save();

                if (($solicitarverificacion[$i] ?? null) === 'Sí' && !$hoja->SOLICITO_ID) {
                    $hoja->SOLICITO_ID = auth()->user()->ID_USUARIO;
                    $hoja->save();
                }

                if (in_array(($estadoaprobacion[$i] ?? null), ['Aprobada', 'Rechazada']) && !$hoja->APROBADO_ID) {
                    $hoja->APROBADO_ID = auth()->user()->ID_USUARIO;
                    $hoja->save();
                }
            }

            // ================== ORDEN DE COMPRA ==================
            $grupos = [];
            for ($i = 0; $i < $total; $i++) {
                if (($requiere_po[$i] ?? null) === 'Sí' && ($estadoaprobacion[$i] ?? null) === 'Aprobada') {
                    $proveedorSeleccionado = $proveedor_seleccionado[$i] ?? null;
                    if ($proveedorSeleccionado) {
                        if (!isset($grupos[$proveedorSeleccionado])) {
                            $grupos[$proveedorSeleccionado] = [
                                'ids' => [],
                                'materiales' => [],
                            ];
                        }

                      

                        if (!in_array((string)$ids[$i], $grupos[$proveedorSeleccionado]['ids'])) {
                            $grupos[$proveedorSeleccionado]['ids'][] = (string)$ids[$i];
                        }

                        
                        $cant = '';
                        $prec = '';
                        if ($proveedorSeleccionado === ($proveedor_q1[$i] ?? null)) {
                            $cant = $cantidadrealq1[$i] ?? '';
                            $prec = $preciounitarioq1[$i] ?? '';
                        } elseif ($proveedorSeleccionado === ($proveedor_q2[$i] ?? null)) {
                            $cant = $cantidadrealq2[$i] ?? '';
                            $prec = $preciounitarioq2[$i] ?? '';
                        } elseif ($proveedorSeleccionado === ($proveedor_q3[$i] ?? null)) {
                            $cant = $cantidadrealq3[$i] ?? '';
                            $prec = $preciounitarioq3[$i] ?? '';
                        }

                        $grupos[$proveedorSeleccionado]['materiales'][] = [
                            'DESCRIPCION'     => $descripciones[$i] ?? '',
                            'CANTIDAD_'       => $cant,
                            'PRECIO_UNITARIO' => $prec,
                            'UNIDAD_MEDIDA'   => $unidades[$i] ?? '', 

                        ];
                    }
                }
            }

            foreach ($grupos as $proveedor => $grupo) {
                $registroExistente = DB::table('formulario_ordencompra')
                    ->get()
                    ->first(function ($registro) use ($grupo) {
                        $hojasExistentes = json_decode($registro->HOJA_ID ?? '[]', true);
                        return count(array_intersect($hojasExistentes, $grupo['ids'])) > 0;
                    });

                if (!$registroExistente) {
                    $año = now()->format('y');
                    $ultimo = DB::table('formulario_ordencompra')
                        ->where('NO_PO', 'like', "RES-PO$año-%")
                        ->orderByDesc('ID_FORMULARIO_PO')
                        ->value('NO_PO');

                    $consecutivo = $ultimo ? (int)substr($ultimo, -3) + 1 : 1;
                    $numeroOrden = sprintf("RES-PO%s-%03d", $año, $consecutivo);

                    DB::table('formulario_ordencompra')->insert([
                        'HOJA_ID'                 => json_encode($grupo['ids']),
                        'NO_MR'                   => $no_mr,
                        'NO_PO'                   => $numeroOrden,
                        'PROVEEDOR_SELECCIONADO' => $proveedor,
                        'MATERIALES_JSON'        => json_encode($grupo['materiales'], JSON_UNESCAPED_UNICODE),
                        'ACTIVO'                  => 1,
                        'created_at'              => now(),
                        'updated_at'              => now(),
                    ]);
                }
            }

            // ================== MATRIZ COMPARATIVA ==================
            $grupos = [];
            for ($i = 0; $i < $total; $i++) {
                $subtotalQ1 = $subtotal_q1[$i] ?? 0;
                $subtotalQ2 = $subtotal_q2[$i] ?? 0;
                $subtotalQ3 = $subtotal_q3[$i] ?? 0;

                if ($subtotalQ1 <= 10001 && $subtotalQ2 <= 10001 && $subtotalQ3 <= 10001) {
                    continue;
                }

                $proveedoresRaw = [
                    $proveedor_q1[$i] ?? '',
                    $proveedor_q2[$i] ?? '',
                    $proveedor_q3[$i] ?? '',
                ];

                $proveedoresOrdenados = array_values(array_filter($proveedoresRaw));
                sort($proveedoresOrdenados, SORT_STRING);
                $grupoKey = implode('|', $proveedoresOrdenados);

                if (!isset($grupos[$grupoKey])) {
                    $grupos[$grupoKey] = [
                        'proveedores_set' => $proveedoresOrdenados,
                        'proveedor_map' => [],
                        'ids' => [],
                        'materiales_por_proveedor' => [],
                        'subtotales' => [],
                        'ivas' => [],
                        'importes' => [],
                    ];
                }

            


                if (!empty($ids[$i]) && !in_array((string)$ids[$i], $grupos[$grupoKey]['ids'])) {
                    $grupos[$grupoKey]['ids'][] = (string)$ids[$i];
                }


                foreach ([1, 2, 3] as $q) {
                    $prov = ${"proveedor_q$q"}[$i] ?? null;
                    $subt = ${"subtotal_q$q"}[$i] ?? 0;
                    $iva = ${"iva_q$q"}[$i] ?? 0;
                    $imp = ${"importe_q$q"}[$i] ?? 0;
                    $cant = ${"cantidadrealq$q"}[$i] ?? '';
                    $prec = ${"preciounitarioq$q"}[$i] ?? '';

                    if (!empty($prov) && $cant > 0) {
                        $grupos[$grupoKey]['proveedor_map'][$prov] = true;
                        $grupos[$grupoKey]['subtotales'][$prov][] = $subt;
                        $grupos[$grupoKey]['ivas'][$prov][] = $iva;
                        $grupos[$grupoKey]['importes'][$prov][] = $imp;
                        $grupos[$grupoKey]['materiales_por_proveedor'][$prov][] = [
                            'DESCRIPCION'     => $descripciones[$i] ?? '',
                            'CANTIDAD_'       => $cant,
                            'PRECIO_UNITARIO' => $prec,
                            'UNIDAD_MEDIDA'   => $unidades[$i] ?? '', 

                        ];
                    }
                }
            }

            foreach ($grupos as $grupo) {
                $superaLimite = false;
                foreach ($grupo['subtotales'] as $subtotales) {
                    foreach ($subtotales as $subt) {
                        if ($subt > 10001) {
                            $superaLimite = true;
                            break 2;
                        }
                    }
                }

                if ($superaLimite) {
                    $registroExistente = DB::table('formulario_matrizcomparativa')
                        ->where('NO_MR', $no_mr)
                        ->get()
                        ->filter(function ($registro) use ($grupo) {
                            $existentes = array_filter([
                                $registro->PROVEEDOR1 ?? null,
                                $registro->PROVEEDOR2 ?? null,
                                $registro->PROVEEDOR3 ?? null,
                            ]);
                            sort($existentes, SORT_STRING);
                            return $existentes === $grupo['proveedores_set'];
                        })
                        ->values()
                        ->first();

                    if ($registroExistente) {
                        $hojasActuales = json_decode($registroExistente->HOJA_ID ?? '[]', true);
                        $hojasNuevas = array_values(array_unique(array_merge($hojasActuales, $grupo['ids'])));

                        $datosUpdate = [
                            'HOJA_ID'    => json_encode($hojasNuevas),
                            'updated_at' => now(),
                        ];

                        foreach ($grupo['proveedores_set'] as $idx => $prov) {
                            $num = $idx + 1;
                            $materialesNuevos = $grupo['materiales_por_proveedor'][$prov] ?? [];
                            $datosUpdate["MATERIALES_JSON_PROVEEDOR{$num}"] = json_encode($materialesNuevos, JSON_UNESCAPED_UNICODE);
                            $datosUpdate["SUBTOTAL_PROVEEDOR{$num}"] = array_sum($grupo['subtotales'][$prov] ?? []);
                            $datosUpdate["IVA_PROVEEDOR{$num}"] = array_sum($grupo['ivas'][$prov] ?? []);
                            $datosUpdate["IMPORTE_PROVEEDOR{$num}"] = array_sum($grupo['importes'][$prov] ?? []);
                        }

                        DB::table('formulario_matrizcomparativa')
                            ->where('ID_FORMULARIO_MATRIZ', $registroExistente->ID_FORMULARIO_MATRIZ)
                            ->update($datosUpdate);

                        HojaTrabajo::whereIn('id', $grupo['ids'])
                            ->update(['REQUIERE_MATRIZ' => 'Sí']);
                    } else {
                        HojaTrabajo::whereIn('id', $grupo['ids'])
                            ->update(['REQUIERE_MATRIZ' => 'Sí']);

                        $dataInsert = [
                            'HOJA_ID'    => json_encode(array_values($grupo['ids'])),
                            'NO_MR'      => $no_mr,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $proveedoresUnicos = array_values($grupo['proveedores_set']);
                        foreach ($proveedoresUnicos as $idx => $prov) {
                            $num = $idx + 1;
                            $dataInsert["PROVEEDOR{$num}"] = $prov;
                            $dataInsert["MATERIALES_JSON_PROVEEDOR{$num}"] = json_encode($grupo['materiales_por_proveedor'][$prov], JSON_UNESCAPED_UNICODE);
                            $dataInsert["SUBTOTAL_PROVEEDOR{$num}"] = array_sum($grupo['subtotales'][$prov] ?? []);
                            $dataInsert["IVA_PROVEEDOR{$num}"] = array_sum($grupo['ivas'][$prov] ?? []);
                            $dataInsert["IMPORTE_PROVEEDOR{$num}"] = array_sum($grupo['importes'][$prov] ?? []);
                        }

                        DB::table('formulario_matrizcomparativa')->insert($dataInsert);
                    }
                }
            }
            /********** FIN MATRIZ COMPARATIVA AGRUPADA Y ACTUALIZADA *************/
        }




        return response()->json(['success' => true]);
    }

    public function mostrarcotizacionq1($id)
    {
        $archivo = HojaTrabajo::findOrFail($id)->DOCUMENTO_Q1;
        return Storage::response($archivo);
    }

    public function mostrarcotizacionq2($id)
    {
        $archivo = HojaTrabajo::findOrFail($id)->DOCUMENTO_Q2;
        return Storage::response($archivo);
    }

    public function mostrarcotizacionq3($id)
    {
        $archivo = HojaTrabajo::findOrFail($id)->DOCUMENTO_Q3;
        return Storage::response($archivo);
    }

    public function obtenerPorMR($no_mr)
    {
        $hojas = HojaTrabajo::where('NO_MR', $no_mr)->get();

        foreach ($hojas as $hoja) {
            $hoja->ES_UNICO_PROVEEDOR = $hoja->MATERIALES_HOJA_JSON ? 'SI' : 'NO';
        }

        return response()->json([
            'success' => true,
            'data' => $hojas
        ]);
    }

    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_FORMULARIO_MR == 0) {
                        DB::statement('ALTER TABLE formulario_requisiconmaterial AUTO_INCREMENT=1;');

                        $year = date('y');
                        $lastMR = mrModel::where('NO_MR', 'like', "RES-MR$year-%")
                            ->orderBy('NO_MR', 'desc')
                            ->first();

                        $nextNumber = $lastMR ? intval(substr($lastMR->NO_MR, -3)) + 1 : 1;
                        $noMR = sprintf("RES-MR%s-%03d", $year, $nextNumber);

                        $materialesJson = is_string($request->MATERIALES_JSON)
                            ? $request->MATERIALES_JSON
                            : json_encode($request->MATERIALES_JSON, JSON_UNESCAPED_UNICODE);

                        $mrs = mrModel::create(array_merge(
                            $request->except(['MATERIALES_JSON']),
                            [
                                'NO_MR' => $noMR,
                                'USUARIO_ID' => auth()->user()->ID_USUARIO,
                                'MATERIALES_JSON' => $materialesJson
                            ]
                        ));

                        return response()->json([
                            'code' => 1,
                            'mr' => $mrs
                        ]);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            mrModel::where('ID_FORMULARIO_MR', $request->ID_FORMULARIO_MR)
                                ->update(['ACTIVO' => $estado]);

                            return response()->json([
                                'code' => 1,
                                'mr' => $estado == 0 ? 'Desactivada' : 'Activada'
                            ]);
                        } else {
                            $mrs = mrModel::find($request->ID_FORMULARIO_MR);
                            if ($mrs) {
                                $datos = $request->except(['USUARIO_ID']);

                                if (isset($datos['MATERIALES_JSON'])) {
                                    $datos['MATERIALES_JSON'] = is_string($datos['MATERIALES_JSON'])
                                        ? $datos['MATERIALES_JSON']
                                        : json_encode($datos['MATERIALES_JSON'], JSON_UNESCAPED_UNICODE);
                                }

                                $mrs->update($datos);

                                return response()->json([
                                    'code' => 1,
                                    'mr' => 'Actualizada'
                                ]);
                            }

                            return response()->json([
                                'code' => 0,
                                'msj' => 'MR no encontrada'
                            ], 404);
                        }
                    }
                    break;

                default:
                    return response()->json([
                        'code' => 1,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {
            Log::error("Error al guardar MR: " . $e->getMessage());
            return response()->json([
                'code' => 0,
                'error' => 'Error al guardar la MR'
            ], 500);
        }
    }

}
