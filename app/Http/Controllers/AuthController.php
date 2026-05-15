<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;



use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\usuario\usuarioModel;

use App\Models\VerificationCode;

use App\Models\proveedor\directorioModel;
use App\Models\proveedor\altaproveedorModel;


use App\Mail\VerificationMail;
use Carbon\Carbon;

class AuthController extends Controller
{


    public function validarRolExterno()
    {
        $esExterno = false;

        if (auth()->check()) {
            $esExterno = auth()->user()->roles()
                ->where('NOMBRE_ROL', 'externo')
                ->where('ACTIVO', 1)
                ->exists();
        }

        return response()->json([
            'externo' => $esExterno
        ]);
    }


    
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->hasAnyRole(['Superusuario', 'Administrador'])) {
                return redirect('/modulos');
            } else {
                return back()->with('error', 'No tienes acceso a esta sección.');
            }
        }
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt(['EMPLEADO_CORREO' => $credentials['email'], 'password' => $credentials['password'], 'ACTIVO' => 1])) {
            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'message' => 'Inicio de sesión exitoso. Redirigiendo...',
                'redirect' => ($user->USUARIO_TIPO == 1) ? '/modulos' : '/alta'
            ]);
        }

        if (Auth::attempt(['RFC_PROVEEDOR' => $credentials['email'], 'password' => $credentials['password'], 'ACTIVO' => 1])) {
            $user = Auth::user();

            $directorio = directorioModel::where('RFC_PROVEEDOR', $credentials['email'])->first();

            if ($directorio && $directorio->CORREO_DIRECTORIO) {
                return $this->sendVerificationCode($directorio->CORREO_DIRECTORIO, $user);
            }

            $alternativo = altaproveedorModel::where('RFC_ALTA', $credentials['email'])->first();

            if ($alternativo && $alternativo->CORREO_DIRECTORIO) {
                return $this->sendVerificationCode($alternativo->CORREO_DIRECTORIO, $user);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'No se encontró un correo asociado a este RFC.'
            ]);
        }




        return response()->json([
            'status' => 'error',
            'message' => 'Estas credenciales no coinciden con nuestros registros.'
        ]);
    }


    protected function sendVerificationCode($correo, $user)
    {
        $codigo = rand(100000, 999999);

        VerificationCode::updateOrCreate(
            ['correo' => $correo],
            ['codigo' => $codigo, 'expires_at' => now()->addMinutes(10)]
        );

        Mail::to($correo)->send(new VerificationMail($codigo));

        return response()->json([
            'status' => 'verification_required',
            'correo' => $correo,
            'redirect' => ($user->USUARIO_TIPO == 1) ? '/modulos' : '/alta'
        ]);
    }



    public function verifyCode(Request $request)
    {
        $verification = VerificationCode::where('correo', $request->correo)
            ->where('codigo', $request->codigo)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return response()->json(['status' => 'error', 'message' => 'Código incorrecto o expirado']);
        }

        $directorio = directorioModel::where('CORREO_DIRECTORIO', $request->correo)->first();

        if ($directorio) {
            $user = usuarioModel::where('RFC_PROVEEDOR', $directorio->RFC_PROVEEDOR)->first();
        } else {
            $altaproveedor = altaproveedorModel::where('CORREO_DIRECTORIO', $request->correo)->first();

            if (!$altaproveedor) {
                return response()->json(['status' => 'error', 'message' => 'No se encontró el correo en ninguno de los formularios.']);
            }

            $user = usuarioModel::where('RFC_PROVEEDOR', $altaproveedor->RFC_ALTA)->first();
        }

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No se encontró un usuario con este RFC.']);
        }

        $verification->delete();
        Auth::login($user);

        return response()->json(['status' => 'success']);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['status' => 'logged_out']);
        }

        return redirect()->route('login');
    }
}
