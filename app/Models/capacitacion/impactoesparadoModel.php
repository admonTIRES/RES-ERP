<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class impactoesparadoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_IMPACTO_ESPERADO';
    protected $table = 'capacitacion_impactoesperado';
    protected $fillable = [
        'IMPACTO_ESPERADO',
        'ACTIVO'
    ];
}
