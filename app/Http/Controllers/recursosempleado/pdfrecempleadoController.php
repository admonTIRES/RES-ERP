<?php

namespace App\Http\Controllers\recursosempleado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\recempleados\recemplaedosModel;


use Barryvdh\DomPDF\Facade\Pdf;

use Carbon\Carbon;
use DB;


class pdfrecempleadoController extends Controller
{
  

    public function generarPermisoausencia($id)
    {
        $registro = recemplaedosModel::findOrFail($id);

        // Catálogo de conceptos
        $conceptos = [
            1 => 'Permiso',
            2 => 'Incapacidad',
            3 => 'Omitir registro en el checador',
            4 => 'Fallecimiento¹',
            5 => 'Matrimonio²',
            6 => 'Permiso de maternidad³',
            7 => 'Permiso de paternidad³',
            8 => 'Compensatorio',
            9 => 'Otros (explique)',
        ];

       

        $solicito = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $registro->USUARIO_ID)
            ->first();



        $jefe = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $registro->JEFE_ID)
            ->first();

        $autorizo = DB::table('usuarios')
            ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
            ->where('ID_USUARIO', $registro->AUTORIZO_ID)
            ->first();


        $nombre_solicito = $solicito
            ? trim("{$solicito->EMPLEADO_NOMBRE} {$solicito->EMPLEADO_APELLIDOPATERNO} {$solicito->EMPLEADO_APELLIDOMATERNO}")
            : '';


        $nombre_jefe = $jefe
        ? trim("{$jefe->EMPLEADO_NOMBRE} {$jefe->EMPLEADO_APELLIDOPATERNO} {$jefe->EMPLEADO_APELLIDOMATERNO}")
        : '';

        $nombre_autorizo = $autorizo
            ? trim("{$autorizo->EMPLEADO_NOMBRE} {$autorizo->EMPLEADO_APELLIDOPATERNO} {$autorizo->EMPLEADO_APELLIDOMATERNO}")
            : '';

            

        $data = [
            'fecha' => $registro->FECHA_SALIDA,
            'nombre_empleado' => $registro->SOLICITANTE_SALIDA,
            'cargo' => $registro->CARGO_PERMISO,
            'no_empleado' => $registro->NOEMPLEADO_PERMISO,
            'observaciones' => $registro->OBSERVACIONES_REC,
            'conceptos' => $conceptos,
            'conceptoSeleccionado' => $registro->CONCEPTO_PERMISO,
            'no_dias' => $registro->NODIAS_PERMISO,
            'no_horas' => $registro->NOHORAS_PERMISO,
            'fecha_inicial' => $registro->FECHA_INICIAL_PERMISO,
            'fecha_final' => $registro->FECHA_FINAL_PERMISO,
            'explique' => $registro->EXPLIQUE_PERMISO,
            'goce_permiso' => $registro->GOCE_PERMISO,
            'nombre_jefe' => $nombre_jefe,
            'nombre_autorizo' => $nombre_autorizo,
            'nombre_solicito' => $nombre_solicito,

        ];

        return Pdf::loadView('pdf.permisopdf', $data)
            ->download('PS-RH-FO-22 Aviso de ausencia y-o permiso.pdf');
    }




    public function generarVacaciones($id)
    {
        try {
            App::setLocale('es'); 
            Carbon::setLocale('es'); 

            $empleado = recemplaedosModel::findOrFail($id);

            $fecha_ingreso = $empleado->FECHA_INGRESO_VACACIONES
                ? Carbon::parse($empleado->FECHA_INGRESO_VACACIONES)->format('Y/m/d')
                : '';

          
            $solicito = DB::table('usuarios')
                ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
                ->where('ID_USUARIO', $empleado->USUARIO_ID)
                ->first();



            $jefe = DB::table('usuarios')
                ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
                ->where('ID_USUARIO', $empleado->JEFE_ID)
                ->first();

            $autorizo = DB::table('usuarios')
                ->select('EMPLEADO_NOMBRE', 'EMPLEADO_APELLIDOPATERNO', 'EMPLEADO_APELLIDOMATERNO')
                ->where('ID_USUARIO', $empleado->AUTORIZO_ID)
                ->first();


            $nombre_solicito = $solicito
                ? trim("{$solicito->EMPLEADO_NOMBRE} {$solicito->EMPLEADO_APELLIDOPATERNO} {$solicito->EMPLEADO_APELLIDOMATERNO}")
                : '';


            $nombre_jefe = $jefe
                ? trim("{$jefe->EMPLEADO_NOMBRE} {$jefe->EMPLEADO_APELLIDOPATERNO} {$jefe->EMPLEADO_APELLIDOMATERNO}")
                : '';

            $nombre_autorizo = $autorizo
                ? trim("{$autorizo->EMPLEADO_NOMBRE} {$autorizo->EMPLEADO_APELLIDOPATERNO} {$autorizo->EMPLEADO_APELLIDOMATERNO}")
                : '';



            $fecha_inicio = Carbon::parse($empleado->FECHA_INICIO_VACACIONES);
            $fecha_termino = Carbon::parse($empleado->FECHA_TERMINACION_VACACIONES);
            $fecha_labores = Carbon::parse($empleado->FECHA_INICIALABORES_VACACIONES);

            $dia_presentacion = ucfirst($fecha_labores->translatedFormat('l'));
            $fecha_presentacion = $dia_presentacion . ', ' . $fecha_labores->format('Y/m/d');

            $fecha_salida = Carbon::parse($empleado->FECHA_SALIDA);
            $dia_salida = $fecha_salida->format('d');
            $mes_salida = ucfirst($fecha_salida->translatedFormat('F'));
            $anio_salida = $fecha_salida->format('Y');

            $pdf = Pdf::loadView('pdf.vacacionespdf', [
                'empleado' => $empleado,
                'fecha_ingreso' => $fecha_ingreso,
                'fecha_inicio' => $fecha_inicio,
                'fecha_termino' => $fecha_termino,
                'fecha_presentacion' => $fecha_presentacion,
                'dia_salida' => $dia_salida,
                'mes_salida' => $mes_salida,
                'anio_salida' => $anio_salida,
                'nombre_jefe' => $nombre_jefe,
                'nombre_autorizo' => $nombre_autorizo,
                'nombre_solicito' => $nombre_solicito,
            ])->setPaper('letter', 'landscape');

            return $pdf->download('PS-RH-FO-23 Solicitud de Vacaciones.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }



}

