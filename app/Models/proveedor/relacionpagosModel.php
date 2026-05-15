<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relacionpagosModel extends Model
{
    use HasFactory;
    protected $table = 'relacionpagosproveedores';
    protected $primaryKey = 'ID_RELACION_PAGOS';
    protected $fillable = [
    'JSON_RELACIONES',
    'FECHA_RELACION',
    'MONTO_MXN',
    'MONTO_USD'
    ];
}
