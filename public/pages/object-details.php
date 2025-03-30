<!-- details about one work -->

<?php
require('../../private/initialize.php');
require('header.php');
echo "<script src='../../private/js/object-details.js' type='text/javascript'></script>";


if(isset($_SESSION['username'])) {
    // give them option to favourite
    // give them option to comment (optional - if we have time)
}


$object_details = [];   //array to save details

if(isset($_GET['object_id'])) {    //this should always be set - gives id to get all artwork information with
    // echo "id is set";
    $object_details = getObjectInfo($_GET['object_id']);
}


    if (isset($_SESSION['username'])) {
        $faveArtworks = getFaves($_SESSION['username']);

        if(in_array($object_details[0]['object_id'], $faveArtworks)){
            echo "<div class='art-container object-details-page fave-artwork' id='{$object_details[0]['object_id']}'>";
        } 
        else{
            echo "<div class='art-container object-details-page' id='{$object_details[0]['object_id']}'>";

            //TODO: make it so you can fave from details page
    } 
}

 ?>

 


<!-- <?php //echo display_errors($errors); ?> -->

<div class="h-box">

    <!-- box for content -->
    <div class="v-box"> 

        <div class="v-box">
            <div class="v-box">
                <?php 
                echo "<h1>".$object_details[0]['title'] ."</h1>";
                echo "<p>".$object_details[0]['artist_id'] ."</p>";
                echo "<p>".$object_details[0]['medium']." (".$object_details[0]['dimensions'].")<p>";
                ?>
            </div>

            <div class='details-img-box'>
                <?php
                    $image_path = $object_details[0]['image_src'];
                    echo "<img class='details-img' src='{$image_path}'>";
                ?>
            </div>

            <div class="v-box">
                <h4>the details</h4>
                <?php
                echo "<p>Location: ".$object_details[0]['city'].", ".$object_details[0]['state'].", ".$object_details[0]['country']."</p>";
                echo "<p>Culture: ".$object_details[0]['culture']."</p>";
                echo "<p>Accession Year: ".$object_details[0]['accession_year']."</p>";
                echo "<p>Department: ".$object_details[0]['department']."</p>";
                ?>
            </div>
        </div>


      
    </div>

    <!-- box for buttons -->
    <div class="button-box">
        <a class="circle-button exit-button" href='browse.php'>close</a>

        <?php
        // favourite button only visible if you are logged in
        if (isset($_SESSION['username'])) {
            $faveArtworks = getFaves($_SESSION['username']);
            if(in_array($object_details[0]['object_id'], $faveArtworks)){
                echo "<a class='circle-button fave-button' href='../../private/favourite.php?object_id=" . urlencode($object_details[0]['object_id']) . "'>unfave &lt;/3</a>";
            }
            else{
                echo "<a class='circle-button fave-button' href='../../private/favourite.php?object_id=" . urlencode($object_details[0]['object_id']) . "'>fave <3</a>";
            }  
            }
        ?>

    </div>

</div>

</div>


<?php  require('footer.php'); ?>

