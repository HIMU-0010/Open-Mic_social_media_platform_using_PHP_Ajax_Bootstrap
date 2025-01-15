<?php

    include('functions.php');
    include('mail_otp.php');


    //for signup
    if(isset($_GET['signup']))
    {
        $response=validateSignupform($_POST);

        if($response['status'])
        {
            if(createUser($_POST))
            {
                header('location: ../../?login');
            }
            else
            {
                echo "<script>alert('Something went wrong!')</script>";
            }
        }
        else
        {
            $_SESSION['error']=$response;
            $_SESSION['formdata']=$_POST;
            header('location: ../../?signup');
        }
    }

    //for login
    if(isset($_GET['login']))
    {
        $response=validateLoginform($_POST);

        if($response['status'])
        {
            $_SESSION['log_status']=true;
            $_SESSION['userid']=checkUser($_POST)['userinfo']['U_ID'];
            $_SESSION['userdata']=checkUser($_POST)['userinfo'];

            if($_SESSION['userdata']['acc_status'] == 0)
            {
                $code=rand(111111,999999);
                $_SESSION['otpcode']=$code;
                sendOTP($_SESSION['userdata']['email'], "Verify Your Email", $code);
            }

            header('location: ../../');
        }
        else
        {
            $_SESSION['error']=$response;
            $_SESSION['formdata']=$_POST;
            header('location:../../?login');
        }
    }

    //for verifying email
    if(isset($_GET['verify_email']))
    {
        if($_SESSION['otpcode']==$_POST['code'])
        {
            if(verifyEmail($_SESSION['userdata']['U_ID']))
            {
                header('location: ../../');
            }
            else
            {
                echo "<script>alert('Something went wrong!')</script>";
            }
        }
        else
        {
            $response['msg']="Incorrect verification code!";
            if(!$_POST['code'])
            {
                $response['msg']="6-digit verification code is required to proceed!"; 
            }
            $response['field']="verify_otp";
            $_SESSION['error']=$response;
            
            header('location: ../../');
        }
    }

    //for resending otp for email verification
    if(isset($_GET['resend_code']))
    {
        $code=rand(111111,999999);
        $_SESSION['otpcode']=$code;
        sendOTP($_SESSION['userdata']['email'], "Verify Your Email", $code);

        header('location: ../../');
    }

    //for user logout
    if(isset($_GET['logout']))
    {
        session_destroy();
        header('location: ../../');
    }

    //to verify email and send otp while recovering account
    if(isset($_GET['forgotPassword']))
    {
        if(!isset($_POST['email']))
        {
            $response['msg']='Email is required!';
            $response['field']='email';

            $_SESSION['error']=$response;

            header('location: ../../?forgotPassword');
        }
        elseif(!isEmailRegistered($_POST['email']))
        {
            $response['msg']='User Not Found! - Try a valid one';
            $response['field']='email';

            $_SESSION['error']=$response;

            header('location: ../../?forgotPassword');
        }
        else
        {      
            $_SESSION['userEmail']=$_POST['email'];
            $code=rand(111111,999999);
            $_SESSION['FP_otpcode']=$code;
            sendOTP($_POST['email'], "Account Recovery", $code);

            header('location: ../../?forgotPassword');
        }
    }
    //to verify otp code while recovering account
    if(isset($_GET['verifyCode']))
    {
        if($_SESSION['FP_otpcode']==$_POST['code'])
        {
            $_SESSION['changePassword']=true;
            unset($_SESSION['FP_otpcode']);
            header('location: ../../?forgotPassword');
        }
        else
        {
            $response['msg']="Incorrect verification code!";
            if(!$_POST['code'])
            {
                $response['msg']="6-digit verification code is required to proceed!"; 
            }
            $response['field']="verify_otp";

            $_SESSION['error']=$response;
            
            header('location: ../../?forgotPassword');
        }
    }
    //for changing password while recovering account
    if(isset($_GET['changePassword']))
    {
        if(!$_POST['password'])
        {
            $response['msg']='Enter your password to proceed!';
            $response['field']='password';

            $_SESSION['error']=$response;
        }
        else
        {
            if(changePassword($_POST['password'],$_SESSION['userEmail']))
            {
                unset($_SESSION['changePassword']);
                unset($_SESSION['userEmail']);
                header('location: ../../');
            }
            else
            {
                unset($_SESSION['changePassword']);
                header('location: ../../?forgotPassword');
                echo "<script>alert('Something went wrong!')</script>";
                
            }
        }
    }

    //for edit profile info
    if(isset($_GET['editProfile']))
    {
        $response=validateEditform($_POST, $_FILES['profile_pic']);

        if($response['status'])
        {
            if(editProfile($_POST,$_FILES['profile_pic']))
            {
                header('location: ../../?edit_profile&success');
            }
            else
            {
                header('location: ../../?edit_profile');
                echo "<script>alert('Something went wrong!')</script>";
            }
        }
        else
        {
            $_SESSION['error']=$response;
            header('location: ../../?edit_profile');
        }
    }

    //for adding a new post
    if(isset($_GET['addpost']))
    {
        $response=validateaddPostform($_POST, $_FILES['post_img']);

        if($response['status'])
        {
            if(createPost($_POST, $_FILES['post_img']))
            {
                header('location: ../../?addedPostSuccessfully');
            }
            else
            {
                header('location: ../../');
                echo "<script>alert('Something went wrong while creating new post!')</script>";
            }
        }
        else
        {
            $_SESSION['error']=$response;
            header('location: ../../');
        }
    }

    //for blocking a user
    if(isset($_GET['blk'])){
        
        $user_id = $_GET['blk'];
          if(blockUser($user_id))
          {
            header("location:{$_SERVER['HTTP_REFERER']}");
          }
          else
          {
              echo "something went wrong";
          }
      
        
      }

?>