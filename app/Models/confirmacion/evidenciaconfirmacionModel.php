<?php

namespace App\Models\confirmacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evidenciaconfirmacionModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_EVIDENCIA_CONFIRMACION';
    protected $table = 'evidencia_confirmacion';
    protected $fillable = [
        'CONFIRMACION_ID',
        'NOMBRE_EVIDENCIA',
        'DOCUMENTO_EVIDENCIA'
        ];
}
