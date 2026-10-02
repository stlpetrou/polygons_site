<?php
/**
 * Plugin Name: Polygons — Performance
 * Description: Strips WordPress front-end bloat the site doesn't use.
 */

defined( 'ABSPATH' ) || exit;

// Emoji scripts & styles.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'emoji_svg_url', '__return_false' );

// oEmbed discovery / host JS, RSD, WLW, shortlink, generator, REST link header.
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
add_filter( 'the_generator', '__return_empty_string' );

// Polylang: language comes from the URL only (/en/) — no cookie, so pages stay cacheable (nginx/Cloudflare).
if ( ! defined( 'PLL_COOKIE' ) ) {
	define( 'PLL_COOKIE', false );
}
// …so front-end AJAX (JetSmartFilters, load more) gets its language from the page that sent it:
// a request from /en/… is answered in English. Runs before Polylang reads `lang`.
if ( ! isset( $_REQUEST['lang'] ) && ! empty( $_SERVER['HTTP_REFERER'] ) && false !== strpos( $_SERVER['SCRIPT_NAME'] ?? '', 'admin-ajax.php' ) ) {
	$polygons_ref = (string) wp_parse_url( $_SERVER['HTTP_REFERER'], PHP_URL_PATH );
	if ( preg_match( '#^/en(/|$)#', $polygons_ref ) && ! preg_match( '#^/wp-admin#', $polygons_ref ) ) {
		$_REQUEST['lang'] = 'en';
		$_POST['lang']    = 'en';
	}
}

// XML-RPC is not used.
add_filter( 'xmlrpc_enabled', '__return_false' );

add_action( 'wp_enqueue_scripts', function () {
	if ( is_admin() || ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
		return;
	}
	// Block-editor CSS — pages are built with Elementor.
	foreach ( array( 'wp-block-library', 'wp-block-library-theme', 'classic-theme-styles', 'global-styles' ) as $h ) {
		wp_dequeue_style( $h );
	}
	wp_dequeue_script( 'wp-embed' );

	// JetFormBuilder enqueues every field module's CSS (plus the WP editor) site-wide.
	// Keep only what our form uses, and only on pages that contain a form.
	$has_form = is_singular() && false !== strpos( (string) get_post_meta( get_queried_object_id(), '_elementor_data', true ), 'jet-form-builder-form' );
	foreach ( wp_styles()->queue as $handle ) {
		if ( 0 !== strpos( $handle, 'jet-fb-' ) && 'jet-form-builder-frontend' !== $handle ) {
			continue;
		}
		// On form pages keep everything except modules we never use.
		if ( $has_form && ! in_array( $handle, array( 'jet-fb-wysiwyg', 'jet-fb-advanced-choices', 'jet-fb-switcher', 'jet-fb-multi-gateway' ), true ) ) {
			continue;
		}
		wp_dequeue_style( $handle );
	}
	if ( ! is_user_logged_in() ) {
		wp_dequeue_style( 'dashicons' );
	}
	wp_dequeue_style( 'editor-buttons' );
}, 100 );

// Stylesheets that are either empty or re-enqueued late (the form renders core/columns
// blocks, which our theme styles) — drop them at output time.
add_filter( 'style_loader_tag', function ( $tag, $handle ) {
	if ( is_admin() || ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
		return $tag;
	}
	$drop = array( 'wp-block-library', 'jet-theme-core-frontend-styles' );
	if ( ! polygons_site_uses_carousels() ) {
		// JetEngine's listing grid declares Swiper for its (unused) carousel mode.
		$drop = array_merge( $drop, array( 'swiper', 'e-swiper' ) );
	}
	return in_array( $handle, $drop, true ) ? '' : $tag;
}, 10, 2 );

/**
 * Does any Elementor page/template/listing use a carousel? (Cached; cleared whenever
 * something is saved, so adding a carousel in Elementor brings Swiper back automatically.)
 */
function polygons_site_uses_carousels() {
	$uses = get_transient( 'polygons_uses_carousels' );
	if ( false === $uses ) {
		global $wpdb;
		$uses = (int) (bool) $wpdb->get_var( "SELECT 1 FROM {$wpdb->postmeta} WHERE meta_key = '_elementor_data' AND ( meta_value LIKE '%\"carousel_enabled\":\"yes\"%' OR meta_value LIKE '%carousel\"%' OR meta_value LIKE '%\"widgetType\":\"image-carousel%' ) LIMIT 1" );
		set_transient( 'polygons_uses_carousels', $uses, DAY_IN_SECONDS );
	}
	return (bool) $uses;
}
add_action( 'save_post', function () {
	delete_transient( 'polygons_uses_carousels' );
} );

// On JetThemeCore template views (blog, single post/project) Elementor prints the Heading
// widget CSS mid-page → headings jump when it arrives. Load it in <head> there only
// (on normal Elementor pages it is already handled, and an extra request slows LCP).
add_action( 'wp_enqueue_scripts', function () {
	if ( ! is_admin() && ( is_home() || is_archive() || is_singular( array( 'post', 'projects' ) ) ) && wp_style_is( 'widget-heading', 'registered' ) ) {
		wp_enqueue_style( 'widget-heading' );
	}
}, 20 );

// No global-styles SVG filters / inline CSS from theme.json.
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

// jQuery Migrate is not needed on the front end.
add_action( 'wp_default_scripts', function ( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		$scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
	}
} );

// Heartbeat only where it's useful.
add_action( 'init', function () {
	if ( ! is_admin() ) {
		wp_deregister_script( 'heartbeat' );
	}
}, 1 );
add_filter( 'heartbeat_settings', function ( $s ) {
	$s['interval'] = 60;
	return $s;
} );

// Keep revisions in check.
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
	define( 'WP_POST_REVISIONS', 10 );
}

// jQuery (needed by JetBlocks/JetEngine) doesn't need to block rendering: print it in the footer.
add_action( 'wp_enqueue_scripts', function () {
	if ( is_admin() || ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
		return;
	}
	foreach ( array( 'jquery', 'jquery-core' ) as $h ) {
		wp_scripts()->add_data( $h, 'group', 1 );
	}
}, 1 );
