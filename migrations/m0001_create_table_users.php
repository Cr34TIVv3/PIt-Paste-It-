<?php

use core\Application;

class m0001_create_table_users {
  
    public function up()
    {
        echo "sunt aici";
        $db = Application::$app->db;
        $SQL = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL, 
            status TINYINT NOT NULL,
            CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )ENGINE=INNODB;"; 
        $db->pdo->exec($SQL);
    } 

    public function down()
    {
        echo "aha";
    }

}