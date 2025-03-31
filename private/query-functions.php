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
        $query_str = "SELECT 
                    title, medium, dimensions, department, object_name, city, state, country, culture 
                    FROM metobjects 
                    WHERE object_id = $id";
        $result = $db->query($query_str); 

        while ($row = $result->fetch_assoc()) {   
            array_push($array, $row);
        };

        return $array;
    }

    //get artist info for the object (object-details.php)
    function getArtistInfo($id){
        global $db;
        $array = []; //default option when not selecting by order number
        $temp_str = "";
        $query_str = "SELECT 
                    artist_role, artist_display_name
                    FROM artists 
                    WHERE artist_id = $id";
        $result = $db->query($query_str); 

        while ($row = $result->fetch_assoc()) {   

            // remove the seperators for when there's multiple artists
            $roles = (explode('|', $row['artist_role']));
            $names = (explode('|', $row['artist_display_name']));

            // combine them in the new order
            for($i = 0; $i < count($roles); $i++){
                $temp_str .= $roles[$i].": ".$names[$i]."<br />";
            }
            array_push($array, $temp_str);

        };

        return $array;
    }

      //insert new fave to db
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

    // remove selected fave from db
    function removeFave($username, $object_id){
        global $db;
        $query_str = "DELETE FROM Member_Favourites WHERE username = '$username' AND object_id = $object_id";
        if ($db->query($query_str)){
            return true;    //success
        }
        else{
            return false;   //failure
        }
    }

    //get artworks from database based on selected mediums (browse.php)
    function getFaveArtworks($username){
        global $db;

        $query_str = "SELECT 
                    metobjects.object_id, 
                    metobjects.title, 
                    metobjects.medium, 
                    metobjects.dimensions, 
                    artists.artist_display_name
                FROM metobjects
                LEFT JOIN artists ON metobjects.object_id = artists.artist_id
        WHERE object_id IN (SELECT object_id FROM Member_Favourites WHERE username = '$username');";

        $result = $db->query($query_str); 

        $artworks = [];
            
        while ($row = $result->fetch_assoc()) { //save details as an associative array
            $artworks[] = [
            'object_id' => $row['object_id'], 
            'title' => $row['title'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions'],
            'artist_display_name' => $row['artist_display_name'],
        ];}
        return $artworks;
    }


    //get artworks from database based on selected mediums (browse.php)
    function getArtworks($selected_mediums){
        global $db;
    
        // create '?' placeholders for each selected medium
        $placeholders = implode(',', array_fill(0, count($selected_mediums), '?')); 

        $query = "SELECT 
                    metobjects.object_id, 
                    metobjects.title, 
                    metobjects.medium, 
                    metobjects.dimensions, 
                    artists.artist_display_name
                FROM metobjects
                LEFT JOIN artists ON metobjects.object_id = artists.artist_id
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
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions'],
            'artist_display_name' => $row['artist_display_name'],
        ];}
        return $artworks;
    }

    //TODO: make this work
    //get artworks from database based on selected mediums AND SECONDARY FILTERS (browse.php)
    function getArtworksFiltered($selected_mediums, $secondary_filters){
        global $db;
    
        //TODO: make this work

        // $query_filter_string = "";
  
        // if(isset($secondary_filters['department'])){
        //     $query_filter_string .= "AND department = " . $secondary_filters['department'];
        // }   
        // if(isset($secondary_filters['city'])){
        //     $query_filter_string .= "AND city = " . $secondary_filters['city'];
        // }  
        // if(isset($secondary_filters['state'])){
        //     $query_filter_string .= "AND s†ate = " . $secondary_filters['s†ate'];
        // }  
        // if(isset($secondary_filters['country'])){
        //     $query_filter_string .= "AND country = " . $secondary_filters['country'];
        // } 
        // if(isset($secondary_filters['accession_year'])){
        //     $query_filter_string .= "accession_year = " . $secondary_filters['accession_year'];
        // } 
        // if(isset($secondary_filters['culture'])){
        //     $query_filter_string .= "culture = " . $secondary_filters['culture'];
        // } 

        // // create '?' placeholders for each selected medium
        // $placeholders = implode(',', array_fill(0, count($selected_mediums), '?')); 

        // $query = "SELECT object_id, title, medium, dimensions 
        //         FROM metobjects 
        //         WHERE medium IN ($placeholders) AND $query_filter_string;";

        // $stmt = $db->prepare($query);
        // $types = str_repeat('s', count($selected_mediums)); // 'sss...' for multiple strings
        // $stmt->bind_param($types, ...$selected_mediums);

        // Create '?' placeholders for each selected medium
    $placeholders = implode(',', array_fill(0, count($selected_mediums), '?'));

    // Base SQL Query
    $sql = "SELECT object_id, title, medium, dimensions FROM metobjects WHERE medium IN ($placeholders)";

    // Handle secondary filters
    $params = $selected_mediums;
    if (!empty($secondary_filters)) {
        foreach ($secondary_filters as $key => $value) {
            $sql .= " AND $key = ?";
            $params[] = $value;
        }
    }

    // Prepare and execute query
    $stmt = $db->prepare($sql);
    $stmt->bind_param(str_repeat("s", count($params)), ...$params); // 's' for each parameter
    $stmt->execute();
    $result = $stmt->get_result();

        // $stmt->execute();
        // $result = $stmt->get_result();

        $artworks = [];
            
        while ($row = $result->fetch_assoc()) { //save details as an associative array
            $artworks[] = [
            'object_id' => $row['object_id'], 
            'title' => $row['title'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions'],
        ];}
        return $artworks;
    }




    ?>