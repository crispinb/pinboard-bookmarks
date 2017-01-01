<?php
/**
 * Prevent direct access to this file.
 *
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) {
   exit( 'No script kiddies please!' );
}

function pinboard_bookmarks_get_tags_for_url( $tags ) {
    $tags_for_url = '';

    // Replace all the occurrences of comma and space in any mix and quantity with a single space.
    $tags = trim( preg_replace( '([\s,]+)', ' ', $tags ) );

    // Pinboard accepts maximum 3 tags for a query
    if ( 3 < count( $tags ) ) {
        $tags_slice = array_slice( $tags_slice, 0, 3 );
        $tags = implode( ' ', $tags_slice );
    }

    // If we have a space separated list of tags (i.e. if we have multiple tags)
    if ( strpos( $tags, ' ' ) ) {
        $tags = explode( ' ', $tags );
        foreach ( $tags as $tag ) {
            $tags_for_url .= '/t:' . $tag;
        }
    // Else we have a single tag
    } else {
        $tags_for_url = '/t:' . $tags;
    }
    return $tags_for_url;
}

/**
 * Check for the cache lifetime in the database and set it to 1800 seconds minimum.
 *
 * @since 1.0
 * @param int $seconds The number of seconds of feed lifetime
 * @return int
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_feed_cache_transient_lifetime Codex Documentation
 */
function pinboard_bookmarks_cache_handler( $seconds ) {
	$options = (array) get_option( 'widget_pinboard-bookmarks-widget' );
	$seconds = isset( $options['time'] ) ? $options['time'] : 1800;
	return $seconds;
}

/**
 * Return an HTML comment with the version of the plugin.
 *
 * @since 1.0
 * @return string $output The HTML comment.
 */
function pinboard_bookmarks_get_generated_by() {
	$output = "\n" . '<!-- Generated by Pinboard Bookmarks ' . PINBOARD_BOOKMARKS_PLUGIN_VERSION . ' -->' . "\n";
	return $output;
}

/**
 * Load the CSS file.
 * The file will be loaded only in the widgets admin page.
 *
 * @since 1.00
 */
function pinboard_bookmarks_load_scripts( $hook ) {
 	if ( $hook != 'widgets.php' ) {
		return;
	}

	// Register and enqueue the CSS file
	wp_register_style( 'pinboard_bookmarks_style', plugins_url( 'pinboard-bookmarks-styles.css', __FILE__ ), array(), PINBOARD_BOOKMARKS_PLUGIN_VERSION, 'all' );
	wp_enqueue_style( 'pinboard_bookmarks_style' );
}

/**
 * Add links to plugins list line.
 *
 * @since 1.0
 */
function pinboard_bookmarks_add_links( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$rate_url = 'https://wordpress.org/support/plugin/' . basename( dirname( __FILE__ ) ) . '/reviews/#new-post';
		$links[] = '<a target="_blank" href="' . $rate_url . '" title="' . esc_attr__( 'Click here to rate and review this plugin on WordPress.org', 'pinboard-bookmarks' ) . '">' . esc_html__( 'Rate this plugin', 'pinboard-bookmarks' ) . '</a>';
	}
	return $links;
}
