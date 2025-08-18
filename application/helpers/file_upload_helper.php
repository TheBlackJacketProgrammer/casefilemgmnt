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
 * @param string $previous_file The previous file path to be deleted
 * @return string The file path where the file was uploaded or default image path
 */
function upload_file($file, $person_type, $name, $previous_file)
{
    // Check if a new file was uploaded
    if (!isset($_FILES[$file]) || empty($_FILES[$file]['name'])) {
        return "assets/img/no-image.png";
    }
    
    $imgname = $_FILES[$file]['name'];
    $person_pic = $person_type . "_" . $name . "_" . $imgname;
    $location = "./assets/img/people/" . $person_pic;

    // If previous file is null, set it to no-image.png
    if($previous_file == "null") {
        $previous_file = "assets/img/no-image.png";
    }
    
    // If same file, return previous location
    if ($previous_file === $location) {
        return $previous_file;
    }
    
    // Remove previous file if it exists and isn't the default image
    if ($previous_file && $previous_file !== "assets/img/no-image.png" && $previous_file !== "null") {
        unlink($previous_file);
    }
    
    // Upload new file
    move_uploaded_file($_FILES[$file]['tmp_name'], $location);
    return $location;
}
