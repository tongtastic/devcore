<?php

namespace core;

class Meta {

	var $meta;

	function __construct() {

		$this->meta = array();

	}
	
	function init($meta) {

		$this->meta = $meta;
			
		add_action('add_meta_boxes', array($this, 'add_new_meta_box'));
		
		add_action('save_post', array($this, 'save_meta_fields'));
		
		add_action('wp_ajax_format_content', array($this, 'format_content'));
		
	}
	
	function add_new_meta_box() {

		$meta_boxes = $this->meta;
		
		foreach($meta_boxes as $meta_box) {
		
			foreach($meta_box['boxes'] as $box) {
			
				$post_type = $meta_box['post_type'];
				
				if(is_array($post_type)) {
				
					foreach($post_type as $type) {
						
						add_meta_box($box['id'].'_meta', $box['name'], array($this, 'show_meta_box'), $type, $box['position'], 'high', array('fields' => $box['fields'], 'box_id' => $box['id']));
						
					}
					
				} else {
			
					add_meta_box($box['id'].'_meta', $box['name'], array($this, 'show_meta_box'), $post_type, $box['position'], 'high', array('fields' => $box['fields'], 'box_id' => $box['id']));
				
				}
				
			}
			
		}

	}

	function show_meta_box($post, $box) {

		$data .= '<input type="hidden" name="'.$box['args']['box_id'].'_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

		$data .= '<table class="form-table">';

			$data .= '<tr><td>';
		
			$data .= $this->meta_fields($box['args']['fields'], $post);

			$data .= '</td></tr>';
		
		$data .= '</table>';
		
		echo $data;
		
	}

	function format_content() {

		$content = $_REQUEST['content'];

		$content = wpautop($content);

		$data['content'] = $content;

		$data['type'] = 'success';

		$response = json_encode($data);

		echo $response;

		die();

	}

	function load_editor($id, $hide = true, $content = null) {

		if($hide == true) {

			$data .= '<div class="editor-wrapper-bg" style="display:none;width:100%;height:100%;background:#fff;position:fixed;z-index:99998;left:0;top:0;" id="wrapper-editor-bg-'.$id.'"></div>';
								
			$data .= '<div class="editor-wrapper" style="display:none;width:70%;left:50%;margin-left:-35%;top:40px;position:fixed;z-index:99999;" id="wrapper-editor'.$id.'">';

				$data .= '<h2>Insert content</h2>';

		}

			$args = array(
				'textarea_name' => $id,
				'textarea_rows' => '20',
				'wpautop' => false
			);
							
			ob_start();
			
			wp_editor($content, 'editor'.$id, $args);

			$editor = ob_get_contents();

			ob_end_clean();

			$data .= $editor;

		if($hide == true) {

				$data .= '<br /><a class="button-primary insert-content" data-editor="'.$id.'" data-editorwrap="#wrapper-editor'.$id.'" data-bg="#wrapper-editor-bg-'.$id.'">Insert</a> <a class="button-secondary close-editor-window" data-editor="'.$id.'" data-editorwrap="#wrapper-editor'.$id.'" data-bg="#wrapper-editor-bg-'.$id.'">Cancel</a>';

			$data .= '</div>';

		}

		return $data;

	}

