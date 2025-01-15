<?php
    global $userdata;
?>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border">
        <div class="container col-9 d-flex justify-content-between">
            <div class="d-flex justify-content-between col-7">
                <a class="navbar-brand" href="?">
                    <img src="assets/img/open_mic.png" alt="" height="40" width="150">
                </a>
            </div>

            <form class="d-flex" id="searchform">
                    <input class="form-control me-2" type="search" id="search" placeholder="looking for someone.." aria-label="Search" autocomplete="off">
                    <div class="bg-white text-end rounded border shadow py-3 px-4 mt-5" style="display:none;position:absolute;z-index:+99;" id="search_result" data-bs-auto-close="true">
                        <button type="button" class="btn-close" aria-label="Close" id="close_search"></button>
                        <div id="searchResultdiv" class="text-start">
                            <p class="text-center text-muted">enter name or username</p>
                        </div>
                    </div>
            </form>

            <ul class="navbar-nav  mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link text-dark" href="?"><i class="bi bi-house-door-fill"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" data-bs-toggle="modal" data-bs-target="#addpost" href="#"><i class="bi bi-plus-square-fill"></i></a>
                </li>
                <li class="nav-item">
                <?php
                    if(getUnreadNotificationsCount()>0){
                ?>
                        <a class="nav-link text-dark position-relative" id="NTF_icon" data-bs-toggle="offcanvas" href="#notification_sidebar" role="button" aria-controls="offcanvasExample">
                                            <i class="bi bi-bell-fill"></i>
                        <span class="unread_NTF_count position-absolute start-10 translate-middle badge p-1 rounded-pill bg-danger">
                        <small><?=getUnreadNotificationsCount()?></small>
                        </span>
                        </a>

                <?php
                    }
                    else
                    {
                ?>
                        <a class="nav-link text-dark" data-bs-toggle="offcanvas" href="#notification_sidebar" role="button" aria-controls="offcanvasExample"><i class="bi bi-bell-fill"></i></a>
                <?php
                    }
                ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#"><i class="bi bi-chat-right-dots-fill"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/img/profile_pic/<?=$userdata['profile_img']?>" alt="" height="25" class="rounded-circle border">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="?user=<?=$userdata['username']?>"><i class="bi bi-person"></i> My Profile</a></li>
                        <!-- <li><a class="dropdown-item" href="#">Account Settings</a></li> -->
                        <li><a class="dropdown-item" href="?edit_profile"><i class="bi bi-pencil-square"></i> Edit Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="assets/php/actions.php?logout">Logout</a></li>
                    </ul>
                </li>

            </ul>
            
        </div>
    </nav>
   
    <!--Add post modal-->
    <div class="modal fade" id="addpost" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" style="display:none" id="displayimg" class="w-100 rounded border">
                    <form method="post" action="assets/php/actions.php?addpost" enctype="multipart/form-data">
                        <div class="my-3">

                            <input class="form-control" name="post_img" id="postimg" type="file" id="formFile">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Say Something...</label>
                            <textarea class="form-control" name="post_text" id="" rows="1"></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="post_anon" class="form-check-input" id="Check">
                            <label class="form-check-label" for="Check">Post Anonymously</label>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary buttonColor">Post</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>

    <!--offcanvas for notifiction bar-->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="notification_sidebar" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Notifications</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        <div class="offcanvas-body">
            <?php
                $notifications = getNotifications();
                foreach($notifications as $ntf)
                {
                    $time = $ntf['created_at'];
                    $user = getUserdata($ntf['from_user_ID']);
                    $post='';
                    if($ntf['post_ID'])
                    {
                        $post='data-bs-toggle="modal" data-bs-target="#postview'.$ntf['post_ID'].'"';
                        $post_data=getPostbypostid($ntf['post_ID']);
                    }
                    $fbtn='';
            ?>
                            <div class="d-flex justify-content-between border-bottom">
                                <div class="d-flex align-items-center p-2">
                                    <div><img src="assets/img/profile_pic/<?=$user['profile_img']?>" alt="" height="40" width="40" class="rounded-circle border">
                                    </div>
                                    <div>&nbsp;&nbsp;</div>
                                    <div class="d-flex flex-column justify-content-center" <?=$post?>>
                                        <a href='?user=<?=$user['username']?>' class="text-decoration-none text-dark"><h6 style="margin: 0px;font-size: small;"><?=$user['first_name']?> <?=$user['last_name']?></h6></a>
                                        <p style="margin:0px;font-size:small" class="<?=$ntf['read_status']?'text-muted':''?>">@<?=$user['username']?> <?=$ntf['ntf_msg']?></p>
                                        <time style="font-size:small" class="timeago <?=$ntf['read_status']?'text-muted':''?> text-small" datetime="<?=$time?>"></time>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                    <?php
                        if($ntf['read_status']==0)
                        {
                    ?>
                                <div class="p-1 bg-danger rounded-circle"></div>

                    <?php
                    }
                    elseif($ntf['read_status']==2)
                    {
                    ?>
                                <span class="badge bg-warning">Post Deleted</span>
                    <?php
                    }
                    ?>

                        </div>
                    </div>
                    <?php
                        if($ntf['post_ID'])
                        {
                    ?>
                            <!-- show post modal from notification offcanvas -->
                            <!-- <div class="modal fade" id="postview<?=$ntf['post_ID']?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body d-flex p-0">
                                            <?php
                                                if($post_data['post_img']!="NULL")
                                                {
                                            ?>
                                                    <div class="col-8">
                                                        <img src="assets/img/posts/<?=$post_data['post_img']?>" class="w-100 rounded-start">
                                                    </div>
                                            <?php
                                                }
                                                $poster_data_id=getPosterId($post_data['P_ID']);
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
                                                    if($post_data['post_text']!="NULL")
                                                    {
                                                ?>
                                                        <div class="d-flex align-items-center p-2 fw-bold border-bottom">
                                                        <?=$post_data['post_text']?>
                                                        </div>
                                                <?php
                                                    }
                                                ?>
                                                <div class="flex-fill align-self-stretch overflow-auto" id="comment_section<?=$post_data['P_ID']?>" style="height: 100px;">
                                                <?php
                                                    $comments=getcommentdata($post_data['P_ID']);
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
                                                    <button class="btn btn-outline-danger rounded-0 border-0 add_comment_btn" data-cs="comment_section<?=$post_data['P_ID']?>" data-post-id="<?=$post_data['P_ID']?>" type="button"
                                                        id="button-addon2">Post</button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div> -->
                    <?php
                        }
                    ?>
                    
            <?php
                }
            ?>     
        </div>
    </div>
