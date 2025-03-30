<?php
require('initialize.php');

//save favourite object id to database with user id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {

    if($_POST['fave'] == "True"){ //if user is adding a fave
        if (insertFave($_SESSION['username'], $_POST['id'])){
            // echo "Favourite saved!";
        }else{
            echo "Error saving favourite.";
        }
    }else if ($_POST['fave'] == "False"){  //if user is removing a fave

        // remove from database
        if (removeFave($_SESSION['username'], $_POST['id'])){
            // echo "Favourite removed.";
        }else{
            echo "Error removing favourite.";
        }
    }

    $artworks = getFaveArtworks($_SESSION['username']); 

    $output = "";
    foreach ($artworks as $a) {
        $output .= create_object_card($a);
    }
    if (empty($artworks)){
        $output = "<div class='v-box'> 
        <h1>You have no faves :,(</h1> 
        <p>How sad. You should head over <a href='browse.php'>here</a> to find some.</p>
        </div>";
    }

    echo $output;

}else{
        echo "Invalid request (favourite.php)";
    }





?>