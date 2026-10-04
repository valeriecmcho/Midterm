<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFourBeansTables extends Migration
{
    public function up()
    {
        // Products table
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'price'          => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false],
            'stock_quantity' => ['type' => 'INT', 'null' => false, 'default' => 0],
            'image'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('products', true);

        // Customers table
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'full_name'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('customers', true);

        // Users table
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'full_name'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'avatar'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users', true);

        // Sales table
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'product_id'  => ['type' => 'INT', 'null' => false],
            'customer_id' => ['type' => 'INT', 'null' => true],
            'sold_by'     => ['type' => 'INT', 'null' => false],
            'quantity'    => ['type' => 'INT', 'null' => false],
            'total_price' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false],
            'created_at'  => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('product_id', 'products', 'id');
        $this->forge->addForeignKey('customer_id', 'customers', 'id');
        $this->forge->addForeignKey('sold_by', 'users', 'id');
        $this->forge->createTable('sales', true);
    }

    public function down()
    {
        $this->forge->dropTable('sales', true);
        $this->forge->dropTable('products', true);
        $this->forge->dropTable('customers', true);
        $this->forge->dropTable('users', true);
    }
}
