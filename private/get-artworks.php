<?php
//idek if this is called
require_once('initialize.php');

// Get stored filters
$culture = isset($_SESSION['culture']) ? $_SESSION['culture'] : [];

// check if secondary filters are set, if so add to query string, at the end make a query with it
    $secondary_filters = [];
    $artist = "";
    $department = "";
    $city = "";
    $state = "";
    $country = "";
    $object_name = "";
    $medium = "";

    if(isset($_SESSION['artist_display_name'])){
        $secondary_filters['artist_display_name'] = $_SESSION['artist_display_name'];    
    }
    if(isset($_SESSION['department'])){
        $secondary_filters['department'] = $_SESSION['department'];
    }
    if(isset($_SESSION['city'])){
        $secondary_filters['city'] = $_SESSION['city'];
    }
    if(isset($_SESSION['state'])){
        $secondary_filters['state'] = $_SESSION['state'];
    }
    if(isset($_SESSION['country'])){
        $secondary_filters['country'] = $_SESSION['country'];
    }
    if(isset($_SESSION['medium'])){
        $secondary_filters['medium'] = $_SESSION['medium'];
    }
    if(isset($_SESSION['object_name'])){
        $secondary_filters['object_name'] = $_SESSION['object_name'];
    }

// print_r($secondary_filters);

// Fetch artworks based on filters
$artworks = getArtworksFiltered($culture, $secondary_filters);

$output = "";
if (count($artworks) > 0) {
    foreach ($artworks as $a) {
        $output .= create_object_card($a); // Function that generates artwork HTML
    }
} else {
    $output = "<p>No artworks found.</p>";
}

echo $output;
?>
