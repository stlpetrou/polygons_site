<?php
/**
 * Effects Lab page (/effects-lab/). Run from app/public:
 *   wp eval-file ../../build/effects-lab.php --user=1
 * Touches only the lab page (meta _pg_lab). Each demo is labelled with its number (#1–#17).
 */

require __DIR__ . '/lib.php';
require __DIR__ . '/content.php';

foreach ( get_posts( array( 'post_type' => 'page', 'post_status' => 'any', 'meta_key' => '_pg_lab', 'numberposts' => -1, 'fields' => 'ids' ) ) as $old ) {
	wp_delete_post( $old, true );
}

$att = function ( $file ) {
	$ids = get_posts( array( 'post_type' => 'attachment', 'meta_key' => '_pg_asset', 'meta_value' => $file, 'fields' => 'ids', 'numberposts' => 1 ) );
	return $ids ? $ids[0] : 0;
};
$listing = function ( $title ) {
	$p = get_posts( array( 'post_type' => 'jet-engine', 'title' => $title, 'numberposts' => 1, 'fields' => 'ids' ) );
	return $p ? $p[0] : 0;
};
$live  = array( 1, 2, 3, 4, 5, 8, 10, 11, 12, 13, 14 );
$label = function ( $n, $name, $cost ) use ( $live ) {
	$on = in_array( $n, $live, true );
	return pg_heading( '#' . $n . ' · ' . $name . ' · ' . $cost . ( $on ? ' · ✓ στο site' : '' ), 'p', 'fx-label' . ( $on ? ' fx-label--live' : '' ) );
};
$q_order = array( array( '_id' => pg_id(), 'type' => 'order_offset', 'order_by' => 'menu_order', 'order' => 'ASC' ) );

$hex_svg = pg_hex_svg( true );

