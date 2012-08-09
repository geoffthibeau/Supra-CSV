<?php
require_once("Debug.php");
require_once(dirname(__FILE__) . '/SupraCsvPlugin.php');

class SupraCsvParser extends SupraCsvPlugin {
    private $file;
    private $filename;
    private $handle;
    private $columns;

    function __construct($filename = null) {

        parent::__construct();

        if($filename) {
            if(empty($this->handle)){
                $this->setFile($filename);
                $this->setHandle(); 
            }
            $this->setColumns();
        }
    }

    private function setHandle() {
        $this->handle = fopen($this->file, "r");
    }

    private function setColumns() {
        $this->columns = fgetcsv($this->handle);
    }

    public function getColumns() {
        
        if(!$this->columns && $this->handle) {
            $this->setColumns();
        }
        return $this->columns;
    }

    public function setFile($filename) {
        $this->filename = $filename;
        $this->file = $this->getCsvDir() . $filename;
    }

    public function getFile() {
        return $this->file;
    }

    public function getFileName() {
        return $this->filename;
    }

    public function ingestContent($mapping) {

        $rp = new RemotePost();
        $cm = new SupraCsvMapper($mapping);

        $cols = $this->getColumns();

        //Debug::describe($this);
        //Debug::describe(fgetcsv($this->handle));

        //die();

        if($cols) {
            while (($data = fgetcsv($this->handle)) !== FALSE) {

                //loop through the columns
                foreach($data as $i=>$d) {
                    $parsed[$cols[$i]] = $d;
                }

                $row = $cm->retrieveMappedData($parsed);

                if(strstr(site_url(),'3dmpekg')) 
                    $row = $this->patchByRow($row);

                $title = $row['post_title'];
                $desc =  $row['post_content'];
                unset($row['post_title']);
                unset($row['post_content']);

                if($rp->injectListing(array('title'=>$title,'desc'=>$desc,'meta'=>$row)))
                    echo '<span class="success">Successfully ingested '. $title . '</span><br />';
                else
                    echo '<span class="error">Problem Ingesting '. $title . '</span><br />';
            }
        }

    }

    private function patchByRow($row) {

        if(strstr(site_url(),'3dmpekg')) {
            $row['manufacturer_level1_value'] = ucfirst(strtolower($row['manufacturer_level1_value']));
    
            if(empty($row['name_value'])) {

                        $row['name_value'] = $row['manufacturer_level1_value'] . " " .
                                             $row['manufacturer_level2_value'] . " " .
                                             $row['year_value'];
            }
        }

        $row['post_title'] = $row['name_value'];

        return $row;
    }

}

class SupraCsvMapper {

    private $mapping = array();
    private $contents;

    function __construct($mapping) {
        $this->setMapping($mapping);        
    }

    public function setMapping($mapping) {
        $this->mapping = array_filter($mapping);
    }

    public function getMapping() {
        return $this->mapping;
    }

    public function retrieveMappedData($data) {

        //map the data with csv named keys to wp_keys
        foreach((array)$this->mapping as $wp_name=>$csv_name) {
            $row[$wp_name] = $data[$csv_name];
        }
           
        return $row;
    }

}

class SupraCsvMapperForm {

    private $filename;
    private $rows;
    private $listing_fields;


    function __construct(SupraCsvParser $cp) {
        $rows = $cp->getColumns();
        $this->filename = $cp->getFileName();
        if(!$rows)
            die('Unable to parse csv.');

        $this->rows = $rows;
        $this->setListingFields();
    }

    public function setListingFields() {

        $postmetas = get_option('scsv_postmeta');

        foreach((array)$postmetas['meta_key'] as $i=>$metakey) {
            $displayname = $postmetas['displayname'][$i];
            $meta[$metakey] = $displayname;
        }

        $this->listing_fields = $meta;
    }

    public function getListingFields() {
        return $this->listing_fields;
    }

    private function displayListingFields() {

        $inputs = null;

        foreach((array)$this->getListingFields() as $k=>$v) {

            $inputs .= self::createInput($k,$v,$this->rows);

        }

        return $inputs;
    }

    public static function createInput($name,$value,$rows) {
          $input = '<span id="label">'.$value.'</span>';
          $input .= '<select id="supra_csv_'.$name.'" name="'.$name.'">';

          $input .= '<option value=""> </option>';

          foreach((array)$rows as $row) {
              $input .= '<option value="'.$row.'">'.$row.'</option>';
          }
 
          $input .= '</select>';

          return '<div id="input">' . $input . "</div>";
    }

    public function getForm() {

        $inputs .= self::createInput('post_title','Title',$this->rows);
        $inputs .= self::createInput('post_content','Description',$this->rows);

        $inputs .= $this->displayListingFields();

        $form = '<form id="supra_csv_mapping_form" data-filename="'.$this->filename.'">';
        $form .= $inputs;
        $form .= '<button id="supra_csv_ingest_csv">Ingest</button></form>';

        return $form;
    }

}
