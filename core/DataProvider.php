<?php 
namespace core;


class DataProvider{

    public static function numberOfUsers()
    {
        $sql = 'SELECT COUNT(*) as TOTAL FROM users';
        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject();

        return $result->TOTAL;


    }
    public static function numberOfPastes()
    {
        
        $sql = 'SELECT COUNT(*) as TOTAL FROM pastes';
        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject();
        return $result->TOTAL;

    }





}