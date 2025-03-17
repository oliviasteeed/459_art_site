<?php

require('initialize.php');

//save favourite object id to database with user id

if (insert_fave($_SESSION['username'], $_GET['object_id'])){
    echo "Favourite saved!";
}else{
    echo "Error saving favourite.";
}



?>