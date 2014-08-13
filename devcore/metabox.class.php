<?php

namespace devcore;

if(!class_exists('MetaBox')) {

	class MetaBox {

		// variable to build metabox structure and items
		var $meta;

		// when initialsed, empty variable
		function __construct() {

			$this->meta = array();

		}

		// called to initialise metabox class
		function init($meta) {

			$this->meta = $meta;
				
			add_action('add_meta_boxes', array($this, 'add_new_meta_box'));
			
			add_action('save_post', array($this, 'save_meta_fields'));

			add_action('admin_head', array($this, 'load_admin_files'));
					
		}

		// loads in required CSS and JS files into admin head
		function load_admin_files() {

			wp_register_script('jquery-ui',get_bloginfo('template_directory').'/assets/admin/js/jquery-ui.min.js',dirname(__FILE__),array('jquery'),true);

			wp_enqueue_script('jquery-ui');

			wp_register_script('color-picker',get_bloginfo('template_directory').'/assets/admin/js/colorpicker.js',dirname(__FILE__),array('jquery'),true);

			wp_enqueue_script('color-picker');

			wp_register_script('meta',get_bloginfo('template_directory').'/assets/admin/js/meta.js',dirname(__FILE__),array('jquery'),true);

			wp_enqueue_script('meta');

			wp_enqueue_style('meta',get_bloginfo('template_directory').'/assets/admin/css/meta.css');

			wp_enqueue_style('colorpicker',get_bloginfo('template_directory').'/assets/admin/css/colorpicker.css');

		}

		// registers metaboxes
		function add_new_meta_box() {

			$metabox = $this->meta;
			
			$post_type = $metabox['post_type'];
			
			if(is_array($post_type)) {
			
				foreach($post_type as $type) {
					
					add_meta_box($metabox['id'].'_meta', $metabox['name'], array($this, 'show_meta_box'), $type, $metabox['position'], 'high', array('fields' => $metabox['fields'], 'box_id' => $metabox['id']));
					
				}
				
			} else {
		
				add_meta_box($metabox['id'].'_meta', $metabox['name'], array($this, 'show_meta_box'), $post_type, $metabox['position'], 'high', array('fields' => $metabox['fields'], 'box_id' => $metabox['id']));
			
			}

		}

		// loads in meta box wrapper
		function show_meta_box($post, $box) {

			$data .= '<input type="hidden" name="'.$box['args']['box_id'].'_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

			$data .= '<table class="form-table">';

				$data .= '<tr><td>';
			
				$data .= $this->meta_fields($box['args']['fields'], $post);

				$data .= '</td></tr>';
			
			$data .= '</table>';
			
			echo $data;
			
		}

		// loads in all meta fields
		function meta_fields($arr, $post) {

			$meta = new Meta;

			foreach ($arr as $meta_box_field) {

				$val = get_post_meta($post->ID, $meta_box_field['id'], true);
							
				switch ($meta_box_field['type']) {

					case 'text' :

						$data .= $meta->text($meta_box_field, $val);
		
					break;

					case 'datepicker' :

						$data .= $meta->datepicker($meta_box_field, $val);
		
					break;

					case 'colorpicker' :

						$data .= $meta->colorpicker($meta_box_field, $val);
		
					break;
		
					case 'textarea' :

						$data .= $meta->textarea($meta_box_field, $val);
				
					break;
						
					case 'checkbox':

						$data .= $meta->checkbox($meta_box_field, $val);
						
					break;
					
					case 'select':

						$data .= $meta->select($meta_box_field, $val);
						
					break;

					case 'radio':

						$data .= $meta->radio($meta_box_field, $val);
						
					break;
						
					case 'upload' :

						$data .= $meta->upload($meta_box_field, $val);
						
					break;
					
					case 'repeatable-text' :

						$data .= $meta->repeatable_text($meta_box_field, $val);
						
					break;

					case 'repeatable-textarea' :

						$data .= $meta->repeatable_textarea($meta_box_field, $val);
						
					break;

					case 'repeatable-upload' :

						$data .= $meta->repeatable_upload($meta_box_field, $val);
						
					break;

				}

			}
			
			return $data;

		}
 
		// fires when fields are being saved
		function save_meta_fields($post_id) {

			global $post;
			
			$meta_box = $this->meta;
		
			if(!isset($_POST[$meta_box['id'].'_meta_box_nonce'])||!wp_verify_nonce($_POST[$meta_box['id'].'_meta_box_nonce'], basename(__FILE__))) {

				return $post_id;

			}

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

				return $post_id;

			}

			if ('page' == $_POST['post_type']) {

				if (!current_user_can('edit_page', $post_id)) {

					return $post_id;

				}

			} elseif (!current_user_can('edit_post', $post_id)) {

				return $post_id;

			}
					
			foreach ($meta_box['fields'] as $meta_box_field) {

				$old = get_post_meta($post_id, $meta_box_field['id'], true);
				
				$new = $_POST[$meta_box_field['id']];

				$find = array(
					'<p>',
					'</p>'
				);

				$replace = array(
					'',
					PHP_EOL
				);

				$new = str_replace($find, $replace, $new);

				if($new) {
				
					if ($new && $new != $old) {
		
						$id = update_post_meta($post_id, $meta_box_field['id'], $new);
		
					} elseif ('' == $new && $old) {
		
						$id = delete_post_meta($post_id, $meta_box_field['id'], $old);
		
					}

				} else {

					$id = delete_post_meta($post_id, $meta_box_field['id'], $old);
				}
						
			}
				
		}
		
	}

}