/* ---------- Services as stack cards (#5) ---------- */
$stack = array();
$imgs  = array( 'web' => 'webdesign.webp', 'branding' => 'graphics.webp', 'hosting' => 'hosting.webp', 'marketing' => 'marketing.webp' );
foreach ( pg_services() as $key => $s ) {
	$stack[] = pg_c( array_merge( pg_card_style( 40, 28 ), array(
		'flex_direction' => 'row', 'flex_direction_mobile' => 'column', 'flex_align_items' => 'center', 'flex_gap' => pg_gap( 40 ),
		'min_height' => pg_size( 360 ), 'css_classes' => 'fx-stack-card',
	) ), array(
		pg_col( array(
			pg_heading( $s['n'], 'p', 'pg-service__num' ),
			pg_heading( $s['title'], 'h3', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(26px, 3vw, 38px)', 'custom' ) ) ),
			pg_lead( '<p>' . $s['short'] . '</p>' ),
		), 55 ),
		pg_col( array( pg_image( $att( $imgs[ $key ] ), '', 'medium_large' ) ), 45 ),
	) );
}

/* ---------- Steps (#7) ---------- */
$steps = array();
foreach ( pg_steps() as $i => $st ) {
	$steps[] = pg_card( array(
		pg_heading( sprintf( '%02d', $i + 1 ), 'p', 'pg-step__num' ),
		pg_heading( $st[0], 'h3' ),
		pg_text( '<p>' . $st[1] . '</p>' ),
	), 'pg-step', array( 'padding' => pg_box( 32, 28, 32, 28 ) ) );
}

/* ---------- Counters (#15) ---------- */
$counters = array();
foreach ( array( array( 120, '+', 'Έργα (δείγμα)' ), array( 12, '', 'Χρόνια εμπειρίας (δείγμα)' ), array( 99.9, '%', 'Uptime hosting (δείγμα)' ), array( 48, 'h', 'Μέση παράδοση προσφοράς (δείγμα)' ) ) as $c ) {
	$counters[] = pg_w( 'counter', array( 'starting_number' => 0, 'ending_number' => $c[0], 'suffix' => $c[1], 'title' => $c[2], 'duration' => 1800, 'thousand_separator' => '', '_css_classes' => 'fx-counter' ) );
}

$data = array(
	// Chrome: reading progress (#9) + smart header marker (#14)
	pg_c( array( 'css_classes' => 'fx-chrome' ), array(
		pg_w( 'html', array( 'html' => '<div class="fx-read" aria-hidden="true"></div><div class="fx-smart-header" hidden></div>' ) ),
	), false ),

	// #1 #2 #3 Hero
	pg_section( 'pg-hero fx-mesh fx-neon-on', array(
		pg_w( 'html', array( 'html' => '<div class="pg-hero__deco fx-draw" aria-hidden="true">' . $hex_svg . '</div>' ) ),
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 8 ) ), array(
			$label( 1, 'Ζωντανό πλέγμα (κούνησε το ποντίκι)', 'JS ~1.5KB' ),
			$label( 2, 'Neon που ανάβει', 'CSS' ),
			$label( 3, 'Το λογότυπο σχεδιάζεται', 'CSS' ),
		) ),
		pg_heading( '<span class="pg-hero__kicker">Effects</span><span class="pg-neon">Lab</span><span class="pg-hero__sub">Polygons motion playground</span>', 'h1', 'pg-hero__title', array( 'align' => 'center' ) ),
		pg_lead( '<p>Κάθε εφέ έχει αριθμό (#1–#17). Κάνε scroll, πέρνα το ποντίκι από πάνω, και πες μου ποια κρατάμε. Το κουμπί κάτω αριστερά σβήνει/ανάβει όλα τα εφέ για σύγκριση.</p>', 'center' ),
	), array( 'min_height' => pg_size( 100, 'vh' ), 'flex_justify_content' => 'center', 'flex_align_items' => 'center', 'flex_gap' => pg_gap( 28 ), 'padding' => pg_box( 150, 24, 110, 24 ) ) ),

	// #17 Marquee
	pg_c( array( 'content_width' => 'boxed', 'padding' => pg_box( 32, 24, 12, 24 ) ), array( $label( 17, 'Marquee που αντιδρά στο scroll (κάνε γρήγορο scroll πάνω/κάτω)', 'JS ~0.4KB' ) ), false ),
	pg_c( array( 'css_classes' => 'pg-marquee fx-velocity' ), array(
		pg_w( 'html', array( 'html' => '<div class="pg-marquee__track" aria-hidden="true">' . str_repeat( '<span>Web Design</span><span>UI / UX</span><span>Branding</span><span>Graphic Design</span><span>Hosting</span><span>SEO</span><span>Digital Marketing</span>', 2 ) . '</div>' ) ),
	), false ),

	// #6 #16 headings
	pg_section( '', array(
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 8 ) ), array(
			$label( 16, 'Κείμενο «αποκωδικοποίησης» στο eyebrow', 'JS ~0.4KB' ),
			$label( 6, 'Τίτλος λέξη-λέξη', 'JS ~0.4KB + CSS' ),
		) ),
		pg_c( array( 'flex_gap' => pg_gap( 16 ), 'flex_align_items' => 'center' ), array(
			pg_heading( 'Τι κάνουμε', 'p', 'pg-eyebrow fx-decode', array( 'align' => 'center', '__globals__' => array( 'typography_typography' => pg_gt( 'accent' ), 'title_color' => pg_gc( 'primary' ) ) ) ),
			pg_heading( 'Όλα όσα χρειάζεται το brand σου. Σε ένα studio.', 'h2', 'fx-words', array( 'align' => 'center' ) ),
		) ),
	), array( 'padding' => pg_box( 140, 24, 60, 24 ) ) ),

	// #5 Stack
	pg_section( '', array(
		$label( 5, 'Κάρτες που στοιβάζονται (scroll)', 'CSS sticky + JS ~0.3KB' ),
		pg_c( array( 'css_classes' => 'fx-stack', 'flex_gap' => pg_gap( 32 ) ), $stack ),
	), array( 'padding' => pg_box( 20, 24, 120, 24 ) ) ),

	// #7 Process
	pg_section( '', array(
		$label( 7, 'Γραμμή προόδου στη διαδικασία', 'CSS (+ scroll-linked σε Chrome/Safari)' ),
		pg_heading( 'Από την ιδέα στο launch.', 'h2', 'fx-words', array( 'align' => 'center' ) ),
		pg_grid( 4, 2, 1, $steps, 'pg-steps fx-progress', 20 ),
	), array( 'padding' => pg_box( 80, 24, 120, 24 ), 'flex_gap' => pg_gap( 56 ) ) ),

	// #8 #10 Projects
	pg_section( '', array(
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_gap' => pg_gap( 8 ) ), array(
			$label( 8, 'Εικόνες αποκαλύπτονται μέσα από εξάγωνο', 'CSS' ),
			$label( 10, 'Κλίση 3D + λάμψη στο hover', 'JS ~0.6KB · μόνο desktop' ),
		) ),
		pg_listing_grid( $listing( 'Κάρτα έργου' ), 3, 2, 1, 3, $q_order, 'pg-projects fx-hex fx-tilt' ),
	), array( 'padding' => pg_box( 40, 24, 120, 24 ), 'flex_gap' => pg_gap( 32 ) ) ),

	// #11 Packages border
	pg_section( '', array(
		$label( 11, 'Φωτεινό περίγραμμα που ακολουθεί τον κέρσορα', 'JS ~0.3KB · μόνο desktop' ),
		pg_listing_grid( $listing( 'Κάρτα πακέτου' ), 3, 1, 1, 3, array_merge( $q_order, array( array( '_id' => pg_id(), 'type' => 'meta_query', 'meta_query_key' => 'group', 'meta_query_compare' => '=', 'meta_query_val' => 'web' ) ) ), 'pg-packs fx-border' ),
	), array( 'padding' => pg_box( 40, 24, 120, 24 ), 'flex_gap' => pg_gap( 32 ) ) ),

	// #15 Counters
	pg_section( 'pg-section--alt', array(
		$label( 15, 'Αριθμοί που μετράνε (Elementor Counter)', 'Elementor widget' ),
		pg_grid( 4, 2, 1, $counters, '', 32 ),
	), array( 'padding' => pg_box( 80, 24, 80, 24 ), 'flex_gap' => pg_gap( 32 ) ) ),

	// #13 View transitions
	pg_section( '', array(
		$label( 13, 'Ομαλή μετάβαση μεταξύ σελίδων (πάτα το κουμπί)', 'CSS · native View Transitions' ),
		pg_c( array( 'css_classes' => 'fx-vt-card', 'flex_gap' => pg_gap( 20 ) ), array(
			pg_image( $att( 'project-3.webp' ), 'fx-vt-media', 'large' ),
			pg_heading( 'Ηλεκτρονικό κατάστημα για brand καλλυντικών', 'h3' ),
			pg_button( 'Άνοιξε το έργο', '?vt=1#vt', 'primary', true, array( '_css_classes' => 'pg-btn pg-btn--primary fx-vt-open' ) ),
			pg_button( 'Πίσω', '?#vt', 'ghost', false, array( '_css_classes' => 'pg-btn pg-btn--ghost fx-vt-back' ) ),
		) ),
		pg_text( '<p>Η εικόνα «ρέει» από την κάρτα στη μεγάλη θέση της νέας σελίδας αντί να αναβοσβήνει η οθόνη. Στο site θα λειτουργεί ανάμεσα σε όλες τις σελίδες (π.χ. κάρτα έργου → σελίδα έργου). Σε browsers χωρίς υποστήριξη η πλοήγηση γίνεται κανονικά.</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ), 'text_color' => pg_gc( 'muted' ) ) ) ),
	), array( 'padding' => pg_box( 100, 24, 100, 24 ), 'flex_gap' => pg_gap( 28 ) ), 'vt' ),

	// #4 #12 CTA
	pg_section( 'pg-cta', array(
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 8 ) ), array(
			$label( 4, 'Λάμψη που ακολουθεί τον κέρσορα', 'JS ~0.2KB · μόνο desktop' ),
			$label( 12, 'Μαγνητικό κουμπί', 'JS ~0.4KB · μόνο desktop' ),
		) ),
		pg_c( array(
			'css_classes' => 'pg-cta__panel fx-glow', 'flex_gap' => pg_gap( 20 ), 'flex_align_items' => 'center',
			'border_border' => 'solid', 'border_width' => pg_all( 1 ), 'border_color' => '#F1515259', 'border_radius' => pg_all( 32 ),
			'padding' => pg_box( 80, 32, 80, 32 ), 'padding_mobile' => pg_box( 48, 20, 48, 20 ),
		), array(
			pg_title_xl( 'Έτοιμοι για απογείωση;' ),
			pg_lead( '<p>Πέρνα το ποντίκι πάνω από το πλαίσιο και πλησίασε το κουμπί.</p>', 'center' ),
			pg_button( 'Ζήτα προσφορά', '/epikoinwnia/', 'primary', true, array( '_css_classes' => 'pg-btn pg-btn--primary fx-magnetic' ) ),
		) ),
	), array( 'padding' => pg_box( 40, 24, 80, 24 ), 'flex_gap' => pg_gap( 20 ) ) ),

	// #9 #14 note
	pg_section( '', array(
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 8 ) ), array(
			$label( 9, 'Μπάρα προόδου ανάγνωσης (πάνω στην οθόνη)', 'CSS' ),
			$label( 14, 'Header που κρύβεται στο scroll ↓ και εμφανίζεται στο ↑', 'JS ~0.2KB' ),
		) ),
		pg_text( '<p>Αυτά τα δύο δουλεύουν σε όλη τη σελίδα: δες την κόκκινη γραμμή στην κορυφή και το header όταν κάνεις scroll.</p>', '', array( 'align' => 'center', '__globals__' => array( 'text_color' => pg_gc( 'muted' ) ) ) ),
	), array( 'padding' => pg_box( 40, 24, 120, 24 ), 'flex_gap' => pg_gap( 16 ) ) ),
);

$id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Effects Lab', 'post_name' => 'effects-lab', 'page_template' => 'elementor_header_footer' ) );
pg_save_elementor( $id, $data );
delete_post_meta( $id, '_pg_build' ); // not owned by build.php — survives full rebuilds
update_post_meta( $id, '_pg_lab', 1 );
update_post_meta( $id, 'rank_math_robots', array( 'noindex', 'nofollow' ) ); // hidden from Google and the sitemap
\Elementor\Plugin::$instance->files_manager->clear_cache();
WP_CLI::success( 'Effects Lab: ' . get_permalink( $id ) );
