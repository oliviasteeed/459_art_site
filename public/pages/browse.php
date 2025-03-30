<!-- main page -->
 <?php
require('../../private/initialize.php');
require('header.php');

 if(isset($_SESSION['username'])) {
    // get set filters and make them set (jquery?)
    }

    // get list of mediums from db 
    $mediums_array = getDbColumn('medium', 'metobjects');

    //get secondary filters from db
    $artists_array = getDbColumn('artist_display_name', 'artists'); 
    $artists_array[0] = "select artist"; 

    $department_array = getDbColumn('dimensions', 'metobjects');
    $department_array[0] = "select department"; 

    $city_array = getDbColumn('city', 'metobjects');
    $city_array[0] = "select city";

    $state_array = getDbColumn('state', 'metobjects');
    $state_array[0] = "select state"; 

    $country_array = getDbColumn('country', 'metobjects');
    $country_array[0] = "select country"; 

    $culture_array = getDbColumn('culture', 'metobjects');
    $culture_array[0] = "select culture"; 

    $selected_mediums = []; //initialize empty array for which mediums tag buttons are selected
    $artworks = []; //initialize empty array for artworks (by medium)

    if(is_post_request()){ //if medium filters have been submitted

        if(isset($_POST['medium'])){
            $selected_mediums = $_POST['medium']; // get user input
            $_SESSION['medium'] = $selected_mediums;

            // get artworks with this medium from db
            $artworks = getArtworks($selected_mediums);
            // print_r($artworks);
            
        } else {    //clear anything saved
            // echo "No medium selected, session cleared";
            $_SESSION['medium'] = [];
            $artworks = getArtworks($mediums_array);    //get all artworks if no filters applied
            // print_r($artworks);
        }
    }else{
        $artworks = getArtworks($mediums_array);    //get all artworks if no filters applied
    }

    // check if secondary filters are set, if so add to query string, at the end make a query with it
    $secondary_filters = [];
    $artist = "";
    $department = "";
    $city = "";
    $state = "";
    $country = "";
    $culture = "";

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
    if(isset($_SESSION['culture'])){
        $secondary_filters['culture'] = $_SESSION['culture'];
    }

    //TODO: integrate secondary filters better with the main filters (they currently do not work)
    // query again
    $session_mediums = [];
    if(isset($_SESSION['medium'])){
        $session_mediums = $_SESSION['medium']; // saved medium selections from session
    }
    else{
        $session_mediums = $mediums_array;  //array of all mediums
    }

    $filtered_artworks = getArtworksFiltered($session_mediums, $secondary_filters);    

    // print_r($filtered_artworks);







        // $_SESSION['mediums_selected'] = $_POST['medium'];

        // $_SESSION['artist_selected'] = $_POST['artist'];
        // $_SESSION['department_selected'] = $_POST['department'];
        // $_SESSION['city_selected'] = $_POST['city'];
        // $_SESSION['state_selected'] = $_POST['state'];
        // $_SESSION['country_selected'] = $_POST['country'];
        // $_SESSION['accession_year_selected'] = $_POST['accession_year'];
        // $_SESSION['culture_selected'] = $_POST['culture'];

        // $mediums = $_POST['medium']; // Get user input

        // $mediums_string = implode(", ", $mediums);
        // echo $mediums;

//         // Prepare statement
//         $stmt = $db->prepare("SELECT title, artist_id, medium, dimensions FROM metobjects WHERE medium IN (?)");
//         $stmt->bind_param("s", $mediums_string); // Bind as a string

//         // Execute and fetch results
//         $stmt->execute();
//         $result = $stmt->get_result();

//         $artworks = []; // initialize an empty array

//         while ($row = $result->fetch_assoc()) { //save details as an associative array
//             $artworks[] = [
//             'title' => $row['title'], 
//             'artist_id' => $row['artist_id'], 
//             'medium' => $row['medium'], 
//             'dimensions' => $row['dimensions']
//     ];
// }

    // }


// ACTUAL UI

echo "<h1>i'm interested in...</h1>";

//create tags for each medium
echo "<h4>medium</h4>";

// form for medium filters
echo "<form class='h-box' action='browse.php' method='post'>";
foreach($mediums_array as $m){
    create_tag($m, $selected_mediums);
}
// hidden input container for storing selected medium tags (since they are buttons not form elements)
echo "<div id='selected-tags'>";

if(isset($_SESSION['medium'])){    //put selected tags in post request always
    foreach($_SESSION['medium'] as $m){
        echo "<input type='hidden' name='medium[]' value='$m'>";
    }
}
echo "</div>";

echo "<input class='circle-button' type='submit' value='go >'/>";
echo "</form>";

echo "<h4>artwork details</h4>";
// echo create_select_input("artist", $artists_array);
echo create_select_input("department", $department_array);
echo create_select_input("city", $city_array);
echo create_select_input("state", $state_array);
echo create_select_input("country", $country_array);
echo create_select_input("culture", $culture_array);

// need to use jquery to see when clicked on, save in session, do something, initiate filter by

// $_SESSION['username'] = $_POST['username'];

// $_SESSION['mediums_selected'][] = $_POST['mediums_selected'];


// create object cards for each artwork
echo "<div class='artwork-box'>";
foreach($artworks as $a){
    create_object_card($a);
}
echo "</div>";






 require('footer.php');

?>
