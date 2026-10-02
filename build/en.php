<?php
/**
 * English version (Polylang). Included at the end of build.php — shares its variables
 * ($img, $L, $q_order, $services, page/template/content ids). Greek is the default language
 * (no prefix), English lives under /en/. Every Greek page, template, listing card, project,
 * testimonial, package and article gets an English translation, so Polylang outputs
 * hreflang, queries return the current language, and JetThemeCore / JetEngine swap in the
 * English header, footer, single templates and listing cards automatically.
 */

require __DIR__ . '/content-en.php';

if ( ! function_exists( 'PLL' ) ) {
	WP_CLI::warning( 'Polylang not active — English version skipped.' );
	return;
}

/* ---- Languages + settings (idempotent) ---- */

$pll = PLL()->model;
foreach ( array(
	array( 'locale' => 'el', 'slug' => 'el', 'name' => 'Ελληνικά', 'flag' => 'gr', 'term_group' => 0 ),
	array( 'locale' => 'en_US', 'slug' => 'en', 'name' => 'English', 'flag' => 'us', 'term_group' => 1 ),
) as $lang ) {
	if ( ! $pll->get_language( $lang['slug'] ) ) {
		$pll->languages->add( $lang );
	}
}
PLL()->options->set( 'default_lang', 'el' );
PLL()->options->set( 'hide_default', true );   // Greek URLs without /el/
PLL()->options->set( 'force_lang', 1 );        // language from the directory (/en/)
PLL()->options->set( 'browser', false );       // no redirect by browser language (SEO + cache)
PLL()->options->set( 'redirect_lang', true );  // translated front page at /en/ (false would give /en/home/)
// Translatable: pages/posts/categories (always) + templates, listing cards and content CPTs.
// project_cat stays shared (category names are the same in both languages).
PLL()->options->set( 'post_types', array( 'jet-theme-core', 'jet-engine', 'projects', 'testimonials', 'packages' ) );
PLL()->options->save();
$pll->clean_languages_cache();
$pll->cache->clean( 'post_types' ); // same request must see the new translatable types

// Everything built so far is Greek.
$pll->set_language_in_mass( 'el' );

$en_pair = function ( $el_id, $en_id ) {
	pll_set_post_language( $en_id, 'en' );
	pll_save_post_translations( array( 'el' => $el_id, 'en' => $en_id ) );
};
$en_page = function ( $title, $slug, $data, $order, $el_id, $parent = 0 ) use ( $en_pair ) {
	$id  = pg_page( $title, $slug, $data, $order, $parent );
	$seo = ( pg_en_seo_meta() + pg_en_seo_meta_more() )[ $slug ] ?? null;
	if ( $seo ) {
		pg_seo( $id, $seo[0], $seo[1] );
	}
	$en_pair( $el_id, $id );
	return $id;
};
$en_cta = function ( $title = 'Ready for take-off?', $text = 'Tell us what you want to achieve and we’ll suggest the smartest way to get there.' ) {
	return pg_cta( $title, $text, 'Get a quote', '/en/get-a-quote/' );
};
$copy_meta = function ( $from, $to, array $keys ) {
	foreach ( $keys as $k ) {
		update_post_meta( $to, $k, get_post_meta( $from, $k, true ) );
	}
};

/* ---- Content translations ---- */

foreach ( pg_en_projects() as $n => $p ) {
	$el = $project_ids[ $n ];
	$id = pg_insert( 'projects', $p['title'], array( 'post_name' => $p['slug'], 'post_excerpt' => $p['excerpt'], 'post_content' => $p['content'], 'menu_order' => $n ), array(
		'client' => $p['client'], 'services' => $p['services'], 'highlight' => $p['highlight'], 'challenge' => $p['challenge'], 'solution' => $p['solution'], 'result' => $p['result'],
	) );
	$copy_meta( $el, $id, array( 'year', 'website', 'gallery', 'featured', '_thumbnail_id' ) );
	wp_set_object_terms( $id, wp_get_object_terms( $el, 'project_cat', array( 'fields' => 'ids' ) ), 'project_cat' );
	$en_pair( $el, $id );
}
foreach ( pg_en_testimonials() as $n => $t ) {
	$id = pg_insert( 'testimonials', $t['name'], array( 'post_content' => $t['quote'], 'menu_order' => $n ), array( 'role' => $t['role'] ) );
	$en_pair( $testimonial_ids[ $n ], $id );
}
foreach ( pg_en_packages() as $n => $p ) {
	$features = array();
	foreach ( $p['features'] as $k => $f ) {
		$features[ 'item-' . $k ] = array( 'feature' => $f );
	}
	$id = pg_insert( 'packages', $p['title'], array( 'menu_order' => $n ), array( 'badge' => $p['badge'], 'subtitle' => $p['subtitle'], 'price' => $p['price'], 'price_note' => $p['note'], 'features' => $features ) );
	$copy_meta( $package_ids[ $n ], $id, array( 'group' ) );
	$en_pair( $package_ids[ $n ], $id );
}

