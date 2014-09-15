<!DOCTYPE html>
	<!--[if lt IE 7]><html class="lt-ie7" <?php language_attributes(); ?>><![endif]-->
	<!--[if IE 7]><html class="ie7" <?php language_attributes(); ?>><![endif]-->
	<!--[if IE 8]><html class="ie8" <?php language_attributes(); ?>><![endif]-->
	<!--[if IE 9]><html class="ie9" <?php language_attributes(); ?>><![endif]-->
	<!--[if gt IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php if (is_search()) { ?>
		<meta name="robots" content="noindex, nofollow" />
		<?php } ?>
		<title><?php wp_title(''); ?></title>
		<?php wp_head(); ?>
		<!-- IE Fix for HTML5 Tags -->
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<script src="<?php bloginfo('template_directory'); ?>/assets/js/respond.js"></script>
		<![endif]-->
	</head>
	<body <?php body_class(); ?>>