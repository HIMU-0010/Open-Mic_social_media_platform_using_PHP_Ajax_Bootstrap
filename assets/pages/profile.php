<?php
    
    global $userdata;
    global $profile_data;
    global $profile_posts;

?>
    <div class="container col-9 rounded-0">
        <div class="col-12 rounded p-4 mt-4 d-flex gap-5">
            <div class="col-4 d-flex justify-content-end align-items-start"><img src="assets/img/profile_pic/<?=$profile_data['profile_img']?>"
                    class="img-thumbnail rounded-circle my-3" style="height:170px;" alt="...">
            </div>
            <div class="col-8">
                <div class="d-flex flex-column">
                    <div class="d-flex gap-5 align-items-center">
                        <span style="font-size: xx-large;"><?=$profile_data['first_name']?> <?=$profile_data['last_name']?></span>
                        <?php
                            if($profile_data['username']!=$userdata['username'])
                            {
                        ?>
                                <div class="dropdown">
                                    <span class="" style="font-size:xx-large" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i> 
                                    </span>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-chat-fill"></i> Message</a></li>
                                        <li><a class="dropdown-item" href="assets/php/actions.php?blk=<?=$profile_data['U_ID']?>"><i class="bi bi-x-circle-fill"></i> Block</a></li>
                                    </ul>
                                </div>
                        <?php
                            }
                            elseif($profile_data['username']==$userdata['username'])
                            {
                        ?>
                                <div class="dropdown">
                                    <span class="" style="font-size:xx-large" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i> 
                                    </span>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="?edit_profile"><i class="bi bi-pencil-square"></i> Edit Profile</a></li>
                                    </ul>
                                </div>
                        <?php
                            }
                        ?>
                        
                    </div>
                    <span style="font-size: larger;" class="text-secondary">@<?=$profile_data['username']?></span>
                    <div class="d-flex gap-2 align-items-center my-3">
                        <a class="btn btn-sm btn-danger buttonColor"><i class="bi bi-file-post-fill"></i> <?=count($profile_posts)?> posts</a>
                        <?php
                                if($profile_data['username']==$userdata['username'])
                                {
                            ?>
                                    <a class="btn btn-sm btn-danger buttonColor" data-bs-toggle="modal" data-bs-target="#supporter_list"><i class="bi bi-people-fill"></i> <?=count($profile_data['supporters'])?> Followers</a>
                                    <a class="btn btn-sm btn-danger buttonColor " data-bs-toggle="modal" data-bs-target="#supporting_list"><i class="bi bi-people-fill"></i> <?=count($profile_data['supporting'])?> Following</a>
                                    
                            <?php
                                }
                                else{
                            ?>
                                    <a class="btn btn-sm btn-danger buttonColor" ><i class="bi bi-people-fill"></i> <?=count($profile_data['supporters'])?> Followers</a>
                                    <a class="btn btn-sm btn-danger buttonColor" ><i class="bi bi-people-fill"></i> <?=count($profile_data['supporting'])?> Following</a>
                            <?php
                                }
                            ?>           
                    </div>
                    <?php
                        if($profile_data['username']!=$userdata['username'])
                        {
                    ?>      
                            <?php
                                if(checkBlockStatus($userdata['U_ID'],$profile_data['U_ID']))
                                {
                            ?> 
                                    <div class="d-flex gap-2 align-items-center my-1">
                                        <button class="btn btn-sm btn-danger buttonColor unblockbtn" data-user-id='<?=$profile_data['U_ID']?>' >Unblock</button>
                                    </div>        
                            <?php
                                }
                                else if(checkBlockStatus($profile_data['U_ID'],$userdata['U_ID']))
                                { 
                            ?>
                                    <div class="alert alert-danger" role="">
                                         <p class="fs-5 text-center" >@<?=$profile_data['username']?> blocked you !</p>
                                    </div>
                            <?php
                                }
                                       elseif(checkSupportstatus($userdata['U_ID'],$profile_data['U_ID']))
                                {
                            ?>
                                    <div class="d-flex gap-2 align-items-center my-1">
                                        <button class="btn btn-sm btn-danger buttonColor unsupportbtn" data-user-id="<?=$profile_data['U_ID']?>">Unsupport</button>
                                    </div>
                            <?php
                                }else
                                {
                            ?>
                                    <div class="d-flex gap-2 align-items-center my-1">
                                        <button class="btn btn-sm btn-danger buttonColor supportbtn" data-user-id="<?=$profile_data['U_ID']?>">Support</button>
                                    </div>
                            <?php
                                }
                            ?>
                    <?php
                        }
                    ?>

                </div>
            </div>
        </div>
        <h3 class="border-bottom">Posts</h3>
        <div class="container">
            <div class=" d-flex flex-wrap justify-content-center mb-4 row">
                <?php
                    if(checkBlk($profile_data['U_ID']))
                    {
                        $profile_posts = array();    
                ?>
                        <div class="text-center" role="">
                            <i class="bi bi-x-octagon-fill"></i><h6>You are not allowed to see posts !</h6>
                        </div>
                <?php
                        
                    }
                    elseif(count($profile_posts)<1)
                    {
                ?>
                        <div class="bg-white my-4 col-7 " role="alert">
                            <h5 class="p-2 fw-bold text-center">NO POST AVAILABLE!!!</h5>
                        </div>
                <?php
                    }
                ?>
                <?php
                    foreach($profile_posts as $post)
                    {
                ?>
                        <div class="card mt-4 col-9">
                        
                        <?php
                            if($post['post_img']!="NULL")
                            {
                        ?>
                                <img src="assets/img/posts/<?=$post['post_img']?>" class="" alt="...">
                        <?php
                            }
                        ?>

                        <?php
                            if($post['post_text']!="NULL")
                            {
                        ?>
                                <div class="card-body fw-bold border-bottom">
                                <?=$post['post_text']?>
                                </div>
                        <?php
                            }
                        ?>

                        <h4 style="font-size: x-larger" class="p-2">
                        <span>
                        <?php
                            if(checkLikestatus($post['P_ID']))
                            {
                                $like_btn_display='none';
                                $unlike_btn_display='';
                            }
                            else
                            {
                                $like_btn_display='';
                                $unlike_btn_display='none';
                            }
                        ?>
                        <i class="bi bi-heart-fill textColor unlikebtn" style="display:<?=$unlike_btn_display?>" data-post-id="<?=$post['P_ID']?>"></i>
                        <i class="bi bi-heart likebtn" style="display:<?=$like_btn_display?>" data-post-id="<?=$post['P_ID']?>"></i>
                        
                        </span>
                        &nbsp;&nbsp;
                        <i class="bi bi-chat-left" data-bs-toggle="modal" data-bs-target="#commentsof<?=$post['P_ID']?>"></i>
                        </h4>
                        <div class="d-inline-flex justify-content-end">
                            <span style="font-size:small" class="text-muted">Posted <?=show_time($post['created_at'])?></span> 
                        </div>
                        
                        <span class="p-1" data-bs-toggle="modal" data-bs-target="#likesof<?=$post['P_ID']?>">Loved by <?=likecount($post['P_ID'])?> people</span>
                        
                    </div>

                    <!--likes list modal-->
                    <div class="modal fade" id="likesof<?=$post['P_ID']?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Loves</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <?php
                                    $loves=getlikedata($post['P_ID']);
                                    foreach($loves as $lovedUser)
                                    {
                                        $lovedUser_data=getUserdata($lovedUser['user_ID']);
                                ?> 
                                        <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center p-2">
                                                    <div><img src="assets/img/profile_pic/<?=$lovedUser_data['profile_img']?>" alt="" height="40" class="rounded-circle border">
                                                    </div>
                                                    <div>&nbsp;&nbsp;</div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="?user=<?=$lovedUser_data['username']?>" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;"><?=$lovedUser_data['first_name']?> <?=$lovedUser_data['last_name']?></h6></a>
                                                        <p style="margin:0px;font-size:small" class="text-muted">@<?=$lovedUser_data['username']?></p>
                                                    </div>
                                                </div>
                                                <?php
                                                    if($lovedUser_data['username']!=$userdata['username'])
                                                    {
                                                ?>
                                                        <?php
                                                            if(checkSupportstatus($lovedUser_data['U_ID']))
                                                            {
                                                        ?>
                                                                <div class="d-flex gap-2 align-items-center my-1">
                                                                    <button class="btn btn-sm btn-danger buttonColor unsupportbtn" data-user-id="<?=$lovedUser_data['U_ID']?>">Unsupport</button>
                                                                </div>
                                                        <?php
                                                            }else
                                                            {
                                                        ?>
                                                                <div class="d-flex gap-2 align-items-center my-1">
                                                                    <button class="btn btn-sm btn-danger buttonColor supportbtn" data-user-id="<?=$lovedUser_data['U_ID']?>">Support</button>
                                                                </div>
                                                        <?php
                                                            }
                                                        ?>
                                                <?php
                                                    }
                                                ?>
                                                
                                                
                                            </div>
                                <?php
                                    }    
                                ?> 
                                </div> 
                            </div>
                        </div>
                    </div>

                    <!--  comment Modal -->
                    <div class="modal fade" id="commentsof<?=$post['P_ID']?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body d-flex p-0">
                                    <?php
                                        if($post['post_img']!="NULL")
                                        {
                                    ?>
                                            <div class="col-8">
                                                <img src="assets/img/posts/<?=$post['post_img']?>" class="w-100 rounded-start">
                                            </div>
                                    <?php
                                        }
                                        $poster_data_id=getPosterId($post['P_ID']);
                                        $poster_data=getUserdata($poster_data_id);
                                    ?>
                                    <div class="col-4 d-flex flex-column">
                                        <div class="d-flex align-items-center p-2 border-bottom">
                                            <div><img src="assets/img/profile_pic/<?=$poster_data['profile_img']?>" alt="" height="50" class="rounded-circle border">
                                            </div>
                                            <div>&nbsp;&nbsp;&nbsp;</div>
                                            <div class="d-flex flex-column justify-content-start align-items-center">
                                                <h6 style="margin: 0px;"><?=$poster_data['first_name']?> <?=$poster_data['last_name']?></h6>
                                                <p style="margin:0px;" class="text-muted">@<?=$poster_data['username']?></p>
                                            </div>
                                        </div>
                                        <?php
                                            if($post['post_text']!="NULL")
                                            {
                                        ?>
                                                <div class="d-flex align-items-center p-2 fw-bold border-bottom">
                                                <?=$post['post_text']?>
                                                </div>
                                        <?php
                                            }
                                        ?>
                                        <div class="flex-fill align-self-stretch overflow-auto" id="comment_section<?=$post['P_ID']?>" style="height: 100px;">
                                        <?php
                                            $comments=getcommentdata($post['P_ID']);
                                            if(count($comments)<1)
                                            {
                                        ?>
                                               <div class="bg-white my-4 p-1 " role="">
                                                    <p class="nocommentmsg text-center">No comments yet</p>
                                                </div> 
                                        <?php
                                            }
                                            foreach($comments as $commentedUser)
                                            {
                                                $commentedUser_data=getUserdata($commentedUser['user_ID']);
                                        ?> 
                                                <div class="d-flex align-items-center p-2">
                                                    <div><img src="assets/img/profile_pic/<?=$commentedUser_data['profile_img']?>" alt="" height="40" class="rounded-circle border">
                                                    </div>
                                                    <div>&nbsp;&nbsp;&nbsp;</div>
                                                    <div class="d-flex flex-column justify-content-start align-items-start">
                                                        <h6 style="margin: 0px;"><a href="?user=<?=$commentedUser_data['username']?>" class="text-decoration-none text-dark" > <?=$commentedUser_data['first_name']?> <?=$commentedUser_data['last_name']?></a></h6>
                                                        <p style="margin: 0px;" class="text-muted fs-6">@<?=$commentedUser_data['username']?></p>
                                                        <p style="margin:0px;" class=""><?=$commentedUser['comment_text']?></p>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                        <div class="input-group p-2 border-top">
                                            <input type="text" class="form-control rounded-0 border-0 comment_input" placeholder="add comment.."
                                                aria-label="Recipient's username" aria-describedby="button-addon2">
                                            <button class="btn btn-outline-danger rounded-0 border-0 add_comment_btn" data-cs="comment_section<?=$post['P_ID']?>" data-post-id="<?=$post['P_ID']?>" type="button"
                                                id="button-addon2">Post</button>
                                        </div>
                                    </div>



                                </div>

                            </div>
                        </div>
                    </div>
                        
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    


    <!--Supporter list modal-->
    <div class="modal fade" id="supporter_list" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supporters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?php
                    foreach($profile_data['supporters'] as $supporter)
                    {
                        $supporter_data=getUserdata($supporter['supporter_ID']);
                ?> 
                        <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center p-2">
                                    <div><img src="assets/img/profile_pic/<?=$supporter_data['profile_img']?>" alt="" height="40" class="rounded-circle border">
                                    </div>
                                    <div>&nbsp;&nbsp;</div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <a href="?user=<?=$supporter_data['username']?>" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;"><?=$supporter_data['first_name']?> <?=$supporter_data['last_name']?></h6></a>
                                        <p style="margin:0px;font-size:small" class="text-muted">@<?=$supporter_data['username']?></p>
                                    </div>
                                </div>
                                <?php
                                    if(checkSupportstatus($supporter_data['U_ID']))
                                    {
                                ?>
                                        <div class="d-flex gap-2 align-items-center my-1">
                                            <button class="btn btn-sm btn-danger buttonColor profileunsupportbtn" data-user-id="<?=$supporter_data['U_ID']?>">Unsupport</button>
                                        </div>
                                <?php
                                    }else
                                    {
                                ?>
                                        <div class="d-flex gap-2 align-items-center my-1">
                                            <button class="btn btn-sm btn-danger buttonColor profilesupportbtn" data-user-id="<?=$supporter_data['U_ID']?>">Support</button>
                                        </div>
                                <?php
                                    }
                                ?>
                                
                            </div>
                <?php
                    }    
                ?> 
                </div> 
            </div>
        </div>
    </div>

    <!--Supporting list modal-->
    <div class="modal fade" id="supporting_list" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supporting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?php
                    foreach($profile_data['supporting'] as $supporting)
                    {
                        $supporting_data=getUserdata($supporting['user_ID']);
                ?> 
                        <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center p-2">
                                    <div><img src="assets/img/profile_pic/<?=$supporting_data['profile_img']?>" alt="" height="40" class="rounded-circle border">
                                    </div>
                                    <div>&nbsp;&nbsp;</div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <a href="?user=<?=$supporting_data['username']?>" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;"><?=$supporting_data['first_name']?> <?=$supporting_data['last_name']?></h6></a>
                                        <p style="margin:0px;font-size:small" class="text-muted">@<?=$supporting_data['username']?></p>
                                    </div>
                                </div>
                                        <div class="d-flex gap-2 align-items-center my-1">
                                            <button class="btn btn-sm btn-danger buttonColor profileunsupportbtn" data-user-id="<?=$supporting_data['U_ID']?>">Unsupport</button>
                                        </div>    
                        </div>
                <?php
                    }    
                ?> 
                </div> 
            </div>
        </div>
    </div>

    
    
    