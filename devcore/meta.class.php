<?php

namespace devcore;

if(!class_exists('Meta')) {

	class Meta {

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

				if($val == 'on') {
				
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
				
					if($val == $value) {
					
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
				
					if(($val == $value) || (!$val && $row == 1)) {
					
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

					if(is_array($val)) {

						foreach($val as $key => $value) {

							$data .= '<div class="meta-repeatable-wrapper">';
					
								$data .= '<input type="text" class="meta-text" name="'.$meta_box_field['id'].'[]" value="'.$val[$key] .'" />';

								$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

								$data .= $this->sortable_button($meta_box_field);

							$data .= '</div>';

						}

					} else {

						$data .= '<div class="meta-repeatable-wrapper">';
				
							$data .= '<input type="text" class="meta-text" name="'.$meta_box_field['id'].'[]" value="'.$val .'" />';

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

					if(is_array($val)) {

						foreach($val as $key => $value) {

							$data .= '<div class="meta-repeatable-wrapper">';
					
							$data .= '<textarea class="meta-textarea'.$repeatable.'" data-editor="'.$meta_box_field['id'].'" name="'.$meta_box_field['id'].'[]" id="field-'.$meta_box_field['id'].'">'.$val[$key].'</textarea>';

								$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

								$data .= $this->sortable_button($meta_box_field);

							$data .= '</div>';

						}

					} else {

						$data .= '<div class="meta-repeatable-wrapper">';
				
							$data .= '<textarea class="meta-textarea'.$repeatable.'" data-editor="'.$meta_box_field['id'].'" name="'.$meta_box_field['id'].'[]" id="field-'.$meta_box_field['id'].'">'.$val.'</textarea>';

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

					if(is_array($val)) {

						foreach($val as $key => $value) {

							$data .= '<div class="meta-repeatable-wrapper">';
					
								$data .= '<input type="text" class="meta-upload" name="'.$meta_box_field['id'].'[]" value="'.$val[$key] .'" />';

								$data .= '<input class="meta-upload-button button-primary" type="button" value="Upload" />';

								$data .= '<input class="meta-remove-button button-secondary" type="button" value="Remove" />';

								$data .= $this->sortable_button($meta_box_field);

							$data .= '</div>';

						}

					} else {

						$data .= '<div class="meta-repeatable-wrapper">';
				
							$data .= '<input type="text" class="meta-upload" name="'.$meta_box_field['id'].'[]" value="'.$val .'" />';

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