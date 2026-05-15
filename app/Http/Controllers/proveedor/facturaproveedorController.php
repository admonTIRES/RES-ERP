<?php

namespace App\Http\Controllers\proveedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use DB;


use App\Models\proveedor\altacontactos;
use App\Models\proveedor\catalogofuncionesproveedorModel;
use App\Models\proveedor\catalogotituloproveedorModel;
use App\Models\proveedor\catalogodocumentoproveedorModel;
use App\Models\proveedor\catalogoverificacionproveedorModel;


use App\Models\proveedor\altacertificacionModel;
use App\Models\proveedor\altaproveedorModel;
use App\Models\proveedor\altareferenciasModel;
use App\Models\proveedor\altadocumentosModel;
use App\Models\proveedor\asignacionproveedorModel;
use App\Models\proveedor\contratoproveedorModel;
use App\Models\proveedor\facturacionModel;





class facturaproveedorController extends Controller
{


    public function validarPuedeSubirFactura()
    {
        $rfc = Auth::user()->RFC_PROVEEDOR;

        $existeBloqueo = DB::table('formulario_facturasproveedores')
            ->where('RFC_PROVEEDOR', $rfc)
            ->whereRaw('UPPER(TRIM(METODO_PAGO)) = "PPD"')
            ->where(function ($query) {
                $query->whereNull('ESTATUS_FACTURA') 
                    ->orWhere('ESTATUS_FACTURA', '!=', 2);
            })
            ->where(function ($query) {
                $query->whereNull('SUBIR_REP')
                    ->orWhere('SUBIR_REP', 0)
                    ->orWhereNull('ESTATUS_REP')
                    ->orWhere('ESTATUS_REP', '!=', 1);
            })
            ->exists();

        if ($existeBloqueo) {
            return response()->json([
                'puede' => false,
                'mensaje' => 'Tiene pendiente de cargar un REP o está en proceso de verificación.'
            ]);
        }

        return response()->json([
            'puede' => true
        ]);
    }

