<?php

namespace App\Models;

use CodeIgniter\Model;

class PerfilModel extends Model
{
    protected $table = 'perfiles';
    protected $primaryKey = 'id_perfil';

    protected $allowedFields = [
        'descripcion'
    ];
}