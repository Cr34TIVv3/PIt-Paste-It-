<?php

use core\Application;
use core\Captcha;
?>


<div class="source">
    <div class="main-container">

        <?php $form = core\form\FormHome::begin('/home', "post") ?>

        <?php echo $form->field($model, '', '')->getTextArea() ?>

        <?php echo $form->field($model, 'highlight', 'Syntax highlight:')->getSelector(["None", "C++", "SQL", "XML"]) ?>

        <?php echo $form->field($model, 'title', 'Paste Name/Title:')->getInput(True) ?>

        <?php if (Application::isGuest()) : ?>

            <?php echo $form->field($model, 'captcha_challenge', '')->getCaptcha() ?>

        <?php else : ?>

            <?php echo $form->field($model, 'expiration', 'Paste expiration:')->getSelector(["1 days", "7 days", "14 days"]) ?>

            <?php echo $form->field($model, 'access_modifier', 'Paste Exposure:')->getSelector(["Public", "Private"]) ?>

            <?php echo $form->field($model, 'password', 'Password (optional):')->passwordField()->getInput() ?>

            <?php echo $form->field($model, 'burn_after_read', 'Burn After Read (Optional):')->getCheckBox() ?>

        <?php endif; ?>


        <div class="field">
            <input type="submit" value="Create New Paste">
        </div>
        <?php core\form\FormHome::end() ?>

    </div>
    <!-- show personal user posts  -->

    <?php if (!Application::isGuest()) : ?>

        <?php core\content\InternalPastesContent::begin() ?>
        <?php echo core\content\InternalPastesContent::generateContent() ?>
        <?php core\content\InternalPastesContent::end() ?>


    <?php endif; ?>

    <!-- show public posts -->

    <?php core\content\PublicPastesContent::begin() ?>
    <?php echo core\content\PublicPastesContent::generateContent() ?>
    <?php core\content\PublicPastesContent::end() ?>


</div>
</div>