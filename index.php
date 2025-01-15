<?php

    include('assets/php/functions.php');

    //to fetch real time user data from db when user is logged in
    if(isset($_SESSION['log_status']))
    {
        $userdata=getUserdata($_SESSION['userid']);
        $posts=getPosts();
        $supporter_suggestion=filterSupporterSuggestion();
    }

    //to move through pages
    if(isset($_SESSION['log_status']) && $userdata['acc_status']==1 && isset($_GET['edit_profile']))
    {
        viewpage('header', ['pageTitle' => 'open_mic - Edit Profile']);
        viewpage('navbar');
        viewpage('edit_profile');
        viewpage('footer');
    }
    elseif(isset($_SESSION['log_status']) && $userdata['acc_status']==1 && isset($_GET['user']))
    {
        $profile_data=getUserdatabyUsername($_GET['user']);
        if(!$profile_data)
        {
            viewpage('header', ['pageTitle' => 'User Not Found']);
            viewpage('navbar');
            viewpage('UserNotFound');
            viewpage('footer');
        }
        else
        {
            $profile_posts=getPostsbyID($profile_data['U_ID']);
            $profile_data['supporters']=getSupporters($profile_data['U_ID']);
            $profile_data['supporting']=getSupporting($profile_data['U_ID']);

            viewpage('header', ['pageTitle' => $profile_data['first_name']." ".$profile_data['last_name']]);
            viewpage('navbar');
            viewpage('profile');
            viewpage('footer');
        }
        
    }
    elseif(isset($_SESSION['log_status']) && $userdata['acc_status']==1)
    {
        viewpage('header', ['pageTitle' => 'open_mic - Home']);
        viewpage('navbar');
        viewpage('wall');
        viewpage('footer');
    }
    elseif(isset($_SESSION['log_status']) && $userdata['acc_status']==0)
    {
        viewpage('header', ['pageTitle' => 'open_mic - Verify Email']);
        viewpage('verify_email');
        viewpage('footer');
    }
    elseif(isset($_SESSION['log_status']) && $userdata['acc_status']==2)
    {
        viewpage('header', ['pageTitle' => 'open_mic - Account Blocked!']);
        viewpage('blocked');
        viewpage('footer');
    }
    elseif(isset($_GET['signup']))
    {
        viewpage('header', ['pageTitle' => 'open_mic - Signup']);
        viewpage('signup');
        viewpage('footer');
    }
    elseif(isset($_GET['login']))
    {
        viewpage('header', ['pageTitle' => 'open_mic - Login']);
        viewpage('login');
        viewpage('footer');
    }
    elseif(isset($_GET['forgotPassword']))
    {
        viewpage('header', ['pageTitle' => 'open_mic - Forget_Password']);
        viewpage('forgot_password');
        viewpage('footer');
    }
    else
    {
        if(isset($_SESSION['log_status']) && $userdata['acc_status']==1)
        {
            viewpage('header', ['pageTitle' => 'open_mic - Home']);
            viewpage('navbar');
            viewpage('wall');
            viewpage('footer');
        }
        else
        {
            viewpage('header', ['pageTitle' => 'open_mic - Login']);
            viewpage('login');
            viewpage('footer');
        }
    }

?>