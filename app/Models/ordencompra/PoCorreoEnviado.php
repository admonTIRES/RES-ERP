<?php

namespace App\Models\ordencompra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoCorreoEnviado extends Model
{
    use HasFactory;
    protected $table = 'po_correos_enviados';

    protected $fillable = [
        'po_id',
        'fecha_envio'
    ];

    
}
