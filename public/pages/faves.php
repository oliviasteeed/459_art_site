<?php
require('../../private/initialize.php');
require('header.php');

$artworks = [];
if (isset($_SESSION['username'])){
    $artworks = getFaveArtworks($_SESSION['username']); 
    if(count($artworks) == "0"){
        echo "<div class='left-align artwork-box'>";
        echo "<div class='v-box'>";
        echo "<h1>You have no faves :,(</h1>";
        echo "<p>How sad. You should head over <a href='browse.php'>here</a> to find some.</p>";
        echo "</div>";
        echo "</div>";
    }
    else{
        // create object cards for each artwork
        echo "<div class='left-align artwork-box'>";
        echo "<div class='artwork-box' id='artwork-box'>";
        foreach($artworks as $a){
            create_object_card($a);
        }
        echo "</div>";
        echo "</div>";
    }
}
else{   //redirect to browse if they somehow got here and are not logged in
    redirect_to(url_for('index.php'));
}




 require('footer.php');

?>


