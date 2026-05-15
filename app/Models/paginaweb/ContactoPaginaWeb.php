<?php

namespace App\Models\paginaweb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoPaginaWeb extends Model
{
    protected $table = 'contactos_paginaweb';
    protected $primaryKey = 'ID_FORMULARIO_CONTACTOSPAGINAWEB';
    protected $fillable = [
        'NOMBRE',
        'CORREO',
        'TELEFONO',
        'MENSAJE',
        'SOLICITUD_ATENDIDA',
        'ATENDIO_SOLICITUD',
        'FECHA_ATENCION',
        'MOTIVO_NOATENDIDO',
        'ACTIVO'
    ];
    
}
