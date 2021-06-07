<?php

use core\Application;
use core\DataProvider;
?>

<script>
    function chartGenerator() {

        e1 = new Element(" Protected pastes", "#569944", "<?php echo DataProvider::numberOfProtectedPastes(Application::$app->user->id) ?>");
        e2 = new Element(" Public pastes", "#569944", "<?php echo DataProvider::numberOfPublicPastes(Application::$app->user->id) ?>");
        e3 = new Element(" Private pastes", "#569944", "<?php echo DataProvider::numberOfPrivatePastes(Application::$app->user->id) ?>");

        elementList = Array();
        elementList.push(e1);
        elementList.push(e2);
        elementList.push(e3);
        createChart(40, 40, elementList, 80, 68);
    }
</script>

<div class="source">
    <div class="main-container">

        <div class="welcome">
            <h1 itemprop="headline">Welcome</h1>
            <div class="line"></div>
            <p itemprop="description">
                Hi <?php echo Application::$app->user->getDisplayName() ?>, this is your personal PasteIt.
                Feel free to share this page with anyone you like.
            </p>
            <p itemprop="description">
                There are some sections that would help you to manage your profile
            </p>
            <p itemprop="description">
                Only you (when logged in) can see your protected, public and private pastes, and only you see the options to edit and delete.
            </p>
        </div>

        <h1 itemprop="headline">My pastes</h1>
        <div class="line"></div>

        <?php core\content\PastesInvolvementContent::begin() ?>
        <?php echo core\content\PastesInvolvementContent::generateContent() ?>
        <?php core\content\PastesInvolvementContent::end() ?>

        <script src="/scripts/deleteAJAX.js"> </script>

        <h1 itemprop="headline">My profile</h1>
        <div class="line"></div>



        <?php $form = core\form\FormAccount::begin('/account', "post") ?>

        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'password')->passwordField() ?>
        <?php echo $form->field($model, 'repeat')->passwordField() ?>



        <tr>
            <td> &nbsp; </td>
            <td><input type="submit" value="Save changes"></td>
        </tr>


        <div class="card">
            <img itemprop="image" src="./resources/fantoma.png" alt="avatar">
            <p itemprop="alternateName"> <?php echo Application::$app->user->getDisplayName() ?> </p>
            <p><?php echo Application::$app->user->email ?></p>
        </div>


        <?php core\form\FormAccount::end() ?>



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