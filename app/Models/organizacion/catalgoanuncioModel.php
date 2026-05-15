<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalgoanuncioModel extends Model
{
    protected $primaryKey = 'ID_CATALOGO_ANUNCIOS';
    protected $table = 'catalogo_anuncios';
    protected $fillable = [
        'TITULO_ANUNCIO',
        'DESCRIPCION_ANUNCIO',
        'TIPO_REPETICION',
        'FECHA_INICIO',
        'FECHA_FIN',
        'HORA_INICIO',
        'HORA_FIN',
        'FECHA_ANUAL',
        'HORA_ANUAL_INICIO',
        'HORA_ANUAL_FIN',
        'MES_MENSUAL',
        'FOTO_ANUNCIO',
        'ACTIVO'
    ];
}
