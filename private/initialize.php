<?php
  ob_start(); // output buffering is turned on

  session_start(); // turn on sessions

  // Assign file paths to PHP constants
  define("PRIVATE_PATH", dirname(__FILE__));
  define("PROJECT_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", PROJECT_PATH . '/public');
  define("SHARED_PATH", PRIVATE_PATH . '/shared');

  // Assign the root URL to a PHP constant
  // * Can dynamically find everything in URL up to "/public"
  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", $doc_root);

  require_once('database.php');
  require_once('functions.php');
  require_once('query-functions.php');
//   require_once('validation_functions.php');

  $db = db_connect();
  $errors = [];

?>
