<?php
// include and initialise the core class
 
include('core/core.class.php');

include('core/meta.class.php');

include('core/visualcomposer.class.php');

$core = new core\Core;

$args = array(
	'post_types' => array(
		array(
			'post_type' => 'course',
			'args' => array(
				'labels' => array(
					'name' => _x('Courses', 'post type general name'),
					'singular_name' => _x('Course', 'post type singular name'),
					'add_new' => __('Add New Course', 'kic'),
					'add_new_item' => __('Add New Course', 'kic'),
					'edit_item' => __('Edit Course', 'kic'),
					'new_item' => __('New Course', 'kic'),
					'view_item' => __('View Course', 'kic'),
					'search_items' => __('Search Courses', 'kic'),
					'not_found' => __('No Courses Found', 'kic'),
					'not_found_in_trash'=> __('No Courses Found in Trash', 'kic'),
					'parent_item_colon' => __('courses', 'kic'),
					'menu_name' => __('Courses', 'kic')
				),
				'singular_label' => __('course'),
				'public' => true,
				'show_ui' => true,
				'publicly_queryable'=> true,
				'query_var'  => true,
				'has_archive' => true,
				'hierarchical' => false,
				'rewrite' => array(
					'with_front' => true
				),
				'supports' => array(
					'title',
					'editor'
				),
				'menu_position'  => 5
			)
		)
	),
	'metaboxes' => array(
		array(
			'post_type' => array(
				'page',
				'course'
			),
			'name' => 'Test metabox',
			'id' => 'test-metabox',
			'position' => 'normal',
			'fields' => array(
				array(
					'name' => 'Text',
					'desc' => 'Test text box',
					'id' => 'text',
					'type' => 'text',
				),
				array(
					'name' => 'Text area',
					'desc' => 'Test text area',
					'id' => 'textarea',
					'type' => 'textarea',
					'rich_editor' => 0
				),
				array(
					'name' => 'Text area RTE',
					'desc' => 'Test text area RTE',
					'id' => 'textarearte',
					'type' => 'textarea',
					'rich_editor' => 1
				),
				array(
					'name' => 'Radio',
					'desc' => 'Test radio group',
					'id' => 'radio',
					'type' => 'radio',
					'options' => array(
						'Test 1' => 'test1',
						'Test 2' => 'test2',
						'Test 3' => 'test3',
					)
				),
				array(
					'name' => 'Select',
					'desc' => 'Test select box',
					'id' => 'select',
					'type' => 'select',
					'options' => array(
						'Test 1' => 'test1',
						'Test 2' => 'test2',
						'Test 3' => 'test3',
					)
				),
				array(
					'name' => 'Checkbox',
					'desc' => 'Test checkbox',
					'id' => 'checkbox',
					'type' => 'checkbox'
				),
				array(
					'name' => 'Upload',
					'desc' => 'Test upload box',
					'id' => 'upload',
					'type' => 'upload',
				),
				array(
					'name' => 'Repeatable Upload',
					'desc' => 'Test repeatable upload box',
					'id' => 'repeatableupload',
					'type' => 'repeatable-upload',
					'sortable' => true
				),
				array(
					'name' => 'Date picker',
					'desc' => 'Test datepicker',
					'id' => 'datepicker',
					'type' => 'datepicker',
					'format' => 'dd-mm-yy'
				),
				array(
					'name' => 'Color picker',
					'desc' => 'Test colorpicker',
					'id' => 'colorpicker',
					'type' => 'colorpicker',
				),
				array(
					'name' => 'Repeatable text',
					'desc' => 'Test repeatable text',
					'id' => 'repeatabletext',
					'type' => 'repeatable-text',
					'sortable' => true
				),
				array(
					'name' => 'Repeatable textarea',
					'desc' => 'Test repeatable textarea',
					'id' => 'repeatabletextarea',
					'type' => 'repeatable-textarea',
					'sortable' => true
				)
			)
		)
	),
	'visualcomposer' => array(
		'template_folder' => 'vc',
		'remove_elements' => array(
			'vc_separator',
			'vc_text_separator',
			'vc_message',
			'vc_tweetmeme',
			'vc_facebook',
			'vc_googleplus',
			'vc_pinterest',
			'vc_toggle',
			'vc_single_image',
			'vc_gallery',
			'vc_images_carousel',
			'vc_tabs',
			'vc_tour',
			'vc_tab',
			'vc_accordion',
			'vc_accordion_tab',
			'vc_teaser_grid',
			'vc_posts_grid',
			'vc_carousel',
			'vc_posts_slider',
			'vc_widget_sidebar',
			'vc_button',
			'vc_button2',
			'vc_cta_button',
			'vc_cta_button2',
			'vc_flickr',
			'vc_progress_bar',
			'vc_pie',
			'vc_wp_search',
			'vc_wp_meta',
			'vc_wp_recentcomments',
			'vc_wp_calendar',
			'vc_wp_pages',
			'vc_wp_tagcloud',
			'vc_wp_custommenu',
			'vc_wp_text',
			'vc_wp_posts',
			'vc_wp_links',
			'vc_wp_categories',
			'vc_wp_archives',
			'vc_wp_rss',
			'vc_raw_js',
			'vc_video'
		)
	)
);

$core->init($args);