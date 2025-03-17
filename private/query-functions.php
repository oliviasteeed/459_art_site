<?php

//get column value options from database (browse.php)
    function getDbColumn($title, $table){
        global $db;
        $array = []; //default option when not selecting by order number
        $query_str = "SELECT DISTINCT $title FROM $table ORDER BY $title ASC";
        $result = $db->query($query_str); 

        while ($row = $result->fetch_array()) {   
            array_push($array, $row[$title]);
        };

        return $array;
    }

    //get object information from database based on input id (object-details.php)
    function getObjectInfo($id){
        global $db;
        $array = []; //default option when not selecting by order number
        $query_str = "SELECT title, artist_id, medium, dimensions, department, object_name, city, state, country, accession_year, culture FROM MetObjects WHERE object_id = $id";
        $result = $db->query($query_str); 

        while ($row = $result->fetch_assoc()) {   
            array_push($array, $row);
        };

        return $array;
    }

      //get object information from database based on input id (object-details.php)
      function insertFave($username, $object_id){
        global $db;
        $query_str = "INSERT INTO Member_Favourites (username, object_id) VALUES ('$username', $object_id)";
        if ($db->query($query_str)){
            return true;    //success
        }
        else{
            return false;   //failure
        }
    }


    //get artworks from database based on selected mediums (browse.php)
    function getArtworks($selected_mediums){
        global $db;
    
        // create '?' placeholders for each selected medium
        $placeholders = implode(',', array_fill(0, count($selected_mediums), '?')); 

        $query = "SELECT object_id, title, artist_id, medium, dimensions, image_src 
                FROM MetObjects 
                WHERE medium IN ($placeholders)";

        $stmt = $db->prepare($query);
        $types = str_repeat('s', count($selected_mediums)); // 'sss...' for multiple strings
        $stmt->bind_param($types, ...$selected_mediums);

        $stmt->execute();
        $result = $stmt->get_result();

        $artworks = [];
            
        while ($row = $result->fetch_assoc()) { //save details as an associative array
            $artworks[] = [
            'object_id' => $row['object_id'], 
            'title' => $row['title'], 
            'artist_id' => $row['artist_id'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions'],
            'image_src' => $row['image_src']
        ];}
        return $artworks;
    }




    ?>