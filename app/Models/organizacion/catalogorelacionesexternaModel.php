<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class catalogorelacionesexternaModel extends Model
{
  
    protected $primaryKey = 'ID_CATALOGO_RELACIONESEXTERNAS';
    protected $table = 'catalogo_relacionesexternas';
    protected $fillable = [
        'NOMBRE_RELACIONEXTERNA',
         'ACTIVO'
    ];
}
