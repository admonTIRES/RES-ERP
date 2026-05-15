<?php

namespace App\Models\organizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class areasLideresModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_AREA_LIDER';
    protected $table = 'areas_lideres';
    protected $fillable = [
        'AREA_ID',
        'LIDER_ID',
        'ACTIVO'
    ];
}
