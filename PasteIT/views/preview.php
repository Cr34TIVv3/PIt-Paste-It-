<?php

use core\Application;
use models\Paste;
use core\DataProvider;
?>

<script src="./scripts/window.js"></script>



<div class="source">
    <div class="main-container">


        <h1><?php echo $record->title; ?></h1>

        <div class="members">
            <h2> This is your post:</h2>
            <h2 id="seeOtherMembers"> See other members <i class="fas fa-users"></i></h2>
        </div>

        <script>
            document.getElementById("seeOtherMembers").addEventListener("click", () => {
                ModalWindow.openModal({
                    title: "Members",
                    content: "<?php echo DataProvider::getMembers($record->id); ?>"
                });

                document.getElementById("modal__close").addEventListener("click", e => ModalWindow.closeModal(e.target));
            });
        </script>

        <div class="pasteContent">
            <pre>
                <code id="toHighlight">
                    <?php echo $record->content;  ?>
                </code>
            </pre>
        </div>


        <?php if (!Application::$app->isVersion) : ?>

            <script src="scripts/highlither.js"></script>
            <script>
                highlight_code("<?php echo $record->highlight ?>");
            </script>
        <?php else : ?>
            <script src="scripts/highlither.js"></script>
            <script>
                highlight_code("<?php echo Paste::findOne(["id" => $record->id])->highlight ?>");
            </script>
        <?php endif; ?>

        <!-- show some option in order to update a post-->

        


        <!-- SHOW THIS FOR MEMBERS ONLY-->

        <?php if (!Application::$app->isVersion) : ?>

            <?php if (Application::$app->isOwner($record->id_user) || Application::$app->isMember($record->id)) : ?>


                <?php $form = core\form\FormHome::begin('/' . $record->slug, "post") ?>
                <h3> Make some changes?</h3>
                <div class="form">
                    <textarea name="content" id="text-area" cols="30" rows="10"> <?php echo $record->content; ?></textarea>
                </div>

                

                <?php  
                    $toTransfer = array(
                        'slug'       => $record->slug,
                        'expiration' => $record->expiration,
                        'title'      => $record->title,
                        'content'    => $record->content,
                        'syntax'     => $record->highlight
                    );

                    $_SESSION['toTransfer'] = $toTransfer; 
                ?>

                <h3 id="csv"> <a href="/download.php" download="File.csv"> Export as CSV <i class="fas fa-file-download"></i> </a> </h3>

                <?php echo $form->field($record, 'title', 'Change Paste Name/Title:')->getInput(True, True) ?>


                <div class="field">
                    <input type="submit" value="Update The Paste">
                </div>
                <?php core\form\FormHome::end() ?>

            <?php endif; ?>


            <!-- SHOW THIS FOR OWNERS ONLY-->

            <?php if (Application::$app->isOwner($record->id_user)) : ?>
                <?php $form = core\form\FormHome::begin('/' . $record->slug . '/addUser', "get") ?>
                <?php echo $form->field($record, 'email', 'Enter email address member:')->getInput(True, True) ?>

                <div class="field">
                    <input type="submit" value="Add user">
                </div>
                <?php core\form\FormHome::end() ?>
            <?php endif; ?>
        <?php endif; ?>

        <!-- update formular -->

        <!-- show some other version of the pastes-->

        <?php if (!Application::$app->isVersion) : ?>
            <?php core\content\VersionPastesContent::begin() ?>
            <?php echo core\content\VersionPastesContent::generateContent($record) ?>
            <?php core\content\VersionPastesContent::end() ?>
        <?php endif; ?>




        <?php if (Application::$app->isVersion && (Application::$app->isMember($record->id) || Application::$app->isOwner($record->id_user))) : ?>
            <i style="color: yellow;" class="fas fa-exclamation-triangle"></i>
            <h6 style="color:beige;">Note: this is an older version: click <a style="color: chartreuse;" href="<?php echo '/' . Paste::findOne(["id" => $record->id])->slug ?>"> here </a> to preview the original version</h6>

            <?php $form = core\form\FormHome::begin('/' . $record->slug, "post") ?>
            <div class="field">
                <input type="submit" value="Promote to Official Post">
            </div>
            <?php core\form\FormHome::end() ?>

        <?php endif; ?>

        <!-- show public posts -->

        <?php core\content\PublicPastesContent::begin() ?>
        <?php echo core\content\PublicPastesContent::generateContent() ?>
        <?php core\content\PublicPastesContent::end() ?>

    </div>
</div>


<script src="/scripts/deleteAJAX.js"> </script>