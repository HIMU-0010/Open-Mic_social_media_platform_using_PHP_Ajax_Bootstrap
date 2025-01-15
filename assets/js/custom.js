
//for previewing the post image
var input = document.querySelector("#postimg");
input.addEventListener("change", preview);

function preview()
{
    var fileobject = this.files[0];
    var filereader = new FileReader();

    filereader.readAsDataURL(fileobject);

    filereader.onload = function ()
    {
        var img_src = filereader.result;
        var img = document.querySelector("#displayimg");
        img.setAttribute('src', img_src);
        img.setAttribute('style', 'display:');
    }
}

//for support user
$(".supportbtn").click(function (){
    var userid = $(this).data('userId');
    var button = this;
    $(button).attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?support',
        method: 'post',
        datatype: 'json',
        data: {user_id: userid},
        success: function (response) {

            var response = JSON.parse(response);

            if(response.status)
            {
                $(button).data('userId', 0);
                $(button).html('<i class="bi bi-check-circle-fill"></i> Supported');
                location.reload();
            }
            else
            {
                $(button).attr('disabled', false);
                alert('something went wrong');
            }
        }
    });
});

//for support button in the user profile modal
$(".profilesupportbtn").click(function (){
    var userid = $(this).data('userId');
    var button = this;
    $(button).attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?support',
        method: 'post',
        datatype: 'json',
        data: {user_id: userid},
        success: function (response) {

            var response = JSON.parse(response);

            if(response.status)
            {
                $(button).data('userId', 0);
                $(button).html('<i class="bi bi-check-circle-fill"></i> Supported');
            }
            else
            {
                $(button).attr('disabled', false);
                alert('something went wrong');
            }
        }
    });
});

//for unsupport user
$(".unsupportbtn").click(function (){

    var userid = $(this).data('userId');
    var button = this;
    $(button).attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?unsupport',
        method: 'post',
        datatype: 'json',
        data: {user_id: userid},
        success: function (response) {

            var response = JSON.parse(response);

            if(response.status)
            {
                $(button).data('userId', 0);
                $(button).html('<i class="bi bi-check-circle-fill"></i> Unsupported');
                location.reload();
            }
            else
            {
                $(button).attr('disabled', false);
                alert('something went wrong');
            }
        }
    });
});

//for unsupport button in the user profile modal
$(".profileunsupportbtn").click(function (){

    var userid = $(this).data('userId');
    var button = this;
    $(button).attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?unsupport',
        method: 'post',
        datatype: 'json',
        data: {user_id: userid},
        success: function (response) {

            var response = JSON.parse(response);

            if(response.status)
            {
                $(button).data('userId', 0);
                $(button).html('<i class="bi bi-check-circle-fill"></i> Unsupported');
            }
            else
            {
                $(button).attr('disabled', false);
                alert('something went wrong');
            }
        }
    });
});


//for  dynamically like a the post
$(".likebtn").click(function (){

    var postid = $(this).data('postId');
    var button = this;
    $(button).attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?like',
        method: 'post',
        datatype: 'json',
        data: {post_id: postid},
        success: function (response) {

            var response = JSON.parse(response);
            
            if(response.status)
            {
                $(button).attr('disabled', false);
                $(button).hide();
                $(button).siblings(".unlikebtn").show();
                location.reload();
            }
            else
            {
                $(button).attr('disabled', false);
                alert('something went wrong');
            }
        }
    });
});

//for  dynamically unlike the post
$(".unlikebtn").click(function (){

    var postid = $(this).data('postId');
    var button = this;
    $(button).attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?unlike',
        method: 'post',
        datatype: 'json',
        data: {post_id: postid},
        success: function (response) {

            var response = JSON.parse(response);

            if(response.status)
            {
                $(button).attr('disabled', false);
                $(button).hide();
                $(button).siblings(".likebtn").show();
                location.reload();
            }
            else
            {
                $(button).attr('disabled', false);
                alert('something went wrong');
            }
        }
    });
});

//for  dynamically add comment
$(".add_comment_btn").click(function (){

    var postid = $(this).data('postId');
    var cs = $(this).data('cs');

    var button = this;
    var commentTxt = $(button).siblings(".comment_input").val();
    $(button).attr('disabled', true);

    if(commentTxt == '')
    {
        $(button).attr('disabled', false);
        return 0;
    }

    $(button).attr('disabled', true);
    $(button).siblings(".comment_input").attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?addcomment',
        type: "POST",
        datatype: 'json',
        data: {post_id: postid, comment_txt: commentTxt},
        success: function (response) {
            
            var response = JSON.parse(response);
            
            if(response.status)
            {
                $(button).attr('disabled', false);
                $(button).siblings(".comment_input").attr('disabled', false);
                $(button).siblings(".comment_input").val("");
                $(".nocommentmsg").hide();
                $("#"+cs).append(response.comment);
            }
            else
            {
                $(button).attr('disabled', false);
                $(button).siblings(".comment_input").attr('disabled', false);
                alert('something went wrong');
            }
        }
    });
});


//initialize timeago selector for post time 
jQuery(document).ready(function () {
    jQuery("time.timeago").timeago();
});


//for showing search box when focused
$("#search").focus(function () {
    $("#search_result").show();
});
//for hiding search box when clicked cross
$("#close_search").click(function () {
    $("#search_result").hide();
});
//for keyup function search
$("#search").keyup(function () {
    var keyword_v = $(this).val();
    console.log(keyword_v);

    $.ajax({
        url: 'assets/php/ajax.php?search',
        type: "POST",
        dataType: 'json',
        data: {keyword: keyword_v},
        success: function (response) {

            console.log(response);
            if (response.status) {
                $("#searchResultdiv").html(response.users);
            } else {
                $("#searchResultdiv").html('<p class="text-center text-muted">no user found !</p>');
            }
        }
    });

});


//to dynamically unblock user
$(".unblockbtn").click(function () {
    
    var user_id_v = $(this).data('userId');
    var button = this;
    $(button).attr('disabled', true);

    $.ajax({
        url: 'assets/php/ajax.php?unblock',
        method: 'post',
        dataType: 'json',
        data: { user_id: user_id_v },
        success: function (response) {
            console.log(response);
            if (response.status) 
            {
                location.reload();
            } 
            else 
            {
                $(button).attr('disabled', false);
                alert('something is wrong,try again after some time');
            }
        }
    });
});

//to dynamically set read_status of NTF to read and hide count icon from nav NTF icon
$("#NTF_icon").click(function () {

    $.ajax({
        url: 'assets/php/ajax.php?notread',
        method: 'post',
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status) 
            {
                $(".unread_NTF_count").hide();
            }
        }
    });

});
