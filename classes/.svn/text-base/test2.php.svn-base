<?php

require_once(dirname(__FILE__) . '/../../../../wp-load.php');

class SupraCsvExtractor {

    /**
    * @param: args
    * --posts_per_page (int)
    * --offset (int)
    * --post_type(string)
    * --orderby(string)
    * --order(enum: DESC,ASC)
    * --post_status(string) 
    * --meta_query(array)
    * --tax_query(array)
    * --year(int)
    * --w(int)
    * --post_taxonomies(array) 
    * --meta_keys(array)
    **/   

    function __construct($args) {

        foreach($args as $k=>$v) {
            $this->properties[$k] = $v;
        }

    }

    private function getPosts() {
        return get_posts($this->properties);
    }

    public function getPostsAndDetails() {
 
        $posts = false;
   
        foreach($this->getPosts() as $i=>$this->post) {
            $this->getCustomFields()->getKeywords();
            $posts[$i] = $this->post;
        }
   
        return $posts;        
    }

    private function getCustomFields() {
        if(!empty($this->properties['meta_keys'])) {
            foreach($this->properties['meta_keys'] as $mk) {
                $post_meta = get_post_meta($this->post->ID,$mk,true);
                if(!empty($post_meta)) $this->post->custom_fields[$mk] = $post_meta;
            }
        }
        else {
             //$this->post->custom_fields = get_post_custom($this->post->ID);      
        }

        return $this;
    }
 
    private function getKeywords() {
        if(!empty($this->properties['post_taxonomies'])) {
            foreach($this->properties['post_taxonomies'] as $pt) {
                $post_terms = get_the_terms($this->post->ID,$pt);
                foreach($post_terms as $post_term) {
                    $this->post->terms[$pt] = $post_term->name;
                }
            }
        }
 
        return $this;
    }

}

class SupraCsvExporter {

    function __construct($args) {
        extract($args);
        $this->posts = $posts;
        $this->parsable_keys = $parsable_keys;
        $this->settings = $settings;
        $this->filename = $filename;
    }    

    private function parseRecords() {
        $records = false;

        foreach($this->posts as $i=>$post) {
            foreach($this->parsable_keys as $key=>$pk) {
                if(!in_array($key,array('custom_fields','terms')) && !is_array($key) || empty($key)) {
                    $this->records[$i][$pk] = $post->$pk;
                }
                else { 
                    foreach($pk as $p) {
                        $post_termkey_key = $post->$key;
                        $this->records[$i][$p] = $post_termkey_key[$p];
                    }
                }
            }
        }

        return $this;
    }

    private function getSettings() {
 
        $defaultSettings = array(
                                 'delimiter'=>',',
                                 'enclosure'=>'"'
                                );
        return array_merge($defaultSettings,$this->settings);

    }

    private function buildCsv() {
        extract($this->getSettings());

        foreach($this->records as $record) {
            $val_array = array();
            $key_array = array();
            foreach($record AS $key => $val) {
                    $key_array[] = $key;
                    if(!empty($escape)) {
                        $val = str_replace($enclosure, $escape.$enclosure, $val);
                        $val = str_replace($delimeter, $escape.$delimiter, $val);
                    }
                    $val_array[] = $enclosure.$val.$enclosure;
            }
            if($c == 0) {
                $this->csvstring .= implode($delimiter, $key_array)."\n";
            }
            $this->csvstring .= implode($delimiter, $val_array)."\n";
            $c++;                
        }     

        return $this;
    }

    public function download() {
        if(empty($this->csvstring)) $this->parseRecords()->buildCsv();

        echo $this->csvstring; die();

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: private");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$this->filename");
        header("Accept-Ranges: bytes");
        echo $this->csvstring;
        exit;
    }
}

$args['fart'] = array(
    "posts_per_page"=>"-1",
    "offset"=>"0",
    "post_type"=>"listing",
    "order_by"=>"post_date",
    "order"=>"DESC",
    "post_status"=>"publish",
    "year"=>"2012",
    //"weeks_ago"=>2
);

$args['test_listing'] = array(
    'posts_per_page'=>20,
    'post_type'=>'post',
    'post_taxonomies'=>array('category'),
    'meta_keys'=>array('llw_lat','llw_lon')
/*
    'meta_query' =>array(
      array(
        'key'=>'enginesize_value',
        'value'=>'1.8'
      ),
      array(
        'key'=>'price_value',
        'value'=>10500
      )
    )
*/
);

$sce = new SupraCsvExtractor($args['fart']);
$posts = $sce->getPostsAndDetails();

echo '<pre>';
print_r($posts);
echo '</pre>';

$args['test_exporter'] = array(
    'posts'=>$posts,
    'parsable_keys'=>array(
                           'post_content','post_title','guid',
                           'custom_fields'=>array('llw_lat','llw_lon'),
                           'terms'=>array('category')
                          ),
    'settings'=>array(),
    'filename'=>'dhiarrhea.csv'
);

//$scex = new SupraCsvExporter($args['test_exporter']);
//$scex->download();
