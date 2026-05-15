<?php

namespace App\Models\contratacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reingresocontratoModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_REINGRESO_CONTRATACION';
    protected $table = 'reingreso_contratacion';
    protected $fillable = [
        'CURP',
        'FECHA_REINGRESO',
        'ACTIVO'
    ];}
