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
    update_option('scsv_filename', $csvfile);
    update_option('scsv_user', $csvuser);
    update_option('scsv_post', $csvpost);
    echo '<div class="updated"><p><strong>Configuration saved</strong></p></div>';
} else {
    $csvfile = get_option('scsv_filename');
    $csvuser = get_option('scsv_user');
    $csvpost = get_option('scsv_post');
}
?>
<div class="wrap">
<h2>Supra Csv Importer</h2>

<h3>Description</h3>
<p>The purpose of this plugin is to parse uploaded csv files into any type of post.
Some themes or plugin store data in post with custom post_type, thus this plugin
provides the functionality to upload data from the csv file to the records that 
the theme or plugin creates. Manage existing csv files and promote ease of use by 
creating presets for both postmeta and ingestion mapping. For more infomation on how to obtain the necessary info
 watch the detailed tutorial. Csv Importer, Csv Parser, Csv Injector, Custom Post.</p>
<h3>Tutorial</h3>
<iframe width="420" height="315" src="http://www.youtube.com/embed/reQ3uvBjRuQ" frameborder="0" allowfullscreen></iframe>
            <h3>Contributions</h3>
            <p>Due to the nature of wordpress and its lack of plugin contribution functionality please fork the following repo.</p>
            <p><a href="https://github.com/zmijevik/Supra-CSV" target="_blank">https://github.com/zmijevik/Supra-CSV</a></p>
            <p>Please keep code encapsulated, lets keep this from turning into a procedural mess!</p>
            <p>You have my guarantee that this project will <u>remain</u> free and open source.</p>
            <p>Feel free to contact me regarding plugin issues and requests.</p>

<h2>Supra CSV Configuration</h2>
<form name="scsv_form" method="post"">
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
                <option value="post" <?if($csvpost['type']=="post") echo 'selected="selected"';?>>Post</option>
                <option value="page" <?if($csvpost['type']=="page") echo 'selected="selected"';?>>Page</option>
            </select>
            <b>or</b>
            Custom Post Type
            <input type="text" name="scsv_custom_posttype" value="<?php if($csvpost['type']!="page"&&$csvpost['type']!="post")echo $csvpost['type']; ?>" size="20">
        </p>
	<p>Default Title<input type="text" name="scsv_defaulttitle" value="<?php echo $csvpost['title']; ?>" size="20"></p>
	<p>Default Description<textarea name="scsv_defaultdesc"><?php echo $csvpost['desc']; ?></textarea></p>
	<p class="submit">
	<input type="submit" name="scsv_submit" value="Update Options" />
	</p>
</form>
</div>
