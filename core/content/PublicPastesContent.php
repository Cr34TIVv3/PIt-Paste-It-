<?php


namespace core\content;

use core\Application;

class PublicPastesContent
{


    public static function begin()
    {
        echo '
        <h1 itemprop="name">Public posts</h1>
        <div class="line"></div>
        <div class="public-pastes">';
    }

    public static function end()
    {
        echo '</div>';
    }

    public static function generateContent()
    {
        $output = '';
 
        /// show public posts from logged in users 


        $sql = 'SELECT * FROM PASTES  JOIN users ON users.id = pastes.id_user WHERE PASTES.access_modifier=\'public\' ORDER BY pastes.CREATED_AT DESC LIMIT 10';

        $statement = Application::$app->db->pdo->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();
        foreach ($result as $record) {
            //loop over each $result (row), setting $key to the column name and $value to the value in the column.
            foreach ($record as $key => $value) {
                 
                if($key == 'slug')
                { 
                    $slug = $value;
                }
                if ($key == 'username') {
                    $username = $value;
                }
                if ($key == 'title') {
                    $title = $value;
                }
            }
            $output .= sprintf(' 
                <a href="/%s">
                <div class="paste-obj">
                    <h3>%s</h3>
                    <p>%s</p>
                </div>
                </a>
            ', $slug, $username, $title);
        }


        $sql = 'SELECT * FROM PASTES  WHERE PASTES.id_user is NULL ORDER BY pastes.CREATED_AT DESC LIMIT 10';

        $statement = Application::$app->db->pdo->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();
        foreach ($result as $record) {
            //loop over each $result (row), setting $key to the column name and $value to the value in the column.
            foreach ($record as $key => $value) {
                 
                if($key == 'slug')
                { 
                    $slug = $value;
                }
                if ($key == 'title') {
                    $title = $value;
                }
            }
            $output .= sprintf(' 
                <a href="/%s">
                <div class="paste-obj">
                    <h3>(UNNAMED)</h3>
                    <p>%s</p>
                </div>
                </a>
            ', $slug, $title);
        }



        return $output;
    }
}
