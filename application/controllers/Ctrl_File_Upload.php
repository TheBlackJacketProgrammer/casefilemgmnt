<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_File_Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

    public function upload_file($file, $person_type, $name)
    {
        // Handle file uploads separately if needed
        if (isset($_FILES[$file]) && $_FILES[$file]['name'] != "" && $_FILES[$file]['name'] != null) {
            $imgname = $_FILES[$file]['name'];
            $person_pic = $person_type."_".$name."_".$imgname;
            $location = "./assets/img/people/".$person_pic;
            if(!file_exists($location))
            {
                // Upload File    
                move_uploaded_file($_FILES[$file]['tmp_name'], $location);
                return $location;
            }
            else{
                return "assets/img/no-image.png";
            }
        }
        else{
            return "assets/img/no-image.png";
        }
    }

}

?>