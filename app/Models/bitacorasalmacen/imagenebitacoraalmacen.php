<?php

namespace App\Models\bitacorasalmacen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imagenebitacoraalmacen extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_IMAGENES_BITACORASALMACEN';
    protected $table = 'imagenes_bitacorasalmacen';
    protected $fillable = [
        'RECEMPLEADO_ID',
        'INVENTARIO_ID',
        'RUTA_FOTOS',
        'ACTIVO'
    ];
}
