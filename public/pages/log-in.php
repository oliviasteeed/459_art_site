<!-- allows user to sign up -->
<?php

require_once('../../private/initialize.php');

require('header.php');

$errors = [];
$username = '';
$password = '';

// if username already set, redirect to browse page
if(isset($_SESSION['username'])) {
    redirect_to(url_for('index.php'));
}

if(is_post_request()) {
  
    if(!empty($_POST['username']) && !empty($_POST['password'])){

        //check if there is a user with the same password in the database
        $password_stmt = $db->prepare("SELECT password_hash FROM members WHERE username = ?");
        $password_stmt->bind_param("s", $_POST['username']);

        // execute prepared statement and get result
        $password_stmt->execute();
        $password_result = $password_stmt->get_result();
        $password_result_row = $password_result->fetch_assoc();

        // if that password is saved in the db, check if entered username matches what is in db
        if(mysqli_num_rows($password_result) != 0){
            $hashed_password = $password_result_row['password_hash'];
            
            //user pw verify to check if entered pw matches hashed saved password
            if(password_verify($_POST['password'], $hashed_password)){
            
            //store username in session and redirect to browse but logged in
            $_SESSION['username'] = $_POST['username'];
            redirect_to('browse.php');
            }
            else{   //if verify fails, display error message
            array_push($errors, "Incorrect username and password combination :( please try again.");
            }


          }else{
            array_push($errors, "This account does not exist, please try again or <a href='sign-up.php'>sign up</a> for a new account.");
          }
    }
}



 ?>

 
<div class="page-card">


<!-- <?php //echo display_errors($errors); ?> -->

<form action="log-in.php" method="post">

<div class="h-box">

    <div class="v-box">

        <div class="v-box m-bottom">
            <h1>get back into it</h1>
            <p>Welcome back, we missed you.</p>

            <!-- show errors from PHP -->
            <?php display_errors($errors); ?>
        </div>

        <div class="h-box m-bottom">
            <div class="v-box">
                <label for="username">username</label>
                <input type="text" id="username" name="username" required/>
            </div>

            <div class="v-box">
                <label for="password">password</label>
                <input type="text" id="password" name="password" required/>
            </div>
        </div>

    </div>

    <div class="button-box">
        <a class="circle-button exit-button" href='browse.php'>cancel</a>
        <input class="circle-button" type="submit" value="log in"/>
    </div>

</div>
</form>

</div>


<?php  require('footer.php'); ?>

