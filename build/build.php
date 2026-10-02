<?php
/**
 * Polygons site builder (Phase 1). Run from app/public:
 *   wp eval-file ../../build/build.php
 *
 * Rebuilds everything it owns (tagged _pg_build / _pg_asset). Re-running WIPES manual
 * Elementor edits to those pages/templates — use it only to reset from scratch.
 */

require __DIR__ . '/lib.php';
require __DIR__ . '/content.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

global $wpdb;

/* ================================================================== Media */

function pg_asset( $file, $title, $alt = '' ) {
	$found = get_posts( array( 'post_type' => 'attachment', 'meta_key' => '_pg_asset', 'meta_value' => basename( $file ), 'fields' => 'ids', 'numberposts' => 1 ) );
	if ( $found ) {
		return $found[0];
	}
	$tmp = wp_tempnam( basename( $file ) );
	copy( $file, $tmp );
	$id = media_handle_sideload( array( 'name' => basename( $file ), 'tmp_name' => $tmp ), 0, $title );
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( $file . ': ' . $id->get_error_message() );
	}
	update_post_meta( $id, '_pg_asset', basename( $file ) );
	update_post_meta( $id, '_wp_attachment_image_alt', $alt ?: $title );
	return $id;
}

$theme_img = get_stylesheet_directory() . '/assets/img/';
$assets    = __DIR__ . '/assets/';
$img       = array(
	'logo'      => pg_asset( $theme_img . 'logo.svg', 'Polygons logo', 'Polygons' ),
	'web'       => pg_asset( $theme_img . 'webdesign.webp', 'Web & UI design', 'Εικονογράφηση: σχεδιασμός ιστοσελίδων και UI' ),
	'branding'  => pg_asset( $theme_img . 'graphics.webp', 'Εταιρική ταυτότητα', 'Εικονογράφηση: εταιρική ταυτότητα και graphics' ),
	'hosting'   => pg_asset( $theme_img . 'hosting.webp', 'Hosting', 'Εικονογράφηση: web hosting' ),
	'marketing' => pg_asset( $theme_img . 'marketing.webp', 'SEO & Marketing', 'Εικονογράφηση: SEO και digital marketing' ),
);
for ( $i = 1; $i <= 6; $i++ ) {
	$img[ 'project' . $i ] = pg_asset( $assets . "project-$i.webp", "Εξώφυλλο έργου $i (placeholder)" );
	$img[ 'client' . $i ]  = pg_asset( $assets . "client-$i.svg", "Λογότυπο πελάτη $i (placeholder)" );
}
set_theme_mod( 'custom_logo', $img['logo'] );
update_option( 'site_icon', $img['logo'] );

/* ================================================================ Cleanup */

$owned_types = array( 'page', 'post', 'jet-theme-core', 'jet-page-template', 'jet-form-builder', 'jet-engine', 'jet-smart-filters', 'projects', 'testimonials', 'clients', 'packages' );
foreach ( get_posts( array( 'post_type' => $owned_types, 'post_status' => 'any', 'meta_key' => '_pg_build', 'numberposts' => -1, 'fields' => 'ids', 'lang' => '' ) ) as $old ) { // 'lang' => '': all languages (Polylang)
	wp_delete_post( $old, true );
}
delete_option( 'jet_page_template_conditions' );

/* ============================================================ Elementor Kit */

$kit_id = (int) get_option( 'elementor_active_kit' );
$ty     = function ( $family, $weight, $size = null, array $more = array() ) {
	$t = array( 'typography_typography' => 'custom', 'typography_font_family' => $family, 'typography_font_weight' => $weight );
	if ( null !== $size ) {
		$t['typography_font_size'] = is_array( $size ) ? $size : pg_size( $size );
	}
	return array_merge( $t, $more );
};
$prefix = function ( $p, array $arr ) {
	$out = array();
	foreach ( $arr as $k => $v ) {
		$out[ $p . substr( $k, strlen( 'typography' ) ) ] = $v;
	}
	return $out;
};

$kit = array_merge(
	get_post_meta( $kit_id, '_elementor_page_settings', true ) ?: array(),
	array(
		'system_colors'     => array(
			array( '_id' => 'primary', 'title' => 'Neon Red', 'color' => '#F15152' ),
			array( '_id' => 'secondary', 'title' => 'Electric Blue', 'color' => '#4A5BFF' ),
			array( '_id' => 'text', 'title' => 'Text', 'color' => '#B9BCC8' ),
			array( '_id' => 'accent', 'title' => 'White', 'color' => '#FFFFFF' ),
		),
		'custom_colors'     => array(
			array( '_id' => 'bg', 'title' => 'Background', 'color' => '#07070A' ),
			array( '_id' => 'surface', 'title' => 'Surface', 'color' => '#101018' ),
			array( '_id' => 'surface2', 'title' => 'Surface raised', 'color' => '#161622' ),
			array( '_id' => 'muted', 'title' => 'Muted text', 'color' => '#80849A' ),
			array( '_id' => 'line', 'title' => 'Hairline', 'color' => PG_LINE ),
			array( '_id' => 'cta', 'title' => 'CTA fill (AA with white)', 'color' => '#D63536' ),
		),
		'system_typography' => array(
			array( '_id' => 'primary', 'title' => 'Display (Jura)' ) + $ty( 'Jura', '700' ),
			array( '_id' => 'secondary', 'title' => 'Headings (Inter)' ) + $ty( 'Inter', '700' ),
			array( '_id' => 'text', 'title' => 'Body' ) + $ty( 'Inter', '400', 17, array( 'typography_font_size_mobile' => pg_size( 16 ), 'typography_line_height' => pg_size( 1.65, 'em' ) ) ),
			array( '_id' => 'accent', 'title' => 'Eyebrow' ) + $ty( 'Jura', '700', 14, array( 'typography_text_transform' => 'uppercase', 'typography_letter_spacing' => pg_size( 0.28, 'em' ), 'typography_line_height' => pg_size( 1.2, 'em' ) ) ),
		),
		'custom_typography' => array(
			array( '_id' => 'lead', 'title' => 'Lead' ) + $ty( 'Inter', '400', 19, array( 'typography_font_size_mobile' => pg_size( 17 ), 'typography_line_height' => pg_size( 1.6, 'em' ) ) ),
			array( '_id' => 'small', 'title' => 'Small' ) + $ty( 'Inter', '400', 15, array( 'typography_line_height' => pg_size( 1.6, 'em' ) ) ),
		),
		// Page
		'body_background_background' => 'classic',
		'body_background_color'      => '#07070A',
		'__globals__'                => array(
			'body_color'                 => pg_gc( 'text' ),
			'body_typography_typography' => pg_gt( 'text' ),
			'link_normal_color'          => pg_gc( 'accent' ),
			'link_hover_color'           => pg_gc( 'primary' ),
			'button_background_color'    => pg_gc( 'cta' ),
			'button_text_color'          => pg_gc( 'accent' ),
			'button_hover_text_color'    => pg_gc( 'accent' ),
		),
		// Headings
		'h1_color'                   => '#FFFFFF',
		'h2_color'                   => '#FFFFFF',
		'h3_color'                   => '#FFFFFF',
		'h4_color'                   => '#FFFFFF',
		'container_width'            => pg_size( 1440 ),
		'space_between_widgets'      => array( 'column' => '0', 'row' => '0', 'unit' => 'px', 'size' => 0, 'isLinked' => true ),
		'default_generic_fonts' => '"Inter Fallback", sans-serif', // metric-matched fallback → no font-swap CLS (polygons.css)
		'site_name'                  => 'Polygons',
		'site_description'           => 'Graphic & Web Services',
		'viewport_tablet'            => 1024,
		'viewport_mobile'            => 767,
		// Buttons
		'button_border_radius'       => pg_all( 999 ),
		'button_padding'             => pg_box( 16, 28, 16, 28 ),
		'button_hover_background_color' => '#C22B2D',
	),
	$prefix( 'h1_typography', $ty( 'Inter', '700', pg_size( 'clamp(40px, 6.5vw, 84px)', 'custom' ), array( 'typography_line_height' => pg_size( 1.08, 'em' ), 'typography_letter_spacing' => pg_size( -0.02, 'em' ) ) ) ),
	$prefix( 'h2_typography', $ty( 'Inter', '700', pg_size( 'clamp(32px, 4.6vw, 56px)', 'custom' ), array( 'typography_line_height' => pg_size( 1.12, 'em' ), 'typography_letter_spacing' => pg_size( -0.02, 'em' ) ) ) ),
	$prefix( 'h3_typography', $ty( 'Inter', '700', 22, array( 'typography_line_height' => pg_size( 1.25, 'em' ), 'typography_letter_spacing' => pg_size( -0.01, 'em' ) ) ) ),
	$prefix( 'button_typography', $ty( 'Inter', '600', 16, array( 'typography_line_height' => pg_size( 1, 'em' ) ) ) )
);
update_post_meta( $kit_id, '_elementor_page_settings', $kit );

/* ==================================================== JetEngine settings */

// Only the modules we use; no Blocks/Bricks view engines; leaner listing markup.
update_option( 'jet_engine_modules', array( 'gallery-grid' => 'true' ) );
update_option( 'jet-engine-performance-tweaks', array( 'optimized_dom' => true, 'enable_elementor_views' => true, 'enable_blocks_views' => false, 'enable_bricks_views' => false ) );

/* ====================================================== JetEngine: types */

function pg_je_field( $name, $title, $type = 'text', array $more = array() ) {
	return array_merge( array( 'title' => $title, 'name' => $name, 'object_type' => 'field', 'type' => $type, 'width' => '100%', 'options' => array(), 'is_required' => false ), $more );
}