    public function validarContratoNumero(Request $request)
    {
        $request->validate([
            'numero_contrato' => 'required|string'
        ]);

        $userRFC = Auth::user()->RFC_PROVEEDOR;
        $numeroContrato = $request->numero_contrato;

        $contrato = contratoproveedorModel::where('RFC_PROVEEDOR', $userRFC)
            ->where('NUMERO_CONTRATO_PROVEEDOR', $numeroContrato)
            ->first();

        if (!$contrato) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'El número de contrato es incorrecto.'
            ]);
        }

        $hoy = Carbon::today();

        $fechaInicio = Carbon::parse($contrato->FECHAI_CONTRATO_PROVEEDOR);
        $fechaFin    = Carbon::parse($contrato->FECHAF_CONTRATO_PROVEEDOR);

        if ($hoy->lt($fechaInicio)) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'El contrato aún no inicia su vigencia.'
            ]);
        }

        if ($hoy->gt($fechaFin)) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'El contrato está vencido.'
            ]);
        }

        return response()->json([
            'valido' => true,
            'mensaje' => 'Contrato validado',
            'contrato' => $contrato
        ]);
    }



    public function validarContratoVigente()
    {
        $userRFC = Auth::user()->RFC_PROVEEDOR;

        $contrato = contratoproveedorModel::where('RFC_PROVEEDOR', $userRFC)
            ->orderBy('ID_CONTRATO_PROVEEDORES', 'desc')
            ->first();

        if (!$contrato) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'No cuenta con contrato registrado.'
            ]);
        }

        $hoy = Carbon::today();

        $fechaInicio = Carbon::parse($contrato->FECHAI_CONTRATO_PROVEEDOR);
        $fechaFin    = Carbon::parse($contrato->FECHAF_CONTRATO_PROVEEDOR);

        if ($hoy->lt($fechaInicio)) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'El contrato aún no inicia su vigencia.'
            ]);
        }

        if ($hoy->gt($fechaFin)) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'No tiene contrato vigente.'
            ]);
        }

        return response()->json([
            'valido' => true,
            'mensaje' => 'Contrato vigente',
            'contrato' => $contrato
        ]);
    }



    public function obtenerContratosProveedor()
    {
        $userRFC = Auth::user()->RFC_PROVEEDOR;

        $hoy = Carbon::today();

        $contratos = contratoproveedorModel::where('RFC_PROVEEDOR', $userRFC)
            ->whereDate('FECHAI_CONTRATO_PROVEEDOR', '<=', $hoy)
            ->whereDate('FECHAF_CONTRATO_PROVEEDOR', '>=', $hoy)
            ->orderBy('ID_CONTRATO_PROVEEDORES', 'desc')
            ->get();

        return response()->json($contratos);
    }


    

    public function validarPOGR(Request $request)
    {
        $request->validate([
            'po' => 'required',
            'gr' => 'required'
        ]);

        $userRFC = Auth::user()->RFC_PROVEEDOR;

        $existe = DB::table('formulario_bitacoragr')
            ->where('PROVEEDOR_KEY', $userRFC)
            ->where('NO_PO', $request->po)
            ->where('NO_RECEPCION', $request->gr)
            ->exists();

        if (!$existe) {
            return response()->json([
                'valido' => false,
                'mensaje' => 'Verifique que estén correcto el No de (PO) y (GR)'
                
            ]);
        }

        return response()->json([
            'valido' => true,
            'mensaje' => 'PO y GR válidos'
        ]);
    }


    public function obtenerTipoProveedor()
    {
        $rfc = Auth::user()->RFC_PROVEEDOR;

        $proveedor = DB::table('formulario_altaproveedor')
            ->where('RFC_ALTA', $rfc)
            ->orderBy('ID_FORMULARIO_ALTA', 'desc')
            ->first();

        return response()->json([
            'tipo' => $proveedor ? $proveedor->TIPO_PERSONA_ALTA : null
        ]);
    }

    public function Tablafacturaproveedores()
    {
        try {
            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = facturacionModel::where('RFC_PROVEEDOR', $userRFC)->get();

            foreach ($tabla as $value) {
                
                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_SOPORTES = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportes" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_SOPORTES = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportes" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';


                    $value->BTN_COMPROBANTE = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-comprobante" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';


                }

                if ($value->TIPO_FACTURA == 'CONTRATO') {
                    $value->TIPO_FACTURA_FORMATO = 'Contrato (No. ' . $value->NO_CONTRATO . ')';
                } elseif ($value->TIPO_FACTURA == 'OC') {
                    $value->TIPO_FACTURA_FORMATO = 'Orden de Compra y Recepción (PO: '. $value->NO_PO . ' | GR: ' . $value->NO_GR . ')';
                } else {
                    $value->TIPO_FACTURA_FORMATO = $value->TIPO_FACTURA;
                }

                if ($value->ESTATUS_FACTURA == 1) {
                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-success">Aprobada</span>';
                } elseif ($value->ESTATUS_FACTURA == 2) {
                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-danger">Rechazada</span>';
                } else {
                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-secondary">En revisión</span>';
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


    public function mostrarsoportefactura($id)
    {
        $archivo = facturacionModel::findOrFail($id)->DOCUMENTOS_SOPORTE_FACTURA;
        return Storage::response($archivo);
    }


    public function mostrarfactura($id)
    {
        $archivo = facturacionModel::findOrFail($id)->FACTURA_PDF;
        return Storage::response($archivo);
    }



    public function mostrareciboelectronico($id)
    {
        $archivo = facturacionModel::findOrFail($id)->ARCHIVO_REP;
        return Storage::response($archivo);
    }



    /////// RECIBO ELECTRIONICO DE PAGO 


    public function Tablacargarrecp()
    {
        try {
            $userRFC = Auth::user()->RFC_PROVEEDOR;

            $tabla = facturacionModel::where('RFC_PROVEEDOR', $userRFC)
                ->where('ESTATUS_FACTURA', 1)
                ->whereRaw("UPPER(TRIM(METODO_PAGO)) = 'PPD'")
                ->where(function ($query) {
                    $query->whereNull('SUBIR_REP')
                        ->orWhere('SUBIR_REP', 0);
                })
                ->where('SUBIR_RECIBO_PAGO', 1) 
                ->get();

                
            foreach ($tabla as $value) {

                if ($value->ACTIVO == 0) {
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                    $value->BTN_SOPORTES = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportes" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill CARGARREP"><i class="bi bi-arrow-bar-up"></i></button>';
                    $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                    $value->BTN_SOPORTES = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-soportes" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                    $value->BTN_FACTURA = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-factura" data-id="' . $value->ID_FORMULARIO_FACTURACION . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                }

                if ($value->TIPO_FACTURA == 'CONTRATO') {
                    $value->TIPO_FACTURA_FORMATO = 'Contrato (No. ' . $value->NO_CONTRATO . ')';
                } elseif ($value->TIPO_FACTURA == 'OC') {
                    $value->TIPO_FACTURA_FORMATO = 'Orden de Compra y Recepción (PO: ' . $value->NO_PO . ' | GR: ' . $value->NO_GR . ')';
                } else {
                    $value->TIPO_FACTURA_FORMATO = $value->TIPO_FACTURA;
                }

                if ($value->ESTATUS_FACTURA == 1) {
                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-success">Aprobada</span>';
                } elseif ($value->ESTATUS_FACTURA == 2) {
                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-danger">Rechazada</span>';
                } else {
                    $value->ESTADO_FACTURA_TEXTO = '<span class="badge bg-secondary">En revisión</span>';
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


    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                    
                    $rfc = Auth::user()->RFC_PROVEEDOR;
                    $requestData = $request->all();
                    $requestData['RFC_PROVEEDOR'] = $rfc;

                    if ($request->ID_FORMULARIO_FACTURACION == 0) {
                        DB::statement('ALTER TABLE formulario_facturasproveedores AUTO_INCREMENT=1;');

                        $cuentas = facturacionModel::create($requestData);

                        if ($request->hasFile('DOCUMENTOS_SOPORTE_FACTURA')) {
                            $file = $request->file('DOCUMENTOS_SOPORTE_FACTURA');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documentos de soporte";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->DOCUMENTOS_SOPORTE_FACTURA = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('FACTURA_PDF')) {
                            $file = $request->file('FACTURA_PDF');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documento factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->FACTURA_PDF = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('FACTURA_XML')) {
                            $file = $request->file('FACTURA_XML');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/XML factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->FACTURA_XML = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('ARCHIVO_REP')) {
                            $file = $request->file('ARCHIVO_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/PDF/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->ARCHIVO_REP = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('XML_REP')) {
                            $file = $request->file('XML_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/XML/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->XML_REP = $filePath;
                            $cuentas->save();
                        }


                        if ($request->hasFile('ARCHIVO_RECIBO_PAGO')) {
                            $file = $request->file('ARCHIVO_RECIBO_PAGO');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo de pago/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->ARCHIVO_RECIBO_PAGO = $filePath;
                            $cuentas->save();
                        }



                    } else {
                        $cuentas = facturacionModel::find($request->ID_FORMULARIO_FACTURACION);

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            $response['code'] = 1;
                            $response['cuenta'] = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                            return response()->json($response);
                        }

                        if ($request->hasFile('DOCUMENTOS_SOPORTE_FACTURA')) {
                            if ($cuentas->DOCUMENTOS_SOPORTE_FACTURA && Storage::exists($cuentas->DOCUMENTOS_SOPORTE_FACTURA)) {
                                Storage::delete($cuentas->DOCUMENTOS_SOPORTE_FACTURA);
                            }
                            $file = $request->file('DOCUMENTOS_SOPORTE_FACTURA');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documentos de soporte";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['DOCUMENTOS_SOPORTE_FACTURA'] = $filePath;
                        }

                        if ($request->hasFile('FACTURA_PDF')) {
                            if ($cuentas->FACTURA_PDF && Storage::exists($cuentas->FACTURA_PDF)) {
                                Storage::delete($cuentas->FACTURA_PDF);
                            }
                            $file = $request->file('FACTURA_PDF');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documento factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['FACTURA_PDF'] = $filePath;
                        }

                        if ($request->hasFile('FACTURA_XML')) {
                            if ($cuentas->FACTURA_XML && Storage::exists($cuentas->FACTURA_XML)) {
                                Storage::delete($cuentas->FACTURA_XML);
                            }
                            $file = $request->file('FACTURA_XML');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/XML factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['FACTURA_XML'] = $filePath;
                        }

                        if ($request->hasFile('ARCHIVO_REP')) {
                            if ($cuentas->ARCHIVO_REP && Storage::exists($cuentas->ARCHIVO_REP)) {
                                Storage::delete($cuentas->ARCHIVO_REP);
                            }
                            $file = $request->file('ARCHIVO_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/PDF/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['ARCHIVO_REP'] = $filePath;
                        }

                        if ($request->hasFile('XML_REP')) {
                            if ($cuentas->XML_REP && Storage::exists($cuentas->XML_REP)) {
                                Storage::delete($cuentas->XML_REP);
                            }
                            $file = $request->file('XML_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/XML/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['XML_REP'] = $filePath;
                        }

                        if ($request->hasFile('ARCHIVO_RECIBO_PAGO')) {
                            if ($cuentas->ARCHIVO_RECIBO_PAGO && Storage::exists($cuentas->ARCHIVO_RECIBO_PAGO)) {
                                Storage::delete($cuentas->ARCHIVO_RECIBO_PAGO);
                            }
                            $file = $request->file('ARCHIVO_RECIBO_PAGO');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo de pago/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['ARCHIVO_RECIBO_PAGO'] = $filePath;
                        }



                        $cuentas->update(collect($requestData)->except('RFC_PROVEEDOR')->toArray());

                       
                    }

                    $response['code'] = 1;
                    $response['cuenta']  = $cuentas;
                    return response()->json($response);


                    break;


                case 2:

                    $rfc = Auth::user()->RFC_PROVEEDOR;
                    $requestData = $request->all();
                    $requestData['RFC_PROVEEDOR'] = $rfc;

                    if ($request->ID_FORMULARIO_FACTURACION == 0) {
                        DB::statement('ALTER TABLE formulario_facturasproveedores AUTO_INCREMENT=1;');

                        $cuentas = facturacionModel::create($requestData);

                        if ($request->hasFile('DOCUMENTOS_SOPORTE_FACTURA')) {
                            $file = $request->file('DOCUMENTOS_SOPORTE_FACTURA');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documentos de soporte";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->DOCUMENTOS_SOPORTE_FACTURA = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('FACTURA_PDF')) {
                            $file = $request->file('FACTURA_PDF');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documento factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->FACTURA_PDF = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('FACTURA_XML')) {
                            $file = $request->file('FACTURA_XML');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/XML factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->FACTURA_XML = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('ARCHIVO_REP')) {
                            $file = $request->file('ARCHIVO_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/PDF/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->ARCHIVO_REP = $filePath;
                            $cuentas->save();
                        }

                        if ($request->hasFile('XML_REP')) {
                            $file = $request->file('XML_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/XML/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->XML_REP = $filePath;
                            $cuentas->save();
                        }


                        if ($request->hasFile('ARCHIVO_RECIBO_PAGO')) {
                            $file = $request->file('ARCHIVO_RECIBO_PAGO');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo de pago/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $cuentas->ARCHIVO_RECIBO_PAGO = $filePath;
                            $cuentas->save();
                        }
                    } else {
                        $cuentas = facturacionModel::find($request->ID_FORMULARIO_FACTURACION);

                        if (isset($request->ELIMINAR)) {
                            $cuentas->ACTIVO = $request->ELIMINAR == 1 ? 0 : 1;
                            $cuentas->save();

                            $response['code'] = 1;
                            $response['cuenta'] = $request->ELIMINAR == 1 ? 'Desactivada' : 'Activada';
                            return response()->json($response);
                        }

                        if ($request->hasFile('DOCUMENTOS_SOPORTE_FACTURA')) {
                            if ($cuentas->DOCUMENTOS_SOPORTE_FACTURA && Storage::exists($cuentas->DOCUMENTOS_SOPORTE_FACTURA)) {
                                Storage::delete($cuentas->DOCUMENTOS_SOPORTE_FACTURA);
                            }
                            $file = $request->file('DOCUMENTOS_SOPORTE_FACTURA');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documentos de soporte";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['DOCUMENTOS_SOPORTE_FACTURA'] = $filePath;
                        }

                        if ($request->hasFile('FACTURA_PDF')) {
                            if ($cuentas->FACTURA_PDF && Storage::exists($cuentas->FACTURA_PDF)) {
                                Storage::delete($cuentas->FACTURA_PDF);
                            }
                            $file = $request->file('FACTURA_PDF');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Documento factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['FACTURA_PDF'] = $filePath;
                        }

                        if ($request->hasFile('FACTURA_XML')) {
                            if ($cuentas->FACTURA_XML && Storage::exists($cuentas->FACTURA_XML)) {
                                Storage::delete($cuentas->FACTURA_XML);
                            }
                            $file = $request->file('FACTURA_XML');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/XML factura";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['FACTURA_XML'] = $filePath;
                        }

                        if ($request->hasFile('ARCHIVO_REP')) {
                            if ($cuentas->ARCHIVO_REP && Storage::exists($cuentas->ARCHIVO_REP)) {
                                Storage::delete($cuentas->ARCHIVO_REP);
                            }
                            $file = $request->file('ARCHIVO_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/PDF/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['ARCHIVO_REP'] = $filePath;
                        }

                        if ($request->hasFile('XML_REP')) {
                            if ($cuentas->XML_REP && Storage::exists($cuentas->XML_REP)) {
                                Storage::delete($cuentas->XML_REP);
                            }
                            $file = $request->file('XML_REP');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo Electrónico de Pago/XML/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['XML_REP'] = $filePath;
                        }

                        if ($request->hasFile('ARCHIVO_RECIBO_PAGO')) {
                            if ($cuentas->ARCHIVO_RECIBO_PAGO && Storage::exists($cuentas->ARCHIVO_RECIBO_PAGO)) {
                                Storage::delete($cuentas->ARCHIVO_RECIBO_PAGO);
                            }
                            $file = $request->file('ARCHIVO_RECIBO_PAGO');
                            $folderPath = "proveedores/{$rfc}/Facturas/{$cuentas->ID_FORMULARIO_FACTURACION}/Recibo de pago/{$cuentas->ID_FORMULARIO_FACTURACION}";
                            $fileName = $file->getClientOriginalName();
                            $filePath = $file->storeAs($folderPath, $fileName);
                            $requestData['ARCHIVO_RECIBO_PAGO'] = $filePath;
                        }



                        $cuentas->update(collect($requestData)->except('RFC_PROVEEDOR')->toArray());

                      
                    }

                    $response['code'] = 1;
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
