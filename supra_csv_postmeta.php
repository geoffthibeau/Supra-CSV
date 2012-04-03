<?php 

require_once('classes/Debug.php');

wp_enqueue_script( 'inputCloner', plugins_url('/js/inputCloner.js', __FILE__) ); 

$postmetas = get_option('sscsv_postmeta');

if(!empty($_POST)) {
    update_option('sscsv_postmeta',$_POST);
    $postmetas = $_POST;
}

?>

<style type="text/css">

    #labeling td {
        text-align: center;
        font-weight: bold;
    }

    #pm_buttons td {
        text-align: center;
    }
</style>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?page=supra_csv_postmeta';?>">
<table id="post_meta_form">
    <tr id="labeling">
        <td>Post Meta Key</td>
        <td>Display Name</td>
    </tr>
<?php 
    if(!empty($postmetas)) {
        foreach($postmetas['meta_key'] as $i=>$metakey) {
        
            $displayname = $postmetas['displayname'][$i];             

            $n = $i + 1;

            echo '<tr id="pm_info'.$n.'" class="pm_info">';
            echo '<td><input type="text" name="meta_key[]" id="meta_key'.$n.'" value="'.$metakey.'" size="40" maxlength="40" /></td>';
            echo '<td><input type="text" name="displayname[]" id="displayname'.$n.'" value="'.$displayname.'" size="40" maxlength="40" /></td>';
            echo '</tr>';
        }
    }
    else {
?>
    <tr id="pm_info1" class="pm_info">
        <td><input type="text" name="meta_key[]" id="meta_key0" size="40" maxlength="40" /></td>
        &nbsp; &nbsp;
        <td><input type="text" name="displayname[]" id="displayname0" size="40" maxlength="40" /></td>
    </tr>
<?php
    }
?>
    <tr id="pm_buttons">   
        <td colspan="2">
            <input  id="add_pmr" type="button" value="Add Post Meta" />
            &nbsp; &nbsp;
            <input  id="rem_pmr" type="button" value="Remove Post Meta" />
        </td>
    </tr>
    <tr id="pm_buttons">   
        <td colspan="2">
            <input type="submit" type="submit" value="Submit" />
        </td>
    </tr>  
</table>
</form>

