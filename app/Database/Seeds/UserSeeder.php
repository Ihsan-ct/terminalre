<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'role' => 'admin'
            ],
            [
                'username' => 'user1',
                'password' => password_hash('user1', PASSWORD_DEFAULT),
                'role' => 'user'
            ],
            [
                'username' => 'user2',
                'password' => password_hash('user2', PASSWORD_DEFAULT),
                'role' => 'user'
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
