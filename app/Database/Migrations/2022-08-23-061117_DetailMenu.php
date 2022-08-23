<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'culinary_place_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'unique' => TRUE,
            ],
            'menu_id' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'unique' => TRUE,
            ],
        ]);

        $this->forge->addKey('culinary_place_id', TRUE);
        $this->forge->addKey('menu_id', TRUE);
        $this->forge->addForeignKey('culinary_place_id', 'culinary_place', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('menu_id', 'menu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_menu');
    }

    public function down()
    {
        $this->forge->dropTable('detail_menu');
    }
}
