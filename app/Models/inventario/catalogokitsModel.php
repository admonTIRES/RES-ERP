<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogokitsModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_CATALOGO_KITS';
    protected $table = 'catalogo_kits';
    protected $fillable = [
        'NOMBRE_KIT',
        'COMPONENTES_JSON',
        'ACTIVO'
    ];
}
