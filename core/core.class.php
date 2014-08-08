<?php

namespace core;

class Core {
	
	function init() {
		
		add_action('widgets_init', array($this, 'register_widgets'));
		add_theme_support('post-thumbnails');
		add_filter('wp_default_editor', create_function('', 'return "tinymce";'));

		if(!is_admin()) {

			add_action('init', array($this, 'removeHeadLinks'));
			add_action('wp_enqueue_scripts', array($this, 'load_core_js'));
			add_action('wp_enqueue_scripts', array($this, 'load_core_css'));
			header("X-UA-Compatible: IE=EDGE");
			add_filter('the_content', array($this, 'shortcode_empty_paragraph_fix'));
			add_filter('next_posts_link_attributes', array($this, 'next_posts_link_attributes'));
			add_filter('wp_title', array($this, 'site_title'));

		}
		
	}

	function load_core_js() {
	
		wp_deregister_script('jquery');
		wp_register_script('jquery',"http".($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js", false, null);
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap',get_bloginfo('template_directory').'/assets/js/bootstrap.min.js',dirname(__FILE__),array('jquery'),true);
		wp_register_script('app',get_bloginfo('template_directory').'/assets/js/app.js',dirname(__FILE__),array('jquery'),true);
		wp_localize_script('app','ajax_url',array('ajaxurl'=>admin_url('admin-ajax.php')));
		wp_enqueue_script('app');
		
	}
	
	function load_core_css() {
	
		wp_enqueue_style('bootstrap',get_bloginfo('template_directory').'/assets/css/bootstrap.min.css');
		wp_enqueue_style('app',get_bloginfo('template_directory').'/assets/css/app.css');
		
	}

	function site_title() {

		if(is_page() || is_single()) {

			global $post;

			$data .= $post->post_title.' | ';
		}

		if(is_tax()) {

			global $wp_query;

			$tax = $wp_query->queried_object;
			$data .= $tax->name;

		}

		$data .= get_bloginfo('title').' | '.get_bloginfo('description');

		return $data;
	}
	
	function removeHeadLinks() {
	
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head','wp_generator');
		
	}	
	
	function register_navs() {
	
		register_nav_menu('primary','Primary Nav');
		register_nav_menu('footer_a','Footer A Nav');
		register_nav_menu('footer_b','Footer B Nav');
		
	}
	
	function register_sidebars() {
				
	}

	function register_widgets() {
				
	}
				
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

	function custom_post_type($args) {

		foreach($args as $arg) {

			register_post_type($arg['name'], $arg['cpt_args']);

			if(isset($arg['ct_args'])) {

				foreach($arg['ct_args'] as $ct) {

					register_taxonomy($ct['name'], $arg['name'], $ct['args']);

				}

			}

		}

	}
		
}