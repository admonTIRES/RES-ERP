<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Models\usuario\usuarioModel;
use Illuminate\Support\Facades\Hash;
use App\Models\usuario\rolesModel;


use App\Models\organizacion\catalogocategoriaModel;

use DB;


class usuarioController extends Controller
{
 
    public function index()
    {
        $roles = CatalogocategoriaModel::where('ACTIVO', 1)->pluck('NOMBRE_CATEGORIA')->toArray();

        array_unshift($roles, 'Superusuario', 'Administrador', 'Proveedor', 'externo');
    
        return view('RH.usuario.usuario', compact('roles'));
    }


    public function Tablausuarios()
    {
        try {
            $tabla = usuarioModel::with('roles')->where('USUARIO_TIPO', 1)->get();

            foreach ($tabla as $value) {
                // Agregar atributos personalizados
                $value->EMPLEADO_NOMBRES = $value->EMPLEADO_NOMBRE . ' ' . $value->EMPLEADO_APELLIDOPATERNO . ' ' . $value->EMPLEADO_APELLIDOMATERNO . '<br>' . $value->EMPLEADO_CARGO;
                $value->EMPLEADO_CORREOS = $value->EMPLEADO_CORREO . '<br>' . $value->EMPLEADO_TELEFONO;

                if ($value->USUARIO_TIPO == 1) {
                    $value->USUARIO_TIPOS = 'Empleado';
                } else {
                    $value->USUARIO_TIPOS = 'Proveedor';

                }

                $value->FOTO_USUARIO_HTML = '<img src="/usuariofoto/' . $value->ID_USUARIO . '" alt="Foto de usuario" class="img-fluid" width="50" height="60">';

                if ($value->ACTIVO == 0) {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_USUARIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_USUARIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                }

                $value->ROLES_ASIGNADOS = $value->roles->pluck('NOMBRE_ROL'); 
                
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








    public function Tablaproveedores()
    {
        try {
            // Cargar usuarios junto con los roles
            $tabla = usuarioModel::with('roles')->where('USUARIO_TIPO', 2)->get();

            foreach ($tabla as $value) {
                $value->EMPLEADO_NOMBRES = $value->EMPLEADO_NOMBRE . ' ' . $value->EMPLEADO_APELLIDOPATERNO . ' ' . $value->EMPLEADO_APELLIDOMATERNO . '<br>' . $value->EMPLEADO_CARGO;
                $value->EMPLEADO_CORREOS = $value->EMPLEADO_CORREO . '<br>' . $value->EMPLEADO_TELEFONO;

                if ($value->USUARIO_TIPO == 1) {
                    $value->USUARIO_TIPOS = 'Empleado';
                } else {
                    $value->USUARIO_TIPOS = 'Proveedor';
                }

                $value->FOTO_USUARIO_HTML = '<img src="/usuariofoto/' . $value->ID_USUARIO . '" alt="Foto de usuario" class="img-fluid" width="50" height="60">';

                if ($value->ACTIVO == 0) {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_USUARIO . '"><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-secondary btn-custom rounded-pill EDITAR" disabled><i class="bi bi-ban"></i></button>';
                } else {
                    $value->BTN_ELIMINAR = '<label class="switch"><input type="checkbox" class="ELIMINAR" data-id="' . $value->ID_USUARIO . '" checked><span class="slider round"></span></label>';
                    $value->BTN_EDITAR = '<button type="button" class="btn btn-warning btn-custom rounded-pill EDITAR"><i class="bi bi-pencil-square"></i></button>';
                }

                $value->ROLES_ASIGNADOS = $value->roles->pluck('NOMBRE_ROL'); 
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

public function mostrarFotoUsuario($usuario_id)
{
    $foto = usuarioModel::findOrFail($usuario_id);
    return Storage::response($foto->FOTO_USUARIO);
}


    public function validarRFC(Request $request)
    {
        $existe = DB::table('usuarios')
            ->where('RFC_PROVEEDOR', $request->RFC_PROVEEDOR)
            ->exists();

        return response()->json(['existe' => $existe]);
    }



    public function store(Request $request)
{
    try {
        DB::beginTransaction(); 

        switch (intval($request->api)) {
            case 1:
                if ($request->ID_USUARIO == 0) {
                    DB::statement('ALTER TABLE usuarios AUTO_INCREMENT=1;');

                    $datosUsuario = $request->all();
                    $datosUsuario['PASSWORD'] = Hash::make($request->PASSWORD);

                    $usuarios = usuarioModel::create($datosUsuario);
                    $usuarioId = $usuarios->ID_USUARIO;

                    if ($request->hasFile('FOTO_USUARIO')) {
                        $imagen = $request->file('FOTO_USUARIO');
                        $rutaCarpetaUsuario = 'usuarios/' . $usuarioId;
                        $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                        $rutaCompleta = $imagen->storeAs($rutaCarpetaUsuario, $nombreArchivo);
                        $usuarios->FOTO_USUARIO = $rutaCompleta;
                        $usuarios->save();
                    }

                    if ($request->has('NOMBRE_ROL')) {
                        foreach ($request->NOMBRE_ROL as $rol) {
                            rolesModel::create([
                                'USUARIO_ID' => $usuarioId,
                                'NOMBRE_ROL' => $rol,
                                'ACTIVO' => 1
                            ]);
                        }
                    }
                } else {
                    if (isset($request->ELIMINAR)) {
                        if ($request->ELIMINAR == 1) {
                            usuarioModel::where('ID_USUARIO', $request['ID_USUARIO'])->update(['ACTIVO' => 0]);
                            rolesModel::where('USUARIO_ID', $request['ID_USUARIO'])->update(['ACTIVO' => 0]);
                            $response['code'] = 1;
                            $response['usuario'] = 'Desactivada';
                        } else {
                            usuarioModel::where('ID_USUARIO', $request['ID_USUARIO'])->update(['ACTIVO' => 1]);
                            rolesModel::where('USUARIO_ID', $request['ID_USUARIO'])->update(['ACTIVO' => 1]);
                            $response['code'] = 1;
                            $response['usuario'] = 'Activada';
                        }
                    } else {
                        $usuarios = usuarioModel::find($request->ID_USUARIO);

                        if ($request->filled('PASSWORD')) {
                            $request['PASSWORD'] = Hash::make($request->PASSWORD);
                        }

                        if ($request->hasFile('FOTO_USUARIO')) {
                            if ($usuarios->FOTO_USUARIO && Storage::exists($usuarios->FOTO_USUARIO)) {
                                Storage::delete($usuarios->FOTO_USUARIO);
                            }

                            $imagen = $request->file('FOTO_USUARIO');
                            $rutaCarpetaUsuario = 'usuarios/' . $usuarios->ID_USUARIO;
                            $nombreArchivo = 'foto_usuario.' . $imagen->getClientOriginalExtension();
                            $rutaCompleta = $imagen->storeAs($rutaCarpetaUsuario, $nombreArchivo);

                            $usuarios->FOTO_USUARIO = $rutaCompleta;
                        }

                        $usuarios->update($request->except('FOTO_USUARIO'));
                        $usuarios->save();

                        if ($request->has('NOMBRE_ROL')) {
                            rolesModel::where('USUARIO_ID', $usuarios->ID_USUARIO)->delete();

                            foreach ($request->NOMBRE_ROL as $rol) {
                                rolesModel::create([
                                    'USUARIO_ID' => $usuarios->ID_USUARIO,
                                    'NOMBRE_ROL' => $rol,
                                    'ACTIVO' => 1
                                ]);
                            }
                        }

                        $response['code'] = 1;
                        $response['usuario'] = 'Actualizada';
                    }
                    DB::commit(); 
                    return response()->json($response);
                }

                $response['code'] = 1;
                $response['usuario'] = $usuarios;
                DB::commit(); 
                return response()->json($response);

            default:
                $response['code'] = 1;
                $response['msj'] = 'Api no encontrada';
                return response()->json($response);
        }
    } catch (Exception $e) {
        DB::rollBack(); 
        return response()->json('Error al guardar la jerarquía: ' . $e->getMessage());
    }
}


// }



}