	function meta_fields($arr, $post) {

		$sortable_bar = '<span class="sort-bar" style="display:block;height:20px;border:solid 1px #ccc;background:#f0f0f0;padding:10px;margin:10px 0">Drag to re-order</span>';

		foreach ($arr as $meta_box_field) {

			$meta = get_post_meta($post->ID, $meta_box_field['id'], true);
						
			switch ($meta_box_field['type']) {

				case 'text' :

					$data .= '<div class="text-field-wrapper" id="wrapper-'.$meta_box_field['id'].'"">';

						$data .= '<h4>'.stripslashes($meta_box_field['name']).'</h4>';
	
						$data .= '<input type="text" name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'" value="'.$meta.'" />';

						$data .= '<p>'.stripslashes($meta_box_field['desc']).'</p>';

					$data .= '</div>';
	
				break;
	
				case 'textarea' :

					$data .= '<div class="textarea-field-wrapper" id="wrapper-'.$meta_box_field['id'].'"">';

						$data .= '<h4>'.stripslashes($meta_box_field['name']).'</h4>';

						if($meta_box_field['rich_editor'] == 0) {
		
							$data .= '<textarea name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'">'.$meta.'</textarea>';

						} else {

							$data .= $this->load_editor($meta_box_field['id'], false, $meta);

						}

						$data .= '<p>'.stripslashes($meta_box_field['desc']).'</p>';

					$data .= '</div>';
			
				break;
					
				case 'checkbox':

					$data .= '<div class="checkbox-field-wrapper" id="wrapper-'.$meta_box_field['id'].'"">';

						$data .= '<h4>'.stripslashes($meta_box_field['name']).'</h4>';
				
						$data .= '<input type="checkbox" name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'"';

						if($meta == 'on') {
						
							$data .= ' checked="checked"';
							
						}

						$data .= ' />';
						
						$data .= '<p>'.stripslashes($meta_box_field['desc']).'</p>';

					$data .= '</div>';
					
				break;
				
				case 'select':

					$data .= '<div class="select-field-wrapper" id="wrapper-'.$meta_box_field['id'].'"">';

						$data .= '<h4>'.stripslashes($meta_box_field['name']).'</h4>';
									
						$data .= '<select name="'.$meta_box_field['id'].'" id="field-'.$meta_box_field['id'].'">';
						
						$data .= '<option value="" selected="selected">Please select an option</option>';
						
						foreach ($meta_box_field['options'] as $key => $value) {
						
							if($meta == $value) {
							
								$data .= '<option value="'.$value.'" selected="selected">'.$key.'</option>';
								
							} else {
						
								$data .= '<option value="'.$value.'">'.$key.'</option>';
							
							}
							
						}
						
						$data .= '</select>';

						$data .= '<p>'.stripslashes($meta_box_field['desc']).'</p>';

					$data .= '</div>';
					
				break;
					
				case 'upload' :

					$data .= '<div class="upload-field-wrapper" id="wrapper-'.$meta_box_field['id'].'">';

						$data .= '<h4>'.stripslashes($meta_box_field['name']).'</h4>';
				
						$data .= '<input type="text" class="upload_field" id="field-'.$meta_box_field['id'].'" name="'.$meta_box_field['id'].'" value="'.$meta .'" />';

						$data .= '<input class="upload_button button-primary" type="button" value="Upload" />';

						$data .= '<p>'.stripslashes($meta_box_field['desc']).'</p>';

						$data .= $this->upload_js($meta_box_field['id']);

					$data .= '</div>';
					
				break;

				case 'repeatable-upload' :

					$data .= '<div class="repeatable-upload-field-wrapper" id="wrapper-'.$meta_box_field['id'].'">';

						$data .= '<h4>'.stripslashes($meta_box_field['name']).'</h4>';

						if(is_array($meta)) {

							foreach($meta as $key => $value) {

								$data .= '<div class="repeatable-wrapper">';
						
									$data .= '<input type="text" class="upload_field" name="'.$meta_box_field['id'].'[]" value="'.$meta[$key] .'" />';

									$data .= '<input class="upload_button button-primary" type="button" value="Upload" />';

									$data .= '<input class="remove_button button-secondary" type="button" value="Remove" />';

								$data .= '</div>';

							}

						} else {

							$data .= '<div class="repeatable-wrapper">';
					
								$data .= '<input type="text" class="upload_field" name="'.$meta_box_field['id'].'[]" value="'.$meta .'" />';

								$data .= '<input class="upload_button button-primary" type="button" value="Upload" />';

								$data .= '<input class="remove_button button-secondary" type="button" value="Remove" />';

							$data .= '</div>';

						}

						$data .= '<input class="add_button button-secondary" type="button" value="Add another" />';

						$data .= '<p>'.stripslashes($meta_box_field['desc']).'</p>';

						$data .= $this->upload_js($meta_box_field['id']);

						$data .= $this->repeatable_js($meta_box_field['id']);

					$data .= '</div>';
					
				break;

			}

		}
		
		return $data;

	}
	
	function save_meta_fields($post_id) {

		global $post;
		
		$meta_boxes = $this->meta;
				
		foreach($meta_boxes as $meta_box) {
			
			foreach($meta_box['boxes'] as $box) {
	
				if (!isset( $_POST[$box['id'].'_meta_box_nonce'])||!wp_verify_nonce($_POST[$box['id'].'_meta_box_nonce'], basename(__FILE__))) {
		
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
						
				foreach ($box['fields'] as $meta_box_field) {
		
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

	function upload_js($id) {

		$data .= "

		<script type='text/javascript'>

		jQuery(document).ready(function() {	
                	
			if(jQuery('#wrapper-".$id." .upload_field').length > 0 ) {
			
				window.formfield = '';

				jQuery('body').on('click', '#wrapper-".$id." .upload_button', function() {
				
					window.formfield = jQuery('#wrapper-".$id." .upload_field',jQuery(this).parent());
					
					tb_show('', 'media-upload.php?type=file&TB_iframe=true');
					
					return false;
					
				});

				window.original_send_to_editor = window.send_to_editor;
					
				window.send_to_editor = function(html) {
				
					if (window.formfield) {
					
						imgurl = jQuery('a','<div>'+html+'</div>').attr('href');
						
						window.formfield.val(imgurl);
						
						tb_remove();
						
					} else {
					
						window.original_send_to_editor(html);
						
					}
					
					window.formfield = '';
					
					window.imagefield = false;
					
				}

			}

		});

		</script>

		";

		return $data;

	}

	function repeatable_js($id) {

		$data .= "

		<script type='text/javascript'>

		jQuery(document).ready(function() {

			jQuery('#wrapper-".$id." .add_button').on('click', function() {
			
				var field = jQuery('#wrapper-".$id."').find('div.repeatable-wrapper:last').clone(true);

				jQuery('input[type=text]', field).val('');

				jQuery('textarea', field).text('');

				var fieldLocation = jQuery('#wrapper-".$id."').find('div.repeatable-wrapper:last');
				
				field.insertAfter(fieldLocation, jQuery('#wrapper-".$id."'));
				
				return false;

			});

			jQuery('#wrapper-".$id." .remove_button').on('click', function() {
		
				var field = jQuery(this).parent();
				
				field.remove();
				
				return false;
			
			});

		});

		</script>

		";

		return $data;

	}
	
}