<?php

use core\Application;

class m0003_create_table_members
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE members (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_paste INT NOT NULL,
            id_user INT NOT NULL,
            CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE members;";
        $db->pdo->exec($SQL);
    }
}
