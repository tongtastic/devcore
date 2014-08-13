DevCore
=======

Very basic Wordpress parent theme just to get you started.

Generates user meta fields, custom post types, custom taxonomies, custom post type meta boxes and custom taxonomy metaboxes.

Also Visual Composer ready, which you can buy [here](http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=tongtastic).

Meta boxes:
===========

Text

Textarea

WYSIWYG

Radio group

Select

Checkbox

Upload

Date picker

Color picker

Repeatable metaboxes:
=====================

Text

Textarea

WYSIWYG

(Repeatable fields are so far only supported by custom post types)

Simple to setup:
================

In functions.php of your child theme, instantiate the class and pass arguments in the following manner:

```

$devcore = new devcore\DevCore;

$args = array(
	'navs' => array(
		'primary' => 'Primary Nav',
		'secondary' => 'Secondary Nav'
	),
	'post_types' => array(
		array(
			'post_type' => 'customposttype',
			'args' => array(
				'labels' => array(
					'name' => __('Custom Post Type', 'devcore'),
					'singular_name' => __('Custom Post Type', 'devcore'),
					'add_new' => __('Add New Custom Post Type', 'devcore'),
					'add_new_item' => __('Add New Custom Post Type', 'devcore'),
					'edit_item' => __('Edit Custom Post Type', 'devcore'),
					'new_item' => __('New Custom Post Type', 'devcore'),
					'view_item' => __('View Custom Post Type', 'devcore'),
					'search_items' => __('Search Custom Post Types', 'devcore'),
					'not_found' => __('No Custom Post Types Found', 'devcore'),
					'not_found_in_trash'=> __('No Custom Post Types Found in Trash', 'devcore'),
					'parent_item_colon' => __('Custom Post Types', 'devcore'),
					'menu_name' => __('Custom Post Types', 'devcore')
				),
				'singular_label' => __('customposttype', 'devcore'),
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
				'customposttype'
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
					'type' => 'textarea'
				),
				array(
					'name' => 'Text area RTE',
					'desc' => 'Test text area RTE',
					'id' => 'textarearte',
					'type' => 'textarea',
					'rich_editor' => true
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
				),
				array(
					'name' => 'Repeatable textarea RTE',
					'desc' => 'Test repeatable textarea RTE',
					'id' => 'repeatabletextarearte',
					'type' => 'repeatable-textarea',
					'sortable' => true,
					'rich_editor' => true
				)
			)
		)
	),
	'taxonomies' => array(
		array(
			'taxonomy' => 'customposttypecategory',
			'post_type' => 'customposttype',
			'args' => array(
				'labels' => array(
					'name' => __('Custom Post Type Category', 'devcore'),
					'singular_name' => __('Custom Post Type Category', 'devcore'),
					'menu_name' => __('Custom Post Type Categories', 'devcore')
				),
				'hierarchical' => true,
				'public' => true,
				'show_ui' => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_tagcloud' => false,
				'rewrite' => array(
					'slug' => 'custom-post-type-category',
					'hierarchical' => true,
					'with_front' => true
				)
			)
		)
	),
	'taxonomy_metaboxes' => array(
		array(
			'taxonomy' => 'customposttypecategory',
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
					'type' => 'textarea'
				),
				array(
					'name' => 'Text area RTE',
					'desc' => 'Test text area RTE',
					'id' => 'textarearte',
					'type' => 'textarea',
					'rich_editor' => true
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
				)
			)
		)
	),
	'user_metaboxes' => array(
		array(
			'level' => 'administrator',
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
					'type' => 'textarea'
				),
				array(
					'name' => 'Text area RTE',
					'desc' => 'Test text area RTE',
					'id' => 'textarearte',
					'type' => 'textarea',
					'rich_editor' => true
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

$devcore->init($args);

```
