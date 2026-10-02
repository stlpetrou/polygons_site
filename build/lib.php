<?php
/**
 * Helpers for composing Elementor JSON.
 *
 * Styling rule: anything an editor may want to change (colours, type, spacing, borders,
 * radii, backgrounds) is set as Elementor settings or comes from the Kit (Site Settings).
 * CSS classes (pg-*) are only hooks for effects Elementor can't express: glows, hover
 * motion, pseudo-element decoration, neon text.
 */

const PG_LINE        = '#FFFFFF14';
const PG_LINE_STRONG = '#FFFFFF29';

function pg_id() {
	return substr( md5( uniqid( '', true ) . wp_rand() ), 0, 7 );
}

function pg_gap( $px ) {
	return array( 'column' => (string) $px, 'row' => (string) $px, 'unit' => 'px', 'size' => $px, 'isLinked' => true );
}

function pg_box( $t, $r, $b, $l, $unit = 'px' ) {
	return array( 'unit' => $unit, 'top' => (string) $t, 'right' => (string) $r, 'bottom' => (string) $b, 'left' => (string) $l, 'isLinked' => false );
}

function pg_all( $v, $unit = 'px' ) {
	return array( 'unit' => $unit, 'top' => (string) $v, 'right' => (string) $v, 'bottom' => (string) $v, 'left' => (string) $v, 'isLinked' => true );
}

function pg_size( $size, $unit = 'px' ) {
	return array( 'unit' => $unit, 'size' => $size, 'sizes' => array() );
}

/** Global colour / typography references. */
function pg_gc( $id ) {
	return 'globals/colors?id=' . $id;
}
function pg_gt( $id ) {
	return 'globals/typography?id=' . $id;
}

/* ------------------------------------------------------------ Structure */

function pg_c( array $s = array(), array $children = array(), $inner = true ) {
	$s = array_merge( array( 'content_width' => 'full', 'flex_direction' => 'column' ), $s );
	return array( 'id' => pg_id(), 'elType' => 'container', 'isInner' => $inner, 'settings' => $s, 'elements' => $children );
}

function pg_w( $type, array $s = array() ) {
	return array( 'id' => pg_id(), 'elType' => 'widget', 'widgetType' => $type, 'settings' => $s, 'elements' => array() );
}

/** Top-level boxed section. */
function pg_section( $class, array $children, array $extra = array(), $anchor = '' ) {
	$s = array_merge( array(
		'content_width'  => 'boxed',
		'flex_direction' => 'column',
		'css_classes'    => trim( 'pg-section ' . $class ),
		'flex_gap'       => pg_gap( 48 ),
		'padding'        => pg_box( 120, 24, 120, 24 ),
		'padding_mobile' => pg_box( 72, 20, 72, 20 ),
	), $extra );
	if ( $anchor ) {
		$s['_element_id'] = $anchor;
	}
	return pg_c( $s, $children, false );
}

/** Card surface: gradient panel, hairline border, rounded. Editable in Elementor. */
function pg_card_style( $pad = 28, $radius = 20 ) {
	return array(
		'background_background'     => 'gradient',
		'background_color'          => '#161622',
		'background_color_b'        => '#101018',
		'background_gradient_angle' => pg_size( 180, 'deg' ),
		'border_border'             => 'solid',
		'border_width'              => pg_all( 1 ),
		'border_color'              => PG_LINE,
		'border_radius'             => pg_all( $radius ),
		'padding'                   => pg_all( $pad ),
	);
}

function pg_card( array $children, $class = '', array $extra = array() ) {
	return pg_c( array_merge( pg_card_style(), array( 'css_classes' => trim( 'pg-card ' . $class ), 'flex_gap' => pg_gap( 14 ) ), $extra ), $children );
}

function pg_grid( $cols, $tablet, $mobile, array $children, $class = '', $gap = 24 ) {
	return pg_c( array(
		'container_type'           => 'grid',
		'grid_columns_grid'        => pg_size( $cols, 'fr' ),
		'grid_columns_grid_tablet' => pg_size( $tablet, 'fr' ),
		'grid_columns_grid_mobile' => pg_size( $mobile, 'fr' ),
		'grid_rows_grid'           => pg_size( 1, 'fr' ),
		'grid_auto_flow'           => 'row',
		'grid_gaps'                => pg_gap( $gap ),
		'css_classes'              => $class,
	), $children );
}

