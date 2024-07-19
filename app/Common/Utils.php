<?php
/**
 * Utils
 *
 * @package Adminscript
 */

namespace Nilambar\Adminscript\Common;

/**
 * Utils class.
 *
 * @since 1.0.0
 */
class Utils {

	/**
	 * Get example formats.
	 *
	 * @since 1.0.0
	 *
	 * @return array Example formats.
	 */
	public static function get_example_formats() {
		$output = [
			[
				'format' => 'd F Y',
				'label'  => '१८ जेठ २०७७',
			],
			[
				'format' => 'F d, Y',
				'label'  => 'जेठ १८, २०७७',
			],
			[
				'format' => 'Y F d',
				'label'  => '२०७७ जेठ १८',
			],
			[
				'format' => 'l, d F Y',
				'label'  => 'आइतबार, १८ जेठ २०७७',
			],
			[
				'format' => 'd.m.y',
				'label'  => '१८.०२.७७',
			],
			[
				'format' => 'Y.m.d',
				'label'  => '२०७७.०२.१८',
			],
			[
				'format' => 'D, d F',
				'label'  => 'आइत, १८ जेठ',
			],
			[
				'format' => 'Y F d, l',
				'label'  => '२०७७ जेठ १८, आइतबार',
			],
		];

		return $output;
	}

	/**
	 * Return blog posts.
	 *
	 * @since 1.0.0
	 *
	 * @return array Posts array.
	 */
	public static function get_blog_feed_items() {
		$output = [];

		$rss = fetch_feed( 'https://www.nilambar.net/category/wordpress/feed' );

		$maxitems = 0;

		$rss_items = [];

		if ( ! is_wp_error( $rss ) ) {
			$maxitems  = $rss->get_item_quantity( 5 );
			$rss_items = $rss->get_items( 0, $maxitems );
		}

		if ( ! empty( $rss_items ) ) {
			foreach ( $rss_items as $item ) {
				$feed_item = [];

				$feed_item['title'] = $item->get_title();
				$feed_item['url']   = $item->get_permalink();

				$output[] = $feed_item;
			}
		}

		return $output;
	}
}
