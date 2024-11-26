<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function register()
    {
        return view('auth/register'); // Render halaman register
    }

    public function submitRegister()
    {
        $data = $this->request->getPost();

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        // Simpan data ke database
        $userModel = new UserModel();
        $userModel->save([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => $hashedPassword,
            'role'       => 2, // Default role sebagai User
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Akun berhasil didaftarkan!');
    }

    public function login()
    {
        return view('auth/login'); // Render halaman login
    }

    public function submitLogin()
    {
        $data = $this->request->getPost();

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        // Periksa email di database
        $userModel = new UserModel();
        $user = $userModel->where('email', $data['email'])->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar!');
        }

        // Periksa password
        if (!password_verify($data['password'], $user['password'])) {
            return redirect()->back()->with('error', 'Password salah!');
        }

        // Simpan data user ke session
        session()->set([
            'user_id' => $user['user_id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ]);

        // Redirect ke dashboard
        return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
    }

    public function logout()
    {
        // Hapus semua data session
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logout berhasil!');
    }
}