// Blog categories (term slugs must be unique in Polylang free → English slugs).
$en_cat_ids = array();
foreach ( pg_en_blog_cats() as $el_slug => $c ) {
	$t = term_exists( $c[0], 'category' ) ?: wp_insert_term( $c[1], 'category', array( 'slug' => $c[0] ) );
	$en_cat_ids[ $el_slug ] = (int) $t['term_id'];
	pll_set_term_language( $en_cat_ids[ $el_slug ], 'en' );
	pll_save_term_translations( array( 'el' => $blog_cat_ids[ $el_slug ], 'en' => $en_cat_ids[ $el_slug ] ) );
}
// Polylang creates an English default category → give it an English name.
$en_default = get_term_by( 'slug', 'uncategorized-en', 'category' );
if ( $en_default ) {
	wp_update_term( $en_default->term_id, 'category', array( 'name' => 'General', 'slug' => 'general' ) );
}
foreach ( pg_en_posts() as $n => $p ) {
	$el  = $post_ids[ $n ];
	$cat = array_search( wp_get_post_categories( $el )[0], $blog_cat_ids, true );
	$id  = pg_insert( 'post', $p['title'], array( 'post_name' => $p['slug'], 'post_excerpt' => $p['excerpt'], 'post_content' => $p['content'], 'post_date' => get_post_field( 'post_date', $el ), 'post_category' => array( $en_cat_ids[ $cat ] ) ) );
	$copy_meta( $el, $id, array( '_thumbnail_id' ) );
	$en_pair( $el, $id );
}

/* ---- Listing cards (translations — JetEngine renders them on /en/ automatically) ---- */

foreach ( array(
	'project' => array( 'Project card (EN)', 'projects', pg_project_card( 'View case study' ) ),
	'package' => array( 'Package card (EN)', 'packages', pg_package_card( 'Get a quote', '/en/get-a-quote/' ) ),
	'post'    => array( 'Article card (EN)', 'post', pg_post_card( 'Read the article' ) ),
) as $key => $def ) {
	$en_pair( $L[ $key ], pg_listing( $def[0], $def[1], $def[2] ) );
}

/* ---- Forms ---- */

$en_messages = function ( $success ) {
	return wp_json_encode( array(
		'success' => $success, 'failed' => 'Something went wrong. Please try again or email us.',
		'validation_failed' => 'Please check the form fields.', 'invalid_email' => 'This email address is not valid.', 'empty_field' => 'This field is required.', 'internal_error' => 'Internal error. Please try again.',
	) );
};
$en_form_id = pg_jfb_form( 'Contact form (EN)', pg_en_form_blocks(),
	'New message from polygons.gr/en — %name%',
	'<p><b>Name:</b> %name%<br><b>Email:</b> %email%<br><b>Company:</b> %company%<br><b>Service:</b> %service%</p><p>%message%</p>',
	'Thank you! We received your message and will get back to you soon.',
	array( 'We received your message — Polygons', '<p>Hi %name%,</p><p>thanks for getting in touch. We’ll reply within one working day.</p><p>Polygons Studio</p>' ) );
update_post_meta( $en_form_id, '_jf_messages', $en_messages( 'Thank you! We received your message and will get back to you soon.' ) );

