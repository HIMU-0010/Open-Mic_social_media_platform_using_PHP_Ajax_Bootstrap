
    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <?php
                if(isset($_SESSION['FP_otpcode']))
                {
                    $action="verifyCode";
                }
                elseif(isset($_SESSION['changePassword']))
                {
                    $action="changePassword";
                }
                else
                {
                    $action="forgotPassword";
                }
            ?>
            <form method="post" action="assets/php/actions.php?<?=$action?>">
                <div class="d-flex justify-content-center">
                    <img class="mb-4" src="assets/img/open_mic.png" alt="" height="45">
                </div>
                <h1 class="h5 mb-3 fw-normal">Recover Account</h1>

                <?php
                    if($action=="forgotPassword")
                    {
                ?>
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control rounded-0" placeholder="username/email">
                            <label for="floatingInput">Enter your email</label>
                        </div>
                        <?=showErrors('email')?>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <button class="btn btn-danger buttonColor" type="submit">Send Verification Code</button>
                        </div>
                <?php
                    }
                ?>

                <?php
                    if($action=="verifyCode")
                    {
                ?>
                        <p>Enter 6 Digit Code Sended to You</p>
                        <div class="form-floating mt-1">
                            <input type="text" name="code" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">######</label>
                        </div>
                        <?=showErrors('verify_otp')?>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <button class="btn btn-danger buttonColor" type="submit">Verify Code</button>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    if($action=="changePassword")
                    {
                ?>
                        <div class="form-floating mt-1">
                            <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">new password</label>
                        </div>
                        <?=showErrors('password')?>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <button class="btn btn-danger buttonColor" type="submit">Change Password</button>
                        </div>
                <?php
                    }
                ?>
                

                <br>
                <a href="?login" class="textColor mt-5"><i class="bi bi-arrow-left-circle-fill"></i> Go Back
                    To
                    Login</a>
            </form>
        </div>
    </div>

<?php

    unset($_SESSION['error']);

?>
