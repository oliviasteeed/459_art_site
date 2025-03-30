<?php
require('../../private/initialize.php');
require('header.php');

$artworks = [];
if (isset($_SESSION['username'])){
    $artworks = getFaveArtworks($_SESSION['username']); 
    if(count($artworks) == "0"){
        // echo "<div class='page-card'>";
        echo "<div class='v-box'>";
        echo "<h1>You have no faves :,(</h1>";
        echo "<p>How sad. You should head over <a href='browse.php'>here</a> to find some.</p>";
        echo "</div>";
        // echo "</div>";
    }
    else{
        // create object cards for each artwork
        echo "<div class='artwork-box'>";
        foreach($artworks as $a){
            create_object_card($a);
        }
        echo "</div>";

    }
}







 require('footer.php');

?>


