<?php
    global $userdata;
    global $posts;
    global $supporter_suggestion;
?>

    <div class="container col-9 rounded-0 d-flex justify-content-between">

        <div class="col-8">
            <?=showErrors('post')?>
            <?php
                if(count($posts)<1)
                {
            ?>
                    <div class="alert alert-danger my-2" role="alert">
                        <h5 class="p-2 fw-bold text-center">NO POST is available right now to be shown!!!</h5>
                        <p class="p-2 fw-bold text-center">Follow someone or add a new post to see new contents in your wall</p>
                    </div>
            <?php
                }
            ?>
            <?php
                foreach($posts as $post)
                {
            ?>
                <div class="card mt-4">
                    <div class="card-title d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center p-2">
                            <img src="assets/img/profile_pic/<?=$post['profile_img']?>" alt="" height="30" class="rounded-circle border">&nbsp;&nbsp;<a href="?user=<?=$post['username']?>" class="text-decoration-none text-dark"><h6><?=$post['first_name']?> <?=$post['last_name']?></h6></a>
                        </div>
                        <div class="p-2">
                            <span style="font-size:small" class="text-muted">Posted</span> <?=show_time($post['created_at'])?>
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                    </div>
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

                    <span class="p-1 mx-1" data-bs-toggle="modal" data-bs-target="#likesof<?=$post['P_ID']?>">Loved by <?=likecount($post['P_ID'])?> people</span>
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
                                               <div class="bg-white my-4 p-1" role="">
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

        <div class="col-4 mt-4 p-3 mx-5">
            <div class="d-flex align-items-center p-2">
                <div><img src="assets/img/profile_pic/<?=$userdata['profile_img']?>" alt="" height="50" class="rounded-circle border">
                </div>
                <div>&nbsp;&nbsp;&nbsp;</div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <a href="?user=<?=$userdata['username']?>" class="text-decoration-none text-dark"><h6 style="margin: 0px;"><?=$userdata['first_name']?> <?=$userdata['last_name']?></h6></a>
                    <p style="margin:0px;" class="text-muted">@<?=$userdata['username']?></p>
                </div>
            </div>
            <div>
                <h6 class="text-muted p-2">You Can Support Them</h6>
                <?php
                    foreach($supporter_suggestion as $supporter)
                    {
                ?>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center p-2">
                                <div><img src="assets/img/profile_pic/<?=$supporter['profile_img']?>" alt="" height="40" class="rounded-circle border">
                                </div>
                                <div>&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-center">
                                    <a href="?user=<?=$supporter['username']?>" class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;"><?=$supporter['first_name']?> <?=$supporter['last_name']?></h6></a>
                                    <p style="margin:0px;font-size:small" class="text-muted">@<?=$supporter['username']?></p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-danger buttonColor supportbtn" data-user-id="<?=$supporter['U_ID']?>" >support</button>
                            </div>
                        </div>
                <?php
                    }
                ?>
                <?php
                    if(count($supporter_suggestion)<1)
                    {
                ?>
                        <p class="p-2 fw-bold bg-white border rounded text-center">You have supported everyone!!!</p>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>

    

<?php
    unset($_SESSION['error']);
?>
