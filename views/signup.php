<!-- <div class="center"> 
    <div class="wrapper">
        <div itemprop="headline"  class="title">
            Register Form -->

<?php

use core\form\Form;


$form = new Form();
?>

        <!-- </div> -->

            <?php $form = core\form\Form::begin('', "post") ?>
            <?php echo $form->field($model, 'username') ?> 
            <?php echo $form->field($model, 'email') ?> 
            <?php echo $form->field($model, 'password') ?> 
            <?php echo $form->field($model, 'repeat') ?> 


            <div class="field">
                <input type="submit" value="Login">
            </div>
            <?php core\form\Form::end() ?>

            <!-- <form action = " " method = "post">
            <div class="field">
                <input type="text" required  name="username">
                <label>Username</label>
            </div>
            <div class="field">
                <input type="text" required name ="email">
                <label>Email Address</label>
            </div>
            <div class="field">
                <input type="password" required name="password">
                <label>Password</label>
            </div>
            <div class="field">
                <input type="password" required name ="repeat">
                <label>Repeat Password</label>
            </div>
            <div class="field">
                <input type="submit" value="Login">
            </div>
        </form>
    </div>
</div> -->