$cpts = array(
	'projects'     => array(
		'name' => 'Έργα', 'singular_name' => 'Έργο', 'public' => true, 'publicly_queryable' => true, 'show_in_nav_menus' => false,
		'rewrite' => true, 'rewrite_slug' => 'oi-doulies-mas', 'has_archive' => false, 'menu_icon' => 'dashicons-portfolio',
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
		'meta_fields' => array(
			pg_je_field( 'client', 'Πελάτης', 'text', array( 'width' => '50%' ) ),
			pg_je_field( 'year', 'Έτος', 'text', array( 'width' => '50%' ) ),
			pg_je_field( 'services', 'Υπηρεσίες', 'text', array( 'width' => '50%', 'description' => 'π.χ. Web design · Branding' ) ),
			pg_je_field( 'website', 'Website (URL)', 'text', array( 'width' => '50%' ) ),
			pg_je_field( 'highlight', 'Βασικό αποτέλεσμα (μία φράση)', 'text' ),
			pg_je_field( 'challenge', 'Η πρόκληση', 'textarea' ),
			pg_je_field( 'solution', 'Η λύση', 'textarea' ),
			pg_je_field( 'result', 'Το αποτέλεσμα', 'textarea' ),
			pg_je_field( 'gallery', 'Gallery', 'gallery', array( 'value_format' => 'id' ) ),
			pg_je_field( 'featured', 'Προβολή στην αρχική', 'switcher' ),
		),
	),
	'testimonials' => array(
		'name' => 'Testimonials', 'singular_name' => 'Testimonial', 'public' => false, 'show_ui' => true, 'menu_icon' => 'dashicons-format-quote',
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'meta_fields' => array(
			pg_je_field( 'role', 'Θέση & εταιρεία', 'text', array( 'description' => 'π.χ. CEO, Εταιρεία' ) ),
		),
	),
	'clients'      => array(
		'name' => 'Πελάτες', 'singular_name' => 'Πελάτης', 'public' => false, 'show_ui' => true, 'menu_icon' => 'dashicons-groups',
		'supports' => array( 'title', 'thumbnail', 'page-attributes' ),
		'meta_fields' => array( pg_je_field( 'url', 'Website (URL)' ) ),
	),
	'packages'     => array(
		'name' => 'Πακέτα', 'singular_name' => 'Πακέτο', 'public' => false, 'show_ui' => true, 'menu_icon' => 'dashicons-tag',
		'supports' => array( 'title', 'page-attributes' ),
		'meta_fields' => array(
			pg_je_field( 'group', 'Ομάδα', 'select', array( 'width' => '50%', 'options' => array( array( 'key' => 'web', 'value' => 'Ιστοσελίδες' ), array( 'key' => 'hosting', 'value' => 'Hosting' ) ) ) ),
			pg_je_field( 'badge', 'Σήμα (π.χ. Δημοφιλές)', 'text', array( 'width' => '50%' ) ),
			pg_je_field( 'subtitle', 'Για ποιον είναι', 'text' ),
			pg_je_field( 'price', 'Τιμή', 'text', array( 'width' => '50%', 'description' => 'π.χ. από €490' ) ),
			pg_je_field( 'price_note', 'Σημείωση τιμής', 'text', array( 'width' => '50%', 'description' => 'π.χ. εφάπαξ, /μήνα' ) ),
			pg_je_field( 'features', 'Τι περιλαμβάνει', 'repeater', array( 'repeater-fields' => array( array( 'title' => 'Χαρακτηριστικό', 'name' => 'feature', 'type' => 'text' ) ) ) ),
		),
	),
);

$wpdb->query( "DELETE FROM {$wpdb->prefix}jet_post_types WHERE slug IN ('" . implode( "','", array_keys( $cpts ) ) . "')" );
$wpdb->query( "DELETE FROM {$wpdb->prefix}jet_taxonomies WHERE slug = 'project_cat'" );

foreach ( $cpts as $slug => $def ) {
	$req = array_merge( array(
		'slug' => $slug, 'show_ui' => true, 'show_in_menu' => true, 'show_in_rest' => true, 'query_var' => true,
		'map_meta_cap' => true, 'hierarchical' => false, 'exclude_from_search' => ! ( $def['public'] ?? false ),
		'publicly_queryable' => $def['public'] ?? false, 'rewrite' => $def['public'] ?? false, 'with_front' => false,
	), $def );
	jet_engine()->cpt->data->set_request( $req );
	jet_engine()->cpt->data->create_item( false );
	// Register now so this run can insert posts; JetEngine registers them on future requests.
	register_post_type( $slug, array( 'public' => $req['public'], 'label' => $def['name'], 'supports' => $def['supports'], 'rewrite' => array( 'slug' => $def['rewrite_slug'] ?? $slug, 'with_front' => false ) ) );
}

jet_engine()->taxonomies->data->set_request( array(
	'name' => 'Κατηγορίες έργων', 'singular_name' => 'Κατηγορία έργου', 'slug' => 'project_cat', 'object_type' => array( 'projects' ),
	'public' => true, 'publicly_queryable' => false, 'show_ui' => true, 'show_in_menu' => true, 'show_in_rest' => true,
	'show_admin_column' => true, 'hierarchical' => true, 'rewrite' => false, 'query_var' => true,
) );
jet_engine()->taxonomies->data->create_item( false );
register_taxonomy( 'project_cat', 'projects', array( 'hierarchical' => true, 'public' => true ) );

/* ==================================================== JetEngine: content */

$cat_ids = array();
foreach ( pg_project_cats() as $slug => $name ) {
	$t                = term_exists( $slug, 'project_cat' ) ?: wp_insert_term( $name, 'project_cat', array( 'slug' => $slug ) );
	$cat_ids[ $slug ] = (int) $t['term_id'];
}

function pg_insert( $type, $title, array $args = array(), array $meta = array() ) {
	$id = wp_insert_post( array_merge( array( 'post_type' => $type, 'post_status' => 'publish', 'post_title' => $title ), $args ) );
	update_post_meta( $id, '_pg_build', 1 );
	foreach ( $meta as $k => $v ) {
		update_post_meta( $id, $k, $v );
	}
	return $id;
}

$project_ids = array();
foreach ( pg_projects() as $n => $p ) {
	$id = $project_ids[ $n ] = pg_insert( 'projects', $p['title'], array( 'post_name' => $p['slug'], 'post_excerpt' => $p['excerpt'], 'post_content' => $p['content'], 'menu_order' => $n ), array(
		'client' => $p['client'], 'year' => $p['year'], 'services' => $p['services'], 'website' => '',
		'highlight' => $p['highlight'], 'challenge' => $p['challenge'], 'solution' => $p['solution'], 'result' => $p['result'],
		'gallery' => implode( ',', array( $img[ 'project' . ( ( $n + 1 ) % 6 + 1 ) ], $img[ 'project' . ( ( $n + 2 ) % 6 + 1 ) ] ) ),
		'featured' => $n < 3 ? 'true' : 'false',
	) );
	set_post_thumbnail( $id, $img[ 'project' . ( $n + 1 ) ] );
	wp_set_object_terms( $id, array( $cat_ids[ $p['cat'] ] ), 'project_cat' );
}
$testimonial_ids = array();
foreach ( pg_testimonials() as $n => $t ) {
	$testimonial_ids[] = pg_insert( 'testimonials', $t['name'], array( 'post_content' => $t['quote'], 'menu_order' => $n ), array( 'role' => $t['role'] ) );
}
for ( $i = 1; $i <= 6; $i++ ) {
	$id = pg_insert( 'clients', "Πελάτης $i (placeholder)", array( 'menu_order' => $i ), array( 'url' => '' ) );
	set_post_thumbnail( $id, $img[ 'client' . $i ] );
}
$package_ids = array();
foreach ( pg_packages() as $n => $p ) {
	$features = array();
	foreach ( $p['features'] as $k => $f ) {
		$features[ 'item-' . $k ] = array( 'feature' => $f );
	}
	$package_ids[] = pg_insert( 'packages', $p['title'], array( 'menu_order' => $n ), array(
		'group' => $p['group'], 'badge' => $p['badge'], 'subtitle' => $p['subtitle'], 'price' => $p['price'], 'price_note' => $p['note'], 'features' => $features,
	) );
}

// Blog: categories + sample articles (native posts, written in the WP block editor).
$blog_cat_ids = array();
foreach ( pg_blog_cats() as $slug => $name ) {
	$t                     = term_exists( $slug, 'category' ) ?: wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
	$blog_cat_ids[ $slug ] = (int) $t['term_id'];
}
wp_update_term( 1, 'category', array( 'name' => 'Γενικά', 'slug' => 'genika' ) ); // default category
foreach ( get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'name' => 'hello-world', 'numberposts' => 1, 'fields' => 'ids' ) ) as $hello ) {
	wp_delete_post( $hello, true );
}
$post_ids = array();
foreach ( pg_posts() as $p ) {
	$id = $post_ids[] = pg_insert( 'post', $p['title'], array( 'post_name' => $p['slug'], 'post_excerpt' => $p['excerpt'], 'post_content' => $p['content'], 'post_date' => $p['date'], 'post_category' => array( $blog_cat_ids[ $p['cat'] ] ) ) );
	set_post_thumbnail( $id, $img[ $p['img'] ] );
}
update_option( 'posts_per_page', 9 );

/* =================================================== JetEngine: listings */

function pg_listing( $title, $post_type, array $data ) {
	$id = wp_insert_post( array(
		'post_type'   => 'jet-engine',
		'post_status' => 'publish',
		'post_title'  => $title,
		'meta_input'  => array(
			'_listing_data'            => array( 'source' => 'posts', 'post_type' => $post_type, 'tax' => '' ),
			'_listing_type'            => 'elementor',
			'_entry_type'              => 'listing',
			'_elementor_page_settings' => array( 'listing_source' => 'posts', 'listing_post_type' => $post_type, 'listing_tax' => '', 'repeater_source' => '', 'repeater_field' => '', 'repeater_option' => '' ),
		),
	) );
	pg_save_elementor( $id, $data, 'jet-listing-items' );
	return $id;
}

$L = array();

