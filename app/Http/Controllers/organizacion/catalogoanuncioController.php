<?php

namespace App\Http\Controllers\organizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\organizacion\catalgoanuncioModel;
use App\Models\empresainformacion\empresainformacionModel;


use DB;



class catalogoanuncioController extends Controller
{

    public function index()
    {
        $now = now(); 
        $hoy = $now->toDateString();        
        $horaActual = $now->format('H:i:s'); 
        $dia = $now->day;
        $mes = $now->month;

        $anunciosDia = catalgoanuncioModel::where('ACTIVO', 1)
            ->where('TIPO_REPETICION', 'normal')
            ->whereDate('FECHA_INICIO', '<=', $hoy)
            ->whereDate('FECHA_FIN', '>=', $hoy)
            ->whereTime('HORA_INICIO', '<=', $horaActual)
            ->whereTime('HORA_FIN', '>=', $horaActual)
            ->get();

        $diaMes = now()->format('d-m'); 

        $anunciosAnio = catalgoanuncioModel::where('ACTIVO', 1)
            ->where('TIPO_REPETICION', 'anual')
            ->where('FECHA_ANUAL', $diaMes)
            ->whereTime('HORA_ANUAL_INICIO', '<=', $horaActual)
            ->whereTime('HORA_ANUAL_FIN', '>=', $horaActual)
            ->get();


        $anunciosMes = catalgoanuncioModel::where('ACTIVO', 1)
            ->where('TIPO_REPETICION', 'mensual')
            ->whereRaw("LPAD(MES_MENSUAL, 2, '0') = ?", [str_pad($mes, 2, '0', STR_PAD_LEFT)])
            ->where(function ($q) use ($horaActual) {
                $q->where(function ($q2) use ($horaActual) {
                    $q2->whereTime('HORA_INICIO', '<=', $horaActual)
                        ->whereTime('HORA_FIN', '>=', $horaActual);
                })
                    ->orWhereNull('HORA_INICIO')
                    ->orWhereNull('HORA_FIN');
            })
            ->get();




        $anunciosDiaAnio = $anunciosDia->merge($anunciosAnio);

        return view('principal.modulos', compact('anunciosDiaAnio', 'anunciosMes'));
    }



    public function obtenerInfoEmpresa()
    {
        $empresa = empresainformacionModel::first();

        if (!$empresa) {
            return response()->json(['error' => 'Empresa no encontrada'], 404);
        }

        return response()->json([
            'datos_generales' => [
                'RFC_EMPRESA'      => $empresa->RFC_EMPRESA,
                'RAZON_SOCIAL'     => $empresa->RAZON_SOCIAL,
                'NOMBRE_COMERCIAL' => $empresa->NOMBRE_COMERCIAL,
                'REGIMEN_CAPITAL'  => $empresa->REGIMEN_CAPITAL,
            ],

            'contactos' => json_decode($empresa->CONTACTOS_JSON, true) ?? [],

            'domicilios' => json_decode($empresa->DIRECCIONES_JSON, true) ?? [],

            'cuenta_sucursales' => $empresa->CUENTA_SUCURSALES,
            'sucursales' => json_decode($empresa->SUCURSALES_JSON, true) ?? []
        ]);
    }

    public function Tablanuncios()
    {
        try {
            $tabla = catalgoanuncioModel::get();

            foreach ($tabla as $value) {
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_ANUNCIOS . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_CATALOGO_ANUNCIOS . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
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



    public function mostrarfotoanuncio($anuncio_id)
    {
        $foto = catalgoanuncioModel::findOrFail($anuncio_id);
        return Storage::response($foto->FOTO_ANUNCIO);
    }






    public function getTipoCambio()
    {
        try {
            $url = "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno";
            $token = "27a9240ee1408c3c53ee5c1d6cde123db668f8ca5e5472a1cef9b63300feb4e1"; 

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Bmx-Token' => $token,
                    'Accept'    => 'application/json'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['bmx']['series'][0]['datos'][0])) {
                return response()->json([
                    'error' => true,
                    'mensaje' => 'No se encontraron datos en la respuesta de Banxico'
                ], 500);
            }

            $serie = $data['bmx']['series'][0]['datos'][0];

            return response()->json([
                'fecha' => $serie['fecha'],
                'dato'  => $serie['dato']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    if ($request->ID_CATALOGO_ANUNCIOS == 0) {
                        DB::statement('ALTER TABLE catalogo_anuncios AUTO_INCREMENT=1;');

                        $datos = $request->except('FOTO_ANUNCIO');
                        $anuncios = catalgoanuncioModel::create($datos);

                        if ($request->hasFile('FOTO_ANUNCIO')) {
                            $file = $request->file('FOTO_ANUNCIO');
                            $folder = "anuncios/{$anuncios->ID_CATALOGO_ANUNCIOS}";
                            $filename = 'foto_anuncio.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs($folder, $filename); 

                            $anuncios->FOTO_ANUNCIO = $path; 
                            $anuncios->save();
                        }

                        $response['code']  = 1;
                        $response['anuncio']  = $anuncios;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            $estado = $request->ELIMINAR == 1 ? 0 : 1;
                            $accion = $estado == 1 ? 'Activada' : 'Desactivada';

                            catalgoanuncioModel::where('ID_CATALOGO_ANUNCIOS', $request->ID_CATALOGO_ANUNCIOS)
                                ->update(['ACTIVO' => $estado]);

                            $response['code'] = 1;
                            $response['anuncio'] = $accion;
                            return response()->json($response);
                        } else {
                            $anuncios = catalgoanuncioModel::find($request->ID_CATALOGO_ANUNCIOS);

                            if (!$anuncios) {
                                return response()->json(['code' => 0, 'msj' => 'Anuncio no encontrado']);
                            }

                            if ($request->hasFile('FOTO_ANUNCIO')) {
                                if ($anuncios->FOTO_ANUNCIO && Storage::exists($anuncios->FOTO_ANUNCIO)) {
                                    Storage::delete($anuncios->FOTO_ANUNCIO);
                                }

                                $file = $request->file('FOTO_ANUNCIO');
                                $folder = "anuncios/{$anuncios->ID_CATALOGO_ANUNCIOS}";
                                $filename = 'foto_anuncio.' . $file->getClientOriginalExtension();
                                $path = $file->storeAs($folder, $filename); 

                                $anuncios->FOTO_ANUNCIO = $path;
                            }

                            $anuncios->fill($request->except('FOTO_ANUNCIO'))->save();

                            $response['code'] = 1;
                            $response['anuncio'] = 'Actualizada';
                            return response()->json($response);
                        }
                    }

                default:
                    return response()->json([
                        'code' => 1,
                        'msj' => 'Api no encontrada'
                    ]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al guardar el anuncio']);
        }
    }

}