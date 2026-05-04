<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'Usuario';
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = [
        'nombre_usuario',
        'contraseña',
        'id_rol',
        'id_persona',
        'baja'
    ];

    public function getUsuariosAll()
    {
        return $this->select('
                Usuario.id_usuario,
                Usuario.nombre_usuario,
                Usuario.contraseña,
                Usuario.id_rol,
                Usuario.id_persona,
                Usuario.baja,
                Rol.descripcion AS rol,
                Datos_personales.nombre,
                Datos_personales.apellido,
                Datos_personales.email,
                Datos_personales.telefono,
                Datos_personales.dni
            ')
            ->join('Rol', 'Rol.id_rol = Usuario.id_rol')
            ->join('Datos_personales', 'Datos_personales.id_persona = Usuario.id_persona')
            ->findAll();
    }

    public function getUsuarioCompleto($id)
    {
        return $this->select('
                Usuario.id_usuario,
                Usuario.nombre_usuario,
                Usuario.contraseña,
                Usuario.id_rol,
                Usuario.id_persona,
                Usuario.baja,
                Rol.descripcion AS rol,
                Datos_personales.nombre,
                Datos_personales.apellido,
                Datos_personales.email,
                Datos_personales.telefono,
                Datos_personales.dni
            ')
            ->join('Rol', 'Rol.id_rol = Usuario.id_rol')
            ->join('Datos_personales', 'Datos_personales.id_persona = Usuario.id_persona')
            ->where('Usuario.id_usuario', $id)
            ->first();
    }

    public function getUsuarioPorEmail($email)
    {
        return $this->select('
                Usuario.id_usuario,
                Usuario.nombre_usuario,
                Usuario.contraseña,
                Usuario.id_rol,
                Usuario.id_persona,
                Usuario.baja,
                Rol.descripcion AS rol,
                Datos_personales.nombre,
                Datos_personales.apellido,
                Datos_personales.email,
                Datos_personales.telefono,
                Datos_personales.dni
            ')
            ->join('Rol', 'Rol.id_rol = Usuario.id_rol')
            ->join('Datos_personales', 'Datos_personales.id_persona = Usuario.id_persona')
            ->where('Datos_personales.email', $email)
            ->first();
    }
}