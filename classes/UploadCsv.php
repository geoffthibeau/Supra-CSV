<?php

require_once('Debug.php');

class UploadCsv {

    private $mimes   = array("text/csv","text/comma-separated-values");
    private $target  = 'wp-content/plugins/supra_csv/csv/';
    private $success = false;
    private $error = "Something went wrong.";

    function __construct($file) {

        if(empty($file['uploaded'])) {
            $this->displayForm();
        }
        else {
            if($this->validateFileType($file['uploaded']['type']))
                $this->processFile($file['uploaded']);

            echo $this->getErrorMsg();
        }

    }

    public function getSuccess() {
        return $this->success;
    }

    public function getErrorMsg() {
        return $this->error;
    }

    private function validateFileType($type) {

        $valid = false;

        foreach($this->mimes as $mime) {
            if($type == $mime) { 
                $valid = true;
                break;
            }
        }

        if(!$valid) {
            $this->error = "File is not a csv format";
            return false;
        } 
        
        return true;
    }

    private function processFile($file) {
        $target = ABSPATH . $this->target . basename( $file['name']); 
 
        if(move_uploaded_file($file['tmp_name'], $target)) {
            $this->success = true;
            $this->error = $file['name'] . " successfully uploaded";
        }
    }

    private function displayForm() {


      echo '<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'?page=supra_csv_upload" method="POST">
        Please choose a file: <input name="uploaded" type="file" /><br />
        <input type="submit" value="Upload" />
      </form>';
    }
}
