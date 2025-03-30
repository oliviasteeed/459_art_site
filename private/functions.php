<!-- functions -->

<?php

// FUNCTIONAL FUNCTIONS (LOL)

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function redirect_to($location) {
    header("Location: " . $location);
    exit;
  }

  function h($string="") {
    return htmlspecialchars($string);
  }

function display_errors($errors=array()) {
    $output = '';
    if(!empty($errors)) {
      echo "<br><strong>";
      foreach($errors as $error) {
        echo $error . "<br>";
      }
      echo "</strong>";
    }
    return $output;
  }



  // UI FUNCTIONS

// Function to create tag buttons
function create_tag($tagname, $selected_mediums) {

  $selected_marker = "";
  if(in_array($tagname, $selected_mediums)){  //if this tag is selected, add selected tag
    $selected_marker = "selected";
  }
  echo "<button type='button' class='tag-button button $selected_marker' data-value='$tagname'>$tagname</button>";
}

// create select dropdown component
function create_select_input($name, $options) {
  echo "<select class='button select-filter' id=\"$name\" name=\"$name\">\n";
  
  $i = 0;
  foreach ($options as $o) {
      create_select_option($options[$i++], $o, $name);
  }
  
  echo "</select>\n";
}

// create individual select dropdown options
function create_select_option($option_name, $o, $name) {
  $selected = '';  // Set selected value if stored in session
  if (isset($_SESSION[$name]) && $_SESSION[$name] == $o) {
      $selected = 'selected';
  }
  
  echo "<option value=\"$o\" $selected>$option_name</option>\n";
}



// creates card for artwork with some information about them
function create_object_card($object_information){
  $id = $object_information['object_id'];
  $title = $object_information['title'];
  $artist_id = $object_information['artist_id'];
  $medium = $object_information['medium'];
  $dimensions = $object_information['dimensions'];
  $image = $object_information['image_src'];

  if (isset($_SESSION['username'])){  //if faves are set, check if this object is in the faves
    $faveArtworks = getFaves($_SESSION['username']);
    if(in_array($id, $faveArtworks)){
      create_fave_object_card($object_information);
      return;
    }
  }

  echo "<div class='v-box art-container' id='$id' onclick='location.href=\"object-details.php?object_id=" . urlencode($id) . "\";'>";

  echo "<div class='img-container'>";
  echo "<img class='browse-image' src='$image'>";
  echo "</div>";
  
  echo "<div class='h-box'>";

  echo "<div class='v-box flex-2'>";
  echo "<h4>$title</h4>";
  echo "<p>$artist_id</p>";
  echo "<p>$medium</p>";
  echo "<p>($dimensions)</p>";
  echo "</div>";

  // favourite button only visible if you are logged in
  echo "<div class='v-box button-box flex-1'>";
  echo "<a class='circle-button fave-button hidden' href='../../private/favourite.php?object_id=" . urlencode($id) . "'>fave <3</a>";
  echo "</div>";

  echo "</div>";
  echo "</div>";
}

// creates fave artwork card (red bg)
function create_fave_object_card($object_information){
  $id = $object_information['object_id'];
  $title = $object_information['title'];
  $artist_id = $object_information['artist_id'];
  $medium = $object_information['medium'];
  $dimensions = $object_information['dimensions'];

  $image = $object_information['image_src'];
  echo "<div class='v-box art-container fave-artwork' id='$id' onclick='location.href=\"object-details.php?object_id=" . urlencode($id) . "\";'>";

  echo "<div class='img-container'>";
  echo "<img class='browse-image' src='$image'>";
  echo "</div>";
  
  echo "<div class='h-box'>";

  echo "<div class='v-box flex-2'>";
  echo "<h4>$title</h4>";
  echo "<p>$artist_id</p>";
  echo "<p>$medium</p>";
  echo "<p>($dimensions)</p>";
  echo "</div>";

  // favourite button only visible if you are logged in
  echo "<div class='v-box button-box flex-1'>";
  echo "<a class='circle-button fave-button hidden' href='../../private/favourite.php?object_id=" . urlencode($id) . "'>unfave &lt;/3</a>";
  echo "</div>";

  echo "</div>";
  echo "</div>";
}


//creates text input component for sign-up/log-in pages
function create_text_input($label, $name) {

  echo "<label for='name'>$label</label>";
  $input = '';    //get text input if set to keep dates visible
  if (isset($_POST[$name])){
      $input = $_POST[$name];
      echo "<input required type=\"text\" name=\"$name\" value=\"$input\">";
  }else{
      echo "<input required type=\"text\" name=\"$name\">";
  }
}



//creates text input component for account details page
function create_text_input_account($label, $name) {

  echo "<label for='name'>$label</label>";
  $input = '';    //get text input if set to keep dates visible

  if ($name == 'username' && isset($_SESSION['username'])){  //username is uneditable once input
    $input = $_SESSION['username'];
    echo "<input readonly type=\"text\" name=\"$name\" value=\"$input\">";
    return;
  }

  if (!strpos($name, 'password')) {  //if not password, show the input
    if (isset($_POST[$name])){  //if recently set in post
      $input = $_POST[$name];
      echo "<input required type=\"text\" name=\"$name\" value=\"$input\">";
  }
  else if (isset($_SESSION['username'])){  //if a user is signed in (and they have details already)
      $input = getUserInfo($_SESSION['username'], $name);
      echo "<input required type=\"text\" name=\"$name\" value=\"$input\">";
  }
  else {
      echo "<input required type=\"text\" name=\"$name\">";
  }
  }
  else{
    echo "<input required type=\"text\" name=\"$name\">";
  }
}


?>