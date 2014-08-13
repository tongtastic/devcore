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

			add_action('wp_ajax_meta_format_content', array($this, 'format_content'));
					
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

		// formats content sent too and from wp editor via AJAX call
		function format_content() {

			$content = $_REQUEST['content'];

			$content = wpautop($content);

			$data['content'] = $content;

			$data['type'] = 'success';

			$response = json_encode($data);

			echo $response;

			die();

		}

		// outputs wp editor / generates wp editor popup for repeatable wysiwyg fields
		function load_editor($id, $hide = true, $content = null, $args = null) {

			if($hide == true) {

				$data .= '<div class="meta-editor-wrapper-bg" id="meta-wrapper-editor-bg-'.$id.'"></div>';
									
				$data .= '<div class="meta-editor-wrapper" id="meta-wrapper-editor'.$id.'">';

					$data .= '<h2>Insert content</h2>';

			}

			if(!$args) {

				$args = array(
					'textarea_name' => $id,
					'textarea_rows' => 30
				);

			}
							
			ob_start();
			
			wp_editor($content, 'editor'.$id, $args);

			$editor = ob_get_contents();

			ob_end_clean();

			$data .= $editor;

			if($hide == true) {

					$data .= '<br /><a class="button-primary meta-insert-content" data-editor="'.$id.'" data-editorwrap="#meta-wrapper-editor'.$id.'" data-bg="#meta-wrapper-editor-bg-'.$id.'">Insert</a>';

					$data .= '<a class="button-secondary meta-close-editor-window" data-editor="'.$id.'" data-editorwrap="#meta-wrapper-editor'.$id.'" data-bg="#meta-wrapper-editor-bg-'.$id.'">Cancel</a>';

				$data .= '</div>';

			}

			return $data;

		}

		// loads in all meta fields
		function meta_fields($arr, $post) {

			foreach ($arr as $meta_box_field) {

				$val = get_post_meta($post->ID, $meta_box_field['id'], true);
							
				switch ($meta_box_field['type']) {

					case 'text' :

						$data .= $this->text($meta_box_field, $val);
		
					break;

					case 'datepicker' :

						$data .= $this->datepicker($meta_box_field, $val);
		
					break;

					case 'colorpicker' :

						$data .= $this->colorpicker($meta_box_field, $val);
		
					break;
		
					case 'textarea' :

						$data .= $this->textarea($meta_box_field, $val);
				
					break;
						
					case 'checkbox':

						$data .= $this->checkbox($meta_box_field, $val);
						
					break;
					
					case 'select':

						$data .= $this->select($meta_box_field, $val);
						
					break;

					case 'radio':

						$data .= $this->radio($meta_box_field, $val);
						
					break;
						
					case 'upload' :

						$data .= $this->upload($meta_box_field, $val);
						
					break;
					
					case 'repeatable-text' :

						$data .= $this->repeatable_text($meta_box_field, $val);
						
					break;

					case 'repeatable-textarea' :

						$data .= $this->repeatable_textarea($meta_box_field, $val);
						
					break;

					case 'repeatable-upload' :

						$data .= $this->repeatable_upload($meta_box_field, $val);
						
					break;

				}

			}
			
			return $data;

		}

		function text($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);

				$data .= '<input type="text" class="meta-text" name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'" value="'.$val.'" />';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function textarea($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);

				if(isset($meta_box_field['rich_editor']) && $meta_box_field['rich_editor'] == true) {

					$data .= $this->load_editor($meta_box_field['id'], false, $meta);

				} else {

					$data .= '<textarea class="meta-textarea" name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'">'.$meta.'</textarea>';

				}

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function datepicker($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);

				$data .= '<input type="text" class="meta-datepicker" name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'" value="'.$val.'" data-dateformat="'.$meta_box_field['format'].'" />';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function colorpicker($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);

				$data .= '<input type="text" class="meta-colorpicker" name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'" value="'.$meta.'" />';

				$data .= '<span class="meta-colorpicker-color"';

				if($meta) {

					$data .= ' style="display:block;background: '.$meta.'"';

				}

				$data .= '></span>';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function checkbox($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);
		
				$data .= '<input type="checkbox" class="meta-checkbox" name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'"';

				if($meta == 'on') {
				
					$data .= ' checked="checked"';
					
				}

				$data .= ' />';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function select($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);
							
				$data .= '<select class="meta-select" name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'">';
				
				$data .= '<option value="" selected="selected">Please select an option</option>';
				
				foreach ($meta_box_field['options'] as $key => $value) {
				
					if($meta == $value) {
					
						$data .= '<option value="'.$value.'" selected="selected">'.$key.'</option>';
						
					} else {
				
						$data .= '<option value="'.$value.'">'.$key.'</option>';
					
					}
					
				}
				
				$data .= '</select>';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function radio($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);

				$row = 1;
																			
				foreach ($meta_box_field['options'] as $key => $value) {

					$data .= '<div class="meta-radio-wrapper">';
				
					if(($meta == $value) || (!$meta && $row == 1)) {
					
						$data .= '<input class="meta-radio" type="radio" name="'.$meta_box_field['id'].'" value="'.$value.'" checked="checked" value="'.$key.'" />';
						
					} else {
				
						$data .= '<input class="meta-radio" type="radio" name="'.$meta_box_field['id'].'" value="'.$value.'" value="'.$key.'" />';
					
					}

					$data .= '<label class="meta-label">'.$key.'</label>';

					$data .= '</div>';

					$row++;
					
				}

				$data .= $this->footer($meta_box_field);
				
			$data .= '</div>';

			return $data;

		}

		function upload($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);
		
				$data .= '<input type="text" class="meta-upload" id="field-'.$meta_box_field['id'].'" name="'.$meta_box_field['id'].'" value="'.$meta .'" />';

				$data .= '<input class="meta-upload-button button-primary" type="button" value="Upload" />';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function repeatable_text($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);

				$data .= '<div class="meta-repeatable-inner">';

					if(is_array($meta)) {

						foreach($meta as $key => $value) {

							$data .= '<div class="meta-repeatable-wrapper">';
					
								$data .= '<input type="text" class="meta-text" name="'.$meta_box_field['id'].'[]" value="'.$meta[$key] .'" />';

								$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

								$data .= $this->sortable_button($meta_box_field);

							$data .= '</div>';

						}

					} else {

						$data .= '<div class="meta-repeatable-wrapper">';
				
							$data .= '<input type="text" class="meta-text" name="'.$meta_box_field['id'].'[]" value="'.$meta .'" />';

							$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

							$data .= $this->sortable_button($meta_box_field);

						$data .= '</div>';

					}

				$data .= '</div>';

				$data .= '<input class="meta-add-button button-secondary" type="button" value="Add another" />';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function repeatable_textarea($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);

				$repeatable = null;

				if(isset($meta_box_field['rich_editor']) && $meta_box_field['rich_editor'] == true) {

					$data .= $this->load_editor($meta_box_field['id']);

					$repeatable = ' meta-rich-editor';

				}

				$data .= '<div class="meta-repeatable-inner">';

					if(is_array($meta)) {

						foreach($meta as $key => $value) {

							$data .= '<div class="meta-repeatable-wrapper">';
					
							$data .= '<textarea class="meta-textarea'.$repeatable.'" data-editor="'.$meta_box_field['id'].'" name="'.$meta_box_field['id'].'[]" id="field-'.$meta_box_field['id'].'">'.$meta[$key].'</textarea>';

								$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

								$data .= $this->sortable_button($meta_box_field);

							$data .= '</div>';

						}

					} else {

						$data .= '<div class="meta-repeatable-wrapper">';
				
							$data .= '<textarea class="meta-textarea'.$repeatable.'" data-editor="'.$meta_box_field['id'].'" name="'.$meta_box_field['id'].'[]" id="field-'.$meta_box_field['id'].'">'.$meta.'</textarea>';

							$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

							$data .= $this->sortable_button($meta_box_field);

						$data .= '</div>';

					}

				$data .= '</div>';

				$data .= '<input class="meta-add-button button-secondary" type="button" value="Add another" />';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

			return $data;

		}

		function repeatable_upload($meta_box_field, $val) {

			$data .= '<div class="'.$this->classes($meta_box_field).'" id="'.$this->id($meta_box_field).'">';

				$data .= $this->header($meta_box_field);

				$data .= '<div class="meta-repeatable-inner">';

					if(is_array($meta)) {

						foreach($meta as $key => $value) {

							$data .= '<div class="meta-repeatable-wrapper">';
					
								$data .= '<input type="text" class="meta-upload" name="'.$meta_box_field['id'].'[]" value="'.$meta[$key] .'" />';

								$data .= '<input class="meta-upload-button button-primary" type="button" value="Upload" />';

								$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

								$data .= $this->sortable_button($meta_box_field);

							$data .= '</div>';

						}

					} else {

						$data .= '<div class="meta-repeatable-wrapper">';
				
							$data .= '<input type="text" class="meta-upload" name="'.$meta_box_field['id'].'[]" value="'.$meta .'" />';

							$data .= '<input class="meta-upload-button button-primary" type="button" value="Upload" />';

							$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

							$data .= $this->sortable_button($meta_box_field);

						$data .= '</div>';

					}

				$data .= '</div>';

				$data .= '<input class="meta-add-button button-secondary" type="button" value="Add another" />';

				$data .= $this->footer($meta_box_field);

			$data .= '</div>';

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

		// prints sortable button where needed
		function sortable_button($field) {

			if(isset($field['sortable']) && $field['sortable'] == true) {

				return '<span class="meta-sortable-button button-secondary">Drag to re-order</span>';

			}

		}

		// adds classes to wrapping element
		function classes($field) {

			$classes[] = 'meta-wrapper';

			$classes[] = 'meta-'.$field['type'].'-field-wrapper';

			if(isset($field['sortable']) && $field['sortable'] == true) {

				$classes[] = 'meta-sortable';

			}

			$classes = implode(' ', $classes);

			return $classes;

		}

		// adds ID to wrapping element
		function id($field) {

			return 'meta-wrapper-'.$field['id'];

		}

		// prints header for metabox element
		function header($field) {

			$data .= '<h4 class="meta-title">'.stripslashes($field['name']).'</h4>';

			return $data;

		}

		function footer($field) {

			$data .= '<span class="meta-description description">'.stripslashes($field['desc']).'</span>';

			return $data;

		}
		
	}

}