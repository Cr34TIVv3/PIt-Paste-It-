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

    public static function numberOfPublicPastes($id = null)
    {
         
        if(isset($id)) {
            $sql = 'SELECT COUNT(*) as TOTAL FROM pastes WHERE id_user = '.$id.' AND access_modifier = \'public\'';
        }
        else {
            $sql = 'SELECT COUNT(*) as TOTAL FROM pastes WHERE access_modifier = \'public\'';
        }
        

        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject();
        return $result->TOTAL;

    }

    public static function numberOfPrivatePastes($id=null)
    {
        if(isset($id)) {
            $sql = 'SELECT COUNT(*) as TOTAL FROM pastes WHERE id_user = '.$id.' AND access_modifier = \'private\'';
        }
        else {
            $sql = 'SELECT COUNT(*) as TOTAL FROM pastes WHERE access_modifier = \'private\'';
        }

        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject();
        return $result->TOTAL;

    }

    public static function numberOfProtectedPastes($id=null)
    {
        if(isset($id)) {
            $sql = 'SELECT COUNT(*) as TOTAL FROM pastes WHERE id_user = '.$id.' AND password IS NOT NULL';
        }
        else {
            $sql = 'SELECT COUNT(*) as TOTAL FROM pastes WHERE password IS NOT NULL';
        }

        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject();
        return $result->TOTAL;

    }
    
    public static function getMembers($id_paste)
    {
        
        $output = '<ol>';
        //take the owner first 
        $sql = 'SELECT email FROM pastes JOIN users on users.id=pastes.id_user WHERE pastes.id = '.$id_paste .' ';
        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchObject();


            $output .= sprintf('<li>%s</li>', $result->email);

        /// then take the colaborators 

        $sql = 'SELECT * FROM ( SELECT *from members WHERE id_paste='.$id_paste.' ) t join users on t.id_user=users.id';
        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

    
        foreach ($result as $record) {
            foreach ($record as $key => $value) {
                if ($key == 'email') {
                    $email = $value;
                }
            }
            $output .= sprintf(' <li>%s</li> ', $email);
            
        }
        $output .= '</ol>';
        return $output;
        
    }
}
