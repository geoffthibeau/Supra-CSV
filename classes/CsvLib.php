<?php
require_once("Debug.php");

class CsvParser {
    private $dir = "wp-content/plugins/supra_csv/csv/";
    private $file;
    private $handle;
    private $columns;

    function __construct($file,$find="",$mapping=null) {
        
        if(empty($this->handle)) {
            $this->setFile(ABSPATH . $this->dir . $file);
            $this->setHandle(); 
        }

        $this->setColumns();

        switch($find) {
            case "columns":
            break;
            case "ingest":
                $this->ingestContent($mapping);
            break;
        }
    }

    private function setHandle() {
        $this->handle = fopen($this->file, "r");
    }

    private function setColumns() {
        $this->columns = fgetcsv($this->handle);
    }

    public function getColumns() {
        return $this->columns;
    }

    public function setFile($file) {
        $this->file = $file;
    }

    public function getFile() {
        return $this->file;
    }

    private function ingestContent($mapping) {
        $rp = new RemotePost();
        $cm = new CsvMapper($mapping);

        $cols = $this->columns;

        if($cols) {
            while (($data = fgetcsv($this->handle)) !== FALSE) {

                //loop through the columns
                foreach($data as $i=>$d) {
                    $parsed[$cols[$i]] = $d;
                }

                $row = $cm->retrieveMappedData($parsed);

                Debug::describe($rp->injectListing(array('meta'=>$row)));
            }
        }

    }
}

class CsvMapper {

    private $mapping;
    private $contents;

    function __construct($mapping) {
        $this->setMapping($mapping);        

        return $this->retrieveMappedData();        
    }

    public function setMapping($mapping) {
        $this->mapping = array_filter($mapping);
    }

    public function getMapping() {
        return $this->mapping;
    }

    public function retrieveMappedData($data) {

        //map the data with csv named keys to wp_keys
        foreach($this->mapping as $wp_name=>$csv_name) {
            $row[$wp_name] = $data[$csv_name];
        }
           
        return $row;
    }

}

class MapperForm {

    private $rows;
    private $listing_fields;


    function __construct($rows) {

        $this->rows = $rows;
        $this->setListingFields();

        echo $this->displayForm();
    }

    public function setListingFields() {

        $postmetas = get_option('sscsv_postmeta');

        foreach($postmetas['meta_key'] as $i=>$metakey) {
            $displayname = $postmetas['displayname'][$i];
            $meta[$metakey] = $displayname;
        }

        $this->listing_fields = $meta;
    }

    public function getListingFields() {
        return $this->listing_fields;
    }

    private function displayListingFields() {

        foreach($this->getListingFields() as $k=>$v) {

            $inputs .= $this->createInput($k,$v,$this->rows);

        }

        return $inputs;
    }

    private function createInput($name,$value,$rows) {
          $input = '<span id="label">'.$value.'</span>';
          $input .= '<select name="'.$name.'">';

          $input .= '<option value=""> </option>';

          foreach($rows as $row) {
              $input .= '<option value="'.$row.'">'.$row.'</option>';
          }
 
          $input .= '</select>';

          return '<div id="input">' . $input . "</div>";
    }

    private function displayForm() {

        $inputs = $this->displayListingFields();

        $form = '<form action="'.$_SERVER['PHP_SELF'].'?page=supra_csv_ingest" method="post">';
        $form .= $inputs;
        $form .= '<input type="submit" value="submit" /></form>';

        return $form;
    }

}
