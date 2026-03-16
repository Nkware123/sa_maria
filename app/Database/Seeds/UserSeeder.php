<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user_object = new UserModel();

        $user_object->insertBatch([
            [
                "Nom" => "Arnaud BIKORIMANA",
                "email" => "arnaud@gmail.com",
                "phone_no" => "61001462",
                "level" => "admin",
                "password" => password_hash("12345678", PASSWORD_DEFAULT)
            ],
            [
                "name" => "Leonce NGENDAKUMANA",
                "email" => "leonce@gmail.com",
                "phone_no" => "61683315",
                "level" => "assistant",
                "password" => password_hash("12345678", PASSWORD_DEFAULT)
            ]
        ]);
    }
}
