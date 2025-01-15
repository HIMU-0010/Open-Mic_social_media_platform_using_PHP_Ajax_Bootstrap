<?php
    global $userdata;
?>
    <div class="container col-9 rounded-0 d-flex justify-content-between">
        <div class="col-12 bg-white border rounded p-4 mt-4 shadow-sm">
            <form method="post" action="assets/php/actions.php?editProfile" enctype="multipart/form-data">
                <div class="d-flex justify-content-center">


                </div>
                <h1 class="h5 mb-3 fw-normal">Edit Profile</h1>

                <?php
                    if(isset($_GET['success']))
                    {
                ?>
                        <div class="alert alert-danger my-2" role="alert">
                            <h6>Profile is updated succcessfully!</h6>
                        </div>
                <?php
                    }
                ?>

                <div class="form-floating mt-1 col-6">
                    <img src="assets/img/profile_pic/<?=$userdata['profile_img']?>" class="img-thumbnail my-3" style="height:150px;" alt="...">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Change Profile Picture</label>
                        <input class="form-control" type="file" name="profile_pic" id="formFile">
                    </div>
                </div>
                <?=showErrors('profile_pic')?>
                <div class="d-flex">
                    <div class="form-floating mt-1 col-6 ">
                        <input type="text" name="first_name" value="<?=$userdata['first_name']?>" class="form-control rounded-0" placeholder="username/email">
                        <label for="floatingInput">first name</label>
                    </div>
                    <div class="form-floating mt-1 col-6">
                        <input type="text" name="last_name" value="<?=$userdata['last_name']?>" class="form-control rounded-0" placeholder="username/email">
                        <label for="floatingInput">last name</label>
                    </div>
                </div>
                <?=showErrors('first_name')?>
                <?=showErrors('last_name')?>
                <div class="d-flex gap-3 my-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios1"
                            value="1" <?=$userdata['gender']==1?'checked':''?> >
                        <label class="form-check-label" for="exampleRadios1">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios3"
                            value="2" <?=$userdata['gender']==2?'checked':''?> >
                        <label class="form-check-label" for="exampleRadios3">
                            Female
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios2"
                            value="0" <?=$userdata['gender']==0?'checked':''?> >
                        <label class="form-check-label" for="exampleRadios2">
                            Other
                        </label>
                    </div>
                </div>
                <div class="form-floating mt-1">
                    <input type="email" name="email" value="<?=$userdata['email']?>" class="form-control rounded-0" placeholder="email" disabled>
                    <label for="floatingInput">email</label>
                </div>
                <div class="form-floating mt-1">
                    <input type="text" name="username" value="<?=$userdata['username']?>"class="form-control rounded-0" placeholder="username/email">
                    <label for="floatingInput">username</label>
                </div>
                <?=showErrors('username')?>
                <div class="form-floating mt-1">
                    <input type="password" name="password" class="form-control rounded-0" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">New password</label>
                </div>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary buttonColor" type="submit">Update Profile</button>



                </div>

            </form>
        </div>

    </div>

<?php
    unset($_SESSION['error']);
?>
    