/** Listing card designs (one per language: the EN listing is a Polylang translation). */
function pg_project_card( $label ) {
	return array(
		pg_c( array_merge( pg_card_style( 0 ), array( 'css_classes' => 'pg-card pg-project', 'flex_gap' => pg_gap( 0 ) ) ), array(
			pg_w( 'jet-listing-dynamic-image', array( 'dynamic_image_source' => 'post_thumbnail', 'dynamic_image_size' => 'medium_large', 'linked_image' => '', 'lazy_load_image' => 'yes', '_css_classes' => 'pg-project__media' ) ),
			pg_c( array( 'padding' => pg_all( 24 ), 'flex_gap' => pg_gap( 10 ), 'flex_grow' => 1 ), array(
				pg_w( 'jet-listing-dynamic-terms', array( 'from_tax' => 'project_cat', 'terms_linked' => '', 'terms_delimiter' => ' · ', '_css_classes' => 'pg-tag' ) ),
				pg_dyn( 'post_title', 'h3', 'pg-project__title' ),
				pg_dyn( 'meta:highlight', 'p', 'pg-project__hl' ),
				pg_w( 'jet-listing-dynamic-link', array( 'dynamic_link_source' => '_permalink', 'link_label' => $label, 'selected_link_icon' => array( 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ), 'link_icon_position' => 3, '_css_classes' => 'pg-stretched pg-link' ) ),
			) ),
		) ),
	);
}
function pg_package_card( $cta, $url ) {
	return array(
		pg_c( array_merge( pg_card_style( 32, 24 ), array( 'css_classes' => 'pg-card pg-pack', 'flex_gap' => pg_gap( 16 ) ) ), array(
			pg_dyn( 'meta:badge', 'span', 'pg-pack__badge' ),
			pg_dyn( 'post_title', 'h3', 'pg-pack__title' ),
			pg_dyn( 'meta:subtitle', 'p', 'pg-pack__sub' ),
			pg_c( array( 'flex_direction' => 'row', 'flex_align_items' => 'baseline', 'flex_gap' => pg_gap( 8 ), 'css_classes' => 'pg-pack__price-row' ), array(
				pg_dyn( 'meta:price', 'span', 'pg-pack__price' ),
				pg_dyn( 'meta:price_note', 'span', 'pg-pack__note' ),
			) ),
			pg_w( 'jet-listing-dynamic-repeater', array( 'dynamic_field_source' => 'features', 'dynamic_field_format' => '%feature%', 'item_tag' => 'div', 'items_delimiter' => '', '_css_classes' => 'pg-pack__list' ) ),
			pg_button( $cta, $url, 'ghost', true, array( 'align' => 'justify', '_css_classes' => 'pg-btn pg-btn--ghost pg-pack__cta' ) ),
		) ),
	);
}
function pg_post_card( $label ) {
	return array(
		pg_c( array_merge( pg_card_style( 0 ), array( 'css_classes' => 'pg-card pg-project pg-post-card', 'flex_gap' => pg_gap( 0 ) ) ), array(
			pg_w( 'jet-listing-dynamic-image', array( 'dynamic_image_source' => 'post_thumbnail', 'dynamic_image_size' => 'medium_large', 'linked_image' => '', 'lazy_load_image' => 'yes', '_css_classes' => 'pg-project__media' ) ),
			pg_c( array( 'padding' => pg_all( 24 ), 'flex_gap' => pg_gap( 10 ), 'flex_grow' => 1 ), array(
				pg_w( 'jet-listing-dynamic-terms', array( 'from_tax' => 'category', 'terms_linked' => '', 'terms_delimiter' => ' · ', '_css_classes' => 'pg-tag' ) ),
				pg_dyn( 'post_title', 'h3', 'pg-project__title' ),
				pg_dyn( 'post_excerpt', 'p', 'pg-post-card__excerpt' ),
				pg_w( 'jet-listing-dynamic-link', array( 'dynamic_link_source' => '_permalink', 'link_label' => $label, 'selected_link_icon' => array( 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ), 'link_icon_position' => 3, '_css_classes' => 'pg-stretched pg-link' ) ),
			) ),
		) ),
	);
}

$L['project'] = pg_listing( 'Κάρτα έργου', 'projects', pg_project_card( 'Δες το case study' ) );

$L['testimonial'] = pg_listing( 'Κάρτα testimonial', 'testimonials', array(
	pg_c( array_merge( pg_card_style( 32 ), array( 'css_classes' => 'pg-card pg-quote', 'flex_gap' => pg_gap( 24 ), 'flex_justify_content' => 'space-between' ) ), array(
		pg_dyn( 'post_content', 'div', 'pg-quote__text' ),
		pg_c( array( 'flex_gap' => pg_gap( 2 ), 'css_classes' => 'pg-quote__who' ), array(
			pg_dyn( 'post_title', 'p', 'pg-quote__name' ),
			pg_dyn( 'meta:role', 'p', 'pg-quote__role' ),
		) ),
	) ),
) );

$L['client'] = pg_listing( 'Λογότυπο πελάτη', 'clients', array(
	pg_c( array( 'css_classes' => 'pg-client', 'flex_align_items' => 'center', 'flex_justify_content' => 'center', 'padding' => pg_all( 12 ) ), array(
		pg_w( 'jet-listing-dynamic-image', array( 'dynamic_image_source' => 'post_thumbnail', 'dynamic_image_size' => 'full', 'linked_image' => '', 'lazy_load_image' => 'yes' ) ),
	) ),
) );

$L['package'] = pg_listing( 'Κάρτα πακέτου', 'packages', pg_package_card( 'Ζήτα προσφορά', '/prosfora/' ) );

$L['post'] = pg_listing( 'Κάρτα άρθρου', 'post', pg_post_card( 'Διάβασε το άρθρο' ) );

/* ================================================================== Forms */

const PG_NOTIFY_EMAIL = 'info@polygons.gr'; // site alias; never the personal address

function pg_jfb_form( $title, $content, $admin_subject, $admin_body, $success, $confirm = null, $progress = false ) {
	$id = wp_insert_post( array( 'post_type' => 'jet-form-builder', 'post_status' => 'publish', 'post_title' => $title, 'post_content' => $content ) );
	update_post_meta( $id, '_pg_build', 1 );
	update_post_meta( $id, '_jf_args', wp_json_encode( array( 'submit_type' => 'ajax', 'required_mark' => '*', 'fields_layout' => 'column', 'fields_label_tag' => 'label', 'enable_progress' => $progress, 'clear' => true ) ) );
	$actions = array(
		array( 'id' => 1, 'type' => 'save_record', 'settings' => array( 'save_record' => array( 'save_user_data' => array( 'ip', 'user_agent', 'referrer' ) ) ) ),
		array( 'id' => 2, 'type' => 'send_email', 'settings' => array( 'send_email' => array(
			'mail_to' => 'custom', 'custom_email' => PG_NOTIFY_EMAIL, 'reply_to' => 'form', 'reply_from_field' => 'email', 'content_type' => 'text/html',
			'subject' => $admin_subject, 'content' => $admin_body,
		) ) ),
	);
	if ( $confirm ) { // confirmation to the visitor
		$actions[] = array( 'id' => 3, 'type' => 'send_email', 'settings' => array( 'send_email' => array(
			'mail_to' => 'form', 'from_field' => 'email', 'content_type' => 'text/html', 'subject' => $confirm[0], 'content' => $confirm[1],
		) ) );
	}
	update_post_meta( $id, '_jf_actions', wp_json_encode( $actions, JSON_UNESCAPED_UNICODE ) );
	update_post_meta( $id, '_jf_messages', wp_json_encode( array(
		'success' => $success, 'failed' => 'Κάτι πήγε στραβά. Δοκίμασε ξανά ή στείλε μας email.',
		'validation_failed' => 'Έλεγξε τα πεδία της φόρμας.', 'invalid_email' => 'Το email δεν είναι έγκυρο.', 'empty_field' => 'Το πεδίο είναι υποχρεωτικό.', 'internal_error' => 'Εσωτερικό σφάλμα. Δοκίμασε ξανά.',
	), JSON_UNESCAPED_UNICODE ) );
	return $id;
}

$form_id = pg_jfb_form( 'Φόρμα επικοινωνίας', pg_form_blocks(),
	'Νέο μήνυμα από το polygons.gr — %name%',
	'<p><b>Όνομα:</b> %name%<br><b>Email:</b> %email%<br><b>Τηλέφωνο:</b> %phone%<br><b>Υπηρεσία:</b> %service%</p><p>%message%</p>',
	'Ευχαριστούμε! Λάβαμε το μήνυμά σου και θα επικοινωνήσουμε σύντομα.',
	array( 'Λάβαμε το μήνυμά σου — Polygons', '<p>Γεια σου %name%,</p><p>ευχαριστούμε που επικοινώνησες μαζί μας. Θα σου απαντήσουμε μέσα σε μία εργάσιμη.</p><p>Polygons Studio</p>' ) );

$quote_form_id = pg_jfb_form( 'Αίτημα προσφοράς (βήματα)', pg_quote_form_blocks(),
	'Νέο αίτημα προσφοράς — %name%',
	'<p><b>Υπηρεσίες:</b> %services%<br><b>Υπάρχον site:</b> %current_site%<br><b>Budget:</b> %budget%<br><b>Χρονοδιάγραμμα:</b> %timeline%</p><p><b>Όνομα:</b> %name%<br><b>Εταιρεία:</b> %company%<br><b>Email:</b> %email%<br><b>Τηλέφωνο:</b> %phone%</p><p>%message%</p>',
	'Ευχαριστούμε! Λάβαμε το αίτημά σου. Θα επικοινωνήσουμε μαζί σου σύντομα για τα επόμενα βήματα.',
	array( 'Λάβαμε το αίτημά σου — Polygons', '<p>Γεια σου %name%,</p><p>ευχαριστούμε για το αίτημα προσφοράς. Το εξετάζουμε και θα επικοινωνήσουμε μαζί σου σύντομα.</p><p>Polygons Studio</p>' ), true );

$audit_form_id = pg_jfb_form( 'Δωρεάν έλεγχος site', pg_audit_form_blocks(),
	'Αίτημα δωρεάν ελέγχου — %site_url%',
	'<p><b>Site:</b> %site_url%<br><b>Email:</b> %email%</p>',
	'Τέλεια! Λάβαμε το site σου και θα σου στείλουμε την αναφορά με email.',
	array( 'Ο δωρεάν έλεγχος του site σου — Polygons', '<p>Γεια σου,</p><p>λάβαμε το αίτημα για έλεγχο του <b>%site_url%</b>. Θα σου στείλουμε την αναφορά ταχύτητας και SEO με email.</p><p>Polygons Studio</p>' ) );

/* ================================================================== Pages */

function pg_page( $title, $slug, $data, $menu_order = 0, $parent = 0 ) {
	$id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $title, 'post_name' => $slug, 'menu_order' => $menu_order, 'post_parent' => $parent, 'page_template' => 'elementor_header_footer' ) );
	pg_save_elementor( $id, $data );
	$seo = pg_seo_meta()[ $slug ] ?? null;
	if ( $seo ) {
		pg_seo( $id, $seo[0], $seo[1] );
	}
	return $id;
}

$services = pg_services();
$q_order  = array( array( '_id' => pg_id(), 'type' => 'order_offset', 'order_by' => 'menu_order', 'order' => 'ASC' ) );

/* ---- Home ---- */

$service_cards = array();
foreach ( $services as $key => $s ) {
	$service_cards[] = pg_card( array(
		pg_image( $img[ $key ], 'pg-card__media', 'medium_large' ),
		pg_heading( $s['n'], 'p', 'pg-num', array( '__globals__' => array( 'typography_typography' => pg_gt( 'accent' ), 'title_color' => pg_gc( 'primary' ) ) ) ),
		pg_heading( $s['title'], 'h3' ),
		pg_text( '<p>' . $s['short'] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ) ) ) ),
		pg_heading( '<a href="' . pg_service_url( $key ) . '">Μάθε περισσότερα <span aria-hidden="true">→</span></a>', 'p', 'pg-link' ),
	), 'pg-card--service' );
}

$why_boxes = array();
foreach ( pg_why() as $w ) {
	$why_boxes[] = pg_feature( $w[0], $w[1], $w[2] );
}

$step_boxes = array();
foreach ( pg_steps() as $i => $st ) {
	$step_boxes[] = pg_card( array(
		pg_heading( sprintf( '%02d', $i + 1 ), 'p', 'pg-step__num' ),
		pg_heading( $st[0], 'h3' ),
		pg_text( '<p>' . $st[1] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ) ) ) ),
	), 'pg-step', array( 'padding' => pg_box( 32, 28, 32, 28 ) ) );
}

