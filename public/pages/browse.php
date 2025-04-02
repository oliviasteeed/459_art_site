<!-- main page -->
 <?php
require('../../private/initialize.php');
require('header.php');

 if(isset($_SESSION['username'])) {


    }

    // get list of mediums from db 
    //TODO: MAKE THIS BASED ON ACTUAL DB
    // $mediums_array = getDbColumn('medium', 'metobjects');
    $objects_array = getDbColumn('object_name', 'metobjects');

    //get secondary filter options from db 
    //TODO: MAKE THIS BASED ON ACTUAL DB
    $artists_array = getDbColumn('artist_display_name', 'artists'); 
    $artists_array[0] = "select artist"; 

    $department_array = getDbColumn('department', 'metobjects');
    $department_array[0] = "select department"; 

    $dimensions_array = getDbColumn('dimensions', 'metobjects');
    $dimensions_array[0] = "select dimensions"; 

    $city_array = getDbColumn('city', 'metobjects');
    $city_array[0] = "select city";

    $state_array = getDbColumn('state', 'metobjects');
    $state_array[0] = "select state"; 

    $country_array = getDbColumn('country', 'metobjects');
    $country_array[0] = "select country"; 

    $culture_array = getDbColumn('culture', 'metobjects');
    $culture_array[0] = "select culture"; 

    $medium_array = getDbColumn('medium', 'metobjects');
    $medium_array[0] = "select medium"; 

    // $selected_mediums = []; //initialize empty array for which mediums tag buttons are selected
    $selected_objects = [];

    $secondary_filters = [
        'artist_display_name' => $_SESSION['artist_display_name'] ?? null,
        'department' => $_SESSION['department'] ?? null,
        'dimensions' => $_SESSION['dimensions'] ?? null,
        'city' => $_SESSION['city'] ?? null,
        'state' => $_SESSION['state'] ?? null,
        'country' => $_SESSION['country'] ?? null,
        'culture' => $_SESSION['culture'] ?? null,
        'medium' => $_SESSION['medium'] ?? null,
    ];

    $artworks = []; //initialize empty array for artworks (by medium)

    if(is_post_request()){ //if medium filters have been submitted
        if(isset($_POST['object_name'])){
            $selected_objects = $_POST['object_name']; // get user input
            $_SESSION['object_name'] = $selected_objects;

            $artworks = getArtworksFiltered($selected_objects, $secondary_filters); // get artworks with this medium from db

            // get artworks with this medium from db
            // $artworks = getArtworks($selected_mediums);
            // print_r($artworks);
            
        } else {    //clear anything saved
            // echo "No medium selected, session cleared";
            unset($_SESSION['object_name']);
            $artworks = getArtworksFiltered($objects_array, $secondary_filters);    //get all artworks if no filters applied
            // print_r($artworks);
        }
    }else{
        $artworks = getArtworksFiltered($objects_array, $secondary_filters);
        // $artworks = getArtworks($mediums_array);    //get all artworks if no filters applied
    }

    // Fetch filters from session
// $mediums = isset($_SESSION['medium']) ? $_SESSION['medium'] : [];

// $artworks = getArtworksFiltered($mediums, $secondary_filters);



// ACTUAL UI

echo "<h1>i'm interested in...</h1>";

//create tags for each medium
echo "<h4>type of work</h4>";

// form for medium filters
echo "<form class='h-box' action='browse.php' method='post'>";
echo "<div class='h-box flex-3'>";
foreach($objects_array as $o){
    create_tag($o, $selected_objects);
}
echo "</div>";

// hidden input container for storing selected medium tags (since they are buttons not form elements)
echo "<div id='selected-tags'>";
if(isset($_SESSION['object_type'])){    //put selected tags in post request always
    foreach($_SESSION['object_type'] as $o){
        echo "<input type='hidden' name='object_type[]' value='$o'>";
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
echo create_select_input("artist_display_name", $artists_array);
echo create_select_input("department", $department_array);
echo create_select_input("medium", $medium_array);
// echo create_select_input("dimensions", $dimensions_array);
echo create_select_input("city", $city_array);
echo create_select_input("state", $state_array);
echo create_select_input("country", $country_array);
echo create_select_input("culture", $culture_array);
echo "</div>";

echo "<div class='button-box flex-1'>";
echo "<button class='circle-button' id='reset-button'>reset all</button>";
echo "</div>";

echo "</div>";



// TODO: PAGINATION 10
// TODO: INTEGRATE WITH DB

// TODO: ARTIST DETAILS PAGE? LINKS?
// TODO: COMMENTS




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
