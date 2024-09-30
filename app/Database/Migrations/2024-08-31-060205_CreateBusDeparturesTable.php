<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusDeparturesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11, // Anda dapat menyesuaikan panjangnya
            ],
            'bus_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'departure_time' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'number_of_passengers' => [
                'type' => 'INT',
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('bus_id', 'buses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bus_departures');
    }

    public function down()
    {
        $this->forge->dropTable('bus_departures');
    }
}
