<?php

namespace App\Models\usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class usuarioModel extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'ID_USUARIO';

    protected $fillable = [
        'USUARIO_TIPO',
        'EMPLEADO_NOMBRE',
        'EMPLEADO_APELLIDOPATERNO',
        'EMPLEADO_APELLIDOMATERNO',
        'CURP',
        'FOTO_USUARIO',
        'EMPLEADO_DIRECCION',
        'EMPLEADO_CARGO',
        'EMPLEADO_TELEFONO',
        'EMPLEADO_FECHANACIMIENTO',
        'EMPLEADO_CORREO',
        'PASSWORD',
        'PASSWORD_2',
        'NOMBRE_COMERCIAL_PROVEEDOR',
        'RFC_PROVEEDOR',
        'ACTIVO',
    ];

    // Campos ocultos al serializar el modelo
    protected $hidden = [
        // 'PASSWORD',
        // 'PASSWORD_2',
        'remember_token',
    ];

    // Nombre del token de "remember me"
    protected $rememberTokenName = 'remember_token';

    /**
     * Devuelve el atributo utilizado para la autenticación
     */
    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

    /**
     * Relación con el modelo rolesModel
     * Un usuario puede tener varios roles
     */
    public function roles()
    {
        return $this->hasMany(rolesModel::class, 'USUARIO_ID', 'ID_USUARIO');
    }

    /**
     * Verifica si el usuario tiene un rol específico
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('NOMBRE_ROL', $role)->exists();
    }

    /**
     * Verifica si el usuario tiene alguno de los roles especificados
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('NOMBRE_ROL', $roles)->exists();
    }

    /**
     * Verifica si el usuario tiene todos los roles especificados
     */
    public function hasAllRoles(array $roles): bool
    {
        $roleCount = $this->roles()->whereIn('NOMBRE_ROL', $roles)->count();
        return $roleCount === count($roles);
    }

    /**
     * Alias para verificar múltiples roles usando hasAnyRole
     */
    public function hasRoles(array $roles): bool
    {
        return $this->hasAnyRole($roles);
    }


 

}
