<?php

namespace core\content;

use core\Application;

class InternalPastesContent
{


    public static function begin()
    {
        echo '
        <h1 itemprop="name">My recent pastes:</h1>
        <div class="line"></div>
        <div class="my-pastes">
        <table itemscope itemtype="https://schema.org/Table">
               <tr>
                   <th>Title</th>
                   <th>Date</th>
                   <th>Expires</th>
                   <th>Syntax</th>
                   <th>Visibility</th>
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

        $user_id = Application::$app->session->get('user');


        $sql = 'SELECT * FROM PASTES where id_user =' . $user_id . ' ORDER BY pastes.CREATED_AT DESC LIMIT 10';

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
                if ($key == 'expiration') {
                    $expiration_date = $value;
                    
                }
                if ($key == 'highlight') {
                    $syntax = $value;
                }
                if ($key == 'access_modifier') {
                    $access_modifier = $value;
                }
            }

            $output .= sprintf(' 
                    <tr>
                           <td> %s </td>         
                           <td> %s </td>
                           <td> %s </td>
                           <td> %s </td>
                           <td> %s </td>
                    </tr>
                
            ', $title, $date, $expiration_date, $syntax,  $access_modifier);
        }



        return $output;
    }
}
