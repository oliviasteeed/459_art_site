<!-- main page -->
 <?php
require('../../private/initialize.php');
require('header.php');

 if(isset($_SESSION['username'])) {


    }

    // get list of mediums from db 
    //TODO: MAKE THIS BASED ON ACTUAL DB
    $mediums_array = getDbColumn('medium', 'MetObjects');

    //get secondary filter options from db 
    //TODO: MAKE THIS BASED ON ACTUAL DB
    $artists_array = getDbColumn('artist_id', 'MetObjects'); 
    $artists_array[0] = "select artist"; 

    $department_array = getDbColumn('department', 'MetObjects');
    $department_array[0] = "select department"; 

    $dimensions_array = getDbColumn('dimensions', 'MetObjects');
    $dimensions_array[0] = "select dimensions"; 

    $city_array = getDbColumn('city', 'MetObjects');
    $city_array[0] = "select city";

    $state_array = getDbColumn('state', 'MetObjects');
    $state_array[0] = "select state"; 

    $country_array = getDbColumn('country', 'MetObjects');
    $country_array[0] = "select country"; 

    $accession_year_array = getDbColumn('accession_year', 'MetObjects');
    $accession_year_array[0] = "select accession year";

    $culture_array = getDbColumn('culture', 'MetObjects');
    $culture_array[0] = "select culture"; 

    $selected_mediums = []; //initialize empty array for which mediums tag buttons are selected
    
    $secondary_filters = [
        'artist_id' => $_SESSION['artist_id'] ?? null,
        'department' => $_SESSION['department'] ?? null,
        'dimensions' => $_SESSION['dimensions'] ?? null,
        'city' => $_SESSION['city'] ?? null,
        'state' => $_SESSION['state'] ?? null,
        'country' => $_SESSION['country'] ?? null,
        'accession_year' => $_SESSION['accession_year'] ?? null,
        'culture' => $_SESSION['culture'] ?? null,
    ];

    $artworks = []; //initialize empty array for artworks (by medium)

    if(is_post_request()){ //if medium filters have been submitted
        if(isset($_POST['medium'])){
            $selected_mediums = $_POST['medium']; // get user input
            $_SESSION['medium'] = $selected_mediums;

            $artworks = getArtworksFiltered($selected_mediums, $secondary_filters); // get artworks with this medium from db

            // get artworks with this medium from db
            // $artworks = getArtworks($selected_mediums);
            // print_r($artworks);
            
        } else {    //clear anything saved
            // echo "No medium selected, session cleared";
            unset($_SESSION['medium']);
            $artworks = getArtworksFiltered($mediums_array, $secondary_filters);    //get all artworks if no filters applied
            // print_r($artworks);
        }
    }else{
        $artworks = getArtworksFiltered($mediums_array, $secondary_filters);
        // $artworks = getArtworks($mediums_array);    //get all artworks if no filters applied
    }

    // Fetch filters from session
// $mediums = isset($_SESSION['medium']) ? $_SESSION['medium'] : [];

// $artworks = getArtworksFiltered($mediums, $secondary_filters);



// ACTUAL UI

echo "<h1>i'm interested in...</h1>";

//create tags for each medium
echo "<h4>medium</h4>";

// form for medium filters
echo "<form class='h-box' action='browse.php' method='post'>";
echo "<div class='h-box flex-3'>";
foreach($mediums_array as $m){
    create_tag($m, $selected_mediums);
}
echo "</div>";

// hidden input container for storing selected medium tags (since they are buttons not form elements)
echo "<div id='selected-tags'>";
if(isset($_SESSION['medium'])){    //put selected tags in post request always
    foreach($_SESSION['medium'] as $m){
        echo "<input type='hidden' name='medium[]' value='$m'>";
    }
}
echo "</div>";

echo "<div class='button-box flex-1'>";
echo "<input class='circle-button' type='submit' value='go >'/>";
echo "</div>";
echo "</form>";

echo "<h4>artwork details</h4>";
echo "<div class='h-box'>";

echo "<div class='flex-3'>";
echo create_select_input("artist_id", $artists_array);
echo create_select_input("department", $department_array);
echo create_select_input("dimensions", $dimensions_array);
echo create_select_input("city", $city_array);
echo create_select_input("state", $state_array);
echo create_select_input("country", $country_array);
echo create_select_input("accession_year", $accession_year_array);
echo create_select_input("culture", $culture_array);
echo "</div>";

echo "<div class='button-box flex-1'>";
echo "<button class='circle-button' id='reset-button'>reset</button>";
echo "</div>";

echo "</div>";


// need to use jquery to see when clicked on, save in session, do something, initiate filter by

// $_SESSION['username'] = $_POST['username'];

// $_SESSION['mediums_selected'][] = $_POST['mediums_selected'];





// create object cards for each artwork
echo "<div class='artwork-box' id='artwork-box'>";
foreach($artworks as $a){
    create_object_card($a);
}
echo "</div>";

if (empty($artworks)) {
    // echo "<div class='page-card'>";
    echo "<div class='v-box'>";
    echo "<h1>No results :,(</h1>";
    echo "<p>Try different filters, or reset all filters to keep browsing artworks.</p>";
    echo "</div>";
    // echo "</div>";
}




 require('footer.php');

?>
