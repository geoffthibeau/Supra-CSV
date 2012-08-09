<?php
session_start();
require_once(dirname(__FILE__).'/UploadCsv.php');
require_once(dirname(__FILE__).'/IngestCsv.php');
require_once(dirname(__FILE__).'/Debug.php');
require_once(dirname(__FILE__).'/Presets.php');
require_once(dirname(__FILE__).'/SupraCsvPostMeta.php');
class SupraCsvAjaxHandler {

    //an instance of IngestCsv for the ingestion commands to share

    function __construct($request) {
        $uc = new UploadCsv();
        $ic = new IngestCsv();
        switch($request['command']) {
            case "delete_file":
                $uc->deleteFileByKey($request['args']);
            break;
            case "download_file":
                $uc->downloadFile($request['args']);
            break;
            case "select_ingest_file":
                $filename = $uc->getFileByKey($request['args']);
                $result['map'] = $ic->parseAndMap($filename);
                $mp = new SupraCsvMappingPreset($filename);
                $result['preset'] = $mp->getForm();
                echo json_encode($result);
            break;
            case "ingest_file":
                $mapping = array();
                parse_str($request['args']['data'], $mapping);
                $params['mapping']  = $mapping;
                $params['filename'] = $request['args']['filename'];
                $ic->ingest($params);
            break;
            case "select_mapping_preset":
                $p = new SupraCsvPreset();
                echo json_encode($p->getPreset($request['args']));
            break;
            case "create_mapping_preset":
                $filename = $uc->getFileByKey($request['args']['filename']);
                $mp = new SupraCsvMappingPreset($filename);
                $mapping = array();
                parse_str($request['args']['preset'], $mapping);
                echo json_encode($mp->savePreset(array('preset'=>$mapping,'preset_name'=>$request['args']['preset_name'])));
            break;
            case "update_mapping_preset":
                $filename = $uc->getFileByKey($request['args']['filename']);
                $mp = new SupraCsvMappingPreset($filename);
                $mapping = array();
                parse_str($request['args']['preset'], $mapping);
                echo json_encode($mp->savePreset(array(
                                                       'preset_id'=>$request['args']['preset_id'],
                                                       'preset_name'=>$request['args']['preset_name'],
                                                       'preset'=>$mapping
                                                       )));
            break;
            case "select_postmeta_preset":
                $pmp = new SupraCsvPostMetaPreset();
                $pm = new SupraCsvPostMeta();
                $preset = $pmp->getPreset($request['args']);
                $postMetas = $preset['preset'];
                update_option('scsv_postmeta',$postMetas);
                $preset = array_merge($preset,array('form'=>$pm->getFormContents($postMetas)));
                echo json_encode($preset);
            break;
            case "delete_mapping_preset":
            case "delete_postmeta_preset":
                $p = new SupraCsvPreset();
                $p->deletePreset($request['args']);
            break;
            case "create_postmeta_preset":
                $mp = new SupraCsvPostMetaPreset();
                $postmetas = array();
                parse_str($request['args']['preset'], $postmetas);
                echo json_encode($mp->savePreset(array('preset'=>$postmetas,'preset_name'=>$request['args']['preset_name'])));
            break;
            case "update_postmeta_preset":
                $mp = new SupraCsvPostMetaPreset();
                $mapping = array();
                parse_str($request['args']['preset'], $mapping);
                echo json_encode($mp->savePreset(array(
                                                       'preset_id'=>$request['args']['preset_id'],
                                                       'preset_name'=>$request['args']['preset_name'],
                                                       'preset'=>$mapping
                                                       )));
            break;
        }
    }
}
