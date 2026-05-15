<?php

namespace App\Models\usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolesModel extends Model
{
    protected $primaryKey = 'ID_ROL';
    protected $table = 'asignar_rol';
    protected $fillable = [
        'USUARIO_ID',
        'NOMBRE_ROL',
        'ACTIVO'
    ];

    public function usuario()
    {
        return $this->belongsTo(usuarioModel::class, 'USUARIO_ID', 'ID_USUARIO');
    }


}    

