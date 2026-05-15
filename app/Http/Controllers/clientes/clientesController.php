<?php

namespace App\Http\Controllers\clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use DB;


use App\Models\solicitudes\solicitudesModel;
use App\Models\solicitudes\verificacionsolicitudModel;


use App\Models\solicitudes\catalogomediocontactoModel;
use App\Models\solicitudes\catalonecesidadModel;
use App\Models\solicitudes\catalogiroempresaModel;
use App\Models\solicitudes\catalogolineanegociosModel;
use App\Models\solicitudes\catalogotiposervicioModel;
use App\Models\proveedor\catalogotituloproveedorModel;



use App\Models\cliente\clienteModel;
use App\Models\cliente\verificacionclienteModel;
use App\Models\cliente\actaclienteModel;




class clientesController extends Controller
{
    public function index()
    {

        $medios = catalogomediocontactoModel::where('ACTIVO', 1)->get();
        $necesidades = catalonecesidadModel::where('ACTIVO', 1)->get();
        $giros = catalogiroempresaModel::where('ACTIVO', 1)->get();
        $lineas = catalogolineanegociosModel::where('ACTIVO', 1)->get();
        $tipos = catalogotiposervicioModel::where('ACTIVO', 1)->get();
        $titulosCuenta = catalogotituloproveedorModel::where('ACTIVO', 1)->get();

        return view('ventas.clientes.clientes', compact('medios', 'necesidades','giros', 'lineas', 'tipos','titulosCuenta'));
    }



