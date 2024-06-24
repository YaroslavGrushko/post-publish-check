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

    const MIN_LINKS_COUNT = 3;

    function __construct(){
        add_action('admin_enqueue_scripts', array($this, 'yvg_enqueue_admin_scripts'));
		add_filter('wp_insert_post_data', array($this, "check_post_publish"), 10, 2);
    }

    function yvg_enqueue_admin_scripts() {
        wp_enqueue_script('app-js', plugin_dir_url(__FILE__) . '/js/app.js', array( 'jquery', 'wp-data', 'wp-element' ), POST_PUBLISH_CHECK_VERSION, true);
    }

    function check_post_publish($data, $postarr){
        if ($data['post_status'] == 'publish' && $postarr['ID']) {
            $content = $data['post_content'];
            $links_count = $this->count_links_in_content($content);
            
            if ($links_count < self::MIN_LINKS_COUNT){
                $data['post_status'] = 'draft';
                echo `
                    <script>
                        console.log("Aborted!");
                    </script>
                `;
            }
        }
        return $data;
    }

    function count_links_in_content($content){
        $count_links = 0;
        if($content != ''){
            // regular expression
            $dom = new DOMDocument;
            $dom->loadHTML($content);
            $count_links = $dom->getElementsByTagName('a')->length;
        }
        
        return $count_links;
    }
}

new Post_Publish_Check();