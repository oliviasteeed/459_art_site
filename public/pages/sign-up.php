<!-- allows user to sign up -->
<?php
require_once('../../private/initialize.php');
require('header.php');
$errors = [];

// go to browse page if already signed in 
if(isset($_SESSION['username'])) {
    redirect_to('browse.php');
}
    
if(is_post_request()){  
    if($_POST['password'] === $_POST['password_confirm']){  //only proceed if entered passwords are the same

      //check if there is a user with the same name in the database
      $username_result = checkUsername($_POST['username']);

      //if count is not 0 that means an account with this username already exists
      if($username_result['count'] != 0){
        array_push($errors, 'This username is already in use. Please try another one or <a href="log-in.php">log in</a> to your account.');
      }
      else
      {  //if there are no other users with this username, save it to the database

        //check that email is valid
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "Valid email!";

            // check that first and last names are valid
            if (!is_numeric($_POST['first_name']) && !is_numeric($_POST['last_name'])) {
            
                $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); //hash the password

                //adding user details to database
                if(addUser($_POST['username'], $hashed_password, $_POST['email'], $_POST['first_name'], $_POST['last_name'])){
                    
                    //if it works, save username in session 
                    $_SESSION['username'] = $_POST['username'];
                    redirect_to('browse.php');
                }
                else{ //sql insertion error
                    array_push($errors, mysqli_error($db));
                }
            } 
            else{ //invalid first and last names
                    array_push($errors, 'Names cannot include numbers, please try again.');
                }

            } else {    //if email is invalid do not save to database
            array_push($errors, 'Invalid email address, please try again.');
        }
      }

    }else{  // if passwords don't match do not save to database
      array_push($errors, "Passwords don't match, please try again :)");
    }
} 


 ?>

 
<div class="page-card">


<!-- <?php //echo display_errors($errors); ?> -->

<form action="sign-up.php" method="post">

<div class="h-box">

    <div class="v-box">

        <div class="v-box m-bottom">
            <h1>sign up for greatness</h1>
            <p>An account allows you to save your faves.<br>You can always change your account details except username later, so don't worry too much about it.</p>
            <!-- show errors from PHP -->
            <?php display_errors($errors); ?>
        </div>


        <div class="h-box m-bottom">
            <div class="v-box">
                <?php echo create_text_input("first name", "first_name");  ?>
            </div>

            <div class="v-box">
                <?php echo create_text_input("last name", "last_name");  ?>
            </div>
        </div>

        <div class="h-box m-bottom">
            <div class="v-box">
                <?php echo create_text_input("email", "email");  ?>
            </div>

            <div class="v-box">
                <?php echo create_text_input("username", "username");  ?> 
            </div>
        </div>

        <div class="h-box">
            <div class="v-box">
                <?php echo create_text_input("password", "password");  ?>
            </div>

            <div class="v-box">
                <?php echo create_text_input("confirm password", "password_confirm");  ?>
            </div>
        </div>

    </div>

    <div class="button-box">
        <a class="circle-button exit-button" href='browse.php'>cancel</a>
        <input class="circle-button" type="submit" value="sign up"/>
    </div>

</div>
</form>

</div>


<?php  require('footer.php'); ?>

