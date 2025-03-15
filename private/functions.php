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

  function create_tag($tagname){
    echo "<button name='medium' class='button'>$tagname</button>";
}

  //create select dropdown component
function create_select_input($name, $options) {
  echo "<select class=\"button\" name=\"$name\">\n"; 
  $i = 0;
  foreach($options as $o) {
      create_select_option($options[$i++], $o, $name);
  }
  echo "</select>\n";
}

//create individual select dropdown options
function create_select_option($option_name, $o, $name) {
  $selected = '';  //get select value to keep selected
  if (isset($_POST[$name]) && $_POST[$name] == $o){
      $selected = 'selected';
  }
  echo "<option value=\"$o\" ";
  echo "$selected>$option_name</option>\n";
}



//creates text input component
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


?>