<?php

class SupraCsvPostTaxonomy {

    private $post_type_taxonomies;

    function __construct() {
        $csvpost = get_option('scsv_post');
        $post_type = $csvpost['type'];
        $this->post_type_taxonomies = get_object_taxonomies( $post_type, 'objects' );
    }
 
    public function validTaxonomyByPostType($tax) {
        return array_key_exists($tax, $this->post_type_taxonomies); 
    }
}
