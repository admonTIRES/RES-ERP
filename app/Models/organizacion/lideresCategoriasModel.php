<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lideresCategoriasModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_LIDER_CATEGORIAS';
    protected $table = 'lideres_categorias';
    protected $fillable = [
        'AREA_ID',
        'LIDER_ID',
        'CATEGORIA_ID',
        'ACTIVO'
    ];
}
