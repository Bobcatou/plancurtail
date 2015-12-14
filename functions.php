<?php
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.2.0' );

// Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,300', array(), CHILD_THEME_VERSION );

}

// Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

// Add Accessibility support
// add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu', 'search-form', 'skip-links', 'rems' ) );
add_theme_support( 'genesis-accessibility', array( 'headings', 'search-form', 'skip-links', 'rems' ) );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom background
add_theme_support( 'custom-background' );

// Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

/**********************************
 *
 * Replace Header Site Title with Inline Logo
 *
 * Fixes Genesis bug - when using static front page and blog page (admin reading settings) Home page is <p> tag and Blog page is <h1> tag
 *
 * Replaces "is_home" with "is_front_page" to correctly display Home page wit <h1> tag and Blog page with <p> tag
 *
 * @author AlphaBlossom / Tony Eppright
 * @link http://www.alphablossom.com/a-better-wordpress-genesis-responsive-logo-header/
 *
 * @edited by Sridhar Katakam
 * @link http://www.sridharkatakam.com/use-inline-logo-instead-background-image-genesis/
 *
************************************/
add_filter( 'genesis_seo_title', 'custom_header_inline_logo', 10, 3 );
function custom_header_inline_logo( $title, $inside, $wrap ) {

	$logo = '<img src="' . get_stylesheet_directory_uri() . '/images/logo.png" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="359" height="72" />';

	$inside = sprintf( '<a href="%s" title="%s">%s</a>', trailingslashit( home_url() ), esc_attr( get_bloginfo( 'name' ) ), $logo );

	// Determine which wrapping tags to use - changed is_home to is_front_page to fix Genesis bug
	$wrap = is_front_page() && 'title' === genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : 'p';

	// A little fallback, in case an SEO plugin is active - changed is_home to is_front_page to fix Genesis bug
	$wrap = is_front_page() && ! genesis_get_seo_option( 'home_h1_on' ) ? 'h1' : $wrap;

	// And finally, $wrap in h1 if HTML5 & semantic headings enabled
	$wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

	return sprintf( '<%1$s %2$s>%3$s</%1$s>', $wrap, genesis_attr( 'site-title' ), $inside );

}

// Remove the site description
//remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'custom_scripts_styles_mobile_responsive' );
function custom_scripts_styles_mobile_responsive() {

	wp_enqueue_script( 'responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_style( 'dashicons' );
}

// Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'sp_previous_page_link' );
function sp_previous_page_link ( $text ) {
	return g_ent( '&laquo; ' ) . __( 'Previous Page', CHILD_DOMAIN );
}

// Customize the next page link
add_filter ( 'genesis_next_link_text' , 'sp_next_page_link' );
function sp_next_page_link ( $text ) {
	return __( 'Next Page', CHILD_DOMAIN ) . g_ent( ' &raquo; ' );
}

/**
 * Remove Genesis Page Templates
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/remove-genesis-page-templates
 *
 * @param array $page_templates
 * @return array
 */
function be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'be_remove_genesis_page_templates' );


/**********************************
 *
 * Listen to the Wind Media Changes
 *
************************************/
/**
*Custom Login Logo
**/
function my_loginlogo() {
  echo '<style type="text/css">
    h1 a {
      background-image: url(' . get_stylesheet_directory_uri() . '/images/logo.png) !important;
    }
  </style>';
}
/**
*Hover Title for Logo
**/
add_action('login_head', 'my_loginlogo');

function my_loginURLtext() {
    return 'Plan Curtail';
}
add_filter('login_headertitle', 'my_loginURLtext');


function my_logincustomCSSfile() {
    wp_enqueue_style('login-styles', get_stylesheet_directory_uri() . '/login_styles.css');
}
add_action('login_enqueue_scripts', 'my_logincustomCSSfile');


/**
*URL for custom logo
**/
function my_loginURL() {
    return 'http://wpbryan.com/development/plancurtail';
}
add_filter('login_headerurl', 'my_loginURL');




/**
*Customer Support Admin Notice
**/

function howdy_message($translated_text, $text, $domain) {
    $new_message = str_replace('Howdy', 'Call Listen to the Wind Media at 678-520-9914 if you have a question', $text);
    return $new_message;
}
add_filter('gettext', 'howdy_message', 10, 3);




//* Customize search form input box text
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( 'Search Plancurtail' );
}

// Make Font Awesome available - Originally for search form magnifying glass
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {

	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );

}

// Customize search form input button text (adds magnfying glass)
add_filter( 'genesis_search_button_text', 'sk_search_button_text' );
function sk_search_button_text( $text ) {

	return esc_attr( '&#xf002;' );

}

