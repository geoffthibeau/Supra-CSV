<?php 

require_once(dirname(__FILE__).'/classes/SupraCsvPlugin.php');

$scp = new SupraCsvPlugin();

if(!empty($_POST['scsv_submit'])) {
    $csvfile= $_POST['scsv_filename'];
    $csvuser['name'] = $_POST['scsv_wpname'];
    $csvuser['pass'] = $_POST['scsv_wppass'];
    $csvpost['publish'] = $_POST['scsv_autopub'];
    $csvpost['type'] = (empty($_POST['scsv_posttype'])) ? $_POST['scsv_custom_posttype'] : $_POST['scsv_posttype'];
    $csvpost['title'] = $_POST['scsv_defaulttitle'];
    $csvpost['desc'] = $_POST['scsv_defaultdesc'];
    $post_terms = $_POST['scsv_custom_terms'];
    $parse_terms = $_POST['scsv_parse_terms'];
    $ingest_debugger = $_POST['scsv_ingest_debugger'];
    $csv_settings = $_POST['scsv_csv_settings'];
    update_option('scsv_filename', $csvfile);
    update_option('scsv_user', $csvuser);
    update_option('scsv_post', $csvpost);
    update_option('scsv_custom_terms', $post_terms);
    update_option('scsv_parse_terms', $parse_terms);
    update_option('scsv_ingest_debugger', $ingest_debugger);
    update_option('scsv_csv_settings', $csv_settings);
    echo '<div class="updated"><p><strong>Configuration saved</strong></p></div>';
} else {
    $csvfile = get_option('scsv_filename');
    $csvuser = get_option('scsv_user');
    $csvpost = get_option('scsv_post');
    $post_terms = get_option('scsv_custom_terms');
    $parse_terms = get_option('scsv_parse_terms');
    $ingest_debugger = get_option('scsv_ingest_debugger');
    $csv_settings = get_option('scsv_csv_settings');
}

?>
<div class="wrap">

  <div style="width: 630px">
  <h2>Supra Csv Importer</h2>
  <div style="float: left; width: 300px;">
    <h3>Description</h3>
    <p>The purpose of this plugin is to parse uploaded csv files into any type of post.
    Some themes or plugin store data in post with custom post_type, thus this plugin
    provides the functionality to upload data from the csv file to the records that
    the theme or plugin creates. Manage existing csv files and promote ease of use by
    creating presets for both postmeta and ingestion mapping. For more infomation on
    how to obtain the necessary info watch the detailed tutorial.</p>
    <h3>Steps to Ingest</h3>
    <ol>
      <li>configure in 'Configuration'</li>
       <li>upload file in 'Upload'</li>
      <li>define postmeta in 'Post Info'</li>
      <li>map the data and import in 'Ingestion'</li>
      <li>save postmeta and mapping presets wherever necessary</li>
    </ol>
    <h3>Importing Terms by Taxonomy</h3>
    <p>provide a comma separated value in the <a href="#custom_terms">custom terms</a> input below<br />
  Exa: enginesize,pricerange<br />
  The mapping selectors will dynamically appear in the ingest page.
    </p>
 
    <h3>Importing complex categories</h3>
    <p>If you desire to import subcategories and deatiled info about the category such
       as the slug, description and parent mark the checkbox in the <a href="#compex_categories">complex categories</a>
    </p>
  </div>
  <div style="float: right;width: 300px;">
    <h3>Rapid Releases</h3>
    <p>There are times when new releases are available and may contain bugs. if you encounter any issues with the plugin ingestion be sure to toggle ingestion debugging by checking the <a href="#ingestion_debugging">box</a> and provide the debug output in the support forum to get the problem solved quickly.</p>

    <h2>Donations</h2>
    <p>Additional requests or feeling generous, feel free to donate!</p>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="CLC8GNV7TRGDU">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    

    <h3>Tutorial</h3>
    <iframe width="420" height="315" src="http://www.youtube.com/embed/0xKpNw1cT-Q" frameborder="0" allowfullscreen></iframe>

    <h3>Contributions</h3>
    <p>Due to the nature of wordpress and its lack of plugin contribution functionality please fork the following repo.</p>
    <p><a href="https://github.com/zmijevik/Supra-CSV" target="_blank">https://github.com/zmijevik/Supra-CSV</a></p>
    <p>Please keep code encapsulated, lets keep this from turning into a procedural mess!</p>
    <p>You have my guarantee that this project will <u>remain</u> free and open source.</p>
    <p>Feel free to contact me regarding plugin issues and requests.</p>
  </div>
  <div style="clear: both"></div>
  </div>

<h2>Supra CSV Configuration</h2>
<form name="scsv_form" method="post"">
        <hr />
        <h4>User Settings</h4>
	<p>Username<input type="text" name="scsv_wpname" value="<?php echo $csvuser['name']; ?>" size="20"></p>
	<p>Pasword<input type="password" name="scsv_wppass" value="<?php echo $csvuser['pass']; ?>" size="20"></p>

        <hr />
        <h4>Post Settings</h4>
	<p>
            Auto Publish
            <select name="scsv_autopub">
                <option value="0">false</option>
                <option value="1" <?php if($csvpost['publish']) echo 'selected="selected"';?>>true</option>
            </select>
        </p>
	<p>
            Post Type
            <select name="scsv_posttype" value="<?php echo $csvpost['type']; ?>">
                <option value=""></option>
                <? foreach(get_post_types() as $post_type): ?>
                <option value="<?=$post_type?>" <?if($csvpost['type']==$post_type) echo 'selected="selected"';?>><?=$post_type?></option>
                <? endforeach ?> 
            </select>
            <b>or</b>
            Custom Post Type
            <input type="text" name="scsv_custom_posttype" value="<?php if($csvpost['type']!="page"&&$csvpost['type']!="post")echo $csvpost['type']; ?>" size="20">
        </p>
	<p>Default Title<input type="text" name="scsv_defaulttitle" value="<?php echo $csvpost['title']; ?>" size="20"></p>
	<p>Default Description<textarea name="scsv_defaultdesc"><?php echo $csvpost['desc']; ?></textarea></p>
        <hr />
        <h4>Ingestion Settings</h4>
        <p id="custom_terms">
          Custom Terms (<span style="color: red">separate terms with commas</span>)
            <input type="text" name="scsv_custom_terms" value="<?=$post_terms?>" size="50">
        </p>
        <p id="compex_categories">
            Parse complex categories: <input type="checkbox" name="scsv_parse_terms" value="true" <?=($parse_terms)?'checked="checked"':''?>>
        </p>
        <p id="ingestion_debugging">
            Debug Ingestion: <input type="checkbox" name="scsv_ingest_debugger" value="true" <?=($ingest_debugger)?'checked="checked"':''?>>
        </p>
        <hr />
        <h4>CSV Settings</h4>
        <p id="csv_settings">
            <? $settings_keys = array('delimiter'=>',','enclosure'=>'"','escape'=>'\\'); ?>
            <? foreach($settings_keys as $k=>$v): ?>
                <?=$k?>:<input type='text' name='scsv_csv_settings[<?=$k?>]' value='<?=($csv_settings[$k])?stripslashes($csv_settings[$k]):$v;?>' size='2' maxlength='2' /><br />
            <? endforeach; ?>
        </p>
        <hr />
        <p class="submit">
            <input type="submit" name="scsv_submit" value="Update Options" />
        </p>
</form>
</div>
