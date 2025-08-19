<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * File Upload Helper
 * 
 * Provides functions for handling file uploads in the application
 */

/**
 * Upload a file and return the file path
 * 
 * @param string $file The file input name from $_FILES
 * @param string $person_type The type of person (e.g., 'complainant', 'complainee')
 * @param string $name The person's name
 * @param string $current_pic The previous file path to be deleted
 * @return string The file path where the file was uploaded or default image path
 */
function upload_file($file, $person_type, $name, $current_pic)
{
    // Check if a new file was uploaded
    if (!isset($_FILES[$file]) || empty($_FILES[$file]['name'])) {
        if($current_pic == "null" || $current_pic == ""){
            return "assets/img/no-image.png";
        }
        else{
            return $current_pic;
        }
    }
    else {
        // $imgname = $_FILES[$file]['name'];
        $person_pic = $person_type . "_" . $name;
        $location = "./assets/img/people/" . $person_pic;
    }
    
    if($current_pic != $location) {
        if ($current_pic && $current_pic !== "assets/img/no-image.png" && $current_pic !== "null") {
            unlink($current_pic);
        }
        // Upload new file
        move_uploaded_file($_FILES[$file]['tmp_name'], $location);
        return $location;
    }
    else{
        return $current_pic;
    }

}
