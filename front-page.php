<?php

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_loop', 'genesis_do_loop' );

//*Move Main Nav above image
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );

//* Call to Action Widget Area
add_action( 'genesis_before_content', 'lwm_cta', 15 );
	function lwm_cta() {
	echo '<div class="lwm_cta_block">';
	echo '<div class="wrap cta_widgets">';
		genesis_widget_area( 'lwm_cta_left', array(
			'before' => '<div class="lwm_cta_leftside">',
			'after' => '</div>',
	) );
			genesis_widget_area( 'lwm_cta_right', array(
			'before' => '<div class="lwm_cta_rightside">',
			'after' => '</div>',
	) );
	echo '</div>';
	echo '</div>';  
}



//* Run the Genesis loop
genesis();