$en_quote_form_id = pg_jfb_form( 'Quote request (EN, steps)', pg_en_quote_form_blocks(),
	'New quote request (EN) — %name%',
	'<p><b>Services:</b> %services%<br><b>Current site:</b> %current_site%<br><b>Budget:</b> %budget%<br><b>Timeline:</b> %timeline%</p><p><b>Name:</b> %name%<br><b>Company:</b> %company%<br><b>Email:</b> %email%<br><b>Phone:</b> %phone%</p><p>%message%</p>',
	'Thank you! We received your request and will get back to you soon about next steps.',
	array( 'We received your request — Polygons', '<p>Hi %name%,</p><p>thanks for your quote request. We’re reviewing it and will get back to you soon.</p><p>Polygons Studio</p>' ), true );
update_post_meta( $en_quote_form_id, '_jf_messages', $en_messages( 'Thank you! We received your request and will get back to you soon about next steps.' ) );

$en_audit_form_id = pg_jfb_form( 'Free site audit (EN)', pg_en_audit_form_blocks(),
	'Free audit request (EN) — %site_url%',
	'<p><b>Site:</b> %site_url%<br><b>Email:</b> %email%</p>',
	'Great! We received your site and will email you the report.',
	array( 'Your free website audit — Polygons', '<p>Hi,</p><p>we received your audit request for <b>%site_url%</b>. We’ll email you the speed and SEO report.</p><p>Polygons Studio</p>' ) );
update_post_meta( $en_audit_form_id, '_jf_messages', $en_messages( 'Great! We received your site and will email you the report.' ) );
$en_audit = pg_en_audit_strings();

/* ---- Pages ---- */

$en_services = pg_en_services();

