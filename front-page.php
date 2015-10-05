<?php

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_loop', 'genesis_do_loop' );

//*Move Main Nav above image
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_nav' );



//* Run the Genesis loop
genesis();

