<!-- allows user to sign up -->
<?php
require_once('../../private/initialize.php');
require('header.php');
$errors = [];

// get user info
$userInfo = getUserInfo($_SESSION['username']);

    
if(is_post_request()){  

    // check if new username is valid

    // check if new email is valid

    // check if new first name is valid

    // check if new last name is valid 
    
}





 ?>

 
<div class="page-card">


<!-- <?php //echo display_errors($errors); ?> -->

<form action="sign-up.php" method="post">

<div class="h-box">

    <div class="v-box">

        <div class="v-box m-bottom">
            <h1>profile</h1>
            <p>Here you can see all your account details and change them too!</p>
            <!-- show errors from PHP -->
            <?php display_errors($errors); ?>
        </div>


        <div class="h-box m-bottom">
            <div class="v-box">
                <?php create_editable_profile_field("first name", "first_name", $userInfo[0]['first_name']);  ?>
            </div>

            <div class="v-box">
                <?php create_editable_profile_field("last name", "last_name", $userInfo[0]['last_name']);  ?>
            </div>
        </div>

        <div class="h-box m-bottom">
            <div class="v-box">
                <?php create_editable_profile_field("email", "email", $userInfo[0]['email']);  ?>
            </div>

            <div class="v-box">
                <?php create_editable_profile_field("username", "username", $userInfo[0]['username']);  ?> 
            </div>
        </div>

    </div>

    <div class="button-box">
        <a class="circle-button exit-button" href='browse.php'>cancel</a>
        <input class="circle-button" type="submit" value="save"/>
    </div>

</div>
</form>

</div>


<?php  require('footer.php'); ?>

