<?php

namespace App\Controllers;

use App\Models\ClienteModel;

class ClienteController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('id_rol') != 1 && session()->get('id_rol') != 2) {
            return redirect()->to('/usuario_logueado');
        }

        $model = new ClienteModel();

        $data['clientes'] = $model->getClientesAll();

        return view('front/header')
             . view('front/navbar')
             . view('back/clientes/lista_clientes', $data)
             . view('front/footer');
    }

    public function editar($id)
    {
        if (session()->get('id_rol') != 1) {
            return redirect()->to('/usuario_logueado');
        }

        $model = new ClienteModel();

        $data['cliente'] = $model->find($id);

        return view('front/header')
             . view('front/navbar')
             . view('back/clientes/editar_clientes', $data)
             . view('front/footer');
    }

    public function actualizar($id)
    {
        if (session()->get('id_rol') != 1) {
            return redirect()->to('/usuario_logueado');
        }

        $model = new ClienteModel();

        $model->update($id, [
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email'    => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'dni'      => $this->request->getPost('dni')
        ]);

        session()->setFlashdata('success', 'Cliente modificado correctamente');
        return redirect()->to('/clientes');
    }

    public function baja($id)
    {
        if (session()->get('id_rol') != 1) {
            return redirect()->to('/usuario_logueado');
        }

        $model = new ClienteModel();
        $model->update($id, ['baja' => 'S']);

        session()->setFlashdata('success', 'Cliente dado de baja correctamente');
        return redirect()->to('/clientes');
    }

    public function alta($id)
    {
        if (session()->get('id_rol') != 1) {
            return redirect()->to('/usuario_logueado');
        }

        $model = new ClienteModel();
        $model->update($id, ['baja' => 'N']);

        session()->setFlashdata('success', 'Cliente activado correctamente');
        return redirect()->to('/clientes');
    }
}