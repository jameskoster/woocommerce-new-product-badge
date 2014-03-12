=== WooCommerce New Product Badge ===
Contributors: jameskoster, CoenJacobs
Tags: woocommerce, ecommerce, new, new product
Requires at least: 3.5
Tested up to: 3.8.1
Stable tag: 0.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Displays a 'new' badge on WooCommerce products published in the last x days.

== Description ==

A very simple plugin that displays a 'new' badge on products that were published in the last x days. X is defined on the catalog tab of the WooCommerce settings screen.

Please feel free to contribute on <a href="https://github.com/jameskoster/woocommerce-new-product-badge">github</a>.

== Installation ==

1. Upload `woocommerce-new-product-badge` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Define how 'new' products must be (in days) to receive the 'new' badge on the catalog tab of the WooCommerce settings screen.
3. Done!

== Frequently Asked Questions ==

= I want to style the badge myself, how do I remove the default styles =

There are only a couple of styles applied to the badge. Although not best practise it's probably safe to just overwrite these with your own css. However, if you want to do it properly you can either dequeue the css:

`
add_action( 'wp_enqueue_scripts', 'remove_new_badge_styles', 30 );
function remove_new_badge_styles() {
	wp_dequeue_style( 'nb-styles' );
}
`

Or use the filter:

`
add_filter( 'woocommerce_new_badge_enqueue_styles', 'remove_new_badge_styles' );
function remove_new_badge_styles() {
	return false;
}
`


== Screenshots ==

1. The new badge.

== Changelog ==

= 0.3.1 - 12/03/2014 =
* Added Hebrew translation. (Props roidayan).

= 0.3.0 - 04/02/2013 =
* Added localization compatibility with WPML

= 0.2 - 23/05/2013 =
* Introduced filter to disable style
* Minor translation fix and added Dutch translation
* Added en_GB .po/.mo
* Stripped object pass by reference

= 0.1 =
Initial release.