<?php
    global $userdata
?>
    <div class="login">
        <div class="col-4 bg-white border rounded p-4 shadow-sm">
            <form>
                <div class="d-flex justify-content-center">
                    <img class="mb-4" src="assets/img/open_mic.png" alt="" height="45">
                </div>
                    <h1 class="h5 mb-3 fw-normal">Hello, <?=$userdata['first_name'].' '.$userdata['last_name'].' '?> your account is blocked by admin</h1>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-danger buttonColor"><a href="assets/php/actions.php?logout" class="textColorWhite" type="submit">Logout</a></button>
                </div>

            </form>
        </div>
    </div>

