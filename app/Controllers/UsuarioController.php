<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    public function login(): string
    {
        helper(['form', 'url']);

        return view('front/header')
             . view('front/navbar')
             . view('back/usuario/login')
             . view('front/footer');
    }

    public function auth()
    {
        $session = session();
        $model = new UsuarioModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('pass');

        $data = $model->where('email', $email)->first();

        if ($data) {
            if ($data['baja'] === 'SI') {
                $session->setFlashdata('msg', 'Usuario dado de baja');
                return redirect()->to('/login');
            }

            $verifyPass = password_verify($password, $data['pass']);

            if ($verifyPass) {
                $sessionData = [
                    'id_usuario' => $data['id_usuario'],
                    'nombre'     => $data['nombre'],
                    'apellido'   => $data['apellido'],
                    'email'      => $data['email'],
                    'usuario'    => $data['usuario'],
                    'perfil_id'  => $data['perfil_id'],
                    'logged_in'  => true
                ];

                $session->set($sessionData);

                return redirect()->to('/usuario_logueado');
            } else {
                $session->setFlashdata('msg', 'Contraseña incorrecta');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'No existe el correo o es incorrecto');
            return redirect()->to('/login');
        }
    }

    public function registro(): string
    {
        helper(['form', 'url']);

        return view('front/header')
             . view('front/navbar')
             . view('back/usuario/registro')
             . view('front/footer');
    }

    public function guardarRegistro()
    {
        helper(['form', 'url']);

        $validationRules = [
            'nombre'   => 'required|min_length[3]',
            'apellido' => 'required|min_length[3]|max_length[50]',
            'usuario'  => 'required|min_length[3]',
            'email'    => 'required|min_length[4]|max_length[100]|valid_email|is_unique[usuarios.email]',
            'pass'     => 'required|min_length[6]|max_length[50]'
        ];

        $validationMessages = [
            'nombre' => [
                'required' => 'El campo nombre es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.'
            ],
            'apellido' => [
                'required' => 'El campo apellido es obligatorio.',
                'min_length' => 'El apellido debe tener al menos 3 caracteres.'
            ],
            'usuario' => [
                'required' => 'El campo usuario es obligatorio.',
                'min_length' => 'El usuario debe tener al menos 3 caracteres.'
            ],
            'email' => [
                'required' => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Debe ingresar un correo válido.',
                'is_unique' => 'Este correo ya está registrado.'
            ],
            'pass' => [
                'required' => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 6 caracteres.'
            ]
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return view('front/header')
                 . view('front/navbar')
                 . view('back/usuario/registro', [
                     'validation' => $this->validator
                 ])
                 . view('front/footer');
        }

        $model = new UsuarioModel();

        $model->save([
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'usuario'   => $this->request->getPost('usuario'),
            'email'     => $this->request->getPost('email'),
            'pass'      => password_hash($this->request->getPost('pass'), PASSWORD_DEFAULT),
            'perfil_id' => 2,
            'baja'      => 'NO'
        ]);

        session()->setFlashdata('success', 'Usuario registrado con éxito');
        return redirect()->to('/login');
    }

    public function usuarioLogueado(): string
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('front/header')
             . view('front/navbar')
             . view('back/usuario/usuario_logueado')
             . view('front/footer');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}