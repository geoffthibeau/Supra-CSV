<?php
include_once('SupraCsvParser_LifeCycle.php');

class SupraCsvParser_Plugin extends SupraCsvParser_LifeCycle {
 
    private $preset_table;
    /**
     * See: http://plugin.michael-simpson.com/?page_id=31
     * @return array of option meta data.
     */
    public function getOptionMetaData() {
        //  http://plugin.michael-simpson.com/?page_id=31
        return array(
            //'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
        );
    }

    public function getPluginDisplayName() {
        return 'Supra Csv Importer';
    }

    protected function getMainPluginFileName() {
        return 'supra-csv-parser.php';
    }

    public function getPresetsTable() {

        if(empty($this->preset_table)) 
            $this->preset_table = $this->prefixTableName('presets');

        return $this->preset_table;
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
                global $wpdb;
                $preset_table= $this->getPresetsTable(); 

                $presetsSql = "
                CREATE TABLE IF NOT EXISTS `$preset_table` (
                `id` int(8) NOT NULL AUTO_INCREMENT,
                `preset_name` varchar(64) NOT NULL,
                `preset_type` varchar(64) NOT NULL,
                `preset` longtext NOT NULL,
                PRIMARY KEY (`id`)
                );";

                $wpdb->query($presetsSql);
    }

    /**
     * See: http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
                global $wpdb;
                $tables[] = $this->prefixTableName('presets');
                foreach($tables as $table) {
                    $wpdb->query("DROP TABLE IF EXISTS `$table`");
                }
    }


    /**
     * Perform actions when upgrading from version X to version Y
     * See: http://plugin.michael-simpson.com/?page_id=35
     * @return void
     */
    public function upgrade() {
    }

    public function scsv_admin() {
        require_once(dirname(__FILE__).'/supra_csv_admin.php');
    }

    public function scsv_ingest() {
        require_once(dirname(__FILE__).'/supra_csv_ingest.php');
    }

    public function scsv_postmeta() {
        require_once(dirname(__FILE__).'/supra_csv_postmeta.php');
    }

    public function scsv_upload() {
        require_once(dirname(__FILE__).'/supra_csv_upload.php');
    }

    public function callAdminActions() {
        add_menu_page("Supra CSV", "Supra CSV", "manage_options", "supra_csv", array(&$this,"scsv_admin"));
        add_submenu_page("supra_csv", "Configuration", "Configuration", "manage_options", "supra_csv", array(&$this,"scsv_admin"));
        add_submenu_page("supra_csv", "Upload", "Upload", "manage_options", "supra_csv_upload", array(&$this,"scsv_upload"));
        add_submenu_page("supra_csv", "Post Info", "Post Info", "manage_options", "supra_csv_postmeta", array(&$this,"scsv_postmeta"));
        add_submenu_page("supra_csv", "Ingestion", "Ingestion", "manage_options", "supra_csv_ingest", array(&$this,"scsv_ingest"));
    }

    public function supraCsvAjax() {
        require_once(dirname(__FILE__).'/classes/SupraCsvAjaxHandler.php');
        $ah = new SupraCsvAjaxHandler($_REQUEST);
        die();    
    }

    public function addActionsAndFilters() {

        add_action('admin_menu', array(&$this, 'callAdminActions'));

        //ajax actions
        add_action('wp_ajax_supra_csv',array(&$this,'supraCsvAjax'));

        // Adding scripts & styles to all pages
        wp_enqueue_script('jquery');
        wp_enqueue_style('my-style', plugins_url('/css/style.css', __FILE__));
        wp_enqueue_script('supra_csv_globals', plugins_url('/js/global.js', __FILE__));


        // Register short codes
        // http://plugin.michael-simpson.com/?page_id=39


        // Register AJAX hooks
        // http://plugin.michael-simpson.com/?page_id=41

    }


}
