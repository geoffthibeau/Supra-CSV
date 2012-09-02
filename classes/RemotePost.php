<?php
require_once('Debug.php');
require_once('SupraCsvPlugin.php');

class RemotePost extends SupraCsvPlugin {
    private $client;
    private $uname;
    private $pass;
    private $postId;
    private $debugging;

    function __construct() {
        parent::__construct();
     
        include ABSPATH . 'wp-includes/class-IXR.php';
        $this->setUser();       
        $pingback = $this->getPluginDirUrl() . "/xmlrpc/supra_xmlrpc.php";
        $this->client = new IXR_Client($pingback);
        $this->debugging = get_option('scsv_ingest_debugger');
        $this->client->debug = $this->debugging;;
    }

    private function setUser() {
        $csvuser = get_option('scsv_user');
        $this->uname = $csvuser['name'];
        $this->pass  = $csvuser['pass'];
    }

    private function _makeCall($args) {

        if(!is_array($args['args'])) throw new Exception('Invalid Argument');

        $post= get_option('scsv_post');

        $default_args = array(
                              'post_id'=>null,
                              'publish'=>$post['publish'],
                             );

        $args = array_merge($default_args, $args);

        if($this->debugging)
            Debug::show($args);

        if($args['function'] == "wp.newPost") {
            if(!$this->client->query($args['function'],$args['post_id'],$this->uname,$this->pass,$args['args'],$args['publish']))
               throw new Exception($this->client->getErrorMessage());
        } else if($args['function'] == "wp.setOptions") {
            if(!$this->client->query($args['function'],$args['post_id'],$this->uname,$this->pass,$args['args']))
               throw new Exception($this->client->getErrorMessage());
        }

        return $this->client->getResponse();
    }

    public function postContent($content) {

        $args = array(
                      'function'=>'wp.newPost',
                      'args'    =>$content, 
                     );

        $response = $this->_makeCall($args);

        if($response) {
            $this->postId = $response;
        }
   
        return $response;
    }

    public function postOptions($options) {

        $args = array(
                      'function'=>'wp.setOptions',
                      'post_id' => $this->postId,
                      'args'    =>$options,
                      'publish' =>null
                     );

        return $this->_makeCall($args);
    }

    public function postContentAndOptions($content,$options) {

        $response['content'] = $this->postContent($content);
        $response['options'] = $this->postOptions($options);
       
        return $response;
    }

    public function injectListing($args) {

        foreach($args['custom_fields'] as $k=>$v) {
            $custom_fields[] = array('key'=>$k,'value'=>$v);
        }

        $post = get_option('scsv_post');

        $params = array('post_title','post_type','post_content','terms_names','terms');
    
        foreach($params as $param) {
            if(empty($args[$param]))
                $$param = $post[$param];
            else
                $$param = $args[$param];
        }

        $content = array(
                         'post_content'=>$post_content,
                         'post_type'=>$post_type,
                         'post_title'=>$post_title,
                         'terms_names'=>$terms_names,
                         'terms'=>$terms,
                         'custom_fields'=>$custom_fields
                        );

        if($post['publish'])
            $content['post_status'] = 'publish';
        else
            $content['post_status'] = 'pending';


        try {
            $success = $this->postContent($content);
        } catch( Exception $e ) {
            echo '<span class="error">'.$e->getMessage().'</span>';
            $success = false;;
        }
         
        return $success;
    }
}
