<!-- details about one work -->

<?php
require('../../private/initialize.php');
require('header.php');


if(isset($_SESSION['username'])) {
    // give them option to favourite
    // give them option to comment (optional - if we have time)
}


$object_details = [];   //array to save details
$artist_details = [];

if(isset($_GET['object_id'])) {    //this should always be set - gives id to get all artwork information with
    // echo "id is set";
    $object_details = getObjectInfo($_GET['object_id']);
    $artist_details = getArtistInfo($_GET['object_id']);
}


 ?>

 
<div class="page-card">


<!-- <?php //echo display_errors($errors); ?> -->

<div class="h-box">

    <!-- box for content -->
    <div class="v-box"> 

        <div class="v-box m-bottom">
            <div class="v-box m-bottom">
                <?php 
                echo "<h1>".$object_details[0]['title'] ."</h1>";
                // echo "<p>".$object_details[0]['artist_display_name'] ."</p>";
                echo "<p>".$object_details[0]['medium']." (".$object_details[0]['dimensions'].")<p>";
                echo "<p>".$artist_details[0]."</p>";
                ?>
            </div>

            <div class='details-img-box'>
            <?php
                $image = "../../img/" . $_GET['object_id'] . ".jpg";
                echo "<img class='details-img' src='" . $image . "'>";
            ?>
            </div>

            <div class="v-box m-bottom">
                <h4>the details</h4>
                <?php
                echo "<p>".$object_details[0]['city'].", ".$object_details[0]['state'].", ".$object_details[0]['country']."</p>";
                echo "<p>".$object_details[0]['culture']."</p>";
                echo "<p>".$object_details[0]['department']."</p>";
                ?>
            </div>
        </div>


      
    </div>

    <!-- box for buttons -->
    <div class="button-box">
        <a class="circle-button exit-button" href='browse.php'>close</a>

        <form action="detailpage.php" method="post">
            <input class="circle-button" type="submit" value="fave <3"/>
        </form>
    </div>

</div>

</div>


<?php  require('footer.php'); ?>

