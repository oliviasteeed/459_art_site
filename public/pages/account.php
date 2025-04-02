<!-- allows user to sign up -->
<?php
require_once('../../private/initialize.php');
require('header.php');
$errors = [];

if(is_post_request()){  

    // check if password was reset
    if (isset($_POST['new_password']) && !empty($_POST['new_password']) && isset($_POST['current_password']) && !empty($_POST['current_password'])){
        // check if entered current password is correct
        $saved_password = getUserInfo($_SESSION['username'], 'password');

        if(password_verify($_POST['current_password'], $saved_password)){
            $hashed_new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); //hash the new password
            updateUserInfo($_SESSION['username'], 'password_hash', $hashed_new_password);
            array_push($errors, "Password successfully updated :)");
        }
        else{
            array_push($errors, "Incorrect current password, please try again :(");
        }
    }

    // updating first name
    if (isset($_POST['first_name']) && !empty($_POST['first_name'])){
        if (!is_numeric($_POST['first_name'])) {
            //make sure input is different before updating
            if($_POST['first_name'] != getUserInfo($_SESSION['username'], 'first_name')){
                updateUserInfo($_SESSION['username'], 'first_name', $_POST['first_name']);
                array_push($errors, "First name successfully updated :)");
            }
        }else{
            array_push($errors, "First name cannot include numbers :(");
        }
    }

    // updating last name
    if (isset($_POST['last_name']) && !empty($_POST['last_name'])){
        if (!is_numeric($_POST['last_name'])) {
            //make sure input is different before updating
            if($_POST['last_name'] != getUserInfo($_SESSION['username'], 'last_name')){
                updateUserInfo($_SESSION['username'], 'last_name', $_POST['last_name']);
                array_push($errors, "Last name successfully updated :)");
            }
        }else{
            array_push($errors, "Last name cannot include numbers :(");
        }
    }

    // updating email
    if (isset($_POST['email']) && !empty($_POST['email'])){
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            //make sure input is different before updating
            if($_POST['email'] != getUserInfo($_SESSION['username'], 'email')){
                updateUserInfo($_SESSION['username'], 'email', $_POST['email']);
                array_push($errors, "Email successfully updated :)");
            }
        }else{
            array_push($errors, "Invalid email address, please try again :(");
        }
    }
}

 ?>

 
<div class="page-card  m-bottom">

        <div class="v-box">
            <div class="h-box small-m-bottom">
                <div class='v-box'>
                    <h1>edit account details</h1>
                    <!-- show errors from PHP -->
                    <?php display_errors($errors); ?>
                </div>
                <div class="button-box">
                    <a class="circle-button exit-button" href='browse.php'>close</a>
                </div>
            </div>

            <form action="account.php" method="post">
                <div class="h-box m-bottom">    
                    <div class="v-box">
                            <h3>update account details</h3>
                            <p class='small-m-bottom'>To update account details, change the desired field, and enter your current password to confirm. Note that you cannot change your username.</p> 

                            <div class="h-box m-bottom">
                                <div class="v-box">
                                    <?php echo create_text_input_account("first name", "first_name");  ?>
                                </div>

                                <div class="v-box">
                                    <?php echo create_text_input_account("last name", "last_name");  ?>
                                </div>
                            </div>

                            <div class="h-box m-bottom">
                                <div class="v-box">
                                    <?php echo create_text_input_account("email", "email");  ?>
                                </div>

                                <div class="v-box">
                                    <?php echo create_text_input_account("username", "username");  ?> 
                                </div>
                            </div>

                            <div class="h-box">
                                <div class="v-box">
                                    <?php echo create_text_input_account("password", "current_password");  ?>
                                </div>
                            </div>
                    </div>

                    <div class="button-box-bottom">
                        <input class="circle-button" type="submit" value="save"/>
                    </div>
                </div>   
            </form>

            <form action="account.php" method="post">
                <div class="h-box m-bottom">    
                    <div class="v-box">
                            <h3>update password</h3>
                            <p class='small-m-bottom'>To update your password, please type your current password, and then your new password.</p> 

                            <div class="h-box">
                                <div class="v-box">
                                    <?php echo create_text_input_account("current password", "current_password");  ?>
                                </div>

                                <div class="v-box">
                                    <?php echo create_text_input_account("new password", "new_password");  ?>
                                </div>
                            </div>
                    </div>

                    <div class="button-box-bottom">
                        <input class="circle-button" type="submit" value="save"/>
                    </div>
                </div>   
            </form>

            
        </div>
        </div>

 







<?php  require('footer.php'); ?>