function pg_row( array $children, $class = '', $gap = 64, $align = 'center' ) {
	return pg_c( array(
		'flex_direction'        => 'row',
		'flex_direction_tablet' => 'column',
		'flex_align_items'      => $align,
		'flex_gap'              => pg_gap( $gap ),
		'css_classes'           => $class,
	), $children );
}

function pg_col( array $children, $width = 50, $class = '', $gap = 20 ) {
	return pg_c( array(
		'width'        => pg_size( $width, '%' ),
		'width_tablet' => pg_size( 100, '%' ),
		'flex_gap'     => pg_gap( $gap ),
		'css_classes'  => $class,
	), $children );
}

/* ------------------------------------------------------------ Type */

function pg_heading( $text, $tag = 'h2', $class = '', array $extra = array() ) {
	return pg_w( 'heading', array_merge( array( 'title' => $text, 'header_size' => $tag, '_css_classes' => $class ), $extra ) );
}

/** Small uppercase kicker above titles — Kit "Eyebrow" typography + Neon Red. */
function pg_eyebrow( $text, $align = '' ) {
	return pg_heading( $text, 'p', 'pg-eyebrow', array(
		'align'       => $align,
		'__globals__' => array( 'typography_typography' => pg_gt( 'accent' ), 'title_color' => pg_gc( 'primary' ) ),
	) );
}

/** Oversized display title (CTA bands). */
function pg_title_xl( $text, $tag = 'h2', $align = 'center' ) {
	return pg_heading( $text, $tag, '', array(
		'align'                  => $align,
		'typography_typography'  => 'custom',
		'typography_font_size'   => pg_size( 'clamp(36px, 5.6vw, 72px)', 'custom' ),
	) );
}

/** Lead paragraph — Kit "Lead" typography, capped measure. */
function pg_lead( $html, $align = '' ) {
	$s = array(
		'editor'                => $html,
		'__globals__'           => array( 'typography_typography' => pg_gt( 'lead' ), 'text_color' => pg_gc( 'text' ) ),
		'_element_width'        => 'initial',
		'_element_custom_width' => pg_size( 680 ),
		'_element_custom_width_mobile' => pg_size( 100, '%' ),
	);
	if ( $align ) {
		$s['align'] = $align;
	}
	return pg_w( 'text-editor', $s );
}

function pg_text( $html, $class = '', array $extra = array() ) {
	return pg_w( 'text-editor', array_merge( array( 'editor' => $html, '_css_classes' => $class ), $extra ) );
}

/** Section intro: eyebrow + title + optional lead. */
function pg_intro( $eyebrow, $title, $lead = '', $align = 'center', $tag = 'h2' ) {
	$a    = 'center' === $align ? 'center' : '';
	$kids = array( pg_eyebrow( $eyebrow, $a ), pg_heading( $title, $tag, '', array( 'align' => $a ) ) );
	if ( $lead ) {
		$kids[] = pg_lead( '<p>' . $lead . '</p>', 'center' === $align ? 'center' : '' );
	}
	return pg_c( array(
		'css_classes'      => 'pg-intro',
		'flex_gap'         => pg_gap( 16 ),
		'flex_align_items' => $a ? 'center' : 'flex-start',
	), $kids );
}

/* ------------------------------------------------------------ Widgets */

/**
 * Button. Primary look comes from Kit button styles; ghost overrides here.
 * pg-btn adds the glow/arrow hover motion.
 */
