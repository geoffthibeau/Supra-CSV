<?php
include(dirname(__FILE__) . '/../../../wp-load.php');
require_once('classes/RemotePost.php');

$rp = new RemotePost();

$post_args = array(
    'post_content' => null,
    'post_type' => 'post',
    'post_title' => null,
    'terms_names' => null,
    'terms' => null,
    'custom_fields' => array(
      0 => array(
        'key' => 'adimia_myweather2',
        'value' => null
      ),
      1 => array(
        'key' => 'adimia_latitude',
        'value' => null
      ),
      2 => array(
       'key' => 'adimia_longitude',
       'value' => null
      )
    ),
    'post_status' => 'publish'
);

$rp->injectListing($post_args);
~                                  