// Home
$cards = array();
foreach ( $en_services as $key => $s ) {
	$cards[] = pg_card( array(
		pg_image( $img[ $key ], 'pg-card__media', 'medium_large' ),
		pg_heading( $s['n'], 'p', 'pg-num', array( '__globals__' => array( 'typography_typography' => pg_gt( 'accent' ), 'title_color' => pg_gc( 'primary' ) ) ) ),
		pg_heading( $s['title'], 'h3' ),
		pg_text( '<p>' . $s['short'] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ) ) ) ),
		pg_heading( '<a href="' . pg_en_service_url( $key ) . '">Learn more <span class="pg-sr-only">about ' . $s['title'] . '</span><span aria-hidden="true">→</span></a>', 'p', 'pg-link' ),
	), 'pg-card--service' );
}
$steps = array();
foreach ( pg_en_steps() as $i => $st ) {
	$steps[] = pg_card( array(
		pg_heading( sprintf( '%02d', $i + 1 ), 'p', 'pg-step__num' ),
		pg_heading( $st[0], 'h3' ),
		pg_text( '<p>' . $st[1] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ) ) ) ),
	), 'pg-step', array( 'padding' => pg_box( 32, 28, 32, 28 ) ) );
}
$en_home_id = $en_page( 'Home', 'home', array(
	pg_section( 'pg-hero fx-mesh fx-neon-on', array(
		pg_w( 'html', array( 'html' => '<div class="pg-hero__deco fx-draw" aria-hidden="true">' . pg_hex_svg( true ) . '</div>' ) ),
		pg_heading( '<span class="pg-hero__kicker">The ultimate</span><span class="pg-neon">All-in-one</span><span class="pg-hero__sub">Graphic &amp; Web Services</span>', 'h1', 'pg-hero__title', array( 'align' => 'center' ) ),
		pg_lead( '<p><strong>Polygons design studio</strong> is the one partner you need for your digital presence. Web design, brand identity, hosting and SEO, all under one roof.</p>', 'center' ),
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 16 ), 'css_classes' => 'pg-hero__actions' ), array(
			pg_button( 'Get a quote', '/en/get-a-quote/', 'primary', true, array( '_css_classes' => 'pg-btn pg-btn--primary fx-magnetic' ) ),
			pg_button( 'See our work', '/en/work/', 'ghost', false ),
		) ),
	), array(
		'min_height' => pg_size( 100, 'vh' ), 'flex_justify_content' => 'center', 'flex_align_items' => 'center', 'flex_gap' => pg_gap( 32 ),
		'padding' => pg_box( 160, 24, 120, 24 ), 'padding_mobile' => pg_box( 130, 20, 80, 20 ),
	) ),
	pg_c( array( 'css_classes' => 'pg-marquee' ), array(
		pg_w( 'html', array( 'html' => '<div class="pg-marquee__track" aria-hidden="true">' . str_repeat( '<span>Web Design</span><span>UI / UX</span><span>Branding</span><span>Graphic Design</span><span>Hosting</span><span>SEO</span><span>Digital Marketing</span>', 2 ) . '</div>' ) ),
	), false ),
	pg_section( 'pg-services', array(
		pg_intro( 'What we do', 'Everything your brand needs.<br>In one studio.', 'Forget juggling multiple vendors. From the first sketch to the first page of Google, we’ve got it covered.' ),
		pg_grid( 4, 2, 1, $cards, 'pg-services__grid fx-border fx-stagger' ),
	), array(), 'services' ),
	pg_section( 'pg-featured', array(
		pg_c( array( 'flex_direction' => 'row', 'flex_direction_mobile' => 'column', 'flex_justify_content' => 'space-between', 'flex_align_items' => 'flex-end', 'flex_gap' => pg_gap( 24 ) ), array(
			pg_intro( 'Selected work', 'Work that speaks<br>for itself.', '', 'left' ),
			pg_button( 'All projects', '/en/work/', 'ghost', true ),
		) ),
		pg_listing_grid( $L['project'], 3, 2, 1, 3, array_merge( $q_order, array( array( '_id' => pg_id(), 'type' => 'meta_query', 'meta_query_key' => 'featured', 'meta_query_compare' => '=', 'meta_query_val' => 'true' ) ) ), 'pg-projects fx-hex fx-tilt' ),
	), array( 'padding' => pg_box( 40, 24, 120, 24 ) ) ),
	pg_section( 'pg-why pg-section--alt', array(
		pg_row( array(
			pg_col( array(
				pg_intro( 'Why Polygons', 'One partner.<br>Zero hassle.', 'A polygon stands strong because all its sides join perfectly. That’s how we work: every part of your digital presence is designed to fit with the rest.', 'left' ),
				pg_button( 'Meet us', '/en/about/', 'ghost', false ),
			), 40 ),
			pg_col( array( pg_grid( 2, 2, 1, array_map( function ( $w ) {
				return pg_feature( $w[0], $w[1], $w[2] );
			}, pg_en_why() ), 'pg-why__grid', 20 ) ), 60 ),
		) ),
	) ),
	pg_section( 'pg-process', array(
		pg_intro( 'How we work', 'From idea to launch.', 'Clear steps, steady communication and no surprises along the way.' ),
		pg_grid( 4, 2, 1, $steps, 'pg-steps', 20 ),
	) ),
	pg_audit_section( $en_audit_form_id, '', $en_audit ),
	pg_section( 'pg-testimonials pg-section--alt', array(
		pg_intro( 'What our clients say', 'The best advertising<br>is a happy client.' ),
		pg_listing_grid( $L['testimonial'], 3, 1, 1, 3, $q_order, 'pg-quotes' ),
	) ),
	pg_section( 'pg-clients', array(
		pg_eyebrow( 'Trusted by', 'center' ),
		pg_listing_grid( $L['client'], 6, 3, 2, 12, $q_order, 'pg-clients', '', 16 ),
	), array( 'padding' => pg_box( 72, 24, 72, 24 ), 'flex_gap' => pg_gap( 28 ) ) ),
	$en_cta(),
), 0, $home_id );

