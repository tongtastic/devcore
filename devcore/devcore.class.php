<?php

namespace devcore;

if(!class_exists('DevCore')) {

	class DevCore {
		
		// fires build functions
		function init($args) {
			
			add_action('init', array($this, 'build'));

			// add featured image support to theme
			add_theme_support('post-thumbnails');

			// force TinyMCE to load as visual editor, not HTML editor
			add_filter('wp_default_editor', create_function('', 'return "tinymce";'));

			// load visual composer class
			new VisualComposer;

			// load front end only functions
			if(!is_admin()) {

				add_action('init', array($this, 'remove_head_links'));

				add_action('wp_enqueue_scripts', array($this, 'load_core_js'));

				add_action('wp_enqueue_scripts', array($this, 'load_core_css'));

				//fixes IE8 compatability mode
				header("X-UA-Compatible: IE=EDGE");

				add_filter('the_content', array($this, 'shortcode_empty_paragraph_fix'));

				add_filter('wp_title', array($this, 'site_title'));

			}

			// build theme from array given
			$this->build($args);
			
		}

		// loads devcore required JS
		function load_core_js() {
		
			// removes built in jquery
			wp_deregister_script('jquery');

			// grabs version 1.8.2 from CDN and enqueues below
			wp_register_script('jquery',"http".($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js", false, null);

			wp_enqueue_script('jquery');

			// enqueues bootstrap
			wp_enqueue_script('bootstrap',get_bloginfo('template_directory').'/assets/js/bootstrap.min.js',dirname(__FILE__),array('jquery'),true);

			// loads in app.js (place all custom JS in here)
			wp_register_script('app',get_bloginfo('template_directory').'/assets/js/app.js',dirname(__FILE__),array('jquery'),true);

			// localises for AJAX calls
			wp_localize_script('app','ajax_url',array('ajaxurl'=>admin_url('admin-ajax.php')));

			wp_enqueue_script('app');
			
		}
		
		// loads front end CSS
		function load_core_css() {
		
			wp_enqueue_style('bootstrap',get_bloginfo('template_directory').'/assets/css/bootstrap.min.css');

			wp_enqueue_style('app',get_bloginfo('template_directory').'/assets/css/app.css');
			
		}

		// generates site title
		function site_title() {

			if(is_page() || is_single()) {

				global $post;

				$data .= $post->post_title.' | ';
			}

			if(is_tax()) {

				global $wp_query;

				$tax = $wp_query->queried_object;
				$data .= $tax->name.' | ';

			}

			$data .= get_bloginfo('title').' | '.get_bloginfo('description');

			return $data;
		}
		
		// removes rubbish from header
		function remove_head_links() {
		
			remove_action('wp_head', 'rsd_link');

			remove_action('wp_head', 'wlwmanifest_link');

			remove_action('wp_head','wp_generator');
			
		}


		// builds core theme stuff
		function build($items) {

			if(isset($items['navs'])) {

				$this->register_navs($items['navs']);

			}

			if(isset($items['post_types'])) {

				$this->register_post_types($items['post_types']);

			}

			if(isset($items['metaboxes'])) {

				$meta_box = new MetaBox;

				foreach($items['metaboxes'] as $metabox) {

					$meta_box->init($metabox);

				}

			}

			if(isset($items['taxonomies'])) {

				$this->register_taxonomies($items['taxonomies']);

			}

			if(isset($items['visualcomposer'])) {

				$visualcomposer = new VisualComposer;

				$visualcomposer->init($items['visualcomposer']);

			}

		}

		// registers custom post types
		function register_post_types($post_types = null) {

			if($post_types) {

				foreach($post_types as $post_type) {

					register_post_type($post_type['post_type'], $post_type['args']);

				}

			}

		}

		// registers custom taxonomies
		function register_taxonomies($taxonomies = null) {

			if($taxonomies) {

				foreach($taxonomies as $taxonomy) {

					register_taxonomy($taxonomy['taxonomy'], $taxonomy['post_type'] , $taxonomy['args']);

				}

			}
		}
		
		// registers navs
		function register_navs($args = null) {

			if($args) {

				foreach($args as $key => $value) {

					register_nav_menu($key, $value);

				}

			}
				
		}
				
		// fixes empty space around shortcodes being turned into paragraph tags	
		function shortcode_empty_paragraph_fix($content) {  

		    $array = array (
		        '<p>[' => '[',
		        ']</p>' => ']',
		        ']<br />' => ']',
		        ']<br>' => ']'
		    );
		 
		    $content = strtr($content, $array);
		 
		    return $content;
		}

	}
			
}