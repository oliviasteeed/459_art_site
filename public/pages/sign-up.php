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
      $username_stmt = $db->prepare("SELECT COUNT(*) as count FROM members WHERE username = ?");
      $username_stmt->bind_param("s", $_POST['username']);

      // execute prepared statement and get result
      $username_stmt->execute();
      $username_result = $username_stmt->get_result();
      $username_result_row = $username_result->fetch_assoc();

      //if count is not 0 that means an account with this username already exists
      if($username_result_row['count'] != 0){
        array_push($errors, 'This username is already in use. Please try another one or <a href="log-in.php">log in</a> to your account.');
      }else{  //if there are no other users with this username, save it to the database

        //check that email is valid
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "Valid email!";

            // check that first and last names are valid
            if (!is_numeric($_POST['first_name']) && !is_numeric($_POST['last_name'])) {
            
                $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); //hash the password

                // prepare statement
                $insert_stmt = $db->prepare("INSERT INTO members (username, password_hash, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
        
                // bind parameters
                $insert_stmt->bind_param('sssss', $_POST['username'], $hashed_password, $_POST['email'], $_POST['first_name'], $_POST['last_name']);
        
                // execute statement and handle errors
                if ($insert_stmt->execute()) {
                    //save username in session 
                    $_SESSION['username'] = $_POST['username'];
        
                    // release resources
                    $insert_stmt->close();
                    $db->close();
        
                    //redirect to browse page but logged in
                    redirect_to('browse.php');

            } else {
                array_push($errors, 'Names cannot include numbers, please try again.');
            }

           

        } else {    //if email is invalid do not save to database
            array_push($errors, 'Invalid email address, please try again.');
        }
          
        } else {    // if database error, display error message
            array_push($errors, mysqli_error($db));
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
            <p>An account allows you to save your favourites to a new album you can always refer to plus changes the button hover effects to red! Sounds worth it to me.</p>
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

