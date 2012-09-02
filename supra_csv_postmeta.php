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
$csvpost = get_option('scsv_post');

$suggestions = $pm->getSuggestions($csvpost['type']);

if(!empty($option)) $postmetas = get_option('scsv_postmeta');
?>
<div id="flash"></div>
    <div id="postmeta_preset"><?=$pmp->getForm();?></div>
    <form id="supra_csv_postmeta_form"><?=$pm->getFormContents($postmetas)?></form>
    <h3>Post Meta Suggestions for Post Type '<?=$csvpost['type']?>'</h3>

        <table id="postmeta_suggestions">
          <thead>
            <tr>
            <th>meta key</th>
            <th>random value</th>
            </tr> 
          </thead>
          <tbody>
          <?
          foreach($suggestions as $i=>$suggestion):
              echo '<tr ';
              echo ($i%2 == 0)?'class="even"':'class="odd"';
              echo '><td>'.$suggestion->meta_key.'</td><td>'.$suggestion->meta_value.'</td></tr>';
          endforeach;
          ?>
          </tbody>
        </table>

