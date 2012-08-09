<?php
require_once('Debug.php');
require_once('SupraCsvPlugin.php');

class RemotePost extends SupraCsvPlugin {
    private $client;
    private $uname;
    private $pass;
    private $postId;

    function __construct() {
        parent::__construct();
     
        include ABSPATH . 'wp-includes/class-IXR.php';
        $this->setUser();       
        $pingback = $this->getPluginDirUrl() . "/xmlrpc/supra_xmlrpc.php";
        $this->client = new IXR_Client($pingback);
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
                              'publish'=>true,
                             );

        $args = array_merge($default_args, $args);

        if($args['function'] == "metaWeblog.newPost") {
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
                      'function'=>'metaWeblog.newPost',
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

        foreach($args['meta'] as $k=>$v) {
            $meta[] = array('key'=>$k,'value'=>$v);
        }

        $post = get_option('scsv_post');

        $params = array('title','type','desc');
    
        foreach($params as $param) {
            if(empty($args[$param]))
                $$param = $post[$param];
            else
                $$param = $args[$param];
        }

        $content = array(
                         'description'=>$desc,
                         'post_type'=>$type,
                         'title'=>$title,
                         'custom_fields'=>$meta);
     
        try {
            return $this->postContent($content);
        } catch( Exception $e ) {
            echo '<span class="error">'.$e->getMessage().'</span>';
            return false;
        }

    }
}
