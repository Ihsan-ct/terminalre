<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function list()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll(); // Mengambil semua data pengguna

        return view('user_list', $data); // Menampilkan view user_list.php dengan data pengguna
    }

    // Menampilkan halaman profil pengguna
    public function profile()
    {
        $session = session();
        $model = new UserModel();
        $username = $session->get('username');

        // Memeriksa apakah username ada di session
        if (!$username) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Mengambil data pengguna berdasarkan username
        $data['user'] = $model->getUserByUsername($username);

        // Memeriksa apakah pengguna ditemukan
        if (!$data['user']) {
            throw new PageNotFoundException("Pengguna dengan username $username tidak ditemukan.");
        }

        // Menampilkan halaman profil pengguna
        return view('user_profile', $data);
    }

    // Memperbarui profil pengguna
    public function update()
    {
        $session = session();
        $username = $session->get('username');

        // Memeriksa apakah pengguna sudah login
        if (!$username) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input password
        $rules = [
            'password' => 'required|min_length[8]',
        ];

        // Memeriksa apakah input valid
        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $data = [
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        // Memeriksa apakah pengguna dengan username tersebut ada
        if (!$model->getUserByUsername($username)) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        // Memperbarui data pengguna
        $user = $model->getUserByUsername($username);
        $model->update($user['id'], $data);

        // Mengarahkan kembali ke halaman profil dengan pesan sukses
        return redirect()->to('/user/profile')->with('message', 'Profil berhasil diperbarui.');
    }

    // Menampilkan form tambah pengguna
    public function create()
    {
        return view('user_create');
    }

    // Menyimpan pengguna baru
    public function store()
    {
        $model = new UserModel();

        $rules = [
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[8]',
            'role'     => 'required|in_list[admin,user]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ];

        if (!$model->save($data)) {
            log_message('error', 'Failed to save user data: ' . $model->errors());
        }

        return redirect()->to('/admin/users')->with('message', 'Pengguna berhasil ditambahkan.');
    }


    // Menampilkan form edit pengguna
    public function edit($id)
    {
        $model = new UserModel();
        $data['user'] = $model->find($id);

        if (!$data['user']) {
            throw new PageNotFoundException("Pengguna dengan ID $id tidak ditemukan.");
        }

        return view('user_edit', $data);
    }


    // Memperbarui pengguna
    public function updateUser($id)
    {
        $model = new UserModel();

        // Validasi input
        $rules = [
            'username' => 'required',
            'role'     => 'required|in_list[admin,user]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
        ];

        $model->update($id, $data);

        return redirect()->to('/admin/list')->with('message', 'Pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna
    public function delete($id)
    {
        $model = new UserModel();

        if (!$model->find($id)) {
            throw new PageNotFoundException("Pengguna dengan ID $id tidak ditemukan.");
        }

        $model->delete($id);

        return redirect()->to('/admin/users')->with('message', 'Pengguna berhasil dihapus.');
    }
}
