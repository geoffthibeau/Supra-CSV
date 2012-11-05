<?php 
require_once('classes/Debug.php');

wp_enqueue_script( 'inputCloner', plugins_url('/js/inputCloner.js', __FILE__) );
wp_enqueue_script( 'extractor', plugins_url('/js/export.js', __FILE__) );

?>

<div id="supra_csv_extractor_form">
 
    <form id="extraction_form"> 
        <h3>Extract Settings</h3>

        <div id="input">
            <label for="posts_per_page">Post Per Page</label>
            <input type="text" id="posts_per_page" name="posts_per_page" maxlength="3" size="3" />
        </div>

        <div id="input">
            <label for="offset">Offset</label>
            <input type="text" id="offset" name="offset" maxlength="3" size="3" />
        </div>

        <div id="input">
            <label for="post_type">Post Type</label>
            <select name="post_type" id="post_type">
            <? foreach(get_post_types() as $post_type): ?>
                <option value="<?=$post_type?>"><?=$post_type?></option>
            <? endforeach ?>
            </select>
        </div>

        <div id="input">
            <label for="order_by">Order By</label>
            <select name="order_by" id="order_by">
                <option value="post_date">Date</option>
                <option value="post_title">Title</option>
                <option value="post_status">Status</option>
                <option value="post_type">Type</option>
            </select>
        </div>

        <div id="input">
            <label for="order">Order</label>
            <select name="order" id="order">
                <option value="DESC">DESC</option>
                <option value="ASC">ASC</option>
            </select>
        </div>

        <div id="input">
            <label for="post_status">Post Status</label>
            <select name="post_status" id="post_status">
                <option value="publish">Published</option>
                <option value="pending">Pending</option>
                <option value="trash">Trash</option>
                <option value="auto-draft">Draft</option>
            </select>
        </div>

        <div id="input">
            <label for="year">Year</label>
            <input type="text" id="year" name="year" maxlength="4" size="4" />
        </div>

        <div id="input">
            <label for="weeks_ago">Weeks Ago</label>
            <input type="text" id="weeks_ago" name="weeks_ago" maxlength="2" size="2" />
        </div>

        <div id="input">
            <button id="extract_and_preview">Extract</button>
        </div>

        <h3>Export Settings</h3>

        <div id="input">
            <label for="filename">Filename</label>
            <input type="text" id="filename" name="filename" size="50" />
        </div>

        <div id="input">
            <label for="post_fields">Post Fields <span class="help">provide a comma separated value</span></label>
            <input type="text" id="post_fields" name="post_fields" size="50" value="post_title,post_content" />
        </div>

        <div id="input">
            <label for="post_taxonomies">Taxonomies <span class="help">provide a comma separated value</span></label>
            <input type="text" id="post_taxonomies" name="post_taxonomies" size="50" />
        </div>

        <div id="input">
            <label for="meta_keys">Meta Keys <span class="help">provide a comma separated value</span></label>
            <input type="text" id="meta_keys" name="meta_keys" size="50" />
        </div>

        <div id="input">
            <button id="extract_and_export">Extract And Export</button>
        </div>

    </form>
</div>
<div id="extracted_results"></div>
