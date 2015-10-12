<?php

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_loop', 'genesis_do_loop' );




//* Slogan for CTA
add_action( 'genesis_before_content', 'lwm_cta_slogan', 10 );
	function lwm_cta_slogan() {
	echo '<div class="wrap cta_slogan_area">';
	echo '<div class="slogan">';
	echo '<h2>Put Phrase to Get Attention Here</h2>';
	echo '</div>';
	echo '</div>';
}

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


//* Filler to reserve area
add_action('genesis_before_content', 'lwm_temp', 15);
	function lwm_temp () {
	echo '<div class="lwm_fill">';			
	echo '<h2>Space for Main Category page links and Blog</h2>';
	echo '</div>'; 
}


//* Run the Genesis loop
genesis();

