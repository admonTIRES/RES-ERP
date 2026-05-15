<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogotipoinventarioModel extends Model
{
    protected $primaryKey = 'ID_CATALOGO_TIPOINVENTARIO';
    protected $table = 'catalogo_tipoinventario';
    protected $fillable = [
        'DESCRIPCION_TIPO',
        'ACTIVO'
    ];
}
