<?php
require_once("Debug.php");
require_once('CsvLib.php');
require_once('RemotePost.php');

class IngestCsv {

    function ParseAndMap($filename) {
        $cp = new SupraCsvParser($filename);
        $mf = new SupraCsvMapperForm($cp);
        return $mf->getForm();
    }

    function ingest($params) {
        $cp = new SupraCsvParser($params['filename']);
        $cp->ingestContent($params['mapping']);
    }
}
