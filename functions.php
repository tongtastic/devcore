<?php
include('core/core.class.php');
include('core/meta.class.php');

$core = new core\Core;

$core->init();

$args = array(
	array(
		'post_type' => 'page',
		'boxes' => array(
			array(
				'name' => 'Course info',
				'id' => 'course_info',
				'position' => 'normal',
				'fields' => array(
					array(
						'name' => 'Text',
						'desc' => 'Test text box',
						'id' => 'text',
						'class' => 'text',
						'type' => 'text',
					),
					array(
						'name' => 'Text area',
						'desc' => 'Test text area',
						'id' => 'textarea',
						'class' => 'textarea',
						'type' => 'textarea',
						'rich_editor' => 0
					),
					array(
						'name' => 'Text area RTE',
						'desc' => 'Test text area RTE',
						'id' => 'textarearte',
						'class' => 'textarearte',
						'type' => 'textarea',
						'rich_editor' => 1
					),
					array(
						'name' => 'Select',
						'desc' => 'Test select box',
						'id' => 'select',
						'class' => 'select',
						'type' => 'select',
						'options' => array(
							'Test 1' => 'test1',
							'Test 2' => 'test2',
							'Test 3' => 'test3',
						)
					),
					array(
						'name' => 'Upload',
						'desc' => 'Test upload box',
						'id' => 'upload',
						'class' => 'upload',
						'type' => 'upload',
					)
				)
			)
		)
	)
);

$meta = new core\Meta;

$meta->init($args);