// Services overview
$stack = array();
foreach ( $en_services as $key => $s ) {
	$stack[] = pg_c( array_merge( pg_card_style( 40, 28 ), array(
		'_element_id' => $key, 'css_classes' => 'pg-service-card', 'flex_direction' => 'row', 'flex_direction_tablet' => 'column',
		'flex_align_items' => 'center', 'flex_gap' => pg_gap( 40 ), 'padding_mobile' => pg_all( 24 ),
	) ), array(
		pg_col( array(
			pg_heading( $s['n'], 'p', 'pg-service__num' ),
			pg_heading( $s['title'], 'h2', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(28px, 3vw, 40px)', 'custom' ) ) ),
			pg_text( '<p>' . $s['long'] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'text' ), 'text_color' => pg_gc( 'text' ) ) ) ),
			pg_chips( array( 'Ideal for' => $s['for'], 'Timeline' => $s['time'] ) ),
			pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_gap' => pg_gap( 12 ) ), array(
				pg_button( 'Get a quote', '/en/get-a-quote/', 'primary' ),
				pg_button( 'Details', pg_en_service_url( $key ), 'ghost', false, array( 'text' => 'Details <span class="pg-sr-only">about ' . $s['title'] . '</span>' ) ),
			) ),
		), 46, '', 14 ),
		pg_col( array( pg_eyebrow( 'What’s included' ), pg_icon_list( $s['list'] ) ), 28, 'pg-service-card__list', 16 ),
		pg_col( array( pg_image( $img[ $key ], 'pg-service__media', 'medium_large' ) ), 26 ),
	) );
}
$en_tab = function ( $group ) use ( $L, $q_order ) {
	return pg_c( array(), array( pg_listing_grid( $L['package'], 3, 1, 1, 6, array_merge( $q_order, array( array( '_id' => pg_id(), 'type' => 'meta_query', 'meta_query_key' => 'group', 'meta_query_compare' => '=', 'meta_query_val' => $group ) ) ), 'pg-packs fx-border' ) ) );
};
$en_svc_id = $en_page( 'Services', 'services', array(
	pg_page_hero( 'Services', 'What we do', 'Four specialties, one team. Pick what you need, or let us build your entire digital presence.' ),
	pg_c( array( 'content_width' => 'boxed', 'css_classes' => 'pg-subnav', 'flex_direction' => 'row', 'flex_justify_content' => 'center', 'padding' => pg_box( 0, 24, 24, 24 ), 'padding_mobile' => pg_box( 0, 20, 24, 20 ) ), array(
		pg_text( '<nav aria-label="Services"><ul class="pg-pills">' . implode( '', array_map( function ( $k, $s ) {
			return '<li><a href="#' . $k . '">' . $s['title'] . '</a></li>';
		}, array_keys( $en_services ), $en_services ) ) . '<li><a href="#packages">Packages</a></li><li><a href="#faq">FAQ</a></li></ul></nav>' ),
	), false ),
	pg_section( 'pg-service-stack', array( pg_c( array( 'css_classes' => 'fx-stack', 'flex_gap' => pg_gap( 40 ) ), $stack ) ), array( 'padding' => pg_box( 32, 24, 120, 24 ), 'padding_mobile' => pg_box( 16, 16, 72, 16 ) ) ),
	pg_section( 'pg-packages', array(
		pg_intro( 'Packages', 'Clear prices.<br>No small print.', 'Ready-made packages for the most common needs. Need something different? We’ll put together a tailored quote.' ),
		array(
			'id' => pg_id(), 'elType' => 'widget', 'widgetType' => 'nested-tabs',
			'settings' => array(
				'tabs' => array( array( '_id' => pg_id(), 'tab_title' => 'Websites' ), array( '_id' => pg_id(), 'tab_title' => 'Hosting' ) ),
				'tabs_justify_horizontal' => 'center', 'breakpoint_selector' => 'none',
				'title_text_color' => '#DCDDE3', 'title_text_color_hover' => '#FFFFFF', 'title_text_color_active' => '#FFFFFF', '_css_classes' => 'pg-tabs',
			),
			'elements' => array( $en_tab( 'web' ), $en_tab( 'hosting' ) ),
		),
	), array(), 'packages' ),
	pg_audit_section( $en_audit_form_id, '', $en_audit ),
	pg_section( 'pg-faq pg-section--alt', array(
		pg_row( array(
			pg_col( array( pg_intro( 'FAQ', 'Frequently asked questions', 'Can’t find the answer you’re looking for? Send us a message, we reply fast.', 'left' ), pg_button( 'Ask a question', '/en/contact/', 'ghost', false ) ), 35 ),
			pg_col( array( pg_faq_widget( pg_en_faq() ) ), 65 ),
		), '', 64, 'flex-start' ),
	), array(), 'faq' ),
	$en_cta( 'Not sure where to start?', 'Tell us what you want to achieve and we’ll suggest the smartest way to get there.' ),
), 1, $svc_id );

