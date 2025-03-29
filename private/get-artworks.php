<?php
require_once('initialize.php');

// Get stored filters
$mediums = isset($_SESSION['medium']) ? $_SESSION['medium'] : [];

// check if secondary filters are set, if so add to query string, at the end make a query with it
    $secondary_filters = [];
    $artist = "";
    $department = "";
    $city = "";
    $state = "";
    $country = "";
    $accession_year = "";
    $culture = "";

    if(isset($_SESSION['artist_id'])){
        $secondary_filters['artist_id'] = $_SESSION['artist_id'];    
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
    if(isset($_SESSION['accession-year'])){
        $secondary_filters['accession_year'] = $_SESSION['accession-year'];
    }
    if(isset($_SESSION['culture'])){
        $secondary_filters['culture'] = $_SESSION['culture'];
    }

print_r($secondary_filters);

// Fetch artworks based on filters
$artworks = getArtworksFiltered($mediums, $secondary_filters);

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
