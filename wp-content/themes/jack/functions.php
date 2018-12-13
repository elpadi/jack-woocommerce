<?php
use WordpressLib\Theme\Assets;

require_once ABSPATH.'/vendor/autoload.php';

add_action('wp_enqueue_scripts', function() {

	wp_enqueue_style( 'twentynineteen-parent-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );

	$assets = new Assets(get_stylesheet_directory_uri(), __DIR__, 'assets/src');
	$assets->css('base/overrides');
	$assets->css('areas/header');

});
