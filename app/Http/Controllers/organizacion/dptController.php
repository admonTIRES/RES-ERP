<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use App\Models\organizacion\formulariodptModel;
use App\Models\organizacion\relacionesinternasModel;
use App\Models\organizacion\relacionesexternasModel;
use App\Models\organizacion\catalogojerarquiaModel;
use App\Models\organizacion\catalogorelacionesexternaModel;
use App\Models\organizacion\catalogofuncionescargoModel;
use App\Models\organizacion\catalogofuncionesgestionModel;
use App\Models\organizacion\catalogocompetenciabasicaModel;
use App\Models\organizacion\catalogoCompotenciasGerencialesModel;




use DB;

class dptController extends Controller
{
            public function index()
        {
            $areas = DB::select("
                SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, LUGAR_CATEGORIA AS LUGAR, PROPOSITO_CATEGORIA AS PROPOSITO, ES_LIDER_CATEGORIA AS LIDER
                FROM catalogo_categorias
                WHERE ACTIVO = 1
            ");


            $areas1 = DB::select("
                    SELECT c.ID_CATALOGO_CATEGORIA AS ID, 
                        c.NOMBRE_CATEGORIA AS NOMBRE, 
                        c.LUGAR_CATEGORIA AS LUGAR, 
                        c.PROPOSITO_CATEGORIA AS PROPOSITO, 
                        c.ES_LIDER_CATEGORIA AS LIDER
                    FROM catalogo_categorias c
                    INNER JOIN formulario_ppt f ON c.ID_CATALOGO_CATEGORIA = f.DEPARTAMENTO_AREA_ID
                    WHERE c.ACTIVO = 1
                ");



            $categorias = DB::select("
            SELECT ID_CATALOGO_CATEGORIA  AS ID, NOMBRE_CATEGORIA AS NOMBRE, ES_LIDER_CATEGORIA AS LIDER
                FROM catalogo_categorias
                WHERE ACTIVO = 1
            ");


            $nivel = catalogojerarquiaModel::orderBy('NOMBRE_JERARQUIA', 'ASC')->get();
            $externo = catalogorelacionesexternaModel::orderBy('NOMBRE_RELACIONEXTERNA', 'ASC')->get();
            $cargo = catalogofuncionescargoModel::orderBy('DESCRIPCION_FUNCION_CARGO', 'ASC')->get();
            $gestion = catalogofuncionesgestionModel::orderBy('DESCRIPCION_FUNCION_GESTION', 'ASC')->get();
            $basicos = catalogocompetenciabasicaModel::orderBy('NOMBRE_COMPETENCIA_BASICA', 'ASC')->get();
            
            $gerenciales = catalogoCompotenciasGerencialesModel::orderBy('NOMBRE_COMPETENCIA_GERENCIAL', 'ASC')->get();


            return view('RH.organizacion.DPT', compact('areas','nivel','externo','cargo','gestion','categorias','basicos', 'gerenciales','areas1'));
        }
  

    
    public function TablaDPT()
    {
        try {

        
            $tabla = DB::select('SELECT dpt.*, cat.NOMBRE_CATEGORIA
                                                FROM formulario_dpt dpt
                                                LEFT JOIN catalogo_categorias cat ON cat.ID_CATALOGO_CATEGORIA = dpt.DEPARTAMENTOS_AREAS_ID');
            foreach ($tabla as $value) {
                $value->INTERNAS = relacionesinternasModel::where('FORMULARIO_DPT_ID', $value->ID_FORMULARIO_DPT)->get();
                $value->EXTERNAS = relacionesexternasModel::where('FORMULARIO_DPT_ID', $value->ID_FORMULARIO_DPT)->get();
    
                $value->ELABORADO_POR = $value->ELABORADO_NOMBRE_DPT . '<br>' . $value->ELABORADO_FECHA_DPT;
                $value->REVISADO_POR = is_null($value->REVISADO_NOMBRE_DPT) ? '<span class="badge text-bg-warning">Sin revisar</span>' : $value->REVISADO_NOMBRE_DPT . '<br>' . $value->REVISADO_FECHA_DPT;
                $value->AUTORIZADO_POR = is_null($value->AUTORIZADO_NOMBRE_DPT) ? '<span class="badge text-bg-danger">Sin autorizar</span>' : $value->AUTORIZADO_NOMBRE_DPT . '<br>' . $value->AUTORIZADO_FECHA_DPT;
    
                if ($value->ACTIVO == 0) {
                $value->BTN_DPT = '<button type="button" class="btn btn-success btn-custom rounded-pill DPT"disabled><i class="bi bi-ban"></i></button>';   
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DPT . '"><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';


            } else {

                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_DPT . '" checked><span class="slider round"></span></label>';
                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DPT = '<button type="button" class="btn btn-success btn-custom rounded-pill DPT"><i class="bi bi-file-earmark-excel-fill"></i></button>';
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
    


public function infoReportan($ID, $LIDER)
{
    try {

        $funciones = DB::select("SELECT ID_CATALOGO_FUNCIONESCARGO ID, DESCRIPCION_FUNCION_CARGO DESCRIPCION, TIPO_FUNCION_CARGO TIPO
        FROM catalogo_funcionescargos
        WHERE CATEGORIAS_CARGO = ? OR TIPO_FUNCION_CARGO = 'Genérica'
        ORDER BY TIPO_FUNCION_CARGO", [$ID]);


        if ($LIDER == 1) {

            $info = DB::select("SELECT GROUP_CONCAT(catCategoria.NOMBRE_CATEGORIA SEPARATOR ', ') AS REPORTAN, COUNT(relacion.CATEGORIA_ID) AS TOTAL
                                FROM lideres_categorias relacion
                                LEFT JOIN catalogo_categorias catLideres ON catLideres.ID_CATALOGO_CATEGORIA = relacion.LIDER_ID
                                LEFT JOIN catalogo_categorias catCategoria ON catCategoria.ID_CATALOGO_CATEGORIA = relacion.CATEGORIA_ID
                                WHERE relacion.LIDER_ID = ?", [$ID]);

        
            $response['code'] = 1;
            $response['REPORTAN'] = $info;
            $response['REPORTA'] = 'Director';
            $response['FUNCIONES'] = $funciones;

            return response()->json($response);
        } else if  ($LIDER == 0){

            $info = DB::select("SELECT IFNULL(catLideres.NOMBRE_CATEGORIA, 'Director') AS REPORTA, 0 AS TOTAL
                                FROM lideres_categorias relacion
                                LEFT JOIN catalogo_categorias catLideres ON catLideres.ID_CATALOGO_CATEGORIA = relacion.LIDER_ID
                                LEFT JOIN catalogo_categorias catCategoria ON catCategoria.ID_CATALOGO_CATEGORIA = relacion.CATEGORIA_ID
                                WHERE relacion.CATEGORIA_ID = ?", [$ID]);
            
            $response['code'] = 1;
            $response['REPORTAN'] = 'Ninguno';
            $response['REPORTA'] = $info;
            $response['FUNCIONES'] = $funciones;

            return response()->json($response);

        } else {


            $info = DB::select("SELECT GROUP_CONCAT(NOMBRE_CARGO SEPARATOR ', ') AS REPORTAN FROM encargados_areas");

            $response['code'] = 1;
            $response['REPORTAN'] = $info;
            $response['REPORTA'] = 'Ninguno';
            $response['FUNCIONES'] = $funciones;

            return response()->json($response);

        }

    } catch (Exception $e) {

        return response()->json([
            'msj' => 'Error ' . $e->getMessage(),
            'data' => 0,
            'code' => 0
        ]);
    }
}



public function consultarfuncionescargo($areaId)
{
    try {
        $funciones = DB::select("
            SELECT 
                ID_CATALOGO_FUNCIONESCARGO AS ID,
                DESCRIPCION_FUNCION_CARGO AS DESCRIPCION,
                TIPO_FUNCION_CARGO AS TIPO
            FROM 
                catalogo_funcionescargos
            WHERE 
                CATEGORIAS_CARGO = ? 
                OR TIPO_FUNCION_CARGO = 'Genérica'
            ORDER BY 
                TIPO_FUNCION_CARGO", [$areaId]);

        return response()->json([
            'code' => 1,
            'FUNCIONES' => $funciones
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'code' => 0,
            'msj' => 'Error: ' . $e->getMessage()
        ]);
    }
}

    
public function store(Request $request)
{
    try {
        switch (intval($request->api)) {
            case 1:
                if (isset($request->ELIMINAR)) {
                    if ($request->ELIMINAR == 1) {
                        $dpt = formulariodptModel::where('ID_FORMULARIO_DPT', $request['ID_FORMULARIO_DPT'])->update(['ACTIVO' => 0]);
                        $response['code'] = 1;
                        $response['DPT'] = 'Desactivado';
                    } else {
                        $dpt = formulariodptModel::where('ID_FORMULARIO_DPT', $request['ID_FORMULARIO_DPT'])->update(['ACTIVO' => 1]);
                        $response['code'] = 1;
                        $response['DPT'] = 'Activado';
                    }
                    return response()->json($response);
                } 

                if ($request->ID_FORMULARIO_DPT == 0) {
                    $funciones_cargo = $request->FUNCIONES_CARGO_DPT ? $request->FUNCIONES_CARGO_DPT : [];
                    $funciones_gestion = $request->FUNCIONES_GESTION_DPT ? $request->FUNCIONES_GESTION_DPT : [];
                    $puestos_interactuan = $request->PUESTOS_INTERACTUAN_DPT ? $request->PUESTOS_INTERACTUAN_DPT : [];

                    DB::statement('ALTER TABLE formulario_dpt AUTO_INCREMENT=1;');
                    $DPT = formulariodptModel::create(array_merge($request->all(), [
                        'FUNCIONES_CARGO_DPT' => $funciones_cargo,
                        'FUNCIONES_GESTION_DPT' => $funciones_gestion,
                        'PUESTOS_INTERACTUAN_DPT' => $puestos_interactuan,
                    ]));

                   

                    if ($request->INTERNAS_CONQUIEN_DPT) {
                        foreach ($request->INTERNAS_CONQUIEN_DPT as $key => $value) {
                            if (isset($request->INTERNAS_PARAQUE_DPT[$key]) || isset($request->INTERNAS_FRECUENCIA_DPT[$key])) {
                                relacionesinternasModel::create([
                                    'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                    'INTERNAS_CONQUIEN_DPT' => $value,
                                    'INTERNAS_PARAQUE_DPT' => $request->INTERNAS_PARAQUE_DPT[$key] ?? null,
                                    'INTERNAS_FRECUENCIA_DPT' => $request->INTERNAS_FRECUENCIA_DPT[$key] ?? null,
                                ]);
                            }
                        }
                    }
                    

                
                    if ($request->EXTERNAS_CONQUIEN_DPT) {
                        foreach ($request->EXTERNAS_CONQUIEN_DPT as $key => $value) {
                            if (isset($request->EXTERNAS_PARAQUE_DPT[$key]) || isset($request->EXTERNAS_FRECUENCIA_DPT[$key])) {
                                relacionesexternasModel::create([
                                    'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                    'EXTERNAS_CONQUIEN_DPT' => $value,
                                    'EXTERNAS_PARAQUE_DPT' => $request->EXTERNAS_PARAQUE_DPT[$key] ?? null,
                                    'EXTERNAS_FRECUENCIA_DPT' => $request->EXTERNAS_FRECUENCIA_DPT[$key] ?? null
                                ]);
                            }
                        }
                    }

                    
                    $response['code'] = 1;
                    $response['DPT'] = $DPT;
                    return response()->json($response);

                } else {
                    $DPT = formulariodptModel::find($request->ID_FORMULARIO_DPT);

                    $funciones_cargo = $request->FUNCIONES_CARGO_DPT ? $request->FUNCIONES_CARGO_DPT : [];
                    $funciones_gestion = $request->FUNCIONES_GESTION_DPT ? $request->FUNCIONES_GESTION_DPT : [];
                    $puestos_interactuan = $request->PUESTOS_INTERACTUAN_DPT ? $request->PUESTOS_INTERACTUAN_DPT : [];

                    $DPT->update(array_merge($request->all(), [
                        'FUNCIONES_CARGO_DPT' => $funciones_cargo,
                        'FUNCIONES_GESTION_DPT' => $funciones_gestion,
                        'PUESTOS_INTERACTUAN_DPT' => $puestos_interactuan,
                    ]));

                    relacionesinternasModel::where('FORMULARIO_DPT_ID', $request->ID_FORMULARIO_DPT)->delete();

                 
                    if ($request->INTERNAS_CONQUIEN_DPT) {
                        foreach ($request->INTERNAS_CONQUIEN_DPT as $key => $value) {
                            if (isset($request->INTERNAS_PARAQUE_DPT[$key]) || isset($request->INTERNAS_FRECUENCIA_DPT[$key])) {
                                relacionesinternasModel::create([
                                    'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                    'INTERNAS_CONQUIEN_DPT' => $value,
                                    'INTERNAS_PARAQUE_DPT' => $request->INTERNAS_PARAQUE_DPT[$key] ?? null,
                                    'INTERNAS_FRECUENCIA_DPT' => $request->INTERNAS_FRECUENCIA_DPT[$key] ?? null,
                                ]);
                            }
                        }
                    }

                    
                    relacionesexternasModel::where('FORMULARIO_DPT_ID', $request->ID_FORMULARIO_DPT)->delete();

                
                    if ($request->EXTERNAS_CONQUIEN_DPT) {
                        foreach ($request->EXTERNAS_CONQUIEN_DPT as $key => $value) {
                            if (isset($request->EXTERNAS_PARAQUE_DPT[$key]) || isset($request->EXTERNAS_FRECUENCIA_DPT[$key])) {
                                relacionesexternasModel::create([
                                    'FORMULARIO_DPT_ID' => $DPT->ID_FORMULARIO_DPT,
                                    'EXTERNAS_CONQUIEN_DPT' => $value,
                                    'EXTERNAS_PARAQUE_DPT' => $request->EXTERNAS_PARAQUE_DPT[$key] ?? null,
                                    'EXTERNAS_FRECUENCIA_DPT' => $request->EXTERNAS_FRECUENCIA_DPT[$key] ?? null
                                ]);
                            }
                        }
                    }

                    $response['code'] = 1;
                    $response['DPT'] = $DPT;
                    return response()->json($response);
                }
            
            default:
                $response['code'] = 2;
                return response()->json($response);
        }
    } catch (Exception $e) {
        return response()->json(['code' => 0, 'message' => 'Error al guardar el Área', 'error' => $e->getMessage()]);
    }
}



}