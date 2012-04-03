<?php 
/*
Plugin Name: Supra CSV Importer
Plugin URI: http://supraliminal.info/wp_plugins/supracsv/
Description: Plugin for parsing a csv file based on user mapping to ingest into the automotive theme wp_meta
Author: J. Persie
Version: 1.0
Author URI: http://supraliminal.info/wp_plugins/
*/


function sscsv_admin() {
        include('supra_csv_admin.php');
}

function sscsv_ingest() {
        require_once('classes/IngestCsv.php');
        $si = new IngestCsv(get_option('sscsv_filename'));
}

function sscsv_postmeta() {
    require_once('supra_csv_postmeta.php');
}

function sscsv_upload() {
        require_once('classes/UploadCsv.php');
        $uc = new UploadCsv($_FILES); 
}

function sscsv_admin_actions() {
    add_menu_page("Supra CSV", "Supra CSV", "manage_options", "supra_csv", "sscsv_admin");

    add_submenu_page("supra_csv", "Configuration", "Configuration", "manage_options", "supra_csv", "sscsv_admin");

    add_submenu_page("supra_csv", "Post Info", "Post Info", "manage_options", "supra_csv_postmeta", "sscsv_postmeta");
    add_submenu_page("supra_csv", "Ingestion", "Ingestion", "manage_options", "supra_csv_ingest", "sscsv_ingest");

    add_submenu_page("supra_csv", "Upload", "Upload", "manage_options", "supra_csv_upload", "sscsv_upload");
}

add_action('admin_menu', 'sscsv_admin_actions');

?>
