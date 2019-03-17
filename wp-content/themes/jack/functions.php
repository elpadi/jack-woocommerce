<?php
use Functional as F;
use WordpressLib\Theme\Assets;

require_once dirname(WP_CONTENT_DIR).'/vendor/autoload.php';

add_action('wp_enqueue_scripts', function() {

	$dir = get_stylesheet_directory();
	$url = get_stylesheet_directory_uri();
	$path = 'assets/dist';
	$name = WP_DEBUG ? 'dev' : 'prod';

	wp_enqueue_script('theme-scripts', "$url/$path/$name.js", [], filemtime("$dir/$path/$name.js"));
	wp_enqueue_style('theme-styles', "$url/$path/$name.css", [], filemtime("$dir/$path/$name.css"));

	wp_dequeue_script('twentynineteen-priority-menu');

}, 100);

function coupon_to_insider_code($s) {
	$i = 'insider code';
	foreach (['coupon code','coupon'] as $w) {
		$s = str_replace(['A '.$w, 'a '.$w, ucfirst($w), $w], ['An '.$i, 'an '.$i, ucfirst($i), $i], $s);
	}
	return $s;
}

if (is_admin() == false) {

	add_filter('theme_mod_custom_logo', function($value) {
		return 1;
	});

	add_filter('get_custom_logo', function($html) {
		$end = '</a>';
		return str_replace($end, sprintf('<img src="%s" alt="%s">', get_stylesheet_directory_uri().'/assets/icons/logo.svg', get_bloginfo('name')).$end, $html);
	});

	add_filter('the_title', function($title, $id=NULL) {
		return str_replace(' &#8211; ', '<span> &#8211; </span>', $title);
	}, 10, 2);

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

	add_filter('woocommerce_coupon_message', function($msg, $msg_code, $coupon) {
		if (WP_DEBUG) {
			var_dump(__FILE__.":".__LINE__." - ".__METHOD__, $msg, $msg_code, $coupon);
			exit(0);
		}
		return __(coupon_to_insider_code($msg), 'jack');
	}, 10, 3);

	add_filter('woocommerce_coupon_error', function($err, $err_code, $coupon) {
		switch ($err_code) {
		case WC_Coupon::E_WC_COUPON_EXPIRED:
			return sprintf(__('The code %s has expired.', 'jack'), $coupon->get_code());
		case WC_Coupon::E_WC_COUPON_PLEASE_ENTER:
		case WC_Coupon::E_WC_COUPON_NOT_EXIST:
			$isChecked = TRUE;
				/*
			const E_WC_COUPON_INVALID_FILTERED               = 100;
			const E_WC_COUPON_INVALID_REMOVED                = 101;
			const E_WC_COUPON_NOT_YOURS_REMOVED              = 102;
			const E_WC_COUPON_ALREADY_APPLIED                = 103;
			const E_WC_COUPON_ALREADY_APPLIED_INDIV_USE_ONLY = 104;
			const E_WC_COUPON_USAGE_LIMIT_REACHED            = 106;
			const E_WC_COUPON_MIN_SPEND_LIMIT_NOT_MET        = 108;
			const E_WC_COUPON_NOT_APPLICABLE                 = 109;
			const E_WC_COUPON_NOT_VALID_SALE_ITEMS           = 110;
			const E_WC_COUPON_MAX_SPEND_LIMIT_MET            = 112;
			const E_WC_COUPON_EXCLUDED_PRODUCTS              = 113;
			const E_WC_COUPON_EXCLUDED_CATEGORIES            = 114;
			const WC_COUPON_SUCCESS                          = 200;
			const WC_COUPON_REMOVED                          = 201;
				 */
		}
		if (!$isChecked && WP_DEBUG) {
			var_dump(__FILE__.":".__LINE__." - ".__METHOD__, $err, $err_code, $coupon);
			exit(0);
		}
		return coupon_to_insider_code($err);
	}, 10, 3);

	add_filter('the_content', function($s) {
		return $s;
	}, 100);

	add_action('woocommerce_before_add_to_cart_form', function() {
		global $post, $product;
		if ($product && preg_match('/^Volume ([0-9]+) Issue ([0-9]+) - (.*)$/', $post->post_title, $matches)) {
			$id = intval($matches[1]) + intval($matches[2]);
			$slug = sanitize_html_class(sanitize_title_with_dashes($matches[3]));
			printf('<p><a href="https://thejackmag.com/issues/%d-%s/layouts" target="_blank" rel="nofollow">View Issue Content</a></p>', $id, $slug);
		}
	});
}

