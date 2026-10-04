<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FourBeansSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Seed staff users if empty
        if ($this->db->table('users')->countAllResults() === 0) {
            $this->db->table('users')->insertBatch([
                [
                    'username'   => 'amiel',
                    'full_name'  => 'Amiel Azucena',
                    'password'   => password_hash('amiel123', PASSWORD_DEFAULT),
                    'avatar'     => null,
                    'created_at' => $now,
                ],
                [
                    'username'   => 'jefferson',
                    'full_name'  => 'Jefferson Tan',
                    'password'   => password_hash('jefferson123', PASSWORD_DEFAULT),
                    'avatar'     => null,
                    'created_at' => $now,
                ],
                [
                    'username'   => 'andrei',
                    'full_name'  => 'Andrei Klein Serrano',
                    'password'   => password_hash('andrei123', PASSWORD_DEFAULT),
                    'avatar'     => null,
                    'created_at' => $now,
                ],
                [
                    'username'   => 'ann',
                    'full_name'  => 'Ann Valerie Camacho',
                    'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                    'avatar'     => null,
                    'created_at' => $now,
                ],
            ]);
        }

        // Seed sample products if empty
        if ($this->db->table('products')->countAllResults() === 0) {
            $this->db->table('products')->insertBatch([
                ['name' => 'Four Beans Signature Latte', 'price' => 185.00, 'stock_quantity' => 24, 'image' => null, 'created_at' => $now],
                ['name' => 'Iced Caramel Macchiato',     'price' => 195.00, 'stock_quantity' => 18, 'image' => null, 'created_at' => $now],
                ['name' => 'Cappuccino',                  'price' => 180.00, 'stock_quantity' => 30, 'image' => null, 'created_at' => $now],
                ['name' => 'Matcha Latte',                'price' => 190.00, 'stock_quantity' => 12, 'image' => null, 'created_at' => $now],
                ['name' => 'Butter Croissant',            'price' => 110.00, 'stock_quantity' => 6,  'image' => null, 'created_at' => $now],
                ['name' => 'Blueberry Cheesecake',        'price' => 220.00, 'stock_quantity' => 8,  'image' => null, 'created_at' => $now],
            ]);
        }

        // Seed sample customers if empty
        if ($this->db->table('customers')->countAllResults() === 0) {
            $this->db->table('customers')->insertBatch([
                ['full_name' => 'Maria Santos', 'email' => 'maria.santos@email.com', 'phone' => '+63 912 345 6789', 'created_at' => $now],
                ['full_name' => 'Enzo Reyes',   'email' => 'enzo.reyes@email.com',   'phone' => '+63 917 890 1234', 'created_at' => $now],
                ['full_name' => 'Anna Cruz',    'email' => 'anna.cruz@email.com',    'phone' => '+63 923 456 7890', 'created_at' => $now],
            ]);
        }
    }
}
