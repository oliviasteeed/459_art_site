<!-- details about one work -->

<!-- allows user to sign up -->
<?php
 require('header.php');
 require('functions.php');

 //check if there is a username in sessions
    // if yes - redirect to already signed in homepage

    // if no allow them to enter username and password
        //check that that username and password aren't already in the db 
            // already in the db - return error telling them to sign in instead
            // not already in the db - save information
                //hash the password
                //whitelist the username


 //if 

 ?>

 
<div class="page-card">


<!-- <?php //echo display_errors($errors); ?> -->

<div class="h-box">

    <!-- box for content -->
    <div class="v-box"> 

        <div class="v-box m-bottom">
            <div class="v-box m-bottom">
                <h1>work name</h1>
                <p><strong>Artist name</strong></p>
                <p>Medium, dimensions</p>
                <p>Year</p>
            </div>

            <div class='details-img-box'>
                <img class='details-img' src='https://media.timeout.com/images/106006274/1920/1440/image.webp'>
            </div>

            <div class="v-box m-bottom">
                <h4>about the work</h4>
                <p>Description Description Description Description Description Description Description Description Description Description Description Description Description </p>
            </div>

            <div class="v-box m-bottom">
                <h4>the details</h4>
                <p>City, State, Country</p>
                <p>Culture</p>
                <p>Period</p>
                <p>Accession Date</p>
                <p>Department</p>
            </div>
        </div>


      
    </div>

    <!-- box for buttons -->
    <div class="button-box">
        <a class="circle-button exit-button" href='index.php'>close</a>

        <form action="detailpage.php" method="post">
            <input class="circle-button" type="submit" value="fave <3"/>
        </form>
    </div>

</div>

</div>


<?php  require('footer.php'); ?>

