<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function register()
    {
        return view('auth/register'); 
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

        // Generate user_id (2 huruf + 2 angka)
        $userModel = new UserModel();
        do {
            $randomUserId = strtoupper(chr(random_int(65, 90)) . chr(random_int(65, 90))) . random_int(10, 99);
        } while ($userModel->where('user_id', $randomUserId)->first());

        // Simpan data user
        $insertResult = $userModel->insert([
            'user_id'    => $randomUserId,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => $hashedPassword,
            'role'       => 2, // Default role
        ]);

        if (!$insertResult) {
            return redirect()->to('/login')->with('success', 'Akun berhasil didaftarkan!');
        }
    }

    public function login()
    {
        return view('auth/login'); 
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

        $userModel = new UserModel();
        $user = $userModel->where('email', $data['email'])->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar!');
        }

        // Verifikasi password
        if (!password_verify($data['password'], $user['password'])) {
            return redirect()->back()->with('error', 'Password salah!');
        }

        // Set session
        session()->set([
            'user_id'    => $user['user_id'],
            'first_name' => $user['first_name'],
            'last_name'  => $user['last_name'],
            'email'      => $user['email'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logout berhasil!');
    }
}
