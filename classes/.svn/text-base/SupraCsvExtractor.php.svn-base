<?php

require_once(dirname(__FILE__) . '/../../../../wp-load.php');

class ExtractorArgumentParser {

    private $exporter_properties = array('post_fields','filename');

    function __construct($args) {
        $this->args = $args;
        $this->parseTaxAndMeta();
        $this->parseWeeksAgo();
        $this->parsePostsPerPage();
        $this->parseRemainingArgs();
        //Debug::show($this->properties);
    }

    protected function parseTaxAndMeta() {

        $toParse = array('post_taxonomies','meta_keys');

        foreach($toParse as $parsing) {

            if(!empty($this->args[$parsing])) {
                $this->properties[$parsing] = explode(',', $this->args[$parsing]);
            }
  
            unset($this->args[$parsing]);
        }
    }

    protected function parsePostsPerPage() {
        if(empty($this->args['posts_per_page'])) {
            $this->properties['posts_per_page'] = -1;
            unset($this->args['posts_per_page']);
        }
    }
 
    protected function parseWeeksAgo() {
        if(!empty($this->args['weeks_ago']))
            $this->properties['w'] = date('W') - (int) $this->args['weeks_ago'];

        unset($this->args['weeks_ago']);
    }

    protected function parseRemainingArgs() {
        foreach($this->args as $k=>$v) {
            if(!in_array($k,$this->exporter_properties))
                $this->properties[$k] = $v;
        }
    }
}

class SupraCsvExtractor extends ExtractorArgumentParser {

    /**
    * @param: args
    * --posts_per_page (int)
    * --offset (int)
    * --post_type(string)
    * --category(string)
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

    public function displayExtractedPosts() {

        $posts = $this->getPostsAndDetails();

        if(count($posts) && !empty($posts[0]))
            $string = '<span class="success">Found '.count($posts).' posts matching the criteria.</span>';
        else
            $string = '<span class="error">No results found matching the creteria</span>';

        foreach($posts as $post) {
            $string .= '<p id="extracted_post"><a href="'.$post->guid.'">'.$post->post_title.'</a></p>';
        }

        return $string;
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

class ExporterArgumentParser extends ExtractorArgumentParser {

    function __construct($posts,$args) {
        $this->posts = $posts;
        $this->args = $args;
        $this->parseTaxAndMeta();
        $this->buildArgs();
    }

    private function buildArgs() {
        $post_fields = explode(',',$this->args['post_fields']);
        $meta_and_terms = array('custom_fields'=>$this->properties['meta_keys'],'terms'=>$this->properties['post_taxonomies']);
        $this->parsable_keys = array_merge($post_fields,$meta_and_terms);
        $this->filename = $this->args['filename'];
        $this->settings = $csv_settings;
    }

}

class SupraCsvExporter extends ExporterArgumentParser {

    private function parseRecords() {
        $records = false;

        foreach($this->posts as $i=>$post) {
            foreach($this->parsable_keys as $key=>$pk) {
                if(!in_array($key,array('custom_fields','terms')) && !is_array($key) || empty($key)) {
                    $this->records[$i][$pk] = $post->$pk;
                }
                else { 
                    foreach((array)$pk as $p) {
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

        return array_merge($defaultSettings,(array)$this->settings);
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

        //echo $this->csvstring; die();

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: private");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$this->filename");
        header("Accept-Ranges: bytes");
        echo $this->csvstring;
        exit;
    }

    public function createFile() {
        if(empty($this->csvstring)) $this->parseRecords()->buildCsv();
        $my_file = dirname(__FILE__) . '/../../../uploads/supra-csv-parser/csv/'.$this->filename;
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        fwrite($handle, $this->csvstring);
    }

    public function addToSession() {
        if(empty($this->csvstring)) $this->parseRecords()->buildCsv();
        $_SESSION['supra_csv']['filename'] = $this->filename;
        $_SESSION['supra_csv']['content'] = $this->csvstring;
    }
}