function pg_button( $text, $url, $variant = 'primary', $icon = true, array $extra = array() ) {
	$s = array(
		'text'         => $text,
		'link'         => array( 'url' => $url, 'is_external' => '', 'nofollow' => '' ),
		'_css_classes' => 'pg-btn pg-btn--' . $variant,
	);
	if ( $icon ) {
		$s['selected_icon'] = array( 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' );
		$s['icon_align']    = 'row-reverse';
		$s['icon_indent']   = pg_size( 10 );
	}
	if ( 'ghost' === $variant ) {
		$s += array(
			'background_color'              => '#FFFFFF08',
			'border_border'                 => 'solid',
			'border_width'                  => pg_all( 1 ),
			'border_color'                  => PG_LINE_STRONG,
			'button_background_hover_color' => '#F1515214',
			'button_hover_border_color'     => '#F15152',
			'hover_color'                   => '#FFFFFF',
		);
	}
	return pg_w( 'button', array_merge( $s, $extra ) );
}

function pg_image( $att_id, $class = '', $size = 'large', array $extra = array() ) {
	return pg_w( 'image', array_merge( array(
		'image'        => array( 'id' => $att_id, 'url' => wp_get_attachment_image_url( $att_id, 'full' ) ),
		'image_size'   => $size,
		'_css_classes' => $class,
	), $extra ) );
}

function pg_icon_list( array $items, $class = 'pg-checklist', $icon = 'fas fa-check' ) {
	$list = array();
	foreach ( $items as $t ) {
		$list[] = array( '_id' => pg_id(), 'text' => $t, 'selected_icon' => array( 'value' => $icon, 'library' => 'fa-solid' ) );
	}
	return pg_w( 'icon-list', array(
		'icon_list'       => $list,
		'_css_classes'    => $class,
		'space_between'   => pg_size( 12 ),
		'icon_color'      => '#F15152',
		'icon_size'       => pg_size( 12 ),
		'text_color'      => '#DCDDE3',
		'text_indent'     => pg_size( 12 ),
	) );
}

/** Icon box with the brand "tinted tile" icon. $card wraps it in a card surface. */
function pg_feature( $icon, $title, $desc, $position = 'top', $card = true ) {
	$s = array(
		'selected_icon'        => array( 'value' => $icon, 'library' => 'fa-solid' ),
		'title_text'           => $title,
		'description_text'     => $desc,
		'title_size'           => 'h3',
		'position'             => $position,
		'position_mobile'      => $position,
		'text_align'           => 'left',
		'view'                 => 'framed',
		'shape'                => 'square',
		'primary_color'        => '#F15152',
		'secondary_color'      => '#F151521A',
		'icon_size'            => pg_size( 20 ),
		'icon_padding'         => pg_size( 15 ),
		'border_width'         => pg_size( 1 ),
		'border_radius'        => pg_all( 14 ),
		'icon_space'           => pg_size( 16 ),
		'title_bottom_space'   => pg_size( 6 ),
		'title_color'          => '#FFFFFF',
		'description_color'    => '#B9BCC8',
		'title_typography_typography'    => 'custom',
		'title_typography_font_size'     => pg_size( 20 ),
		'title_typography_font_weight'   => '700',
		'description_typography_typography' => 'custom',
		'description_typography_font_size'  => pg_size( 15.5 ),
		'_css_classes'         => 'pg-feature',
	);
	if ( $card ) {
		$s += array(
			'_background_background' => 'classic',
			'_background_color'      => '#101018',
			'_border_border'         => 'solid',
			'_border_width'          => pg_all( 1 ),
			'_border_color'          => PG_LINE,
			'_border_radius'         => pg_all( 20 ),
			'_padding'               => pg_all( 28 ),
		);
		$s['_css_classes'] .= ' pg-feature--card';
	}
	return pg_w( 'icon-box', $s );
}

/* ------------------------------------------------------------ Page parts */

/** Inner-page hero: breadcrumbs (Rank Math) + eyebrow + H1 + lead, optional buttons. */
function pg_page_hero( $eyebrow, $title, $lead, array $actions = array() ) {
	$kids = array( pg_breadcrumbs(), pg_intro( $eyebrow, $title, $lead, 'center', 'h1' ) );
	if ( $actions ) {
		$kids[] = pg_c( array( 'flex_direction' => 'row', 'flex_wrap' => 'wrap', 'flex_justify_content' => 'center', 'flex_gap' => pg_gap( 16 ) ), $actions );
	}
	return pg_section( 'pg-page-hero', $kids, array( 'padding' => pg_box( 160, 24, 88, 24 ), 'padding_mobile' => pg_box( 124, 20, 56, 20 ), 'flex_gap' => pg_gap( 28 ) ) );
}

/** Rank Math breadcrumbs (also outputs BreadcrumbList schema). */
function pg_breadcrumbs( $align = 'center' ) {
	return pg_text( '[rank_math_breadcrumb]', 'pg-crumbs', array( 'align' => $align ) );
}

/** Rank Math SEO title + meta description for a post. */
function pg_seo( $post_id, $title, $desc ) {
	update_post_meta( $post_id, 'rank_math_title', $title );
	update_post_meta( $post_id, 'rank_math_description', $desc );
}

function pg_cta( $title = 'Έτοιμοι για απογείωση;', $text = '', $btn = 'Ζήτα προσφορά', $url = '/prosfora/' ) {
	$text = $text ?: 'Μεταμόρφωσε την ψηφιακή σου παρουσία με τις ολοκληρωμένες υπηρεσίες μας. Έλα στο πλήρωμα των πελατών που ήδη πετάνε ψηλά.';
	return pg_section( 'pg-cta', array(
		pg_c( array(
			'css_classes'      => 'pg-cta__panel fx-glow',
			'flex_gap'         => pg_gap( 20 ),
			'flex_align_items' => 'center',
			'border_border'    => 'solid',
			'border_width'     => pg_all( 1 ),
			'border_color'     => '#F1515259',
			'border_radius'    => pg_all( 32 ),
			'padding'          => pg_box( 72, 32, 72, 32 ),
			'padding_mobile'   => pg_box( 48, 20, 48, 20 ),
		), array(
			pg_title_xl( $title ),
			pg_lead( '<p>' . $text . '</p>', 'center' ),
			pg_button( $btn, $url, 'primary', true, array( '_css_classes' => 'pg-btn pg-btn--primary fx-magnetic' ) ),
		) ),
	), array( 'padding' => pg_box( 40, 24, 120, 24 ) ) );
}

/** "Free site audit" band (#elegxos): pitch + checklist on the left, URL/email form on the right. */
function pg_audit_section( $form_id, $class = '', array $t = array() ) {
	$t = array_merge( array(
		'eyebrow' => 'Δωρεάν έλεγχος',
		'title'   => 'Πόσο γρήγορο είναι το site σου;',
		'text'    => 'Στείλε μας τη διεύθυνση και θα σου επιστρέψουμε μια σύντομη αναφορά με ό,τι σε κρατάει πίσω, και πώς διορθώνεται.',
		'list'    => array( 'Ταχύτητα & Core Web Vitals (κινητό και desktop)', 'Βασικό SEO: τίτλοι, meta, δομή', 'Εμπειρία στο κινητό & προσβασιμότητα' ),
		'anchor'  => 'elegxos',
	), $t );
	return pg_section( trim( 'pg-audit ' . $class ), array(
		pg_c( array_merge( pg_card_style( 48, 28 ), array(
			'css_classes'           => 'pg-audit__card fx-glow',
			'flex_direction'        => 'row',
			'flex_direction_tablet' => 'column',
			'flex_align_items'      => 'center',
			'flex_gap'              => pg_gap( 48 ),
			'padding_mobile'        => pg_all( 24 ),
		) ), array(
			pg_col( array(
				pg_eyebrow( $t['eyebrow'] ),
				pg_heading( $t['title'], 'h2', '', array( 'typography_typography' => 'custom', 'typography_font_size' => pg_size( 'clamp(28px, 3.2vw, 42px)', 'custom' ) ) ),
				pg_text( '<p>' . $t['text'] . '</p>', '', array( '__globals__' => array( 'typography_typography' => pg_gt( 'text' ), 'text_color' => pg_gc( 'text' ) ) ) ),
				pg_icon_list( $t['list'] ),
			), 50, '', 14 ),
			pg_col( array(
				pg_w( 'jet-form-builder-form', array( 'form_id' => (string) $form_id, 'submit_type' => 'ajax', 'fields_layout' => 'column', 'fields_label_tag' => 'label', 'required_mark' => '*' ) ),
			), 50, 'pg-form-inline' ),
		) ),
	), array( 'padding' => pg_box( 40, 24, 120, 24 ), 'padding_mobile' => pg_box( 24, 16, 72, 16 ) ), $t['anchor'] );
}

/** FAQ accordion (nested-accordion) with FAQ schema. $faq = [ [question, answer], … ] */
function pg_faq_widget( array $faq ) {
	$items = array();
	$panes = array();
	foreach ( $faq as $f ) {
		$items[] = array( '_id' => pg_id(), 'item_title' => $f[0] );
		$panes[] = pg_c( array( 'padding' => pg_box( 0, 24, 22, 24 ) ), array( pg_text( '<p>' . $f[1] . '</p>' ) ) );
	}
	return array(
		'id' => pg_id(), 'elType' => 'widget', 'widgetType' => 'nested-accordion',
		'settings' => array(
			'items'                                    => $items,
			'faq_schema'                               => 'yes',
			'title_tag'                                => 'h3',
			'default_state'                            => 'all_collapsed',
			'max_items_expended'                       => 'one',
			'accordion_item_title_position_horizontal' => 'stretch',
			'accordion_item_title_icon_position'       => 'end',
			'accordion_item_title_icon'                => array( 'value' => 'fas fa-plus', 'library' => 'fa-solid' ),
			'accordion_item_title_icon_active'         => array( 'value' => 'fas fa-minus', 'library' => 'fa-solid' ),
			'_css_classes'                             => 'pg-faq__list',
		),
		'elements' => $panes,
	);
}

/** Chips row, e.g. "Ιδανικό για …" / "Διάρκεια …". */
function pg_chips( array $pairs ) {
	$html = '<ul class="pg-chips">';
	foreach ( $pairs as $label => $value ) {
		$html .= '<li><span>' . $label . '</span> ' . $value . '</li>';
	}
	return pg_text( $html . '</ul>' );
}

/* ------------------------------------------------------------ JetEngine */

/** Dynamic field. $src = post_title|post_excerpt|post_content or meta:key */
function pg_dyn( $src, $tag = 'div', $class = '', array $extra = array() ) {
	$s = array( 'field_tag' => $tag, '_css_classes' => $class, 'hide_if_empty' => 'yes' );
	if ( 0 === strpos( $src, 'meta:' ) ) {
		$s += array( 'dynamic_field_source' => 'meta', 'dynamic_field_post_meta_custom' => substr( $src, 5 ) );
	} else {
		$s += array( 'dynamic_field_source' => 'object', 'dynamic_field_post_object' => $src );
	}
	return pg_w( 'jet-listing-dynamic-field', array_merge( $s, $extra ) );
}

function pg_listing_grid( $listing_id, $cols, $tablet, $mobile, $num, array $query = array(), $class = '', $anchor = '', $gap = 24 ) {
	$s = array(
		'lisitng_id'           => (string) $listing_id,
		'columns'              => (string) $cols,
		'columns_tablet'       => (string) $tablet,
		'columns_mobile'       => (string) $mobile,
		'posts_num'            => $num,
		'horizontal_gap'       => pg_size( $gap ),
		'vertical_gap'         => pg_size( $gap ),
		'equal_columns_height' => 'yes',
		'posts_query'          => $query,
		'not_found_message'    => 'Δεν βρέθηκαν εγγραφές.',
		'_css_classes'         => $class,
	);
	if ( $anchor ) {
		$s['_element_id'] = $anchor;
	}
	return pg_w( 'jet-listing-grid', $s );
}

/** The brand hexagon; $draw adds pathLength so #3 (fx-draw) can draw it. */
function pg_hex_svg( $draw = false ) {
	$paths = array( 'M31.5 1 62 19.3v34.4L31.5 72 1 53.7V19.3Z', 'M31.5 1v71', 'M1 19.3l61 34.4', 'M62 19.3 1 53.7' );
	$out   = '';
	foreach ( $paths as $i => $d ) {
		$out .= $draw ? sprintf( '<path pathLength="1" style="--d:%d" d="%s"/>', $i, $d ) : sprintf( '<path d="%s"/>', $d );
	}
	return '<svg viewBox="0 0 63 73">' . $out . '</svg>';
}

/* ------------------------------------------------------------ Save */

function pg_save_elementor( $post_id, array $data, $template_type = 'wp-page' ) {
	update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $post_id, '_elementor_template_type', $template_type );
	update_post_meta( $post_id, '_elementor_version', ELEMENTOR_VERSION );
	update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $data, JSON_UNESCAPED_UNICODE ) ) );
	update_post_meta( $post_id, '_pg_build', 1 );
}