$home = array(
	pg_section( 'pg-hero fx-mesh fx-neon-on', array(
		pg_w( 'html', array( 'html' => '<div class="pg-hero__deco fx-draw" aria-hidden="true">' . pg_hex_svg( true ) . '</div>' ) ),
		pg_heading( '<span class="pg-hero__kicker">The ultimate</span><span class="pg-neon">All-in-one</span><span class="pg-hero__sub">Graphic &amp; Web Services</span>', 'h1', 'pg-hero__title', array( 'align' => 'center' ) ),
		pg_lead( '<p>Το <strong>Polygons design studio</strong> είναι ο ένας συνεργάτης που χρειάζεσαι για την ψηφιακή σου παρουσία. Σχεδιασμός ιστοσελίδων, εταιρική ταυτότητα, hosting και SEO, όλα κάτω από την ίδια στέγη.</p>', 'center' ),
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 16 ), 'css_classes' => 'pg-hero__actions' ), array(
			pg_button( 'Ζήτα προσφορά', '/prosfora/', 'primary', true, array( '_css_classes' => 'pg-btn pg-btn--primary fx-magnetic' ) ),
			pg_button( 'Δες τις δουλειές μας', '/oi-doulies-mas/', 'ghost', false ),
		) ),
	), array(
		'min_height'           => pg_size( 100, 'vh' ),
		'flex_justify_content' => 'center',
		'flex_align_items'     => 'center',
		'flex_gap'             => pg_gap( 32 ),
		'padding'              => pg_box( 160, 24, 120, 24 ),
		'padding_mobile'       => pg_box( 130, 20, 80, 20 ),
	) ),
	pg_c( array( 'css_classes' => 'pg-marquee' ), array(
		pg_w( 'html', array( 'html' => '<div class="pg-marquee__track" aria-hidden="true">' . str_repeat( '<span>Web Design</span><span>UI / UX</span><span>Branding</span><span>Graphic Design</span><span>Hosting</span><span>SEO</span><span>Digital Marketing</span>', 2 ) . '</div>' ) ),
	), false ),
	pg_section( 'pg-services', array(
		pg_intro( 'Τι κάνουμε', 'Όλα όσα χρειάζεται το brand σου.<br>Σε ένα studio.', 'Ξέχνα την ταλαιπωρία των πολλών συνεργατών. Από το πρώτο σκίτσο μέχρι την πρώτη θέση στη Google, τα έχουμε όλα καλυμμένα.' ),
		pg_grid( 4, 2, 1, $service_cards, 'pg-services__grid fx-border fx-stagger' ),
	), array(), 'ypiresies' ),
	pg_section( 'pg-featured', array(
		pg_c( array( 'flex_direction' => 'row', 'flex_direction_mobile' => 'column', 'flex_justify_content' => 'space-between', 'flex_align_items' => 'flex-end', 'flex_gap' => pg_gap( 24 ) ), array(
			pg_intro( 'Επιλεγμένα έργα', 'Δουλειά που μιλάει<br>από μόνη της.', '', 'left' ),
			pg_button( 'Όλα τα έργα', '/oi-doulies-mas/', 'ghost', true ),
		) ),
		pg_listing_grid( $L['project'], 3, 2, 1, 3, array_merge( $q_order, array( array( '_id' => pg_id(), 'type' => 'meta_query', 'meta_query_key' => 'featured', 'meta_query_compare' => '=', 'meta_query_val' => 'true' ) ) ), 'pg-projects fx-hex fx-tilt' ),
	), array( 'padding' => pg_box( 40, 24, 120, 24 ) ) ),
	pg_section( 'pg-why pg-section--alt', array(
		pg_row( array(
			pg_col( array(
				pg_intro( 'Γιατί Polygons', 'Ένας συνεργάτης.<br>Μηδέν μπλέξιμο.', 'Ένα πολύγωνο στέκει γερό επειδή όλες του οι πλευρές ενώνονται σωστά. Έτσι δουλεύουμε κι εμείς: κάθε κομμάτι της ψηφιακής σου παρουσίας σχεδιάζεται να ταιριάζει με τα υπόλοιπα.', 'left' ),
				pg_button( 'Γνώρισέ μας', '/poioi-eimaste/', 'ghost', false ),
			), 40 ),
			pg_col( array( pg_grid( 2, 2, 1, $why_boxes, 'pg-why__grid', 20 ) ), 60 ),
		) ),
	) ),
	pg_section( 'pg-process', array(
		pg_intro( 'Πώς δουλεύουμε', 'Από την ιδέα στο launch.', 'Ξεκάθαρα βήματα, σταθερή επικοινωνία και καμία έκπληξη στην πορεία.' ),
		pg_grid( 4, 2, 1, $step_boxes, 'pg-steps', 20 ),
	) ),
	pg_audit_section( $audit_form_id ),
	pg_section( 'pg-testimonials pg-section--alt', array(
		pg_intro( 'Τι λένε οι πελάτες μας', 'Η καλύτερη διαφήμιση<br>είναι ένας ικανοποιημένος πελάτης.' ),
		pg_listing_grid( $L['testimonial'], 3, 1, 1, 3, $q_order, 'pg-quotes' ),
	) ),
	pg_section( 'pg-clients', array(
		pg_eyebrow( 'Μας εμπιστεύονται', 'center' ),
		pg_listing_grid( $L['client'], 6, 3, 2, 12, $q_order, 'pg-clients', '', 16 ),
	), array( 'padding' => pg_box( 72, 24, 72, 24 ), 'flex_gap' => pg_gap( 28 ) ) ),
	pg_cta(),
);
$home_id = pg_page( 'Αρχική', 'arxiki', $home, 0 );

/* ---- Τι κάνουμε ---- */

$svc_page = array( pg_page_hero( 'Υπηρεσίες', 'Τι κάνουμε', 'Τέσσερις ειδικότητες, μία ομάδα. Διάλεξε ό,τι χρειάζεσαι ή άφησέ μας να στήσουμε ολόκληρη την ψηφιακή σου παρουσία.' ) );
$svc_page[] = pg_c( array( 'content_width' => 'boxed', 'css_classes' => 'pg-subnav', 'flex_direction' => 'row', 'flex_justify_content' => 'center', 'padding' => pg_box( 0, 24, 24, 24 ), 'padding_mobile' => pg_box( 0, 20, 24, 20 ) ), array(
	pg_text( '<nav aria-label="Υπηρεσίες"><ul class="pg-pills">' . implode( '', array_map( function ( $k, $s ) {
		return '<li><a href="#' . $k . '">' . $s['title'] . '</a></li>';
	}, array_keys( $services ), $services ) ) . '<li><a href="#paketa">Πακέτα</a></li><li><a href="#faq">Συχνές ερωτήσεις</a></li></ul></nav>' ),
), false );
$stack_cards = array();
foreach ( $services as $key => $s ) {
	$stack_cards[] = pg_c( array_merge( pg_card_style( 40, 28 ), array(
		'_element_id'           => $key,
		'css_classes'           => 'pg-service-card',
		'flex_direction'        => 'row',
		'flex_direction_tablet' => 'column',
		'flex_align_items'      => 'center',
		'flex_gap'              => pg_gap( 40 ),
		'padding_mobile'        => pg_all( 24 ),
	) ), array(
		pg_col( array(
			pg_heading( $s['n'], 'p', 'pg-service__num' ),
			pg_heading( $s['title'], 'h2', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(28px, 3vw, 40px)', 'custom' ) ) ),
			pg_text( '<p>' . $s['long'] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'text' ), 'text_color' => pg_gc( 'text' ) ) ) ),
			pg_chips( array( 'Ιδανικό για' => $s['for'], 'Διάρκεια' => $s['time'] ) ),
			pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_gap' => pg_gap( 12 ) ), array(
				pg_button( 'Ζήτα προσφορά', '/prosfora/', 'primary' ),
				pg_button( 'Αναλυτικά', pg_service_url( $key ), 'ghost', false, array( 'text' => 'Αναλυτικά <span class="pg-sr-only">για ' . $s['title'] . '</span>' ) ),
			) ),
		), 46, '', 14 ),
		pg_col( array(
			pg_eyebrow( 'Τι περιλαμβάνει' ),
			pg_icon_list( $s['list'] ),
		), 28, 'pg-service-card__list', 16 ),
		pg_col( array( pg_image( $img[ $key ], 'pg-service__media', 'medium_large' ) ), 26 ),
	) );
}
$svc_page[] = pg_section( 'pg-service-stack', array(
	pg_c( array( 'css_classes' => 'fx-stack', 'flex_gap' => pg_gap( 40 ) ), $stack_cards ),
), array( 'padding' => pg_box( 32, 24, 120, 24 ), 'padding_mobile' => pg_box( 16, 16, 72, 16 ) ) );
$tab = function ( $group ) use ( $L, $q_order ) {
	return pg_c( array(), array( pg_listing_grid( $L['package'], 3, 1, 1, 6, array_merge( $q_order, array( array( '_id' => pg_id(), 'type' => 'meta_query', 'meta_query_key' => 'group', 'meta_query_compare' => '=', 'meta_query_val' => $group ) ) ), 'pg-packs fx-border' ) ) );
};
$svc_page[] = pg_section( 'pg-packages', array(
	pg_intro( 'Πακέτα', 'Ξεκάθαρες τιμές.<br>Χωρίς ψιλά γράμματα.', 'Έτοιμα πακέτα για τις πιο συνηθισμένες ανάγκες. Χρειάζεσαι κάτι διαφορετικό; Φτιάχνουμε προσφορά στα μέτρα σου.' ),
	array(
		'id' => pg_id(), 'elType' => 'widget', 'widgetType' => 'nested-tabs',
		'settings' => array(
			'tabs'                  => array( array( '_id' => pg_id(), 'tab_title' => 'Ιστοσελίδες' ), array( '_id' => pg_id(), 'tab_title' => 'Hosting' ) ),
			'tabs_justify_horizontal' => 'center',
			'breakpoint_selector'     => 'none',
			'title_text_color'        => '#DCDDE3',
			'title_text_color_hover'  => '#FFFFFF',
			'title_text_color_active' => '#FFFFFF',
			'_css_classes'          => 'pg-tabs',
		),
		'elements' => array( $tab( 'web' ), $tab( 'hosting' ) ),
	),
), array(), 'paketa' );
$faq_widget = pg_faq_widget( pg_faq() );
$svc_page[] = pg_audit_section( $audit_form_id );
$svc_page[] = pg_section( 'pg-faq pg-section--alt', array(
	pg_row( array(
		pg_col( array( pg_intro( 'FAQ', 'Συχνές ερωτήσεις', 'Δεν βρίσκεις την απάντηση που ψάχνεις; Στείλε μας μήνυμα, απαντάμε γρήγορα.', 'left' ), pg_button( 'Κάνε μια ερώτηση', '/epikoinwnia/', 'ghost', false ) ), 35 ),
		pg_col( array( $faq_widget ), 65 ),
	), '', 64, 'flex-start' ),
), array(), 'faq' );
$svc_page[] = pg_cta( 'Δεν ξέρεις από πού να ξεκινήσεις;', 'Πες μας τι θέλεις να πετύχεις και θα σου προτείνουμε τον πιο έξυπνο δρόμο για να φτάσεις εκεί.' );
$svc_id     = pg_page( 'Τι κάνουμε', 'ti-kanoume', $svc_page, 1 );

