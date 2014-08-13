<?php

namespace devcore;

if(!class_exists('UserMeta')) {

	class UserMeta {

		var $meta;

		function __construct() {

			$this->meta = array();

		}

		function init($meta) {

			$this->meta = $meta;

			add_action('show_user_profile', array($this, 'show_user_fields'));

			add_action('edit_user_profile', array($this, 'show_user_fields'));

			add_action('personal_options_update', array($this, 'save_user_fields'));

			add_action('edit_user_profile_update', array($this, 'save_user_fields'));

		}

		function show_user_fields($user) {

			$meta_box_fields = $this->meta;

			$meta = new Meta;

			$data .= '<table class="form-table"><tr><th></th><td>';

			foreach($meta_box_fields['fields'] as $meta_box_field) {

				$val = esc_attr(get_the_author_meta($meta_box_field['id'], $user->ID));

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
					
				}

			}

			$data .= '</td></tr></table>';

			echo $data;

		}

		function save_user_fields($user_id) {

			$meta_box_fields = $this->meta;

			if(!current_user_can('edit_user', $user_id)) {

				return false;

			} else {

				foreach($meta_box_fields['fields'] as $meta_box_field) {

					update_usermeta($user_id, $meta_box_field['id'], $_POST[$meta_box_field['id']]);

				}

			}

		}

	}

}