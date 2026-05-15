<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\VerificationCode;
use App\Mail\VerificationMail;

class VerificationController extends Controller
{
    public function enviarCodigo(Request $request)
    {
        $correo = $request->input('correo');

        if (!$correo) {
            return response()->json(['error' => 'Correo requerido'], 400);
        }

        $codigo = Str::random(6);

        VerificationCode::updateOrCreate(
            ['correo' => $correo],
            ['codigo' => $codigo, 'expires_at' => Carbon::now()->addMinutes(10)]
        );

        Mail::to($correo)->send(new VerificationMail($codigo));

        return response()->json(['message' => 'Código enviado al correo']);
    }


    public function verificarCodigo(Request $request)
    {
        $correo = $request->input('correo');
        $codigoIngresado = $request->input('codigo');

        $registro = VerificationCode::where('correo', $correo)
            ->where('codigo', $codigoIngresado)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($registro) {
            $registro->delete();
            return response()->json(['message' => 'Código válido, puede actualizar'], 200);
        }

        return response()->json(['error' => 'Código incorrecto o expirado'], 400);
    }
}
