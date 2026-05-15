<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogotituloproveedorModel extends Model
{
    use HasFactory;
    protected $table = 'catalogo_tituloproveedores';
    protected $primaryKey = 'ID_CATALOGO_TITULOPROVEEDOR';
    protected $fillable = [
        'NOMBRE_TITULO',
        'ABREVIATURA_TITULO',
        'ACTIVO'
    ];
}
