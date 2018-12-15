<?php
use WordpressLib\Theme\Assets;

require_once ABSPATH.'/vendor/autoload.php';

add_action('wp_enqueue_scripts', function() {

	wp_enqueue_style( 'twentynineteen-parent-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );

	$assets = new Assets(get_stylesheet_directory_uri(), __DIR__, 'assets/src');
	$assets->css('base/overrides');
	$assets->css('header/header');
	$assets->css('header/nav');
	$assets->css('content/content');
	$assets->css('content/product-grid');
	$assets->css('content/product');
	
});

if (is_admin() == false) {

	add_filter('theme_mod_custom_logo', function($value) {
		return 1;
	});

	add_filter('get_custom_logo', function($html) {
		$end = '</a>';
		return str_replace($end, sprintf('<img src="%s" alt="%s">', get_stylesheet_directory_uri().'/assets/icons/logo.svg', get_bloginfo('name')).$end, $html);
	});

	add_filter('the_title', function($title) {
		$parts = explode(' &#8211; ', $title);
		if (count($parts) == 1) return $title;
		return sprintf('%s<span>%s</span>', $parts[0], implode('', array_slice($parts, 1)));
	});

}

