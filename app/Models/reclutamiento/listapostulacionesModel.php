<?php

namespace App\Models\reclutamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listapostulacionesModel extends Model
{
    protected $primaryKey = 'ID_LISTA_POSTULANTES';
    protected $table = 'lista_postulantes';
    protected $fillable = [
        'VACANTES_ID',
        'CURP',
        'ACTIVO'
       
    ];
}
