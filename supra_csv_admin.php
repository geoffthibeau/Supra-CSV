<?php 
if(!empty($_POST['csv_submit'])) {
    $csvfile= $_POST['sscsv_filename'];
    $csvuser['name'] = $_POST['sscsv_wpname'];
    $csvuser['pass'] = $_POST['sscsv_wppass'];
    $csvpost['publish'] = $_POST['sscsv_autopub'];
    $csvpost['type'] = $_POST['sscsv_posttype'];
    $csvpost['title'] = $_POST['sscsv_defaulttitle'];
    $csvpost['desc'] = $_POST['sscsv_defaultdesc'];
    update_option('sscsv_filename', $csvfile);
    update_option('sscsv_user', $csvuser);
    update_option('sscsv_post', $csvpost);
?>
<div class="updated"><p><strong>Configuration saved</strong></p></div>
<?php
} else {
    $csvfile = get_option('sscsv_filename');
    $csvuser = get_option('sscsv_user');
    $csvpost = get_option('sscsv_post');
}
?>
<div class="wrap">
<h2>Skysoft CSV Configuration</h2>
<form name="sscsv_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<h4>CSV Settings</h4>
	<p>CSV Filename<input type="text" name="sscsv_filename" value="<?php echo $csvfile; ?>" size="20"></p>
        <hr />
        <h4>User Settings</h4>
	<p>Username<input type="text" name="sscsv_wpname" value="<?php echo $csvuser['name']; ?>" size="20"></p>
	<p>Pasword<input type="password" name="sscsv_wppass" value="<?php echo $csvuser['pass']; ?>" size="20"></p>

        <hr />
        <h4>Post Settings</h4>
	<p>
            Auto Publish
            <select name="sscsv_autopub">
                <option value="0">false</option>
                <option value="1" <?php if($csvpost['publish']) echo 'selected="selected"';?>>true</option>
            </select>
        </p>
	<p>Post Type<input type="text" name="sscsv_posttype" value="<?php echo $csvpost['type']; ?>" size="20"></p>
	<p>Default Title<input type="text" name="sscsv_defaulttitle" value="<?php echo $csvpost['title']; ?>" size="20"></p>
	<p>Default Description<textarea name="sscsv_defaultdesc"><?php echo $csvpost['desc']; ?></textarea></p>
	<p class="submit">
	<input type="submit" name="csv_submit" value="Update Options" />
	</p>
</form>
</div>
