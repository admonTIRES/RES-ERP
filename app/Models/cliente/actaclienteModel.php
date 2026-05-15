<?php

namespace App\Models\cliente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actaclienteModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID_ACTA_CLIENTE';
    protected $table = 'actaconstitutiva_cliente';
    protected $fillable = [
        'CLIENTE_ID',
        'ACTA_CONSTITUVA',
        'NUMERO_CONSTITUVA',
        'EVIDENCIA_CONSTITUVA',
        ];

}