// Service pages (/en/services/<slug>/) — same builder as the Greek ones
$en_service_page_ids = array();
foreach ( pg_en_service_pages() as $key => $d ) {
	$page = pg_service_page_data( $key, $d, $en_services, pg_en_service_pages(), 'pg_en_service_url', array(
		'cta' => 'Get a quote', 'cta_url' => '/en/get-a-quote/', 'incl' => 'What’s included', 'incl_anchor' => 'included', 'incl_title' => 'Everything you need,<br>nothing you don’t.',
		'for' => 'Ideal for', 'time' => 'Timeline', 'how' => 'How we work', 'how_title' => 'Four clear steps.',
		'pk' => 'Packages', 'pk_title' => 'Clear prices.<br>No small print.', 'pk_lead' => 'Need something different? We’ll put together a tailored quote.', 'pk_anchor' => 'packages',
		'rel' => 'Related work', 'rel_title' => 'See it in practice.', 'all_work' => 'All projects', 'work_url' => '/en/work/',
		'faq_title' => 'Frequently asked questions', 'faq_lead' => 'Can’t find the answer you’re looking for? Send us a message, we reply fast.', 'ask' => 'Ask a question', 'contact_url' => '/en/contact/',
		'others' => 'All in one studio', 'others_title' => 'Explore our other services.',
		'cta_title' => 'Let’s talk about your project.', 'cta_text' => 'Tell us what you need and we’ll send you a clear quote with cost and timeline.',
	), $img, $L, $q_order );
	$pid = $en_page( $d['menu'], $d['slug'], $page, (int) $en_services[ $key ]['n'], $service_page_ids[ $key ], $en_svc_id );
	pg_seo( $pid, $d['seo'][0], $d['seo'][1] );
	$en_service_page_ids[ $key ] = $pid;
}

// Work
$en_filter_id = pg_insert( 'jet-smart-filters', 'Project category (EN)', array(), array(
	'_filter_type' => 'radio', '_data_source' => 'taxonomies', '_source_taxonomy' => 'project_cat', '_add_all_option' => 'true', '_all_option_label' => 'All',
	'_ability_deselect_radio' => 'false', '_show_empty_terms' => 'false', '_only_child' => 'false', '_is_hierarchical' => 'false', '_filter_label' => '', '_query_var' => 'project_cat',
) );
$en_works_id = $en_page( 'Work', 'work', array(
	pg_page_hero( 'Portfolio', 'Our work', 'Websites, brands and campaigns we designed and built. Open a project to see the whole story behind it.' ),
	pg_section( 'pg-works', array(
		pg_heading( 'All projects', 'h2', 'pg-sr-only' ),
		pg_w( 'jet-smart-filters-radio', array( 'filter_id' => array( (string) $en_filter_id ), 'content_provider' => 'jet-engine', 'apply_type' => 'ajax', 'apply_on' => 'value', 'query_id' => 'work', 'show_label' => '', 'show_decorator' => '', '_css_classes' => 'pg-filter' ) ),
		pg_listing_grid( $L['project'], 3, 2, 1, 12, $q_order, 'pg-projects fx-hex fx-tilt', 'work' ),
	), array( 'padding' => pg_box( 8, 24, 96, 24 ), 'flex_gap' => pg_gap( 32 ) ) ),
	$en_cta( 'Your project could be next.', 'Have an idea? Let’s turn it into something that stands out.' ),
), 2, $works_id );

