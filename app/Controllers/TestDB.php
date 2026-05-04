<?php

namespace App\Controllers;

class TestDB extends BaseController
{
    public function index()
{
    try {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT 1 AS prueba");
        $row = $query->getRow();

        echo "Conectado a SQL Server. Prueba: " . $row->prueba;

    } catch (\Throwable $e) {
        echo "<pre>";
        echo $e->getMessage();
        echo "</pre>";
    }
}
}