    public function Tablaclientesventas()
{
    try {
        
         $tabla = clienteModel::get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_CLIENTES . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CLIENTES . '"><span class="slider round"></span></label>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-constancia" data-id="' . $value->ID_FORMULARIO_CLIENTES . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                $value->BTN_VISUALIZAR = '<button type="button" class="btn btn-primary btn-custom rounded-pill VISUALIZAR"><i class="bi bi-eye"></i></button>';
                $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_FORMULARIO_CLIENTES . '" checked><span class="slider round"></span></label>';

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


public function mostrarconstanciacliente($id)
{
    $archivo = clienteModel::findOrFail($id)->CONSTANCIA_DOCUMENTO;
    return Storage::response($archivo);
}

/// VERIFICACION DEL CLIENTE



public function Tablaverificacionusuario(Request $request)
{
    try {
        $cliente = $request->get('cliente');

        $tabla = verificacionclienteModel::where('CLIENTE_ID', $cliente)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button type="button" class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacionproveedor" data-id="' . $value->ID_VERIFICACION_PROVEEDOR . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
                } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                    $value->BTN_DOCUMENTO = '<button type="button" class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-verificacionproveedor" data-id="' . $value->ID_VERIFICACION_PROVEEDOR . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';
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

public function mostrarverificacionclienteventas($id)
{
    $archivo = verificacionclienteModel::findOrFail($id)->EVIDENCIA_VERIFICACION;
    return Storage::response($archivo);
}


///  ACTA CONSTITUTIVA


public function Tablactaconstitutivausuario(Request $request)
{
    try {
        $cliente = $request->get('cliente');

        $tabla = actaclienteModel::where('CLIENTE_ID', $cliente)->get();

        foreach ($tabla as $value) {
            if ($value->ACTIVO == 0) {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-veracta" data-id="' . $value->ID_ACTA_CLIENTE . '" title="Ver documento "> <i class="bi bi-filetype-pdf"></i></button>';

            } else {

                $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                $value->BTN_DOCUMENTO = '<button class="btn btn-danger btn-custom rounded-pill pdf-button ver-archivo-veracta" data-id="' . $value->ID_ACTA_CLIENTE . '" title="Ver documento"> <i class="bi bi-filetype-pdf"></i></button>';

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


public function mostraractaclienteventas($id)
{
    $archivo = actaclienteModel::findOrFail($id)->EVIDENCIA_CONSTITUVA;
    return Storage::response($archivo);
}



    public function store(Request $request)
    {
        try {
            switch (intval($request->api)) {
                case 1:
                
                    if ($request->ID_FORMULARIO_CLIENTES == 0) {
                        DB::statement('ALTER TABLE formulario_clientes AUTO_INCREMENT=1;');

                        $data = $request->except(['contactos', 'direcciones', 'CONSTANCIA_DOCUMENTO']);
                        $data['CONTACTOS_JSON'] = is_string($request->CONTACTOS_JSON) ? $request->CONTACTOS_JSON : json_encode($request->CONTACTOS_JSON ?? []);
                        $data['DIRECCIONES_JSON'] = is_string($request->DIRECCIONES_JSON) ? $request->DIRECCIONES_JSON : json_encode($request->DIRECCIONES_JSON ?? []);

                        $cliente = clienteModel::create($data);

                        if ($request->hasFile('CONSTANCIA_DOCUMENTO')) {
                            $documento = $request->file('CONSTANCIA_DOCUMENTO');
                            $idCliente = $cliente->ID_FORMULARIO_CLIENTES;

                            $nombreArchivo = 'constancia.' . $documento->getClientOriginalExtension();
                            $rutaCarpeta = 'cliente/' . $idCliente . '/Constancia';
                            $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                            $cliente->CONSTANCIA_DOCUMENTO = $rutaCompleta;
                            $cliente->save();
                        }

                        $response['code'] = 1;
                        $response['cliente'] = $cliente;
                        return response()->json($response);
                    } else {
                        if (isset($request->ELIMINAR)) {
                            if ($request->ELIMINAR == 1) {
                                clienteModel::where('ID_FORMULARIO_CLIENTES', $request->ID_FORMULARIO_CLIENTES)
                                    ->update(['ACTIVO' => 0]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Desactivada';
                            } else {
                                clienteModel::where('ID_FORMULARIO_CLIENTES', $request->ID_FORMULARIO_CLIENTES)
                                    ->update(['ACTIVO' => 1]);
                                $response['code'] = 1;
                                $response['cliente'] = 'Activada';
                            }
                        } else {
                            $cliente = clienteModel::find($request->ID_FORMULARIO_CLIENTES);

                            $data = $request->except(['contactos', 'direcciones', 'CONSTANCIA_DOCUMENTO']);
                            $data['CONTACTOS_JSON'] = is_string($request->CONTACTOS_JSON) ? $request->CONTACTOS_JSON : json_encode($request->CONTACTOS_JSON ?? []);
                            $data['DIRECCIONES_JSON'] = is_string($request->DIRECCIONES_JSON) ? $request->DIRECCIONES_JSON : json_encode($request->DIRECCIONES_JSON ?? []);

                            $cliente->update($data);

                            if ($request->hasFile('CONSTANCIA_DOCUMENTO')) {
                                if ($cliente->CONSTANCIA_DOCUMENTO && Storage::exists($cliente->CONSTANCIA_DOCUMENTO)) {
                                    Storage::delete($cliente->CONSTANCIA_DOCUMENTO);
                                }

                                $documento = $request->file('CONSTANCIA_DOCUMENTO');
                                $idCliente = $cliente->ID_FORMULARIO_CLIENTES;

                                $nombreArchivo = 'constancia.' . $documento->getClientOriginalExtension();
                                $rutaCarpeta = 'cliente/' . $idCliente . '/Constancia';
                                $rutaCompleta = $documento->storeAs($rutaCarpeta, $nombreArchivo);

                                $cliente->CONSTANCIA_DOCUMENTO = $rutaCompleta;
                                $cliente->save();
                            }

                            $response['code'] = 1;
                            $response['cliente'] = 'Actualizada';
                        }

                        return response()->json($response);
                    }

                    break;


                case 2:
                        if ($request->ID_VERIFICACION_CLIENTE == 0) {
                            DB::statement('ALTER TABLE verificacion_cliente AUTO_INCREMENT=1;');
                            $cliente = verificacionclienteModel::create($request->all());
                    
                            if ($request->hasFile('EVIDENCIA_VERIFICACION')) {
                                $documento = $request->file('EVIDENCIA_VERIFICACION');
                                $clienteId = $request->CLIENTE_ID;
                                $registroId = $cliente->ID_VERIFICACION_CLIENTE;
                    
                                $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $documento->getClientOriginalName());
                    
                                $ruta = "cliente/{$clienteId}/verificacion del cliente/{$registroId}";
                                $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);
                    
                                $cliente->EVIDENCIA_VERIFICACION = $rutaCompleta;
                                $cliente->save();
                            }
                        } else {
                            if (isset($request->ELIMINAR)) {
                                if ($request->ELIMINAR == 1) {
                                    $cliente = verificacionclienteModel::where('ID_VERIFICACION_CLIENTE', $request['ID_VERIFICACION_CLIENTE'])->update(['ACTIVO' => 0]);
                                    $response['code'] = 1;
                                    $response['cliente'] = 'Desactivada';
                                } else {
                                    $cliente = verificacionclienteModel::where('ID_VERIFICACION_CLIENTE', $request['ID_VERIFICACION_CLIENTE'])->update(['ACTIVO' => 1]);
                                    $response['code'] = 1;
                                    $response['cliente'] = 'Activada';
                                }
                            } else {
                                $cliente = verificacionclienteModel::find($request->ID_VERIFICACION_CLIENTE);
                                $cliente->update($request->all());
                    
                                if ($request->hasFile('EVIDENCIA_VERIFICACION')) {
                                    $documento = $request->file('EVIDENCIA_VERIFICACION');
                                    $clienteId = $cliente->CLIENTE_ID;
                                    $registroId = $cliente->ID_VERIFICACION_CLIENTE;
                    
                                    $nombreArchivo = preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-]/u', '_', $documento->getClientOriginalName());
                    
                                    $ruta = "cliente/{$clienteId}/verificacion del cliente/{$registroId}";
                                    $rutaCompleta = $documento->storeAs($ruta, $nombreArchivo);
                    
                                    $cliente->EVIDENCIA_VERIFICACION = $rutaCompleta;
                                    $cliente->save();
                                }
                    
                                $response['code'] = 1;
                                $response['cliente'] = 'Actualizada';
                            }
                    
                            return response()->json($response);
                        }
                    
                        $response['code'] = 1;
                        $response['cliente'] = $cliente;
                        return response()->json($response);
                        break;
                    

                        case 3:
                            if ($request->ID_ACTA_CLIENTE == 0) {
                                DB::statement('ALTER TABLE actaconstitutiva_cliente AUTO_INCREMENT=1;');
                                $cliente = actaclienteModel::create($request->all());
                        
                                if ($request->hasFile('EVIDENCIA_CONSTITUVA')) {
                                    $documento = $request->file('EVIDENCIA_CONSTITUVA');
                                    $clienteId = $request->CLIENTE_ID;
                                    $registroId = $cliente->ID_ACTA_CLIENTE;
                        
                                    $nombreArchivo = preg_replace(
                                        '/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-_]/u',
                                        '_',
                                        pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME)
                                    );
                                    $extension = $documento->getClientOriginalExtension();
                                    $nombreConExtension = $nombreArchivo . '.' . $extension;
                        
                                    $ruta = "cliente/{$clienteId}/Acta constitutiva/{$registroId}";
                                    $rutaCompleta = $documento->storeAs($ruta, $nombreConExtension);
                        
                                    $cliente->EVIDENCIA_CONSTITUVA = $rutaCompleta;
                                    $cliente->save();
                                }
                            } else {
                                if (isset($request->ELIMINAR)) {
                                    if ($request->ELIMINAR == 1) {
                                        actaclienteModel::where('ID_ACTA_CLIENTE', $request['ID_ACTA_CLIENTE'])->update(['ACTIVO' => 0]);
                                        $response['code'] = 1;
                                        $response['cliente'] = 'Desactivada';
                                    } else {
                                        actaclienteModel::where('ID_ACTA_CLIENTE', $request['ID_ACTA_CLIENTE'])->update(['ACTIVO' => 1]);
                                        $response['code'] = 1;
                                        $response['cliente'] = 'Activada';
                                    }
                                } else {
                                    $cliente = actaclienteModel::find($request->ID_ACTA_CLIENTE);
                                    $cliente->update($request->all());
                        
                                    if ($request->hasFile('EVIDENCIA_CONSTITUVA')) {
                                        $documento = $request->file('EVIDENCIA_CONSTITUVA');
                                        $clienteId = $cliente->CLIENTE_ID;
                                        $registroId = $cliente->ID_ACTA_CLIENTE;
                        
                                        $nombreArchivo = preg_replace(
                                            '/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\-_]/u',
                                            '_',
                                            pathinfo($documento->getClientOriginalName(), PATHINFO_FILENAME)
                                        );
                                        $extension = $documento->getClientOriginalExtension();
                                        $nombreConExtension = $nombreArchivo . '.' . $extension;
                        
                                        $ruta = "cliente/{$clienteId}/Acta constitutiva/{$registroId}";
                                        $rutaCompleta = $documento->storeAs($ruta, $nombreConExtension);
                        
                                        $cliente->EVIDENCIA_CONSTITUVA = $rutaCompleta;
                                        $cliente->save();
                                    }
                        
                                    $response['code'] = 1;
                                    $response['cliente'] = 'Actualizada';
                                }
                        
                                return response()->json($response);
                            }
                        
                            $response['code'] = 1;
                            $response['cliente'] = $cliente;
                            return response()->json($response);
                            break;
                        


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
