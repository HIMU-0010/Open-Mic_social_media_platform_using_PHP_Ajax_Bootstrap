
    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form method="post" action="assets/php/actions.php?verify_email">
                <div class="d-flex justify-content-center">
                    <img class="m-1 mb-2" src="assets/img/open_mic.png" alt="" height="40" width="120">
                </div>
                <h1 class="h5 mb-3 fw-normal">Verify Your Email</h1>


                <p>Enter 6 Digit Code Sent to Your Email</p>
                <div class="form-floating mt-1">

                    <input type="text" name="code" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">######</label>
                </div>
                <?=showErrors('verify_otp')?>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-danger" type="submit">Verify Email</button>
                    <a href="assets/php/actions.php?resend_code" class="text-danger" type="submit">Resend Code</button>
                </div>
                <br>
                <a href="assets/php/actions.php?logout" class="text-danger mt-5"><i class="bi bi-arrow-left-circle-fill"></i>
                    Logout</a>
            </form>
        </div>
    </div>

<?php

    unset($_SESSION['error']);

?>
