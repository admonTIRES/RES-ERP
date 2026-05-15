<?php

namespace App\Models\cliente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clienteModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_FORMULARIO_CLIENTES';
    protected $table = 'formulario_clientes';
    protected $fillable = [
        'RFC_CLIENTE',
        'RAZON_SOCIAL_CLIENTE',
        'NOMBRE_COMERCIAL_CLIENTE',
        'GIRO_EMPRESA_CLIENTE',
        'REPRESENTANTE_LEGAL_CLIENTE',
        'PAGINA_CLIENTE',
        'CONTACTOS_JSON',
        'DIRECCIONES_JSON',
        'EMITE_ORDEN',
        'CONSTANCIA_DOCUMENTO',
        'FECHA_CONSTANCIA',
        'ACTIVO'
        ];
}
