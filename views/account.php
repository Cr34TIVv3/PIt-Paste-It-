<?php

use core\Application;
?>
<div class="source">
    <div class="main-container">

        <div class="welcome">
            <h1 itemprop="headline">Welcome</h1>
            <div class="line"></div>
            <p itemprop="description">
                Hi <?php echo Application::$app->user->getDisplayName() ?>, this is your personal Pastebin.
                Feel free to share this page with anyone you like.
            </p>
            <p itemprop="description">
                There are some sections that would help you to manage your profile
            </p>
            <p itemprop="description">
                Only you (when logged in) can see your folders,
                unlisted and private pastes, and only you see the options to edit and delete.
            </p>
        </div>

        <h1 itemprop="headline">My pastes</h1>
        <div class="line"></div>

        <?php core\content\PastesInvolvementContent::begin() ?>
        <?php echo core\content\PastesInvolvementContent::generateContent() ?>
        <?php core\content\PastesInvolvementContent::end() ?>


        <!-- <div class="my-pastes">
            <table itemscope itemtype="https://schema.org/Table">
                <tr>
                    <th>Titlu</th>
                    <th>Date</th>
                    <th>Expires</th>
                    <th>Syntax</th>
                    <th>Visibility</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>Tuxy</td>
                    <td>21.02.2019</td>
                    <td>Never</td>
                    <td>Java</td>
                    <td>Private</td>
                    <td title="Edit paste"><i class="fas fa-pen"></i></td>
                    <td title="Delete paste"><i class="fas fa-times"></i></td>
                </tr>
                <tr>
                    <td>Pinguinescu</td>
                    <td>21.01.2020</td>
                    <td>Never</td>
                    <td>C++</td>
                    <td>Public</td>
                    <td title="Edit paste"><i class="fas fa-pen"></i></td>
                    <td title="Delete paste"><i class="fas fa-times"></i></td>
                </tr>
                <tr>
                    <td>Pinguin</td>
                    <td>21.01.2020</td>
                    <td>Never</td>
                    <td>C++</td>
                    <td>Public</td>
                    <td title="Edit paste"><i class="fas fa-pen"></i></td>
                    <td title="Delete paste"><i class="fas fa-times"></i></td>
                </tr>
            </table>
        </div> -->
        <!--div for my-pastes!-->



        <h1 itemprop="headline">My profile</h1>
        <div class="line"></div>

        <div class="yourProfile">
            <table class="informationAccount" itemscope itemtype="https://schema.org/Table">
                <tr>
                    <th><label id="username">Change username:</label></th>
                    <td><input type="text"></td>
                </tr>
                <tr>
                    <th><label id="email">Change email:</label></th>
                    <td><input type="text"></td>
                </tr>
                <tr>
                    <th><label id="password">Change password:</label></th>
                    <td><input type="password"></td>
                </tr>
                <tr>
                    <th><label id="conf-password">Confirm password:</label></th>
                    <td><input type="password"></td>
                </tr>
                <tr>
                    <td> &nbsp; </td>
                    <td><input type="submit" value="Save changes"></td>
                </tr>
            </table>


            <div class="card">
                <img itemprop="image" src="./resources/fantoma.png" alt="avatar">
                <p itemprop="alternateName">iustin2000</p>
                <p>iustinian.petrariu@gmail.com</p>
            </div>
        </div>


        <h1 itemprop="headline">Statistics</h1>
        <div class="line"></div>

        <div itemprop="interactionStatistic" class="statistics">
            <canvas id="myCanvas" width="500" height="500"></canvas>
        </div>

        <div class="log-out">
            <button onclick="location.href='/logout'"> Log out </button>
        </div>

    </div>
</div>

</div>