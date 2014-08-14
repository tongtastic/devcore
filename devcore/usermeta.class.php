<?php

namespace devcore;

if(!class_exists('UserMeta')) {

	class UserMeta {

		var $meta;

		var $base_fields;

		function __construct() {

			$this->meta = array();

			$this->base_fields = array(
				'text',
				'textarea',
				'upload',
				'checkbox',
				'radio',
				'colorpicker',
				'datepicker'
			);

		}

		function init($meta) {

			$this->meta = $meta;

			add_action('profile_update', array($this, 'show_user_fields'));

			add_action('show_user_profile', array($this, 'show_user_fields'));

			add_action('edit_user_profile', array($this, 'show_user_fields'));

			add_action('personal_options_update', array($this, 'save_user_fields'));

			add_action('edit_user_profile_update', array($this, 'save_user_fields'));

		}

		function show_user_fields($user = null) {

			if(!$user) {

				$user = wp_get_current_user();

			}

			$meta_box_fields = $this->meta;

			$base_fields = $this->base_fields;

			$meta = new Meta;

			$is_user_role = false;

			if(in_array($meta_box_fields['level'], $user->roles)) {

				$is_user_role = true;

			}

			if($is_user_role == true) {

				$data .= '<table class="form-table"><tr><th></th><td>';

				foreach($meta_box_fields['fields'] as $meta_box_field) {

					$val = esc_attr(get_the_author_meta($meta_box_field['id'], $user->ID));

					foreach($base_fields as $base_field) {

						if($meta_box_field['type'] == $base_field) {

							$data .= $meta->$base_field($meta_box_field, $val);

						}

					}

				}

				$data .= '</td></tr></table>';

				echo $data;

			}

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