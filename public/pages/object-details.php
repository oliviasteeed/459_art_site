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
    // $object_details = getObjectInfo($_GET['object_id']);
    $object_details = getObjectInfo($_GET['object_id']);
    $artist_details = getArtistInfo($_GET['object_id']);

    //if they have a username check if this is a fave
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
else{   //echo start of divs even if not logged in
    echo "<div class='art-container object-details-page' id='{$object_details[0]['object_id']}'>";
}



}else{
    //show error here
}







 ?>

 


<!-- <?php //echo display_errors($errors); ?> -->

<div class="h-box">

    <!-- box for content -->
    <div class="v-box"> 

        <div class="v-box">
            <div class="v-box">
                <?php 
                $artist = $object_details[0]['artist_display_name'] ?? 'No artist information';
                $title = $object_details[0]['title'] ?? 'No title information';

                echo "<h1>".$title."</h1>";
                echo "<p class='italic'>".$artist."</p>";
                ?>
            </div>

            <div class='details-img-box'>
                <?php
                    // $image_path = $object_details[0]['image_src'];
                    $image = "../../img/" . $_GET['object_id'] . ".jpg";
                    echo "<img class='details-img' src='" . $image . "'>";
                    // echo "<img class='details-img' src='{$image_path}'>";
                ?>
            </div>

            <div class="v-box">
                <h4>the details</h4>
                <?php

                $medium = $object_details[0]['medium'] ?? 'No medium information';
                $object_name = $object_details[0]['object_name'] ?? 'No object name information';
                $dimensions = $object_details[0]['dimensions'] ?? 'No dimensions information';
                $city = $object_details[0]['city'] ?? 'No city information';
                $state = $object_details[0]['state'] ?? 'no state information';
                $country = $object_details[0]['country'] ?? 'no country information';
                $culture = $object_details[0]['culture'] ?? 'No culture information';
                $department = $object_details[0]['department'] ?? 'No department information';

                echo "<p><strong>Object Type:</strong> ".$object_name."</p>";
                echo "<p><strong>Medium:</strong> ".$medium."</p>";
                echo "<p><strong>Dimensions:</strong> ".$dimensions."<p>";
                echo "<p><strong>Location:</strong> ".$city.", ".$state.", ".$country."</p>";
                echo "<p><strong>Culture</strong> ".$culture."</p>";
                echo "<p><strong>Department:</strong> ".$department."</p>";
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

