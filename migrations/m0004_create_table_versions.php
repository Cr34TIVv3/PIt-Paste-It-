<?php

use core\Application;

class m0004_create_table_versions
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE versions (
            id INT NOT NULL,
            id_user INT NOT NULL,
            title VARCHAR(50),
            slug VARCHAR(50) PRIMARY KEY,
            content VARCHAR(1000) NOT NULL,
            CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE versions;";
        $db->pdo->exec($SQL);
    }
}
