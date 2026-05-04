<?php

namespace App\Models;

use CodeIgniter\Model;

class SistemaModel extends Model
{
    protected $table = 'Sistema';
    protected $primaryKey = 'id_sistema';

    protected $allowedFields = [
        'nombre_sistema',
        'baja'
    ];
}