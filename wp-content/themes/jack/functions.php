<?php
use WordpressLib\Theme\Assets;

require_once ABSPATH.'/vendor/autoload.php';

add_action('wp_enqueue_scripts', function() {

	wp_enqueue_style( 'twentynineteen-parent-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get( 'Version' ) );

	$assets = new Assets(get_stylesheet_directory_uri(), __DIR__, 'assets/src');

	$assets->dir('base', 'css');
	$assets->dir('header', 'css');
	$assets->dir('content', 'css');
	
	$assets->dir('base', 'js');
	$assets->dir('content', 'js');

	$assets->js('main');

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

	/* replace cover dropdown with images */
	add_filter('woocommerce_dropdown_variation_attribute_options_html', function($html, $args) {

		extract($args, EXTR_SKIP);

		if ($attribute != 'pa_cover') return $html;

		preg_match_all('/value="([^\s]+?)"/', $html, $matches);

		$doc = new DOMDocument('1.0');
		$doc->loadHTML("<html><body>$html</body></html>");
		$select = $doc
			->getElementsByTagName('select')
			->item(0);

		$select->setAttribute('class', $select->getAttribute('class') . ' screen-reader-text');
		$html = $select->ownerDocument->saveHTML($select);

		$variations = array_map(function($childID) {
			return new WC_Product_Variation($childID);
		}, $product->get_visible_children());

		$indexes = array_map(function($v) use ($matches) {
			return array_search($v->get_variation_attributes()['attribute_pa_cover'], $matches[1]);
		}, $variations);
		array_multisort($indexes, $variations);

		$html .= implode('', array_map(function($v) { return $v->get_image(); }, $variations));

		return '<div class="cover-images">' . $html . '</div>';

	}, 10, 2);

	add_filter('woocommerce_attribute_label', function($label, $name, $product) {
		if ($name == 'cover') $label = "<span>Select</span>$label";
		return $label;
	}, 10, 3);

}