/* ---- Σελίδες υπηρεσιών (/ti-kanoume/<slug>/) ---- */

/**
 * One service page. $d = page data (pg_service_pages / pg_en_service_pages), $services = card data
 * (pg_services / pg_en_services), $all = all service pages, $url = key → page URL, $t = UI strings.
 */
function pg_service_page_data( $key, array $d, array $services, array $all, callable $url, array $t, array $img, array $L, array $q_order ) {
	$s    = $services[ $key ];
	$page = array(
		pg_page_hero( $d['eyebrow'], $d['h1'], $d['lead'], array(
			pg_button( $t['cta'], $t['cta_url'], 'primary', true, array( '_css_classes' => 'pg-btn pg-btn--primary fx-magnetic' ) ),
			pg_button( $t['incl'], '#' . $t['incl_anchor'], 'ghost', false ),
		) ),
		pg_section( 'pg-service-intro', array(
			pg_row( array(
				pg_col( array(
					pg_heading( $d['intro_h'], 'h2', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(28px, 3.2vw, 42px)', 'custom' ) ) ),
					pg_text( $d['intro'], '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'lead' ), 'text_color' => pg_gc( 'text' ) ) ) ),
					pg_chips( array( $t['for'] => $s['for'], $t['time'] => $s['time'] ) ),
				), 56, '', 20 ),
				pg_col( array( pg_image( $img[ $key ], 'pg-service__media', 'medium_large' ) ), 44 ),
			) ),
		), array( 'padding' => pg_box( 24, 24, 96, 24 ) ) ),
		pg_section( 'pg-service-features pg-section--alt', array(
			pg_intro( $t['incl'], $t['incl_title'] ),
			pg_grid( 3, 2, 1, array_map( function ( $f ) {
				return pg_feature( $f[0], $f[1], $f[2] );
			}, $d['features'] ), 'pg-features fx-border fx-stagger', 20 ),
		), array(), $t['incl_anchor'] ),
		pg_section( 'pg-process', array(
			pg_intro( $t['how'], $t['how_title'] ),
			pg_grid( 4, 2, 1, array_map( function ( $st, $i ) {
				return pg_card( array(
					pg_heading( sprintf( '%02d', $i + 1 ), 'p', 'pg-step__num' ),
					pg_heading( $st[0], 'h3' ),
					pg_text( '<p>' . $st[1] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ) ) ) ),
				), 'pg-step', array( 'padding' => pg_box( 32, 28, 32, 28 ) ) );
			}, $d['process'], array_keys( $d['process'] ) ), 'pg-steps', 20 ),
		) ),
	);
	if ( $d['packages'] ) {
		$page[] = pg_section( 'pg-packages pg-section--alt', array(
			pg_intro( $t['pk'], $t['pk_title'], $t['pk_lead'] ),
			pg_listing_grid( $L['package'], 3, 1, 1, 6, array_merge( $q_order, array( array( '_id' => pg_id(), 'type' => 'meta_query', 'meta_query_key' => 'group', 'meta_query_compare' => '=', 'meta_query_val' => $d['packages'] ) ) ), 'pg-packs fx-border' ),
		), array(), $t['pk_anchor'] );
	}
	if ( $d['cats'] ) {
		$page[] = pg_section( 'pg-featured', array(
			pg_c( array( 'flex_direction' => 'row', 'flex_direction_mobile' => 'column', 'flex_justify_content' => 'space-between', 'flex_align_items' => 'flex-end', 'flex_gap' => pg_gap( 24 ) ), array(
				pg_intro( $t['rel'], $t['rel_title'], '', 'left' ),
				pg_button( $t['all_work'], $t['work_url'], 'ghost', true ),
			) ),
			pg_listing_grid( $L['project'], 3, 2, 1, 3, array_merge( $q_order, array( array( '_id' => pg_id(), 'type' => 'tax_query', 'tax_query_taxonomy' => 'project_cat', 'tax_query_compare' => 'IN', 'tax_query_field' => 'slug', 'tax_query_terms' => implode( ',', $d['cats'] ) ) ) ), 'pg-projects fx-hex fx-tilt' ),
		) );
	}
	$page[] = pg_section( 'pg-faq pg-section--alt', array(
		pg_row( array(
			pg_col( array( pg_intro( 'FAQ', $t['faq_title'], $t['faq_lead'], 'left' ), pg_button( $t['ask'], $t['contact_url'], 'ghost', false ) ), 35 ),
			pg_col( array( pg_faq_widget( $d['faq'] ) ), 65 ),
		), '', 64, 'flex-start' ),
	), array(), 'faq' );
	$others = array();
	foreach ( $all as $k2 => $d2 ) {
		if ( $k2 !== $key ) {
			$others[] = pg_card( array(
				pg_heading( $services[ $k2 ]['n'], 'p', 'pg-num', array( '__globals__' => array( 'typography_typography' => pg_gt( 'accent' ), 'title_color' => pg_gc( 'primary' ) ) ) ),
				pg_heading( '<a href="' . $url( $k2 ) . '" class="pg-stretched">' . $services[ $k2 ]['title'] . '</a>', 'h3' ),
				pg_text( '<p>' . $services[ $k2 ]['short'] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ) ) ) ),
			), 'pg-card--service pg-card--link' );
		}
	}
	$page[] = pg_section( 'pg-other-services', array(
		pg_intro( $t['others'], $t['others_title'] ),
		pg_grid( 3, 1, 1, $others, 'fx-border', 20 ),
	) );
	$page[] = pg_cta( $t['cta_title'], $t['cta_text'], $t['cta'], $t['cta_url'] );
	return $page;
}

$service_page_ids = array();
foreach ( pg_service_pages() as $key => $d ) {
	$s    = $services[ $key ];
	$page = pg_service_page_data( $key, $d, $services, pg_service_pages(), 'pg_service_url', array(
		'cta' => 'Ζήτα προσφορά', 'cta_url' => '/prosfora/', 'incl' => 'Τι περιλαμβάνει', 'incl_anchor' => 'perilamvanei', 'incl_title' => 'Όλα όσα χρειάζεσαι,<br>τίποτα περιττό.',
		'for' => 'Ιδανικό για', 'time' => 'Διάρκεια', 'how' => 'Πώς δουλεύουμε', 'how_title' => 'Τέσσερα ξεκάθαρα βήματα.',
		'pk' => 'Πακέτα', 'pk_title' => 'Ξεκάθαρες τιμές.<br>Χωρίς ψιλά γράμματα.', 'pk_lead' => 'Χρειάζεσαι κάτι διαφορετικό; Φτιάχνουμε προσφορά στα μέτρα σου.', 'pk_anchor' => 'paketa',
		'rel' => 'Σχετικά έργα', 'rel_title' => 'Δες το στην πράξη.', 'all_work' => 'Όλα τα έργα', 'work_url' => '/oi-doulies-mas/',
		'faq_title' => 'Συχνές ερωτήσεις', 'faq_lead' => 'Δεν βρίσκεις την απάντηση που ψάχνεις; Στείλε μας μήνυμα, απαντάμε γρήγορα.', 'ask' => 'Κάνε μια ερώτηση', 'contact_url' => '/epikoinwnia/',
		'others' => 'Όλα σε ένα studio', 'others_title' => 'Δες και τις υπόλοιπες υπηρεσίες.',
		'cta_title' => 'Ας μιλήσουμε για το δικό σου project.', 'cta_text' => 'Πες μας τι χρειάζεσαι και θα σου στείλουμε ξεκάθαρη προσφορά, με κόστος και χρονοδιάγραμμα.',
	), $img, $L, $q_order );

	$pid = pg_page( $d['menu'], $d['slug'], $page, (int) $s['n'], $svc_id );
	pg_seo( $pid, $d['seo'][0], $d['seo'][1] );
	$service_page_ids[ $key ] = $pid;
}

/* ---- Οι δουλειές μας ---- */

$filter_id = pg_insert( 'jet-smart-filters', 'Κατηγορία έργου', array(), array(
	'_filter_type'           => 'radio',
	'_data_source'           => 'taxonomies',
	'_source_taxonomy'       => 'project_cat',
	'_add_all_option'        => 'true',
	'_all_option_label'      => 'Όλα',
	'_ability_deselect_radio' => 'false',
	'_show_empty_terms'      => 'false',
	'_only_child'            => 'false',
	'_is_hierarchical'       => 'false',
	'_filter_label'          => '',
	'_query_var'             => 'project_cat',
) );
$works_page = array(
	pg_page_hero( 'Portfolio', 'Οι δουλειές μας', 'Ιστοσελίδες, brands και καμπάνιες που σχεδιάσαμε και υλοποιήσαμε. Πάτα σε ένα έργο για να δεις όλη την ιστορία πίσω του.' ),
	pg_section( 'pg-works', array(
		pg_heading( 'Όλα τα έργα', 'h2', 'pg-sr-only' ),
		pg_w( 'jet-smart-filters-radio', array(
			'filter_id'        => array( (string) $filter_id ),
			'content_provider' => 'jet-engine',
			'apply_type'       => 'ajax',
			'apply_on'         => 'value',
			'query_id'         => 'erga',
			'show_label'       => '',
			'show_decorator'   => '',
			'_css_classes'     => 'pg-filter',
		) ),
		pg_listing_grid( $L['project'], 3, 2, 1, 12, $q_order, 'pg-projects fx-hex fx-tilt', 'erga' ),
	), array( 'padding' => pg_box( 8, 24, 96, 24 ), 'flex_gap' => pg_gap( 32 ) ) ),
	pg_cta( 'Το επόμενο project μπορεί να είναι το δικό σου.', 'Έχεις μια ιδέα; Ας τη μετατρέψουμε μαζί σε κάτι που θα ξεχωρίζει.' ),
);
$works_id = pg_page( 'Οι δουλειές μας', 'oi-doulies-mas', $works_page, 2 );

/* ---- Ποιοι είμαστε ---- */

