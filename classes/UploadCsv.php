<?php
require_once(dirname(__FILE__).'/SupraCsvPlugin.php');
class UploadCsv extends SupraCsvPlugin {

    private $mimes   = array("text/csv","text/comma-separated-values");
    private $success = false;
    private $error;
    private $preview_num = 10;

    function __construct($file = null) {
        parent::__construct();

        if(!empty($file['uploaded'])) {
            $this->processFile($file['uploaded']);
        }
    }

    public function renderForms() { 
        echo '<div id="response">'.$this->getErrorMsg().'</div>'; 
        echo $this->getForm();
        echo $this->getUploads();
        echo '<div id="supra_csv_preview"></div>';
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
            $this->error = '<span class="error">File is not a csv format</span>';
            $valid = false;
        } 
        
        return $valid;
    }

    private function processFile($file) {
        if($this->validateFileType($file['type'])) {
            $this->error = '<span class="error">Something went wrong.</span>';
            $target = $this->getCsvDir() . basename( $file['name']); 
 
            if(move_uploaded_file($file['tmp_name'], $target)) {
                $this->success = true;
                $this->error = '<span class="success">' . $file['name'] . " successfully uploaded</span>";
            }
        }
    }

    private function getForm() {

            return '<form enctype="multipart/form-data" method="POST">
            Please choose a file: <input name="uploaded" type="file" />
            <input type="submit" value="Upload" />
            </form>';
    }

    private function getUploads() {
        $files = $this->getUploadedFiles();
        
        foreach($files as $i=>$file) {
            $delete_button = '<button id="delete_upload" data-key="'.$i.'">Delete</button>';
            $download_button = '<button id="download_upload" data-file="'.$file.'">Preview / Download</button>';
            $list .= '<li>'.$delete_button.$download_button.$file.'</li>';
        }

        return '<ul id="uploaded_files">'.$list.'</ul>'; 
    }

    public function getUploadedFiles() {
        return array_diff((array)scandir($this->getCsvDir()), array('..', '.'));
    }

    public function getFileByKey($key) {
        $files = $this->getUploadedFiles();
        return $files[$key];
    }

    public function deleteFileByKey($key) {

        $filename = $this->getFileByKey($key);

        $success = unlink($this->getCsvDir() . $filename);

        if($success)
            $this->error = '<span class="success">Successfully deleted ' . $filename . '</span>';
        else
            $this->error = '<span class="error">Error deleting ' . $filename . '</span>';

        $this->renderForms();
    }

    function downloadFile($file) {
        $filename= $this->getCsvDirUrl() . $file;
	echo '<b>(showing First '.$this->preview_num.' lines)</b> or ' .
             '<a href="'.$filename.'" target="_blank">Download File</a>';
        $row = 1;
        if (($handle = fopen($filename, "r")) !== FALSE) {
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                echo "<br />";
                $row++;
                    echo implode(',',$data);
                if($row==10) break;
            }
            fclose($handle);
        }
    }

    public function displayFileSelector() {

        $options = '<option value=""></option>'; 

        foreach($this->getUploadedFiles() as $key=>$file) {
            $options .= '<option value="'.$key.'">'.$file.'</option>';
        } 

        echo '<label for="select_csv_file">File To Ingest:</label><select id="select_csv_file">'.$options.'</select>';
    }
}
