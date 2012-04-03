<?php

require_once("Debug.php");
require_once('CsvLib.php');
require_once('RemotePost.php');

class IngestCsv {


    function __construct($filename) {
        ini_set('error_reporting', E_ALL);
        
        try {
        $this->ParseAndMap($filename);
        }
        catch(Exception $e) {
            var_dump($e->getMessage());
        }
    }

 
    function ParseAndMap($filename) {

        if(empty($_POST)) {
            $cp = new CsvParser($filename,"columns");
            $mf = new MapperForm($cp->getColumns());
        }
        else {
            $cp = new CsvParser($filename,"ingest",$_POST);
        }
    }
}

