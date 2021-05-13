<?php

namespace core\content;

use core\Application;

class VersionPastesContent
{


    public static function begin()
    {
        echo '
        <h1 itemprop="name">See other versions:</h1>
        <div class="line"></div>
        <div class="my-pastes">
        <table itemscope itemtype="https://schema.org/Table">
                <tr>
                    <th> Made by </th>
                    <th> Having email </th>
                    <th> Title   </th>
                    <th> Date    </th>
                    <th></th>
                    <th></th>
                </tr> ';
    }

    public static function end()
    {
        echo  '</table>
            </div> ';
    }

    public static function generateContent($record)
    {
        //TODO
        $output = '';

        $user_id = Application::$app->session->get('user');


        $sql = 'SELECT * FROM pastes p JOIN versions v ON p.id=v.id JOIN users u ON v.id_user=u.id WHERE p.id =' . $record->id;

        $statement = Application::$app->db->pdo->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();



        foreach ($result as $record) {
            //loop over each $result (row), setting $key to the column name and $value to the value in the column.
            // echo "<pre>";
            // var_dump($record);
            // echo "</pre>";
            // exit;

            foreach ($record as $key => $value) {

                if ($key == 'title') {
                    $title = $value;
                }
                if ($key == 'CREATED_AT') {
                    $date = $value;
                }
                if ($key == 'username') {
                    $user = $value;
                }
                if ($key == 'email') {
                    $email = $value;
                }
                if ($key == 'slug') {
                    $slug = $value;
                }
            }

            $output .= sprintf(' 
                    <tr>
                           <td> %s </td>
                           <td> %s </td>     
                           <td> %s </td>
                           <td> %s </td>
                           <td><a href="'.$slug.'"><i class="fas fa-search"></i></a></td>
                           <td><a href="'.$slug."/delete".'"><i class="fas fa-backspace"></i></a></td>
                    </tr>
                
            ', $user, $email, $title, $date, $slug);
        }



        return $output;
    }
}
