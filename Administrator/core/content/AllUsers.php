<?php

namespace core\content;

use core\Application;

class AllUsers
{
    public static function begin()
    {
        echo '
        <h1 itemprop="name">Here are all users from application:</h1>
        <div class="line"></div>
        <div class="my-pastes">
        <table itemscope itemtype="https://schema.org/Table">
               <tr>
                   <th>Id</th>
                   <th>Username</th>
                   <th>Email</th>
                   <th>Created at</th>
                   <th> </th>
               </tr> ';
    }

    public static function end()
    {
        echo  '</table>
            </div> ';
    }

    public static function generateContent()
    {

        $output = '';
        // $user_id = Application::$app->session->get('user');
        $sql = 'SELECT * FROM users';
        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $record) {

            foreach ($record as $key => $value) {
                if ($key == 'id') {
                    $id = $value;
                }
                if ($key == 'username') {
                    $name = $value;
                }
                if ($key == 'email') {
                    $email = $value;
                }
                if ($key == 'CREATED_AT') {
                    $date = $value;
                }
            }

            $output .= sprintf(' 
                    <tr>
                            <td> %s </td>         
                            <td> %s </td>
                            <td> %s </td>
                            <td> %s </td>
                            <td><p class="deleteBtn" id="' . $id . "/delete" . '"><i class="fas fa-backspace"></i></p></td>
                    </tr>
                
            ',$id, $name, $email, $date);
        }

        return $output;
    }
}
