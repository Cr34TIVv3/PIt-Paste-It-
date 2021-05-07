<?php

use core\Application;

class m0002_create_table_pastes {
  
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE pastes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_user INT,
            slug VARCHAR(50),
            expiration TIMESTAMP,
            content VARCHAR(1000) NOT NULL,
            password VARCHAR(255) NOT NULL, 
            title VARCHAR(100),
            burn_after_read boolean,
            highlight VARCHAR(20) NOT NULL,
            access_modifier VARCHAR(20) NOT NULL,
            CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UPDATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )ENGINE=INNODB;"; 
        $db->pdo->exec($SQL);
    } 

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE pastes;"; 
        $db->pdo->exec($SQL);
    }

}