<?php

use core\Application;
?>
<div class="source">
    <div class="main-container">

        <h1><?php echo $record->title; ?></h1>


        <div class="content">
            <pre>
                <code>
                    <?php echo $record->content; ?>
                </code>
            </pre>
        </div>


        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/styles/default.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.7.2/highlight.min.js"></script>
        <script>
            hljs.highlightAll();
        </script>

        <div class="form">
            <textarea name="content" id="text-area" cols="30" rows="10"> <?php echo $record->content; ?></textarea>
        </div>



        <!-- show some option in order to update a post-->

        <?php $form = core\form\FormHome::begin('/'.$record->slug, "post") ?>
        <?php echo $form->field($record, 'title', 'Change Paste Name/Title:')->getInput(True) ?>

        <div class="field">
            <input type="submit" value="Update The Paste">
        </div>


        <?php core\form\FormHome::end() ?>


        <!-- update formular -->






        <!-- show some other version of the pastes-->








        <!-- show internal posts -logged in users-->

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