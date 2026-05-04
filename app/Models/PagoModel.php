<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'Pago';
    protected $primaryKey = 'id_pago';

    protected $allowedFields = [
        'fecha_pago',
        'monto',
        'id_medio_pago',
        'id_persona',
        'id_mensualidad',
        'id_sistema',
        'cobrado_por'
    ];

    public function getPagosAll()
    {
        return $this->select('
                Pago.id_pago,
                Pago.fecha_pago,
                Pago.monto,
                Medio_pago.descripcion AS medio_pago,
                Datos_personales.nombre,
                Datos_personales.apellido,
                Sistema.nombre_sistema,
                Usuario.nombre_usuario AS cobrado_por
            ')
            ->join('Medio_pago', 'Medio_pago.id_medio_pago = Pago.id_medio_pago')
            ->join('Datos_personales', 'Datos_personales.id_persona = Pago.id_persona')
            ->join('Sistema', 'Sistema.id_sistema = Pago.id_sistema')
            ->join('Usuario', 'Usuario.id_usuario = Pago.cobrado_por')
            ->findAll();
    }

    public function getPagosCliente($idPersona)
    {
        return $this->select('
                Pago.id_pago,
                Pago.fecha_pago,
                Pago.monto,
                Medio_pago.descripcion AS medio_pago,
                Sistema.nombre_sistema
            ')
            ->join('Medio_pago', 'Medio_pago.id_medio_pago = Pago.id_medio_pago')
            ->join('Sistema', 'Sistema.id_sistema = Pago.id_sistema')
            ->where('Pago.id_persona', $idPersona)
            ->findAll();
    }
}