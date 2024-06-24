<?php 
/**
 * Plugin Name: Post Publish Check
 * Plugin URI: https://yvg.com.ua/
 * Description: Post Publish Check.
 * Version: 1.0.0
 * Author: Yaroslav Grushko
 * Author URI: https://yvg.com.ua/
 * Text Domain: postpublishcheck
 * Domain Path: /languages/
 */


 if( !defined('POST_PUBLISH_CHECK_VERSION') ){
	define('POST_PUBLISH_CHECK_VERSION', '1.0.0');
}

if( !defined('POST_PUBLISH_CHECK_DIR') ){
	define('POST_PUBLISH_CHECK_DIR', plugin_dir_path( __FILE__ ));
}
class Post_Publish_Check {
    function __construct(){
		
	}
}



new Post_Publish_Check();