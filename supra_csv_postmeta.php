<?php 

require_once('classes/Debug.php');
require_once('classes/Presets.php');
require_once('classes/SupraCsvPostMeta.php');

$pmp = new SupraCsvPostMetaPreset();
$pm = new SupraCsvPostMeta();

wp_enqueue_script( 'inputCloner', plugins_url('/js/inputCloner.js', __FILE__) ); 
wp_enqueue_script( 'base_preset', plugins_url('/js/base_preset.js', __FILE__) ); 
wp_enqueue_script( 'postmeta_preset', plugins_url('/js/postmeta_preset.js', __FILE__) ); 

$postmetas = null;

$option = get_option('scsv_postmeta');

if(!empty($option)) $postmetas = get_option('scsv_postmeta');
?>
<div id="flash"></div>
<div id="postmeta_preset"><?=$pmp->getForm();?></div>
<form id="supra_csv_postmeta_form"><?=$pm->getFormContents($postmetas)?></form>