// About
$en_about_id = $en_page( 'About', 'about', array(
	pg_page_hero( 'About us', 'Who we are', 'A creative studio with an explorer’s spirit and one mission: to make your digital presence shine.' ),
	pg_section( 'pg-story', array(
		pg_row( array(
			pg_col( array(
				pg_eyebrow( 'Our story' ),
				pg_heading( 'Every strong brand has many sides.', 'h2' ),
				pg_text( pg_en_story(), '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'lead' ) ) ) ),
			), 55 ),
			pg_col( array( pg_w( 'html', array( 'html' => '<div class="pg-emblem fx-draw" aria-hidden="true">' . pg_hex_svg( true ) . '</div>' ) ) ), 45, 'pg-story__emblem' ),
		) ),
	), array( 'padding' => pg_box( 40, 24, 96, 24 ) ) ),
	pg_section( 'pg-values pg-section--alt', array(
		pg_intro( 'Our values', 'The things that don’t change.' ),
		pg_grid( 3, 1, 1, array_map( function ( $v ) {
			return pg_feature( $v[0], $v[1], $v[2] );
		}, pg_en_values() ), 'pg-values__grid', 24 ),
	) ),
	pg_section( 'pg-testimonials', array(
		pg_intro( 'What our clients say', 'Relationships that last.' ),
		pg_listing_grid( $L['testimonial'], 3, 1, 1, 3, $q_order, 'pg-quotes' ),
	) ),
	$en_cta( 'Let’s meet.', 'A coffee (or a video call) is all it takes to see how we can help.' ),
), 3, $about_id );

// Blog (posts page /en/articles/; rendered by the archive template's English translation)
$en_blog_id = $en_page( 'Blog', 'articles', array(), 4, $blog_id );

// Contact
$en_contact_id = $en_page( 'Contact', 'contact', array(
	pg_page_hero( 'Contact', 'Let’s start something together.', 'Tell us about your project and we’ll get back to you as soon as possible, usually within the same working day.' ),
	pg_section( 'pg-contact', array(
		pg_row( array(
			pg_col( array(
				pg_heading( 'Contact details', 'h2', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(26px, 3vw, 34px)', 'custom' ) ) ),
				pg_lead( '<p>Prefer to talk directly? Send an email or give us a call.</p>' ),
				pg_c( array( 'flex_gap' => pg_gap( 16 ), 'css_classes' => 'pg-contact-list' ), array_map( function ( $c ) {
					return pg_feature( $c[0], $c[1], $c[2], 'left', false );
				}, pg_en_contact_info() ) ),
			), 38 ),
			pg_col( array(
				pg_w( 'jet-form-builder-form', array( 'form_id' => (string) $en_form_id, 'submit_type' => 'ajax', 'fields_layout' => 'column', 'fields_label_tag' => 'label', 'required_mark' => '*' ) ),
			), 62, 'pg-form-card' ),
		), '', 48, 'flex-start' ),
	), array( 'padding' => pg_box( 24, 24, 120, 24 ) ) ),
), 5, $contact_id );

// Get a quote
$en_quote_id = $en_page( 'Get a quote', 'get-a-quote', array(
	pg_page_hero( 'Get a quote', 'Let’s see what you need.', 'Three short steps and we’ll have everything we need to prepare a clear proposal for you.' ),
	pg_section( 'pg-quote-page', array(
		pg_row( array(
			pg_col( array(
				pg_heading( 'What happens next', 'h2', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(26px, 3vw, 34px)', 'custom' ) ) ),
				pg_c( array( 'flex_gap' => pg_gap( 20 ), 'css_classes' => 'pg-contact-list' ), array_map( function ( $st, $i ) {
					return pg_feature( $st[0], sprintf( '%d. %s', $i + 1, $st[1] ), $st[2], 'left', false );
				}, pg_en_quote_steps(), array_keys( pg_en_quote_steps() ) ) ),
				pg_text( '<p>Prefer to write freely? <a href="/en/contact/">Send us a message</a> or open the chat at the bottom right.</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'small' ), 'text_color' => pg_gc( 'muted' ) ) ) ),
			), 36 ),
			pg_col( array(
				pg_w( 'jet-form-builder-form', array( 'form_id' => (string) $en_quote_form_id, 'submit_type' => 'ajax', 'fields_layout' => 'column', 'fields_label_tag' => 'label', 'required_mark' => '*', 'enable_progress' => 'yes' ) ),
			), 64, 'pg-form-card pg-form-card--steps' ),
		), '', 48, 'flex-start' ),
	), array( 'padding' => pg_box( 24, 24, 120, 24 ) ) ),
), 6, $quote_id );

/* ---- Menus ---- */

$en_service_items = array();
foreach ( pg_en_service_pages() as $key => $d ) {
	$en_service_items[] = array( $d['menu'], $en_service_page_ids[ $key ] );
}
$en_main_menu     = pg_menu( 'Main menu (EN)', array( array( 'What we do', $en_svc_id, $en_service_items ), array( 'Work', $en_works_id ), array( 'About', $en_about_id ), array( 'Blog', $en_blog_id ), array( 'Contact', $en_contact_id ) ) );
$en_services_menu = pg_menu( 'Footer · Services (EN)', array_merge( $en_service_items, array( array( 'Packages & pricing', '/en/services/#packages' ) ) ) );

/* ---- Templates (translations of the Greek ones) ---- */

$en_pair( $header_id, pg_header_tpl( 'Header (EN)', $en_main_menu, array( 'cta' => 'Get a quote', 'cta_url' => '/en/get-a-quote/' ) ) );
$en_pair( $footer_id, pg_footer_tpl( 'Footer (EN)', $en_main_menu, $en_services_menu, array(
	'about' => 'Graphic &amp; web services, all in one. We design, build, host and promote brands that stand out.',
	'nav' => 'Navigation', 'services' => 'Services', 'contact' => 'Contact', 'start' => 'Start a project', 'cta_url' => '/en/get-a-quote/',
	'chat' => 'Open the chat', 'rights' => 'All rights reserved.',
) ) );
$en_pair( $single_id, pg_jtc_template( 'Project — single (EN)', 'jet_single', pg_project_single_data( array(
	'client' => 'Client', 'year' => 'Year', 'services' => 'Services', 'result' => 'Result',
	'challenge' => 'The challenge', 'solution' => 'The solution', 'outcome' => 'The result',
	'more_eyebrow' => 'More work', 'more_title' => 'Keep exploring.', 'all' => 'All projects', 'all_url' => '/en/work/',
	'cta_title' => 'Liked what you saw?', 'cta_text' => 'Let’s build something similar (or even better) for your business.', 'cta' => 'Get a quote', 'cta_url' => '/en/get-a-quote/',
), $L, $q_order ) ) );
$en_pair( $archive_id, pg_jtc_template( 'Blog — archive (EN)', 'jet_archive', pg_blog_archive_data( array(
	'lead' => 'Practical guides on websites, SEO, hosting and brand identity. No jargon, just what you need to make the right decisions.',
	'list_h' => 'Articles', 'none' => 'No articles here yet.',
	'cta_title' => 'Rather have us handle it?', 'cta_text' => 'Tell us what you need and we’ll suggest the smartest way forward.', 'cta' => 'Get a quote', 'cta_url' => '/en/get-a-quote/',
), $L ) ) );
$en_pair( $post_single_id, pg_jtc_template( 'Article — single (EN)', 'jet_single', pg_post_single_data( array(
	'more_title' => 'Keep reading.', 'all' => 'All articles', 'all_url' => '/en/articles/',
	'cta_title' => 'Want us to look at your site?', 'cta_text' => 'Tell us what you need and we’ll reply with a concrete proposal.', 'cta' => 'Get a quote', 'cta_url' => '/en/get-a-quote/',
), $L ) ) );
$en_pair( $notfound_id, pg_jtc_template( '404 (EN)', 'jet_page', array(
	pg_section( 'pg-page-hero pg-404 fx-neon-on', array(
		pg_w( 'html', array( 'html' => '<div class="pg-404__hex fx-draw" aria-hidden="true">' . pg_hex_svg( true ) . '</div>' ) ),
		pg_intro( 'Error 404', 'This page<br><span class="pg-neon">doesn’t exist.</span>', 'It may have moved, or the address has a typo. Here’s where you can go:', 'center', 'h1' ),
		pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 12 ) ), array(
			pg_button( 'Home', '/en/', 'primary' ),
			pg_button( 'What we do', '/en/services/', 'ghost', false ),
			pg_button( 'Work', '/en/work/', 'ghost', false ),
			pg_button( 'Blog', '/en/articles/', 'ghost', false ),
			pg_button( 'Contact', '/en/contact/', 'ghost', false ),
		) ),
	), array( 'min_height' => pg_size( 80, 'vh' ), 'flex_justify_content' => 'center', 'flex_align_items' => 'center', 'flex_gap' => pg_gap( 28 ) ) ),
) ) );

$pll->clean_languages_cache(); // page_on_front / page_for_posts per language changed

WP_CLI::log( sprintf( 'EN: home %d, services %d (+%s), work %d, about %d, blog %d, contact %d, quote %d', $en_home_id, $en_svc_id, implode( ',', $en_service_page_ids ), $en_works_id, $en_about_id, $en_blog_id, $en_contact_id, $en_quote_id ) );
