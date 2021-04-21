<?php
namespace core;


class Database 
{
    public \PDO $pdo;
    public function __construct($dsn, $user, $password)
    {   
        
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    }
}  