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
        
        $output = '';

        $user_id = Application::$app->session->get('user');


        $sql = 'SELECT * FROM pastes p JOIN versions v ON p.id=v.id JOIN users u ON v.id_user=u.id WHERE p.id =' . $record->id;

        $statement = Application::$app->db->pdo->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();


        // var_dump($result);
        
        foreach ($result as $record) {

            foreach ($record as $key => $value) {

                if ($key == 'title') {
                    $title = $value;
                }
                if ($key == 10) {
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
                           <td><a href="%s"><i class="fas fa-search"></i></a></td>
            ', $user, $email, $title, $date, $slug);
            
           
            if(Application::$app->isMember($record[0] ) || Application::$app->isOwner($record['id_user']) )
            {
                $output .= '
                           <td><p class="delteBtn" id="'.$slug.'/delete"><i class="fas fa-backspace"></i></p></td>
                             </tr>  ' ; 
            }
            else 
            {
                $output .= '</tr>';
            
            }
        }
        

        return $output;
    }
}
