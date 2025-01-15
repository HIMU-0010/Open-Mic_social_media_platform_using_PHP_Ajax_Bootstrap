<?php

    include('functions.php');

    //to dynamically support user
    if(isset($_GET['support']))
    {
        $user_id = $_POST['user_id'];
        if(supportUser($user_id))
        {
            $response['status']=true;
        }
        else
        {
            $response['status']=false;
        }
        echo json_encode($response);
    }

    //to dynamically unsupport user
    if(isset($_GET['unsupport']))
    {
        $user_id = $_POST['user_id'];
        if(unsupportUser($user_id))
        {
            $response['status']=true;
        }
        else
        {
            $response['status']=false;
        }
        echo json_encode($response);
    }

    //to dynamically like post
    if(isset($_GET['like']))
    {
        $post_id = $_POST['post_id'];

        if(!checkLikestatus($post_id))
        {
            if(likepost($post_id))
            {
                $response['status']=true;
            }
            else
            {
                $response['status']=false;
            }

            echo json_encode($response);
        }
    }

    //to dynamically unlike post
    if(isset($_GET['unlike']))
    {
        $post_id = $_POST['post_id'];

        if(checkLikestatus($post_id))
        {
            if(unlikepost($post_id))
            {
                $response['status']=true;
            }
            else
            {
                $response['status']=false;
            }

            echo json_encode($response);
        }
    }

    //to dynamically add comment on a post
    if(isset($_GET['addcomment']))
    {
        $post_id = $_POST['post_id'];
        $comment = $_POST['comment_txt'];

        if(commentpost($post_id, $comment))
        {
            $User_data=getUserdata($_SESSION['userid']);
            $response["status"]=true;
            $response["comment"]='<div class="d-flex align-items-center p-2">
                                    <div><img src="assets/img/profile_pic/'.$User_data['profile_img'].'" alt="" height="40" class="rounded-circle border">
                                    </div>
                                    <div>&nbsp;&nbsp;&nbsp;</div>
                                    <div class="d-flex flex-column justify-content-start align-items-start">
                                         <h6 style="margin: 0px;"><a href="?user='.$User_data['username'].'" class="text-decoration-none text-dark">'.$User_data['first_name'].' '.$User_data['last_name'].'</a></h6>
                                        <p style="margin: 0px;" class="text-muted fs-6">@<'.$User_data['username'].'</p>
                                        <p style="margin:0px;" class="">'.$comment.'</p>
                                    </div>
                                </div>';
        }
        else
        {
            $response['status']=false;
        }

        echo json_encode($response);
    }

    //to dynamically search a user
    if(isset($_GET['search']))
    {
        $keyword = $_POST['keyword'];
        $data = searchUser($keyword);
        $users=array();
            if(count($data)>0)
            {
                $response['status']=true;

                foreach($data as $user)
                {
                    $btn='';
                
                    $users[]='<div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center p-2">
                                          <div>
                                            <img src="assets/img/profile_pic/'.$user['profile_img'].'" alt="" height="40" class="rounded-circle border">
                                          </div>
                                          <div>&nbsp;&nbsp;</div>
                                          <div class="d-flex flex-column justify-content-center">
                                            <a href="?user='.$user['username'].'" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;">'.$user['first_name'].' '.$user['last_name'].'</h6></a>
                                            <p style="margin:0px;font-size:small" class="text-muted">@'.$user['username'].'</p>
                                          </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        '.$btn.'
                                    </div>
                                </div>';
                }     
                $response['users']=$users;
            }
            else
            {
                $response['status']=false;
            }
        
            echo json_encode($response);
    }


    //to dynamically unblock a user
    if(isset($_GET['unblock']))
    {
        $user_id = $_POST['user_id'];
    
    
        if(unblockUser($user_id)){
            $response['status']=true;
        }else{
            $response['status']=false;
        }
    
        echo json_encode($response);
    }

    //for dynamically set read_status of NTF to read
    if(isset($_GET['notread']))
    {
        if(setNTFread())
        {
            $response['status']=true;
        }
        else
        {
            $response['status']=false;
        }
    
        echo json_encode($response);
    }
?>