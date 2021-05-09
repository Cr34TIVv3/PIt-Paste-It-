


<?php $form = core\form\FormHome::begin('/'.$record->slug, "get") ?>

        <h5>This post is protected, you have to input the password in order to have access</h5>

         <label for="Password">Password :</label>
            <input type="password" id="fname" name="enter_password">

        <div class="field">
            <input type="submit" value="Submit Password">
        </div>
        
<?php core\form\FormHome::end() ?>