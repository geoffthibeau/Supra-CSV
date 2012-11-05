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
    $report_issue = $_POST['scsv_report_issue'];
    update_option('scsv_filename', $csvfile);
    update_option('scsv_user', $csvuser);
    update_option('scsv_post', $csvpost);
    update_option('scsv_custom_terms', $post_terms);
    update_option('scsv_parse_terms', $parse_terms);
    update_option('scsv_ingest_debugger', $ingest_debugger);
    update_option('scsv_report_issue', $report_issue);
    update_option('scsv_csv_settings', $csv_settings);
    echo '<div class="updated"><p><strong>Configuration saved</strong></p></div>';
} else {
    $csvfile = get_option('scsv_filename');
    $csvuser = get_option('scsv_user');
    $csvpost = get_option('scsv_post');
    $post_terms = get_option('scsv_custom_terms');
    $parse_terms = get_option('scsv_parse_terms');
    $ingest_debugger = get_option('scsv_ingest_debugger');
    $report_issue = get_option('scsv_report_issue');
    $csv_settings = get_option('scsv_csv_settings');
}

?>
<div style="width: 630px">
<h2>Supra CSV Configuration</h2>
        <hr />
<div style="float: left; width: 300px;">
<form name="scsv_form" method="post">
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
</div>
<div style="float: right; width: 300px;">
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
        <p id="issue_reporting">
            Report Issues: <input type="checkbox" name="scsv_report_issue" value="true" <?=($report_issue)?'checked="checked"':''?>>
        </p>
        <hr />
        <h4>CSV Settings</h4>
        <p id="csv_settings">
            <? $settings_keys = array('delimiter'=>',','enclosure'=>'"','escape'=>'\\'); ?>
            <? foreach($settings_keys as $k=>$v): ?>
                <?=$k?>:<input type='text' name='scsv_csv_settings[<?=$k?>]' value='<?=($csv_settings[$k])?stripslashes($csv_settings[$k]):$v;?>' size='2' maxlength='2' /><br />
            <? endforeach; ?>
        </p>
</div>
<div style="clear: both"></div>
<hr />
        <p class="submit">
            <input type="submit" name="scsv_submit" value="Update Options" />
        </p>
</form>
</div>

