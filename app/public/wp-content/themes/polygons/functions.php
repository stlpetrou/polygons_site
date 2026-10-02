<?php
/**
 * Polygons — Kava child theme.
 *
 * Header, footer and page bodies are built with Elementor + JetThemeCore, so the
 * parent theme's own CSS/JS/Google Fonts are not needed on the front end.
 */

defined( 'ABSPATH' ) || exit;

define( 'POLYGONS_URI', get_stylesheet_directory_uri() );
define( 'POLYGONS_DIR', get_stylesheet_directory() );

/**
 * Kava: keep only the modules we use.
 */
add_filter( 'kava-theme/allowed-modules', function () {
	return array( 'crocoblock' => array() );
} );

/**
 * Parent theme style is not loaded — the child stylesheet has no dependencies.
 */
add_filter( 'kava-theme/assets-depends/styles', '__return_empty_array' );
add_filter( 'kava-theme/assets-depends/script', '__return_empty_array' );

/**
 * Drop parent-theme assets that Elementor-built templates don't need.
 */
add_action( 'wp_enqueue_scripts', function () {
	foreach ( array( 'font-awesome', 'kava-theme-main-style', 'kava-theme-dynamic-style', 'cx-google-fonts-kava', 'kava-theme-style' ) as $handle ) {
		wp_dequeue_style( $handle );
	}
	wp_dequeue_script( 'kava-theme-script' );

	$css = POLYGONS_DIR . '/assets/css/polygons.css';
	wp_enqueue_style( 'polygons', POLYGONS_URI . '/assets/css/polygons.css', array(), filemtime( $css ) );

	$js = POLYGONS_DIR . '/assets/js/polygons.js';
	wp_enqueue_script( 'polygons', POLYGONS_URI . '/assets/js/polygons.js', array(), filemtime( $js ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
}, 9999 );

// Kava prints customizer CSS inline when the file cache is off.
add_action( 'wp', function () {
	if ( function_exists( 'kava_theme' ) && isset( kava_theme()->dynamic_css ) ) {
		remove_action( 'wp_head', array( kava_theme()->dynamic_css, 'print_inline_css' ), 99 );
		remove_action( 'wp_enqueue_scripts', array( kava_theme()->dynamic_css, 'add_inline_css' ), 99 );
	}
} );

/**
 * Preload the fonts used above the fold.
 */
add_action( 'wp_head', function () {
	foreach ( array( 'inter-latin', 'inter-greek', 'jura-latin' ) as $font ) {
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( POLYGONS_URI . '/assets/fonts/' . $font . '.woff2' ) );
	}
}, 1 );

/**
 * Brand colour for mobile browser UI.
 */
add_action( 'wp_head', function () {
	echo '<meta name="theme-color" content="#07070a">' . "\n";
}, 2 );

/**
 * SVG uploads for administrators only (logos, icons).
 */
add_filter( 'upload_mimes', function ( $mimes ) {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
} );

/**
 * <main> landmark around the page body (Elementor header-footer pages and
 * JetThemeCore body templates such as the project single).
 */
$polygons_open_main  = function () {
	echo '<main id="main" class="site-main">';
};
$polygons_close_main = function () {
	echo '</main>';
};
add_action( 'elementor/page_templates/header-footer/before_content', $polygons_open_main );
add_action( 'elementor/page_templates/header-footer/after_content', $polygons_close_main );
add_action( 'jet-theme-core/theme-builder/render/body-location/before', $polygons_open_main );
add_action( 'jet-theme-core/theme-builder/render/body-location/after', $polygons_close_main );

/**
 * Effects (#1 #2 #3 #4 #5 #8 #10 #11 #12 #13 #14) — site-wide, opt-in per element via fx-* classes.
 * The mesh (#1) script is loaded on demand by fx.js only where a .fx-mesh exists.
 */
add_action( 'wp_enqueue_scripts', function () {
	$v = function ( $rel ) {
		return filemtime( POLYGONS_DIR . $rel );
	};
	wp_enqueue_style( 'polygons-fx', POLYGONS_URI . '/assets/css/fx.css', array( 'polygons' ), $v( '/assets/css/fx.css' ) );
	wp_enqueue_script( 'polygons-fx', POLYGONS_URI . '/assets/js/fx.js', array(), $v( '/assets/js/fx.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	wp_add_inline_script( 'polygons-fx', 'window.polygonsFx=' . wp_json_encode( array( 'mesh' => POLYGONS_URI . '/assets/js/fx-mesh.js?ver=' . $v( '/assets/js/fx-mesh.js' ) ) ) . ';', 'before' );

	if ( polygons_is_fx_lab() ) {
		wp_enqueue_style( 'polygons-lab', POLYGONS_URI . '/assets/css/lab.css', array( 'polygons-fx' ), $v( '/assets/css/lab.css' ) );
		wp_enqueue_script( 'polygons-lab', POLYGONS_URI . '/assets/js/lab.js', array(), $v( '/assets/js/lab.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	}
}, 10000 );

/**
 * #13: give each project's featured image a stable view-transition name, so the card
 * image on listings morphs into the hero image on the project page.
 */
add_filter( 'wp_get_attachment_image_attributes', function ( $attr, $attachment ) {
	$post = get_post();
	if ( $post && 'projects' === $post->post_type && (int) get_post_thumbnail_id( $post ) === (int) $attachment->ID ) {
		$attr['style'] = trim( ( $attr['style'] ?? '' ) . ';view-transition-name:project-' . $post->ID, ';' );
	}
	return $attr;
}, 10, 2 );

/**
 * Effects Lab (/effects-lab/): noindex; demo of every effect incl. ones not used on the site.
 */
function polygons_is_fx_lab() {
	return is_page( 'effects-lab' );
}
add_filter( 'wp_robots', function ( $robots ) {
	if ( polygons_is_fx_lab() ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
	}
	return $robots;
} );
// #13 lab demo: "?vt=1" renders the detail state before first paint so the transition can morph into it.
add_action( 'wp_head', function () {
	if ( polygons_is_fx_lab() ) {
		echo "<script>if(new URLSearchParams(location.search).has('vt'))document.documentElement.classList.add('fx-vt-detail');</script>\n";
	}
}, 0 );

/**
 * [pg_year] — current year for the footer.
 */
add_shortcode( 'pg_year', function () {
	return esc_html( wp_date( 'Y' ) );
} );

/** True on English (/en/) views. */
function polygons_is_en() {
	return function_exists( 'pll_current_language' ) && 'en' === pll_current_language();
}

/**
 * Blog helpers used in the JetThemeCore blog templates (Elementor text widgets):
 * [pg_archive_title] [pg_blog_cats] [pg_pagination] [pg_post_meta]
 */
add_shortcode( 'pg_archive_title', function () {
	return is_category() || is_tag() ? esc_html( single_term_title( '', false ) ) : esc_html( get_the_title( (int) get_option( 'page_for_posts' ) ) );
} );

// Category pills («Όλα» + categories that have posts); current one marked for screen readers.
add_shortcode( 'pg_blog_cats', function () {
	$current = is_category() ? get_queried_object_id() : 0;
	$item    = function ( $url, $label, $active ) {
		return sprintf( '<li><a href="%s"%s>%s</a></li>', esc_url( $url ), $active ? ' aria-current="page"' : '', esc_html( $label ) );
	};
	$en   = polygons_is_en();
	$html = $item( get_permalink( (int) get_option( 'page_for_posts' ) ), $en ? 'All' : 'Όλα', ! $current );
	foreach ( get_categories( array( 'hide_empty' => true ) ) as $cat ) {
		$html .= $item( get_category_link( $cat ), $cat->name, $current === $cat->term_id );
	}
	return '<nav aria-label="' . ( $en ? 'Article categories' : 'Κατηγορίες άρθρων' ) . '"><ul class="pg-pills">' . $html . '</ul></nav>';
} );

// Real, crawlable page links (/blog/page/2/) instead of a JS "load more".
add_shortcode( 'pg_pagination', function () {
	$en    = polygons_is_en();
	$links = paginate_links( array( 'type' => 'list', 'prev_text' => $en ? '← Newer' : '← Προηγούμενα', 'next_text' => $en ? 'Older →' : 'Επόμενα →' ) );
	return $links ? '<nav aria-label="' . ( $en ? 'Article pages' : 'Σελίδες άρθρων' ) . '">' . $links . '</nav>' : '';
} );

// Date · reading time (≈200 words/min).
add_shortcode( 'pg_post_meta', function () {
	$words = count( preg_split( '/\s+/u', trim( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ) ) ) );
	$min   = max( 1, (int) round( $words / 200 ) );
	if ( polygons_is_en() ) {
		return sprintf( '<p><time datetime="%s">%s</time> · %d min read</p>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( 'F j, Y' ) ), $min );
	}
	return sprintf( '<p><time datetime="%s">%s</time> · %d %s ανάγνωση</p>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( 'j F Y' ) ), $min, 1 === $min ? 'λεπτό' : 'λεπτά' );
} );

/**
 * Breadcrumbs: projects live under «Οι δουλειές μας» (the CPT has no archive of its own).
 */
add_filter( 'rank_math/frontend/breadcrumb/items', function ( $crumbs ) {
	if ( is_singular( 'projects' ) ) {
		$page = get_page_by_path( 'oi-doulies-mas' );
		if ( $page && function_exists( 'pll_get_post' ) ) {
			$page = get_post( pll_get_post( $page->ID ) ?: $page->ID ); // «Work» on /en/
		}
		if ( $page ) {
			array_splice( $crumbs, 1, 0, array( array( get_the_title( $page ), get_permalink( $page ) ) ) );
		}
	}
	return $crumbs;
} );

/**
 * [pg_lang_switch] — link to the other language (Polylang). Goes to the translation when one
 * exists, otherwise to that language's home. Placed in the header templates.
 */
add_shortcode( 'pg_lang_switch', function () {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return '';
	}
	$out = '';
	foreach ( (array) pll_the_languages( array( 'raw' => 1, 'hide_if_no_translation' => 0 ) ) as $l ) {
		if ( ! empty( $l['current_lang'] ) ) {
			continue;
		}
		$label = 'en' === $l['slug'] ? 'English version' : 'Ελληνική έκδοση';
		$out  .= sprintf( '<a href="%s" hreflang="%s" lang="%s" aria-label="%s">%s</a>', esc_url( $l['url'] ), esc_attr( $l['locale'] ), esc_attr( $l['slug'] ), esc_attr( $label ), esc_html( strtoupper( $l['slug'] ) ) );
	}
	return $out;
} );

// Rank Math breadcrumb "home" label in the current language.
add_filter( 'rank_math/frontend/breadcrumb/items', function ( $crumbs ) {
	if ( function_exists( 'pll_current_language' ) && 'en' === pll_current_language() && ! empty( $crumbs[0] ) ) {
		$crumbs[0][0] = 'Home';
	}
	return $crumbs;
}, 20 );

// Rank Math 404 title in English on /en/.
add_filter( 'rank_math/frontend/title', function ( $title ) {
	return is_404() && function_exists( 'pll_current_language' ) && 'en' === pll_current_language() ? 'Page not found | Polygons' : $title;
} );