$value_boxes = array();
foreach ( pg_values() as $v ) {
	$value_boxes[] = pg_feature( $v[0], $v[1], $v[2] );
}
$about_page = array(
	pg_page_hero( 'Σχετικά με εμάς', 'Ποιοι είμαστε', 'Ένα δημιουργικό studio με εξερευνητικό πνεύμα και μία αποστολή: να κάνουμε την ψηφιακή σου παρουσία να λάμπει.' ),
	pg_section( 'pg-story', array(
		pg_row( array(
			pg_col( array(
				pg_eyebrow( 'Η ιστορία μας' ),
				pg_heading( 'Κάθε δυνατό brand έχει πολλές πλευρές.', 'h2' ),
				pg_text( pg_about_story(), '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'lead' ) ) ) ),
			), 55 ),
			pg_col( array(
				pg_w( 'html', array( 'html' => '<div class="pg-emblem fx-draw" aria-hidden="true">' . pg_hex_svg( true ) . '</div>' ) ),
			), 45, 'pg-story__emblem' ),
		) ),
	), array( 'padding' => pg_box( 40, 24, 96, 24 ) ) ),
	pg_section( 'pg-values pg-section--alt', array(
		pg_intro( 'Οι αξίες μας', 'Αυτά που δεν αλλάζουν.' ),
		pg_grid( 3, 1, 1, $value_boxes, 'pg-values__grid', 24 ),
	) ),
	pg_section( 'pg-testimonials', array(
		pg_intro( 'Τι λένε οι πελάτες μας', 'Σχέσεις που κρατάνε.' ),
		pg_listing_grid( $L['testimonial'], 3, 1, 1, 3, $q_order, 'pg-quotes' ),
	) ),
	pg_cta( 'Ας γνωριστούμε.', 'Ένας καφές (ή ένα video call) είναι αρκετός για να δούμε πώς μπορούμε να σε βοηθήσουμε.' ),
);
$about_id = pg_page( 'Ποιοι είμαστε', 'poioi-eimaste', $about_page, 3 );

/* ---- Επικοινωνία ---- */

$info_boxes = array();
foreach ( pg_contact_info() as $c ) {
	$info_boxes[] = pg_feature( $c[0], $c[1], $c[2], 'left', false );
}
$contact_page = array(
	pg_page_hero( 'Επικοινωνία', 'Ας ξεκινήσουμε κάτι μαζί.', 'Πες μας για το project σου και θα σου απαντήσουμε το συντομότερο δυνατό, συνήθως μέσα στην ίδια εργάσιμη.' ),
	pg_section( 'pg-contact', array(
		pg_row( array(
			pg_col( array(
				pg_heading( 'Στοιχεία επικοινωνίας', 'h2', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(26px, 3vw, 34px)', 'custom' ) ) ),
				pg_lead( '<p>Προτιμάς να μιλήσουμε απευθείας; Στείλε email ή πάρε μας τηλέφωνο.</p>' ),
				pg_c( array( 'flex_gap' => pg_gap( 16 ), 'css_classes' => 'pg-contact-list' ), $info_boxes ),
			), 38 ),
			pg_col( array(
				pg_w( 'jet-form-builder-form', array( 'form_id' => (string) $form_id, 'submit_type' => 'ajax', 'fields_layout' => 'column', 'fields_label_tag' => 'label', 'required_mark' => '*' ) ),
			), 62, 'pg-form-card' ),
		), '', 48, 'flex-start' ),
	), array( 'padding' => pg_box( 24, 24, 120, 24 ) ) ),
);
$contact_id = pg_page( 'Επικοινωνία', 'epikoinwnia', $contact_page, 4 );

/* ---- Ζήτα προσφορά ---- */

$quote_steps = array();
foreach ( pg_quote_steps() as $i => $st ) {
	$quote_steps[] = pg_feature( $st[0], sprintf( '%d. %s', $i + 1, $st[1] ), $st[2], 'left', false );
}
$quote_page = array(
	pg_page_hero( 'Ζήτα προσφορά', 'Ας δούμε τι χρειάζεσαι.', 'Τρία σύντομα βήματα και έχουμε όλα όσα χρειαζόμαστε για να σου ετοιμάσουμε μια ξεκάθαρη πρόταση.' ),
	pg_section( 'pg-quote-page', array(
		pg_row( array(
			pg_col( array(
				pg_heading( 'Τι γίνεται μετά', 'h2', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(26px, 3vw, 34px)', 'custom' ) ) ),
				pg_c( array( 'flex_gap' => pg_gap( 20 ), 'css_classes' => 'pg-contact-list' ), $quote_steps ),
				pg_text( '<p>Προτιμάς να γράψεις ελεύθερα; <a href="/epikoinwnia/">Στείλε μας μήνυμα</a> ή άνοιξε το chat κάτω δεξιά.</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ), 'text_color' => pg_gc( 'muted' ) ) ) ),
			), 36 ),
			pg_col( array(
				pg_w( 'jet-form-builder-form', array( 'form_id' => (string) $quote_form_id, 'submit_type' => 'ajax', 'fields_layout' => 'column', 'fields_label_tag' => 'label', 'required_mark' => '*', 'enable_progress' => 'yes' ) ),
			), 64, 'pg-form-card pg-form-card--steps' ),
		), '', 48, 'flex-start' ),
	), array( 'padding' => pg_box( 24, 24, 120, 24 ) ) ),
);
$quote_id = pg_page( 'Ζήτα προσφορά', 'prosfora', $quote_page, 5 );

/* ---- Blog (posts page; rendered by the "Blog — archive" template) ---- */

$blog_id = pg_page( 'Blog', 'blog', array(), 6 );
update_option( 'page_for_posts', $blog_id );

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home_id );

/* ================================================================== Menus */

/** $items = [ [title, page_id|url, (children)], … ] */
function pg_menu( $name, array $items, $menu_id = 0, $parent = 0 ) {
	if ( ! $menu_id ) {
		$menu = wp_get_nav_menu_object( $name );
		if ( $menu ) {
			wp_delete_nav_menu( $menu->term_id );
		}
		$menu_id = wp_create_nav_menu( $name );
	}
	foreach ( $items as $item ) {
		$args = array( 'menu-item-status' => 'publish', 'menu-item-parent-id' => $parent, 'menu-item-title' => $item[0] );
		if ( is_int( $item[1] ) ) {
			$args += array( 'menu-item-object' => 'page', 'menu-item-object-id' => $item[1], 'menu-item-type' => 'post_type' );
		} else {
			$args += array( 'menu-item-type' => 'custom', 'menu-item-url' => $item[1] );
		}
		$item_id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( ! empty( $item[2] ) ) {
			pg_menu( $name, $item[2], $menu_id, $item_id );
		}
	}
	return $menu_id;
}

$service_items = array();
foreach ( pg_service_pages() as $key => $d ) {
	$service_items[] = array( $d['menu'], $service_page_ids[ $key ] );
}
$main_menu     = pg_menu( 'Κύριο μενού', array( array( 'Τι κάνουμε', $svc_id, $service_items ), array( 'Οι δουλειές μας', $works_id ), array( 'Ποιοι είμαστε', $about_id ), array( 'Blog', $blog_id ), array( 'Επικοινωνία', $contact_id ) ) );
$services_menu = pg_menu( 'Footer · Υπηρεσίες', array_merge( $service_items, array( array( 'Πακέτα & τιμές', '/ti-kanoume/#paketa' ) ) ) );
set_theme_mod( 'nav_menu_locations', array( 'main' => $main_menu ) );

/* ============================================== Theme Builder templates */

function pg_jtc_template( $title, $type, array $data ) {
	$id = wp_insert_post( array(
		'post_type' => 'jet-theme-core', 'post_status' => 'publish', 'post_title' => $title,
		'meta_input' => array( '_jet_template_conditions' => array(), '_jet_template_content_type' => 'elementor', '_jet_template_type' => $type ),
	) );
	wp_set_object_terms( $id, $type, 'jet_library_type' );
	pg_save_elementor( $id, $data, $type );
	return $id;
}

function pg_logo() {
	return pg_w( 'jet-logo', array( 'logo_type' => 'both', 'logo_image_from' => 'from_site_logo', 'logo_text_from' => 'custom', 'logo_text' => 'POLYGONS', 'logo_display' => 'inline', '_css_classes' => 'pg-logo' ) );
}

/**
 * Header / footer per language ($t = strings). Polylang + JetThemeCore swap in the translated
 * template automatically on /en/ pages.
 */
function pg_header_tpl( $title, $menu, array $t ) {
	return pg_jtc_template( $title, 'jet_header', array(
		pg_c( array(
			'content_width' => 'boxed', 'flex_direction' => 'row', 'flex_align_items' => 'center', 'flex_justify_content' => 'space-between',
			'flex_gap' => pg_gap( 24 ), 'flex_wrap' => 'nowrap', 'css_classes' => 'pg-header', 'padding' => pg_box( 18, 24, 18, 24 ), 'padding_mobile' => pg_box( 14, 20, 14, 20 ),
		), array(
			pg_logo(),
			pg_c( array( 'flex_direction' => 'row', 'flex_align_items' => 'center', 'flex_gap' => pg_gap( 20 ), 'flex_gap_mobile' => pg_gap( 10 ), 'padding' => pg_all( 0 ), 'css_classes' => 'pg-header__right' ), array(
				pg_w( 'jet-nav-menu', array( 'nav_menu' => (string) $menu, 'layout' => 'horizontal', 'mobile_trigger_visible' => 'yes', 'mobile_trigger_devices' => 'tablet', 'mobile_menu_layout' => 'right-side', '_css_classes' => 'pg-nav' ) ),
				pg_text( '[pg_lang_switch]', 'pg-lang' ),
				pg_button( $t['cta'], $t['cta_url'], 'primary', false, array( 'size' => 'sm', 'button_padding' => pg_box( 12, 20, 12, 20 ), 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 15 ), '_css_classes' => 'pg-btn pg-btn--primary pg-header__cta', 'hide_mobile' => 'hidden-mobile' ) ),
			) ),
		), false ),
	) );
}

function pg_footer_tpl( $title, $main_menu, $services_menu, array $t ) {
	return pg_jtc_template( $title, 'jet_footer', array(
		pg_c( array( 'content_width' => 'boxed', 'flex_gap' => pg_gap( 48 ), 'css_classes' => 'pg-footer', 'padding' => pg_box( 80, 24, 32, 24 ), 'padding_mobile' => pg_box( 56, 20, 24, 20 ) ), array(
			pg_c( array(
				'container_type' => 'grid', 'grid_columns_grid' => array( 'unit' => 'custom', 'size' => '2fr 1fr 1fr 1.3fr' ),
				'grid_columns_grid_tablet' => pg_size( 2, 'fr' ), 'grid_columns_grid_mobile' => pg_size( 1, 'fr' ), 'grid_rows_grid' => pg_size( 1, 'fr' ), 'grid_gaps' => pg_gap( 40 ),
			), array(
				pg_c( array( 'flex_gap' => pg_gap( 16 ) ), array(
					pg_logo(),
					pg_text( '<p>' . $t['about'] . '</p>', 'pg-footer__about', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ), 'text_color' => pg_gc( 'muted' ) ) ) ),
				) ),
				pg_c( array( 'flex_gap' => pg_gap( 16 ) ), array(
					pg_eyebrow( $t['nav'] ),
					pg_w( 'jet-nav-menu', array( 'nav_menu' => (string) $main_menu, 'layout' => 'vertical', 'mobile_trigger_visible' => '', '_css_classes' => 'pg-footer__menu' ) ),
				) ),
				pg_c( array( 'flex_gap' => pg_gap( 16 ) ), array(
					pg_eyebrow( $t['services'] ),
					pg_w( 'jet-nav-menu', array( 'nav_menu' => (string) $services_menu, 'layout' => 'vertical', 'mobile_trigger_visible' => '', '_css_classes' => 'pg-footer__menu' ) ),
				) ),
				pg_c( array( 'flex_gap' => pg_gap( 16 ) ), array(
					pg_eyebrow( $t['contact'] ),
					pg_text( '<p><a href="mailto:info@polygons.gr">info@polygons.gr</a><br><a href="tel:+302100000000">+30 210 000 0000</a></p>', 'pg-footer__contact', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ) ) ) ),
					pg_button( $t['start'], $t['cta_url'], 'ghost', true ),
				) ),
			) ),
			pg_w( 'html', array( 'html' => '<button type="button" class="pg-chat" data-tawk="6abd4b04fd2d7034457f3282/1k3pmq2dh" aria-label="' . esc_attr( $t['chat'] ) . '"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H9l-5 4v-4H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/></svg><span>Chat</span></button>', '_css_classes' => 'pg-chat-widget' ) ),
			pg_text( '<p>© [pg_year] Polygons Studio. ' . $t['rights'] . '</p>', 'pg-footer__bottom', array( 'align' => 'center', '__globals__' => array( 'typography_typography' => pg_gt( 'small' ), 'text_color' => pg_gc( 'muted' ) ) ) ),
		), false ),
	) );
}

