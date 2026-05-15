<?php

namespace App\Models\capacitacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materialdidacticoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_MATERIAL_DIDACTICO';
    protected $table = 'capacitacion_materialdidactivo';
    protected $fillable = [
        'MATERIAL_DIDACTICO',
        'ACTIVO'
    ];
}