//* Remove Post Info, Post Meta from Custom Post Types
add_action ( 'get_header', 'rv_cpt_remove_post_info_genesis' );
function rv_cpt_remove_post_info_genesis() {
	if ( 'post' !== get_post_type() ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}

//* Footer Back to Home Link
add_action('genesis_before_footer', 'lwm_back_to_home', 5);
	function lwm_back_to_home () {
	echo '<div class="lwm_back_to_home_block">';
	echo '<div class="wrap interior_bth">';
	echo '<div class="back_to_home">';
	echo '<h4>Back to Home page</h4>';
	echo '</div>';
	echo '</div>';
	echo '</div>';

	}
	
	



//* Show custom menu in Footer
//add_action( 'genesis_footer', 'sk_custom_menu_in_footer', 5 );
//function sk_custom_menu_in_footer() {

//	$class = 'menu genesis-nav-menu menu-footer';

//	$args = array(
//		'menu'           => 'Footer Menu', // Enter name of your custom menu here
//		'container'      => '',
//		'menu_class'     => $class,
//		'echo'           => 0,
//		'depth'           => 1,
//	);

//	$nav = wp_nav_menu( $args );

//	$nav_markup_open = genesis_markup( array(
//		'html5'   => '<nav %s>',
//		'xhtml'   => '<div id="nav">',
//		'context' => 'nav-footer',
//		'echo'    => false,
//	) );
//	$nav_markup_open .= genesis_structural_wrap( 'menu-footer', 'open', 0 );

//	$nav_markup_close  = genesis_structural_wrap( 'menu-footer', 'close', 0 );
//	$nav_markup_close .= genesis_html5() ? '</nav>' : '</div>';

//	$nav_output = $nav_markup_open . $nav . $nav_markup_close;

//	echo $nav_output;

//}

//* Customize footer credits
//add_filter( 'genesis_footer_creds_text', 'sp_footer_creds_text' );
//function sp_footer_creds_text() {
//echo '<div class="lwm_credits"><p>';
//echo 'Copyright &copy; ';
//echo date('Y');
//echo ' &middot; <a href="http://plancurtail.org">Plan Curtail</a> &middot; Built by: <a href="http://www.listentothewindmedia.com" title="Listen to the Wind Media">Listen to the Wind Media</a>';
//echo '</p></div>';
//}




/**
* Change the site description (also called tagline)
* to include html code.
* Remove description, add whatever change you want to make.
* Then add description back to header.
*
* @author Terry Collins
* @since 1.0.0
*/
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
//add_action( 'genesis_before_header', 'child_seo_site_description', 5 );

//function child_seo_site_description() {

//echo '<h2 class="site-description">Our Mission: <em>To motivate and aid people in reducing their energy use and C0<sub>2</sub> emissions</em></h2>';

//}


//* Adds Searchbox to Primary menu

//add_filter( 'wp_nav_menu_items', 'theme_menu_extras', 10, 2 );
/**
 * Filter menu items, appending either a search form or today's date.
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
//function theme_menu_extras( $menu, $args ) {

	//* Change 'primary' to 'secondary' to add extras to the secondary navigation menu
//	if ( 'primary' !== $args->theme_location )
//		return $menu;

	
//	ob_start();
//	get_search_form();
//	$search = ob_get_clean();
//	$menu  .= '<li class="right search">' . $search . '</li>';

//	return $menu;

//}



/**********************************
 ** WiDGET SECTION BELOW
************************************/

//* New CTA/Donate Section

//* 1st Column
genesis_register_sidebar( array(
	'id'            => 'lwm_donate_column_1',
	'name'          => __( 'CTA/Donate Area - First Third', 'plancurtail' ),
	'description'   => __( 'Initial Build Coded 1/3 width', 'plancurtail' ),
) );
//* 2nd Column
genesis_register_sidebar( array(
	'id'            => 'lwm_donate_column_2',
	'name'          => __( 'CTA/Donate Area - Second Third', 'plancurtail' ),
	'description'   => __( 'Initial Build Coded 1/3 width', 'plancurtail' ),
) );
genesis_register_sidebar( array(
	'id'            => 'lwm_donate_column_3',
	'name'          => __( 'CTA/Donate Area - Third Third', 'plancurtail' ),
	'description'   => __( 'Initial Build Coded 1/3 width', 'plancurtail' ),
) );



//* CTA Widget section

//* 1st Column
//genesis_register_sidebar( array(
//	'id'            => 'lwm_cta_left',
//	'name'          => __( 'CTA - Left Side', 'plancurtail' ),
//	'description'   => __( 'Initial Build Coded 1/2 width', 'plancurtail' ),
//) );
//* 2nd Column
//genesis_register_sidebar( array(
//	'id'            => 'lwm_cta_right',
//	'name'          => __( 'CTA - Right Side', 'plancurtail' ),
//	'description'   => __( 'Initial Build Coded 1/2 width', 'plancurtail' ),
//) );




//* Featured Category and Blog Section

//* 1st Column
genesis_register_sidebar( array(
	'id'            => 'lwm_fpb_column_1',
	'name'          => __( 'Featured Area - Housing', 'plancurtail' ),
	'description'   => __( 'Section for Featured Housing Article', 'plancurtail' ),
) );
//* 2nd Column
genesis_register_sidebar( array(
	'id'            => 'lwm_fpb_column_2',
	'name'          => __( 'Featured Area - Cars', 'plancurtail' ),
	'description'   => __( 'Section for Featured Cars Article', 'plancurtail' ),
) );

//* 3rd Column
genesis_register_sidebar( array(
	'id'            => 'lwm_fpb_column_3',
	'name'          => __( 'Featured Area - Food', 'plancurtail' ),
	'description'   => __( 'Section for Featured Article', 'plancurtail' ),
) );





