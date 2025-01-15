<?php

    include('config.php');
    
    //to display pages from index.php
    function viewpage($pageName,$data="")
    {
        include("assets/pages/$pageName.php");
    }

    //for validating signup form
    function validateSignupform($form_data)
    {
        $response=array();
        $response['status']=true;

        if(!$form_data['password'])
        {
            $response['msg']="Password is Required!";
            $response['status']=false;
            $response['field']='password';
        }

        if(!$form_data['first_name'])
        {
            $response['msg']="First Name is Required!";
            $response['status']=false;
            $response['field']='first_name';
        }

        if(!$form_data['last_name'])
        {
            $response['msg']="Last name is Required!";
            $response['status']=false;
            $response['field']='last_name';
        }

        if(!$form_data['username'])
        {
            $response['msg']="Username is Required!";
            $response['status']=false;
            $response['field']='username';
        }

        if(!$form_data['email'])
        {
            $response['msg']="Email is Required!";
            $response['status']=false;
            $response['field']='email';
        }

        if(isEmailRegistered($form_data['email']))
        {
            $response['msg']="Email already in use!";
            $response['status']=false;
            $response['field']='email';
        }

        if(isUsernameRegistered($form_data['username']))
        {
            $response['msg']="Username is not available!";
            $response['status']=false;
            $response['field']='username';
        }

        return $response;
    }

    //for validating login form
    function validateLoginform($form_data)
    {
        $response=array();
        $response['status']=true;
        $isBlank=false;
        if(!$form_data['password'])
        {
            $response['msg']="Password is Required!";
            $response['status']=false;
            $response['field']='password';
            $isBlank=true;
        }

        if(!$form_data['username_email'])
        {
            $response['msg']="Username/Email is Required!";
            $response['status']=false;
            $response['field']='username_email';
            $isBlank=true;
        }
        
        if(!$isBlank && !checkUser($form_data)['status'])
        {
            $response['msg']="login credentials are invalid!";
            $response['status']=false;
            $response['field']='checkuser';
        }

        return $response;
    }

    //for validating profile edit form
    function validateEditform($form_data, $image_data)
    {
        $response=array();
        $response['status']=true;

        if(!$form_data['first_name'])
        {
            $response['msg']="First Name is Required!";
            $response['status']=false;
            $response['field']='first_name';
        }

        if(!$form_data['last_name'])
        {
            $response['msg']="Last name is Required!";
            $response['status']=false;
            $response['field']='last_name';
        }

        if(!$form_data['username'])
        {
            $response['msg']="Username is Required!";
            $response['status']=false;
            $response['field']='username';
        }

        if(isUsernameRegisteredbyOther($form_data['username']))
        {
            $response['msg']=$form_data['username']." is not available!";
            $response['status']=false;
            $response['field']='username';
        }

        if($image_data['name'])
        {
           $image=basename($image_data['name']);
           $image_type=strtolower(pathinfo($image, PATHINFO_EXTENSION));
           $image_size=$image_data['size']/1000;

           if($image_type!='jpg' && $image_type!='jpeg' && $image_type!='png')
           {
                $response['msg']="Only jpg, jpeg & png is allowed to be used!";
                $response['status']=false;
                $response['field']='profile_pic';
           }

           if($image_size>5000)
           {
                $response['msg']="Up to 5mb of picture size can be uploaded!";
                $response['status']=false;
                $response['field']='profile_pic';
           }
        }
        return $response;
    }

    //for validating add new post form
    function validateaddPostform($form_data, $image_data)
    {
        $response=array();
        $response['status']=true;

        if(!$form_data['post_text'] && !$image_data['name'])
        {
            $response['msg']="Either a text message or an image is needed to create a post";
            $response['status']=false;
            $response['field']='post';
        }

        if($image_data['name'])
        {
           $image=basename($image_data['name']);
           $image_type=strtolower(pathinfo($image, PATHINFO_EXTENSION));
           $image_size=$image_data['size']/1000;

           if($image_type!='jpg' && $image_type!='jpeg' && $image_type!='png')
           {
                $response['msg']="Only jpg, jpeg & png is allowed to be used!";
                $response['status']=false;
                $response['field']='post';
           }

           if($image_size>5000)
           {
                $response['msg']="Up to 5mb of picture size can be uploaded!";
                $response['status']=false;
                $response['field']='post';
           }
        }
        return $response;
    }

    //check for duplicate email
    function isEmailRegistered($email)
    {
        global $dbconn;

        $query="SELECT COUNT(*) as row FROM users WHERE email='$email'";
        $run=mysqli_query($dbconn, $query);
        $result=mysqli_fetch_assoc($run);

        return $result['row'];
    }

    //check for duplicate username while signing up
    function isUsernameRegistered($username)
    {
        global $dbconn;
        $query="SELECT COUNT(*) as row FROM users WHERE username='$username'";
        $run=mysqli_query($dbconn, $query);
        $result=mysqli_fetch_assoc($run);
        return $result['row'];
    }

    //check for duplicate username while edit profile
    function isUsernameRegisteredbyOther($username)
    {
        global $dbconn;

        $id=$_SESSION['userid'];

        $query="SELECT COUNT(*) as row FROM users WHERE username='$username' && U_ID!='$id'";
        $run=mysqli_query($dbconn, $query);
        $result=mysqli_fetch_assoc($run);
        
        return $result['row'];
    }

    //to check if user exist in DB for login
    function checkUser($logindata)
    {
        global $dbconn;

        $username_email=mysqli_real_escape_string($dbconn, $logindata['username_email']);
        $password=md5(mysqli_real_escape_string($dbconn, $logindata['password']));

        $query="SELECT * FROM users WHERE (username='$username_email' || email='$username_email') && pswd='$password'";
        $run=mysqli_query($dbconn, $query);
        $data['userinfo']=mysqli_fetch_assoc($run) ?? array();

        if(count($data['userinfo'])>0)
        {
            $data['status']=true;
        }
        else
        {
            $data['status']=false;
        }

        return $data;
    }

    //to show error in form
    function showErrors($field)
    {
        if(isset($_SESSION['error']))
        {
            $error=$_SESSION['error'];
            if($error['field']==$field)
            {
                ?>
                <div class="alert alert-danger my-2" role="alert">
                    <?=$error['msg']?>
                </div>
                <?php
            }
        }
    }

    //to show form data in their individual fields, if there is any error in the form
    function showFormData($field)
    {
        if(isset($_SESSION['formdata']))
        {
            $formdata=$_SESSION['formdata'];
            return $formdata[$field];
        }
    }

    //to register a new user in DB
    function createUser($data)
    {
        global $dbconn;

        $first_name=mysqli_real_escape_string($dbconn, $data['first_name']);
        $last_name=mysqli_real_escape_string($dbconn, $data['last_name']);
        $email=mysqli_real_escape_string($dbconn, $data['email']);
        $username=mysqli_real_escape_string($dbconn, $data['username']);
        $gender=$data['gender'];
        $password=md5(mysqli_real_escape_string($dbconn, $data['password']));

        $query="INSERT INTO users(first_name, last_name, email, username, gender, pswd)
        VALUES ('$first_name', '$last_name', '$email', '$username', '$gender', '$password')";

        return mysqli_query($dbconn, $query);
    }

    //get user data by id
    function getUserdata($user_id)
    {
        global $dbconn;

        $query="SELECT * FROM users WHERE U_ID='$user_id'";
        $run=mysqli_query($dbconn, $query);
        return mysqli_fetch_assoc($run) ?? array();
    }

    //get user data by username
    function getUserdatabyUsername($username)
    {
        global $dbconn;

        $query="SELECT * FROM users WHERE username='$username'";
        $run=mysqli_query($dbconn, $query);
        return mysqli_fetch_assoc($run) ?? array();
    }
    
    //verify email
    function verifyEmail($userid)
    {
        global $dbconn;

        $query="UPDATE users SET acc_status=1 WHERE U_ID = '$userid'";
        return mysqli_query($dbconn, $query);
    }
    
    //change password for recovering account
    function changePassword($NEWpswd, $email)
    {
        global $dbconn;

        $NEWpswd=md5($NEWpswd);

        $query="UPDATE users SET pswd='$NEWpswd' WHERE email='$email'";
        return mysqli_query($dbconn, $query);
    }

    //edit profile
    function editProfile($form_data, $image_data)
    {
        global $dbconn;

        $first_name=mysqli_real_escape_string($dbconn, $form_data['first_name']);
        $last_name=mysqli_real_escape_string($dbconn, $form_data['last_name']);
        $username=mysqli_real_escape_string($dbconn, $form_data['username']);
        $gender=$form_data['gender'];
        if(!$_POST['password'])
        {
            $password=$_SESSION['userdata']['pswd'];
        }
        else
        {
            $password=md5(mysqli_real_escape_string($dbconn, $form_data['password']));
        }
        $profile_img="";
        if($image_data['name'])
        {
            $image_name=time().basename($image_data['name']);
            $image_dir="../img/profile_pic/$image_name";
            move_uploaded_file($image_data['tmp_name'], $image_dir);
            $profile_img=", profile_img='$image_name'";
        }

        $query="UPDATE users SET first_name='$first_name', last_name='$last_name', username='$username', gender='$gender', pswd='$password' $profile_img WHERE U_ID='$_SESSION[userid]'";
        return mysqli_query($dbconn, $query);
    }

    //add new post
    function createPost($form_data, $image_data)
    {
        global $dbconn;

        $post_text="NULL";
        if($form_data['post_text']) 
        {
            $post_text=mysqli_real_escape_string($dbconn, $form_data['post_text']);
        }

        $post_img="NULL";
        if($image_data['name'])
        {
            $image_name=time().basename($image_data['name']);
            $image_dir="../img/posts/$image_name";
            move_uploaded_file($image_data['tmp_name'], $image_dir);
            $post_img=$image_name;
        }

        if($form_data['post_anon']) 
        {
            $query="INSERT INTO posts(U_ID, post_img, post_text) 
            VALUES (1, '$post_img', '$post_text')";

            return mysqli_query($dbconn, $query);
        }
        else
        {
            $id=$_SESSION['userid'];
            $query="INSERT INTO posts(U_ID, post_img, post_text) 
            VALUES ($id, '$post_img', '$post_text')";

            return mysqli_query($dbconn, $query);
        }
    }

    //for getting new posts
    function getPosts()
    {
        global $dbconn;
        $current_user_id = $_SESSION['userid'];

        $query="SELECT posts.P_ID, posts.post_img, posts.post_text, posts.created_at, users.first_name, users.last_name, users.username, users.profile_img
        FROM posts JOIN users
        ON posts.U_ID = users.U_ID
        WHERE users.U_ID = $current_user_id OR users.U_ID IN (SELECT supporters.user_ID 
                                                               FROM supporters
                                                               WHERE supporters.supporter_ID = $current_user_id)
        ORDER BY P_ID DESC";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_all($run, true);
    }

    //for getting new posts by userid
    function getPostsbyID($userid)
    {
        global $dbconn;

        $query="SELECT * FROM posts WHERE U_ID=$userid ORDER BY P_ID DESC";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_all($run, true);
    }

    //for getting a post by post id
    function getPostbypostid($postid)
    {
        global $dbconn;

        $query="SELECT * FROM posts WHERE P_ID=$postid";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_assoc($run);
    }

    //for getting poster_id from post_id
    function getPosterId($post_id)
    {
        global $dbconn;

        $query = "SELECT U_ID FROM posts WHERE P_ID=$post_id";
        $run = mysqli_query($dbconn,$query);

        return mysqli_fetch_assoc($run)['U_ID'];
    }

    //for getting supporter suggestion
    function getSupporterSuggestion()
    {
        global $dbconn;

        $current_user_id = $_SESSION['userid'];

        $query="SELECT * FROM users WHERE U_ID!=$current_user_id";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_all($run, true);
    }
    //filter supporter suggestion
    function filterSupporterSuggestion()
    {
        $user_list=getSupporterSuggestion();
        $filtered_user_list=array();

        foreach($user_list as $user)
        {
            if(!checkSupportstatus($user['U_ID']) && count($filtered_user_list)<6)
            {
                $filtered_user_list[]=$user;
            }
        }
        return $filtered_user_list;
    }
    //check if the current user is supporting the passed id
    function checkSupportstatus($userid)
    {
        global $dbconn;

        $current_user_id = $_SESSION['userid'];

        $query="SELECT count(*) as row FROM supporters WHERE supporter_ID=$current_user_id && user_ID=$userid";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_assoc($run)['row'];
    }
    //check if the current user is supported by the passed id
    function checkSupportedstatus($userid)
    {
        global $dbconn;

        $current_user_id = $_SESSION['userid'];

        $query="SELECT count(*) as row FROM supporters WHERE supporter_ID=$userid && user_ID=$current_user_id";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_assoc($run)['row'];
    }

    //to support user
    function supportUser($user_id)
    {
        global $dbconn;
        $current_user_id=$_SESSION['userid'];

        $query="INSERT INTO supporters (supporter_ID, user_ID) VALUES ($current_user_id, $user_id)";

        createNotification($current_user_id,$user_id,"started supporting you !");

        return mysqli_query($dbconn, $query);
    }

    //to unsupport user
    function unsupportUser($user_id)
    {
        global $dbconn;
        $current_user_id=$_SESSION['userid'];

        $query="DELETE FROM supporters WHERE supporter_ID=$current_user_id && user_ID=$user_id";

        createNotification($current_user_id,$user_id,"have unsupported you !");

        return mysqli_query($dbconn, $query);
    }

    //for getting users who supports the current user
    function getSupporters($userId)
    {
        global $dbconn;

        $query="SELECT * FROM supporters WHERE user_ID=$userId";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_all($run, true);
    }

    //for getting users whom the current user supports
    function getSupporting($userId)
    {
        global $dbconn;

        $query="SELECT * FROM supporters WHERE supporter_ID=$userId";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_all($run, true);
    }

    //check like status on a post
    function checkLikestatus($postid)
    {
        global $dbconn;
        $current_user_id=$_SESSION['userid'];

        $query="SELECT count(*) as row FROM likes WHERE post_ID=$postid && user_ID=$current_user_id";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_assoc($run)['row'];
    }

    //to like a post
    function likepost($postid)
    {
        global $dbconn;
        $current_user_id=$_SESSION['userid'];

        $query="INSERT INTO likes (post_ID, user_ID) VALUES ($postid, $current_user_id)";


        $poster_id = getPosterId($postid);
   
        if($poster_id!=$current_user_id)
        {
            createNotification($current_user_id,$poster_id,"liked your post !",$postid);
        }

        return mysqli_query($dbconn, $query);
    }

    //to unlike a post
    function unlikepost($postid)
    {
        global $dbconn;
        $current_user_id=$_SESSION['userid'];

        $query="DELETE FROM likes WHERE post_ID=$postid && user_ID=$current_user_id";

        return mysqli_query($dbconn, $query);
    }

    //like count
    function likecount($postid)
    {
        global $dbconn;

        $query="SELECT count(*) as row FROM likes WHERE post_ID=$postid";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_assoc($run)['row'];
    }

    //get like data
    function getlikedata($postid)
    {
        global $dbconn;

        $query="SELECT * FROM likes WHERE post_ID=$postid";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_all($run, true);
    }

    //to add comment on a post
    function commentpost($postid, $comment)
    {
        global $dbconn;

        $current_user_id=$_SESSION['userid'];
        $comment=mysqli_real_escape_string($dbconn, $comment);

        $query="INSERT INTO comments (post_ID, user_ID, comment_text) VALUES ($postid, $current_user_id, '$comment')";

        $poster_id = getPosterId($postid);

        if($poster_id!=$current_user_id)
        {
            createNotification($current_user_id,$poster_id,"commented on your post",$postid);
        }

        return mysqli_query($dbconn, $query);
    }

    //get comment data
    function getcommentdata($postid)
    {
        global $dbconn;

        $query="SELECT * FROM comments WHERE post_ID=$postid";
        $run=mysqli_query($dbconn, $query);

        return mysqli_fetch_all($run, true);
    }

    //for showing time
    function show_time($time)
    {
        return '<time style="font-size:small" class="timeago text-muted text-small" datetime="'.$time.'"></time>';
    }

    //for searching the users
    function searchUser($keyword)
    {
        global $dbconn;

        $query ="SELECT * FROM users WHERE username LIKE '%".$keyword."%' || (first_name LIKE '%".$keyword."%' || last_name LIKE '%".$keyword."%') LIMIT 5";
        $run = mysqli_query($dbconn,$query);

        return mysqli_fetch_all($run,true);

    }

    //for blocking a user
    function blockUser($blocked_user_id)
    {
        global $dbconn;

        $current_user_id=$_SESSION['userid'];

        $query="INSERT INTO blocks(user_ID,blocked_user_ID) VALUES($current_user_id,$blocked_user_id)";
      
        createNotification($current_user_id, $blocked_user_id, "Blocked you");

        $query2="DELETE FROM supporters WHERE supporter_ID=$current_user_id && user_ID=$blocked_user_id";
        mysqli_query($dbconn,$query2);

        $query3="DELETE FROM supporters WHERE supporter_ID=$blocked_user_id && user_ID=$current_user_id";
        mysqli_query($dbconn,$query3);

        return mysqli_query($dbconn,$query);   
    }

    //for unblocking a user
    function unblockUser($user_id)
    {
        global $dbconn;

        $current_user_id=$_SESSION['userid'];

        $query="DELETE FROM blocks WHERE user_ID=$current_user_id && blocked_user_ID=$user_id";

        createNotification($current_user_id,$user_id,"Unblocked you !");

        return mysqli_query($dbconn,$query);   
    }

    //for checking if the user1 have blocked the user2
    function checkBlockStatus($user1,$user2)
    {
        global $dbconn;
        
        $query="SELECT count(*) as row FROM blocks WHERE user_ID=$user1 && blocked_user_ID=$user2";
        $run = mysqli_query($dbconn,$query);

        return mysqli_fetch_assoc($run)['row'];
    }

    //for checking block table (used in the post section of te profile)
    function checkBlk($user_id)
    {
        global $dbconn;

        $current_user_id = $_SESSION['userid'];

        $query="SELECT count(*) as row FROM blocks WHERE (user_ID=$current_user_id && blocked_user_ID=$user_id) || (user_ID=$user_id && blocked_user_ID=$current_user_id)";
        $run = mysqli_query($dbconn,$query);

        return mysqli_fetch_assoc($run)['row'];
    }

    //for creating notification
    function createNotification($from_user_id,$to_user_id,$msg,$post_id=0)
    {
        global $dbconn;

        $query="INSERT INTO notifications(from_user_ID,to_user_ID,ntf_msg,post_ID) VALUES($from_user_id,$to_user_id,'$msg',$post_id)";

        mysqli_query($dbconn,$query);    
    } 

    //for getting notification
    function getNotifications()
    {
        $current_user_id = $_SESSION['userid'];
      
          global $dbconn;

          $query="SELECT * FROM notifications WHERE to_user_ID=$current_user_id ORDER BY NTF_ID DESC";
          $run = mysqli_query($dbconn,$query);

          return mysqli_fetch_all($run,true);
      }

     //for fetch unread notification from DB
     function getUnreadNotificationsCount()
     {
        global $dbconn;

        $current_user_id = $_SESSION['userid'];

        $query="SELECT count(*) as row FROM notifications WHERE to_user_ID=$current_user_id && read_status=0 ORDER BY NTF_ID DESC";
        $run = mysqli_query($dbconn,$query);

        return mysqli_fetch_assoc($run)['row'];
    }

    //for setting notification read status=1(read)
    function setNTFread()
    {
       global $dbconn;

       $current_user_id = $_SESSION['userid'];

       $query="UPDATE notifications SET read_status=1 WHERE to_user_ID=$current_user_id";

       return mysqli_query($dbconn,$query);
   }

?>