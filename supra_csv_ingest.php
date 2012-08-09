<?php
require_once(dirname(__FILE__).'/classes/IngestCsv.php');
require_once(dirname(__FILE__).'/classes/UploadCsv.php');
require_once(dirname(__FILE__).'/classes/Presets.php');
$uc = new UploadCsv();
wp_enqueue_script( 'base_preset', plugins_url('/js/base_preset.js', __FILE__) ); 
wp_enqueue_script( 'postmeta_preset', plugins_url('/js/mapping_preset.js', __FILE__) ); 
wp_enqueue_script( 'misc', plugins_url('/js/misc.js', __FILE__) ); 
?>
<div id="flash"></div>
<? $uc->displayFileSelector();?>
<div id="preset_container">
  <div id="supra_csv_ingestion_mapper"></div>
  <div id="supra_csv_mapping_preset"></div>
  <div class="clear"></div>
</div>
<div id="supra_csv_ingestion_log">
   <img id="patience" src="<?=$uc->getPluginDirUrl()?>/img/patience.gif" style="display:none"/>
</div>

