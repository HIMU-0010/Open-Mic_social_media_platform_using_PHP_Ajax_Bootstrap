

    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form action="assets/php/actions.php?login" method="post">
                <div class="d-flex justify-content-center">

                    <img class="mb-4" src="assets/img/open_mic.png" alt="" height="55" width="180">
                </div>
                <?=showErrors('checkuser')?>
                <div class="form-floating">
                    <input type="text" name="username_email" value="<?=showFormData('username_email')?>" class="form-control rounded-0" placeholder="username/email">
                    <label for="floatingInput">username/email</label>
                </div>
                <?=showErrors('username_email')?>

                <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">password</label>
                </div>
                <?=showErrors('password')?>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-danger buttonColor" type="submit">Log in</button>
                    <a href="?signup" class="textColor">Create New Account</a>


                </div>
                <a href="?forgotPassword" class="textColor">Forgot password ?</a>
            </form>
        </div>
    </div>



<?php

    unset($_SESSION['error']);
    unset($_SESSION['formdata']);

?>