<?php
// include and initialise the core class
 
include('devcore/devcore.class.php');

include('devcore/metabox.class.php');

include('devcore/visualcomposer.class.php');

$devcore = new devcore\DevCore;

$args = array(
	'navs' => array(
		'primary' => 'Primary Nav',
		'secondary' => 'Secondary Nav'
	),
	'post_types' => array(
		array(
			'post_type' => 'course',
			'args' => array(
				'labels' => array(
					'name' => __('Courses', 'core'),
					'singular_name' => __('Course', 'core'),
					'add_new' => __('Add New Course', 'core'),
					'add_new_item' => __('Add New Course', 'core'),
					'edit_item' => __('Edit Course', 'core'),
					'new_item' => __('New Course', 'core'),
					'view_item' => __('View Course', 'core'),
					'search_items' => __('Search Courses', 'core'),
					'not_found' => __('No Courses Found', 'core'),
					'not_found_in_trash'=> __('No Courses Found in Trash', 'core'),
					'parent_item_colon' => __('courses', 'core'),
					'menu_name' => __('Courses', 'core')
				),
				'singular_label' => __('course', 'core'),
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
	'taxonomies' => array(
		array(
			'taxonomy' => 'coursecategory',
			'post_type' => 'course',
			'args' => array(
				'labels' => array(
					'name' => __('Course category', 'devcore'),
					'singular_name' => __('Course category', 'devcore'),
					'menu_name' => __('Course categories', 'devcore')
				),
				'hierarchical' => true,
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud' => false,
				'rewrite' => array(
					'slug' => 'courses',
					'hierarchical' => true,
					'with_front' => true
				)
			)
		)
	)
);

$devcore->init($args);