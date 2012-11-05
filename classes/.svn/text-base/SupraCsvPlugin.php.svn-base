<?php
require_once(dirname(__FILE__).'/SupraCsvDBAL.php');
require_once(dirname(__FILE__).'/../SupraCsvParser_Plugin.php');

class SupraCsvPlugin {

    private $plugin_name = 'supra-csv-parser';
    public $dbal = false;

    //set the DBAL instance
    public function __construct() {
           $this->dbal = new SupraCsvDBAL(DB_NAME,DB_HOST,DB_USER,DB_PASSWORD);
           $this->plugin = new SupraCsvParser_Plugin();
    }

    public function getPresetsTable() {
        return $this->plugin->getPresetsTable();
    }

    public function getPluginDirUrl() {
        return WP_PLUGIN_URL . '/' . $this->plugin_name .'/';
    }

    public function getCsvDir() {
        return WP_CONTENT_DIR . '/uploads/' . $this->plugin_name .'/'. 'csv' . '/';
    }

    public function getCsvDirUrl() {
        return WP_CONTENT_URL . '/uploads/' . $this->plugin_name .'/'. 'csv' . '/';
    }
}
