<?php


namespace core\content;

use core\Application;
use DivisionByZeroError;

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


        $sql = 'SELECT * FROM pastes  JOIN users ON users.id = pastes.id_user WHERE PASTES.access_modifier=\'public\' AND pastes.expiration > CURRENT_TIMESTAMP ORDER BY pastes.CREATED_AT DESC LIMIT 10';

        $statement = Application::$app->db->pdo->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();


        foreach ($result as $record) {
            //loop over each $result (row), setting $key to the column name and $value to the value in the column.
            foreach ($record as $key => $value) {

                if ($key == 'slug') {
                    $slug = $value;
                }
                if ($key == 'username') {
                    $username = $value;
                }
                if ($key == 'title') {
                    $title = $value;
                }
                if ($key == 10) {
                    $date = $value;
                }
                if ($key == 'burn_after_read') {
                    $burn = $value;
                }
                if ($key == 5) {
                    $password = $value;
                }
            }


            $icons = '<div class = "features" >';
            if ($burn != null && $burn == true) {
                $icons .= ' <i class="fas fa-fire-alt"></i>';
            }
            if ($password != null) {
                $icons .= '<i class="fas fa-lock"></i>';
            }

            $icons .= ' </div>';
            $output .= sprintf(' 
                <a href="/%s">
                <div class="div-block">
                    <div class="paste-obj">
                        <div class="information" >
                            <h3> <span>Author:</span> %s</h3>
                            <p> <span>Title: </span> %s</p>
                            <p> <span>Date: </span> %s </p>
                        </div>
                        %s
                    </div>
                </div>
                </a>
            ', $slug, $username, $title, $date, $icons);
        }


        $sql = 'SELECT * FROM PASTES  WHERE PASTES.id_user is NULL AND pastes.expiration > CURRENT_TIMESTAMP ORDER BY pastes.CREATED_AT DESC LIMIT 10';

        $statement = Application::$app->db->pdo->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll();
        foreach ($result as $record) {
            //loop over each $result (row), setting $key to the column name and $value to the value in the column.
            foreach ($record as $key => $value) {

                if ($key == 'slug') {
                    $slug = $value;
                }
                if ($key == 'title') {
                    $title = $value;
                }
                if ($key == 10) {
                    $date = $value;
                }
            }
            $output .= sprintf(' 
                <a href="/%s">
                    <div class="div-block">
                        <div class="paste-obj">
                           <div class="information" >
                                <h3><span>Author:</span> (UNNAMED)</h3>
                                <p><span>Title:</span> %s </p>
                                <p><span>Date:</span> %s <p>
                            </div>
                        </div>


                        <div class="features">

                        </div>
                    </div>
                </a>
            ', $slug, $title, $date);
        }



        return $output;
    }
}
