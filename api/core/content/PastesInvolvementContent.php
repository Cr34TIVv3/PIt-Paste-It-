<?php

namespace core\content;

use core\Application;

class PastesInvolvementContent
{


    public static function begin()
    {
        echo '
        <div class="my-pastes">
            <table itemscope itemtype="https://schema.org/Table">
                <tr>
                    <th>Titlu</th>
                    <th>Owner</th>
                    <th>Date</th>
                    <th>Expires</th>
                    <th>Syntax</th>
                    <th>Visibility</th>
                    <th> </th>
                    <th> </th>
                </tr>';
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

        $sql = 'SELECT * FROM (SELECT pastes.id_user, pastes.slug, pastes.title, pastes.expiration, pastes.highlight, pastes.access_modifier FROM members JOIN pastes ON members.id_paste = pastes.id WHERE members.id_user = '.$user_id.' AND pastes.expiration > CURRENT_TIMESTAMP) t JOIN users ON t.id_user = users.id;';
        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
      

        
        if($result != null)
        {
            
            foreach ($result as $record) {
                //loop over each $result (row), setting $key to the column name and $value to the value in the column.
              
                foreach ($record as $key => $value) {
    
                    if ($key == 'title') {
                        $title = $value;
                    }
                    if ($key == 'email') {
                        $owner = $value;
                    }
                    if ($key == 'CREATED_AT') {
                        $date = $value;   
                    }
                    if ($key == 'expiration') {
                        $date_expiration = $value;
                    }
                    if ($key == 'highlight') {
                        $highlight = $value;
                    }
                    if ($key == 'access_modifier') {
                        $access_modifier = $value;
                    }
                    if ($key == 'slug') {
                        $slug = $value;
                    }
                }
                // <td><a href="'.$slug.'"><i class="fas fa-search"></i></a></td>
                // <td><a href="'.$slug."/delete".'"><i class="fas fa-backspace"></i></a></td>
                $output .= sprintf(' 
                        <tr>
                               <td> %s </td>         
                               <td> %s </td>
                               <td> %s </td>
                               <td> %s </td>
                               <td> %s </td>         
                               <td> %s </td>
                               <td><a href="'.$slug.'"><i class="fas fa-search"></i></a></td>
                               <td><p class="deleteBtn" id="'.$slug."/delete".'"><i class="fas fa-backspace"></i></p></td>
                        </tr>
                    
                ', $title, $owner, $date, $date_expiration, $highlight,  $access_modifier);
            }
        }

        $user_id = Application::$app->session->get('user');
        
         

        ///why join
        $sql = 'SELECT * FROM pastes JOIN users ON pastes.id_user = users.id WHERE pastes.id_user = '.$user_id.' AND pastes.expiration > CURRENT_TIMESTAMP;';

        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $record) {
            //loop over each $result (row), setting $key to the column name and $value to the value in the column.

            foreach ($record as $key => $value) {
                
                if ($key == 'title') {
                    $title = $value;
                }
                if ($key == 'email') {
                    $owner = $value;
                }
                if ($key == 'CREATED_AT') {
                    $date = $value;   
                }
                if ($key == 'expiration') {
                    $date_expiration = $value;
                }
                if ($key == 'highlight') {
                    $highlight = $value;
                }
                if ($key == 'access_modifier') {
                    $access_modifier = $value;
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
                        <td> %s </td>         
                        <td> %s </td>
                        <td><a href="'.$slug.'"><i class="fas fa-search"></i></a></td>
                        <td><p class="deleteBtn" id="'.$slug."/delete".'"><i class="fas fa-backspace"></i></p></td>
                    </tr>
                
            ', $title, $owner, $date,  $date_expiration,  $highlight,  $access_modifier);
        }

        return $output;
    }
}
