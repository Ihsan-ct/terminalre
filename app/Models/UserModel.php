<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];

    // Mendapatkan pengguna berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Menambahkan pengguna baru
    public function addUser($data)
    {
        // Menyimpan data pengguna baru ke database
        return $this->insert($data);
    }

    // Memperbarui pengguna berdasarkan ID
    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    // Menghapus pengguna berdasarkan ID
    public function deleteUser($id)
    {
        return $this->delete($id);
    }
}
