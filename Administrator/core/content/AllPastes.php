<?php

namespace core\content;

use core\Application;

class AllPastes
{
    public static function begin()
    {
        echo '
        <h1 itemprop="name">Here are all the pastes from application:</h1>
        <div class="line"></div>
        <div class="my-pastes">
        <table itemscope itemtype="https://schema.org/Table">
               <tr>
                   <th>Id</th>
                   <th>Slug</th>
                   <th>Title</th>
                   <th>Date</th>
                   <th>Expires</th>
                   <th>Syntax</th>
                   <th>Visibility</th>
                   <th>Updated at</th>
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
        $sql = 'SELECT * FROM PASTES';
        $statement = Application::$app->db->pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $record) {

            foreach ($record as $key => $value) {
                if ($key == 'id') {
                    $id = $value;
                }
                if ($key == 'slug') {
                    $slug = $value;
                }
                if ($key == 'UPDATED_AT') {
                    $updated_date = $value;
                }
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
                            <td> %s </td>
                            <td> %s </td>
                            <td> %s </td>
                            <td><p class="deleteBtn" id="' . $slug . "/delete" . '"><i class="fas fa-backspace"></i></p></td>
                    </tr>
                
            ',$id, $slug, $title, $date, $expiration_date, $syntax,  $access_modifier, $updated_date);
        }

        return $output;
    }
}