$header_id = pg_header_tpl( 'Header', $main_menu, array( 'cta' => 'Ζήτα προσφορά', 'cta_url' => '/prosfora/' ) );
$footer_id = pg_footer_tpl( 'Footer', $main_menu, $services_menu, array(
	'about' => 'Graphic &amp; web services, all in one. Σχεδιάζουμε, χτίζουμε, φιλοξενούμε και προωθούμε brands που ξεχωρίζουν.',
	'nav' => 'Πλοήγηση', 'services' => 'Υπηρεσίες', 'contact' => 'Επικοινωνία', 'start' => 'Ξεκίνα ένα project', 'cta_url' => '/prosfora/',
	'chat' => 'Άνοιξε το chat', 'rights' => 'Με επιφύλαξη παντός δικαιώματος.',
) );

/* ---- Single: Έργο ---- */

/** Project single template (strings per language). */
function pg_project_single_data( array $t, array $L, array $q_order ) {
	$meta_chip = function ( $label, $key ) {
		return pg_c( array( 'flex_gap' => pg_gap( 4 ), 'css_classes' => 'pg-meta' ), array(
			pg_heading( $label, 'p', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'accent' ), 'title_color' => pg_gc( 'muted' ) ) ) ),
			pg_dyn( 'meta:' . $key, 'p', 'pg-meta__value' ),
		) );
	};
	$story_col = function ( $label, $key ) {
		return pg_card( array(
			pg_eyebrow( $label ),
			pg_dyn( 'meta:' . $key, 'div', '', array( 'dynamic_field_filter' => 'yes', 'filter_callback' => 'wpautop' ) ),
		), 'pg-story-card' );
	};
	return array(
		pg_section( 'pg-page-hero pg-project-hero', array(
			pg_c( array( 'flex_gap' => pg_gap( 16 ), 'flex_align_items' => 'center' ), array(
				pg_breadcrumbs(),
				pg_w( 'jet-listing-dynamic-terms', array( 'from_tax' => 'project_cat', 'terms_linked' => '', 'terms_delimiter' => ' · ', 'terms_alignment' => 'center', '_css_classes' => 'pg-tag' ) ),
				pg_dyn( 'post_title', 'h1', 'pg-project-hero__title', array( 'field_alignment' => 'center' ) ),
				pg_dyn( 'post_excerpt', 'p', '', array( 'field_alignment' => 'center', '_element_width' => 'initial', '_element_custom_width' => pg_size( 720 ), '_element_custom_width_mobile' => pg_size( 100, '%' ), '__globals__' => array( 'field_typography_typography' => pg_gt( 'lead' ) ) ) ),
			) ),
			pg_grid( 4, 2, 2, array( $meta_chip( $t['client'], 'client' ), $meta_chip( $t['year'], 'year' ), $meta_chip( $t['services'], 'services' ), $meta_chip( $t['result'], 'highlight' ) ), 'pg-meta-row', 16 ),
			pg_w( 'jet-listing-dynamic-image', array( 'dynamic_image_source' => 'post_thumbnail', 'dynamic_image_size' => 'full', 'linked_image' => '', 'lazy_load_image' => '', '_css_classes' => 'pg-project-hero__img' ) ),
		), array( 'padding' => pg_box( 160, 24, 40, 24 ), 'padding_mobile' => pg_box( 130, 20, 32, 20 ), 'flex_gap' => pg_gap( 40 ) ) ),
		pg_section( 'pg-project-story', array(
			pg_grid( 3, 1, 1, array( $story_col( $t['challenge'], 'challenge' ), $story_col( $t['solution'], 'solution' ), $story_col( $t['outcome'], 'result' ) ), '', 20 ),
			pg_dyn( 'post_content', 'div', 'pg-prose' ),
			pg_dyn( 'meta:gallery', 'div', 'pg-gallery', array( 'dynamic_field_filter' => 'yes', 'filter_callback' => 'jet_engine_img_gallery_grid', 'img_gallery_cols' => 2, 'img_gallery_size' => 'large', 'img_gallery_lightbox' => '' ) ),
		), array( 'padding' => pg_box( 40, 24, 80, 24 ), 'flex_gap' => pg_gap( 40 ) ) ),
		pg_section( 'pg-more', array(
			pg_c( array( 'flex_direction' => 'row', 'flex_direction_mobile' => 'column', 'flex_justify_content' => 'space-between', 'flex_align_items' => 'flex-end', 'flex_gap' => pg_gap( 24 ) ), array(
				pg_intro( $t['more_eyebrow'], $t['more_title'], '', 'left' ),
				pg_button( $t['all'], $t['all_url'], 'ghost', true ),
			) ),
			pg_listing_grid( $L['project'], 3, 2, 1, 3, array_merge( $q_order, array( array( '_id' => pg_id(), 'type' => 'posts_params', 'posts_not_in' => '%current_id%' ) ) ), 'pg-projects fx-hex fx-tilt' ),
		), array( 'padding' => pg_box( 40, 24, 80, 24 ) ) ),
		pg_cta( $t['cta_title'], $t['cta_text'], $t['cta'], $t['cta_url'] ),
	);
}
$single_id = pg_jtc_template( 'Έργο — single', 'jet_single', pg_project_single_data( array(
	'client' => 'Πελάτης', 'year' => 'Έτος', 'services' => 'Υπηρεσίες', 'result' => 'Αποτέλεσμα',
	'challenge' => 'Η πρόκληση', 'solution' => 'Η λύση', 'outcome' => 'Το αποτέλεσμα',
	'more_eyebrow' => 'Κι άλλα έργα', 'more_title' => 'Συνέχισε την εξερεύνηση.', 'all' => 'Όλα τα έργα', 'all_url' => '/oi-doulies-mas/',
	'cta_title' => 'Σου άρεσε αυτό που είδες;', 'cta_text' => 'Ας φτιάξουμε κάτι αντίστοιχο (ή ακόμα καλύτερο) για τη δική σου επιχείρηση.', 'cta' => 'Ζήτα προσφορά', 'cta_url' => '/prosfora/',
), $L, $q_order ) );

/* ---- Blog: archive (posts page + categories) and single post ---- */

/** Blog archive template (posts page + categories). */
function pg_blog_archive_data( array $t, array $L ) {
	return array(
		pg_section( 'pg-page-hero', array(
			pg_breadcrumbs(),
			pg_c( array( 'css_classes' => 'pg-intro', 'flex_gap' => pg_gap( 16 ), 'flex_align_items' => 'center' ), array(
				pg_eyebrow( 'Blog', 'center' ),
				pg_text( '<h1>[pg_archive_title]</h1>', 'pg-archive-title', array( 'align' => 'center' ) ),
				pg_lead( '<p>' . $t['lead'] . '</p>', 'center' ),
			) ),
			pg_text( '[pg_blog_cats]', 'pg-subnav', array( 'align' => 'center' ) ),
		), array( 'padding' => pg_box( 160, 24, 40, 24 ), 'padding_mobile' => pg_box( 124, 20, 32, 20 ), 'flex_gap' => pg_gap( 28 ) ) ),
		pg_section( 'pg-blog', array(
			pg_heading( $t['list_h'], 'h2', 'pg-sr-only' ),
			pg_w( 'jet-listing-grid', array( 'lisitng_id' => (string) $L['post'], 'columns' => '3', 'columns_tablet' => '2', 'columns_mobile' => '1', 'is_archive_template' => 'yes', 'horizontal_gap' => pg_size( 24 ), 'vertical_gap' => pg_size( 24 ), 'equal_columns_height' => 'yes', 'not_found_message' => $t['none'], '_css_classes' => 'pg-projects fx-stagger' ) ),
			pg_text( '[pg_pagination]', 'pg-pagination' ),
		), array( 'padding' => pg_box( 24, 24, 96, 24 ), 'flex_gap' => pg_gap( 40 ) ) ),
		pg_cta( $t['cta_title'], $t['cta_text'], $t['cta'], $t['cta_url'] ),
	);
}
$archive_id = pg_jtc_template( 'Blog — archive', 'jet_archive', pg_blog_archive_data( array(
	'lead' => 'Πρακτικοί οδηγοί για ιστοσελίδες, SEO, hosting και εταιρική ταυτότητα. Χωρίς τεχνική ορολογία, με ό,τι χρειάζεται για να πάρεις σωστές αποφάσεις.',
	'list_h' => 'Άρθρα', 'none' => 'Δεν υπάρχουν ακόμα άρθρα εδώ.',
	'cta_title' => 'Προτιμάς να το αναλάβουμε εμείς;', 'cta_text' => 'Πες μας τι χρειάζεσαι και θα σου προτείνουμε τον πιο έξυπνο δρόμο.', 'cta' => 'Ζήτα προσφορά', 'cta_url' => '/prosfora/',
), $L ) );

