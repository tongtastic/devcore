<?php

namespace core;

class VisualComposer {

	function init($args) {

		if(function_exists('vc_set_as_theme')) {

			$this->map_folder($args['template_folder']);

			if(isset($args['remove_elements'])) {

				$this->remove_elements($args['remove_elements']);

			}
	
			add_filter('vc_shortcodes_css_class', array($this, 'custom_classes'), 10, 2);

			add_action('wp_head', array($this, 'fix_container_classes'));

			global $Vc_Base;

			remove_action('wp_head', array($Vc_Base, 'addMetaData'));

		} else {

			add_action('admin_notices', array($this, 'install_nag'));

		}
				
	}

	//removes unused items from visual composers element library
	function remove_elements($vc_remove) {

		foreach ($vc_remove as $vc_item) {

			if(function_exists('vc_remove_element')) {

				vc_remove_element($vc_item);

			}

		}
		
	}

	// adds attributes
	function add_attributes() {

		$vc_map_updates = array(
			array(
				'item' => '',
				'atts' => array()
			)
		);

		foreach($vc_map_updates as $vc_item) {

			if(function_exists('vc_map_update')) {

				vc_map_update($vc_item['item'], $vc_item['atts']);

			}

		}


	}

	//changes folder
	function map_folder($folder = null) {

		if(!$folder) {

			$folder = '/core/visual_composer/';

		} else {

			$folder = $folder;

		}

		$dir = get_stylesheet_directory() . $folder;

		if(function_exists('vc_set_template_dir')) {

			vc_set_template_dir($dir);

		}

	}

	//swaps out front end classes to be more like bootstrap
	function custom_classes($class_string, $tag) {

		if ($tag == 'vc_row' || $tag == 'vc_row_inner') {

			$class_string = str_replace('vc_row-fluid', 'row', $class_string);

		}

		if ($tag == 'vc_column' || $tag == 'vc_column_inner') {

			$class_string = preg_replace('/vc_span(\d{1,2})/', 'col-md-$1', $class_string);

		}

		$remove = array(
			'wpb_row',
			'wpb_column',
			'column_container'
		);

		$class_string = str_replace($remove, '', $class_string);

		return $class_string;

	}

	//fixes nested containers
	function fix_container_classes() {

		?>
		<style type="text/css">
		.container .container {width: 100%!important;padding-left: 0!important;padding-right: 0!important;}
		</style>
		<?php

	}

	//reminds to install Visual Composer and provides link
	function install_nag() {
		?>
		<div class="update-nag">
        	<p><?php _e('This theme kicks ass with <a target="_blank" href="http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=tongtastic">Visual Composer</a> installed, you can get that <a target="_blank" href="http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=tongtastic">here</a>, and you wont\' regret it ;)', 'core'); ?></p>
    	</div>
		<?php
	}

}