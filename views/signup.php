<?php

use core\form\Form;

$form = new Form();

?>

        <!-- </div> -->

            <?php $form = core\form\Form::begin('', "post") ?>
            <?php echo $form->field($model, 'username') ?> 
            <?php echo $form->field($model, 'email') ?> 
            <?php echo $form->field($model, 'password')->passwordField() ?> 
            <?php echo $form->field($model, 'repeat') ->passwordField()?> 


            <div class="field">
                <input type="submit" value="Login">
            </div>
            <?php core\form\Form::end() ?>