/** Single post template. */
function pg_post_single_data( array $t, array $L ) {
	return array(
		pg_section( 'pg-page-hero pg-post-hero', array(
			pg_breadcrumbs(),
			pg_c( array( 'flex_gap' => pg_gap( 16 ), 'flex_align_items' => 'center' ), array(
				pg_w( 'jet-listing-dynamic-terms', array( 'from_tax' => 'category', 'terms_linked' => 'yes', 'terms_delimiter' => ' · ', 'terms_alignment' => 'center', '_css_classes' => 'pg-tag' ) ),
				pg_dyn( 'post_title', 'h1', 'pg-post-hero__title', array( 'field_alignment' => 'center' ) ),
				pg_text( '[pg_post_meta]', 'pg-post-meta', array( 'align' => 'center' ) ),
			) ),
			pg_w( 'jet-listing-dynamic-image', array( 'dynamic_image_source' => 'post_thumbnail', 'dynamic_image_size' => 'large', 'linked_image' => '', 'lazy_load_image' => '', '_css_classes' => 'pg-post-hero__img' ) ),
		), array( 'padding' => pg_box( 160, 24, 24, 24 ), 'padding_mobile' => pg_box( 124, 20, 16, 20 ), 'flex_gap' => pg_gap( 32 ) ) ),
		pg_section( 'pg-article', array(
			pg_dyn( 'post_content', 'div', 'pg-prose pg-prose--article' ),
		), array( 'padding' => pg_box( 24, 24, 80, 24 ) ) ),
		pg_section( 'pg-more pg-section--alt', array(
			pg_c( array( 'flex_direction' => 'row', 'flex_direction_mobile' => 'column', 'flex_justify_content' => 'space-between', 'flex_align_items' => 'flex-end', 'flex_gap' => pg_gap( 24 ) ), array(
				pg_intro( 'Blog', $t['more_title'], '', 'left' ),
				pg_button( $t['all'], $t['all_url'], 'ghost', true ),
			) ),
			pg_listing_grid( $L['post'], 3, 2, 1, 3, array( array( '_id' => pg_id(), 'type' => 'posts_params', 'posts_not_in' => '%current_id%' ) ), 'pg-projects' ),
		), array( 'padding' => pg_box( 96, 24, 80, 24 ) ) ),
		pg_cta( $t['cta_title'], $t['cta_text'], $t['cta'], $t['cta_url'] ),
	);
}
$post_single_id = pg_jtc_template( 'Άρθρο — single', 'jet_single', pg_post_single_data( array(
	'more_title' => 'Διάβασε ακόμα.', 'all' => 'Όλα τα άρθρα', 'all_url' => '/blog/',
	'cta_title' => 'Θέλεις να το δούμε για το δικό σου site;', 'cta_text' => 'Στείλε μας τι χρειάζεσαι και θα σου απαντήσουμε με συγκεκριμένη πρόταση.', 'cta' => 'Ζήτα προσφορά', 'cta_url' => '/prosfora/',
), $L ) );

/* ---- 404 ---- */

$notfound_id = pg_jtc_template( '404', 'jet_page', array(
	pg_section( 'pg-page-hero pg-404 fx-neon-on', array(
		pg_w( 'html', array( 'html' => '<div class="pg-404__hex fx-draw" aria-hidden="true">' . pg_hex_svg( true ) . '</div>' ) ),
		pg_intro( 'Σφάλμα 404', 'Αυτή η σελίδα<br><span class="pg-neon">δεν υπάρχει.</span>', 'Ίσως άλλαξε διεύθυνση ή γράφτηκε λάθος. Δες από εδώ πού μπορείς να πας:', 'center', 'h1' ),
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 12 ) ), array(
			pg_button( 'Αρχική', '/', 'primary' ),
			pg_button( 'Τι κάνουμε', '/ti-kanoume/', 'ghost', false ),
			pg_button( 'Οι δουλειές μας', '/oi-doulies-mas/', 'ghost', false ),
			pg_button( 'Blog', '/blog/', 'ghost', false ),
			pg_button( 'Επικοινωνία', '/epikoinwnia/', 'ghost', false ),
		) ),
	), array( 'min_height' => pg_size( 80, 'vh' ), 'flex_justify_content' => 'center', 'flex_align_items' => 'center', 'flex_gap' => pg_gap( 28 ) ) ),
) );

/* ---- Page templates (conditions) ---- */

$layout = function ( $body ) use ( $header_id, $footer_id ) {
	return array(
		'header' => array( 'id' => $header_id, 'enabled' => true, 'override' => true ),
		'body'   => array( 'id' => $body, 'enabled' => true, 'override' => true ),
		'footer' => array( 'id' => $footer_id, 'enabled' => true, 'override' => true ),
	);
};
$all_conditions = array();
foreach ( array(
	array( 'Polygons — Entire site', array( array( 'id' => 'pg-entire', 'include' => 'true', 'group' => 'entire', 'subGroup' => 'entire', 'subGroupValue' => '', 'priority' => 100 ) ), false ),
	array( 'Polygons — Έργα single', array( array( 'id' => 'pg-projects-single', 'include' => 'true', 'group' => 'singular', 'subGroup' => 'cpt-single-projects', 'subGroupValue' => array( 'all' ), 'priority' => 28 ) ), $single_id ),
	array( 'Polygons — Blog archive', array( array( 'id' => 'pg-blog-archive', 'include' => 'true', 'group' => 'archive', 'subGroup' => 'archive-all-post', 'subGroupValue' => '', 'priority' => 10 ) ), $archive_id ),
	array( 'Polygons — 404', array( array( 'id' => 'pg-404', 'include' => 'true', 'group' => 'singular', 'subGroup' => 'singular-404', 'subGroupValue' => '', 'priority' => 5 ) ), $notfound_id ),
	array( 'Polygons — Άρθρο single', array( array( 'id' => 'pg-post-single', 'include' => 'true', 'group' => 'singular', 'subGroup' => 'singular-post', 'subGroupValue' => array( 'all' ), 'priority' => 30 ) ), $post_single_id ),
) as $pt_def ) {
	$pt = wp_insert_post( array(
		'post_type' => 'jet-page-template', 'post_status' => 'publish', 'post_title' => $pt_def[0],
		'meta_input' => array( '_conditions' => $pt_def[1], '_relation_type' => 'or', '_type' => 'unassigned', '_layout' => $layout( $pt_def[2] ), '_pg_build' => 1 ),
	) );
	$all_conditions[ $pt ] = array( 'conditions' => $pt_def[1], 'relation_type' => 'or' );
}
update_option( jet_theme_core()->theme_builder->page_templates_manager->page_template_conditions_option_key, $all_conditions, true );

/* ============================================================ English (Polylang) */

require __DIR__ . '/en.php';

/* ============================================================ SEO (Rank Math) */

// Only the modules we use (no analytics/AI/link counter → less admin & DB work).
update_option( 'rank_math_modules', array( 'sitemap', 'rich-snippet', 'redirections', 'seo-analysis' ) );
\RankMath\Installer::create_tables( array( 'redirections' ) ); // module enabled by option → create its tables ourselves
$rm_logo = pg_asset( $assets . 'logo-512.png', 'Polygons logo (PNG)', 'Polygons' );
$rm_og   = pg_asset( $assets . 'og-default.jpg', 'Polygons — social image', 'Polygons: ιστοσελίδες, branding, hosting & SEO' );
$rm_hide = array( 'jet-theme-core', 'jet-engine', 'e-floating-buttons', 'jet-form-builder', 'elementor_library' );

$titles = array_merge( get_option( 'rank-math-options-titles', array() ), array(
	'title_separator'              => '|',
	'knowledgegraph_type'          => 'company',
	'knowledgegraph_name'          => 'Polygons',
	'website_name'                 => 'Polygons',
	'website_alternate_name'       => 'Polygons Studio',
	'knowledgegraph_logo'          => wp_get_attachment_url( $rm_logo ),
	'knowledgegraph_logo_id'       => $rm_logo,
	'open_graph_image'             => wp_get_attachment_url( $rm_og ),
	'open_graph_image_id'          => $rm_og,
	'local_business_type'          => 'Organization',
	'email'                        => PG_NOTIFY_EMAIL,
	'url'                          => home_url( '/' ),
	'disable_author_archives'      => 'on', // one-team studio: no author pages
	'pt_page_title'                => '%title% %sep% %sitename%',
	'pt_page_default_rich_snippet' => 'off',
	'pt_post_title'                => '%title% %sep% %sitename%',
	'pt_post_description'          => '%excerpt%',
	'pt_projects_title'            => '%title% %sep% %sitename%', // same pattern in every language
	'pt_projects_description'      => '%excerpt%',
	'pt_projects_default_rich_snippet' => 'off',
	'404_title'                    => 'Η σελίδα δεν βρέθηκε %sep% %sitename%',
	'tax_category_title'           => '%term% %sep% Blog %sep% %sitename%',
	'tax_category_description'     => 'Άρθρα για %term%: πρακτικοί οδηγοί και συμβουλές από την ομάδα του Polygons.',
) );
foreach ( $rm_hide as $pt ) {
	$titles[ "pt_{$pt}_custom_robots" ] = 'on';
	$titles[ "pt_{$pt}_robots" ]        = array( 'noindex', 'nofollow' );
	$titles[ "pt_{$pt}_add_meta_box" ]  = 'off';
}
update_option( 'rank-math-options-titles', $titles );

update_option( 'rank-math-options-general', array_merge( get_option( 'rank-math-options-general', array() ), array(
	'breadcrumbs'                => 'on',
	'breadcrumbs_separator'      => '›',
	'breadcrumbs_home'           => 'on',
	'breadcrumbs_home_label'     => 'Αρχική',
	'breadcrumbs_blog_page'      => 'on',
	'breadcrumbs_archive_format' => '%s',
	'breadcrumbs_search_format'  => 'Αναζήτηση: %s',
	'breadcrumbs_404_label'      => 'Η σελίδα δεν βρέθηκε',
	'new_window_external_links'  => 'off', // don't hijack the visitor's tab
	'frontend_seo_score'         => 'off',
	'content_ai_post_types'      => array(),
	'llms_post_types'            => array( 'post', 'page', 'projects' ),
) ) );

$sitemap = array_merge( get_option( 'rank-math-options-sitemap', array() ), array(
	'authors_sitemap'      => 'off',
	'html_sitemap'         => 'off',
	'tax_category_sitemap' => 'on',
	'pt_projects_sitemap'  => 'on',
) );
foreach ( $rm_hide as $pt ) {
	$sitemap[ "pt_{$pt}_sitemap" ] = 'off';
}
update_option( 'rank-math-options-sitemap', $sitemap );
update_option( 'rank_math_registration_skip', true ); // same as "Skip" in the wizard: works without a Rank Math account
update_option( 'rank_math_wizard_completed', true );

\RankMath\Sitemap\Cache::invalidate_storage(); // sitemap is cached — rebuild it with the new pages/languages
flush_rewrite_rules( false );
\Elementor\Plugin::$instance->files_manager->clear_cache();
WP_CLI::success( sprintf( 'Built pages %s, quote %d, listings %s, form %d, filter %d, single %d', implode( ',', array( $home_id, $svc_id, $works_id, $about_id, $contact_id ) ), $quote_id, implode( ',', $L ), $form_id, $filter_id, $single_id ) );
