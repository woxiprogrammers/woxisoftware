<?php
/**
*	This file has been preloaded, so you can wp_enqueue_style to out in wp_head();
*/	

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $king;
	
	wp_enqueue_style('king-menu-18');
	
?>
<!--Header Layout 18: Location /templates/header/-->
<header class="header header18">
	<div class="container_fhstyle">
	    <!-- Logo -->
	    <div class="logo">
			<a href="<?php echo SITE_URI; ?>" id="logo18">
				<img src="<?php echo esc_url( $king->cfg['logo'] ); ?>" alt="<?php bloginfo('description'); ?>" />
			</a>    
	    </div>	
		<!-- Navigation Menu -->
	    <div class="menu_main">
	      <div class="navbar yamm navbar-default">
	          <div class="navbar-header">
	            <div class="navbar-toggle .navbar-collapse .pull-right " data-toggle="collapse" data-target="#navbar-collapse-1">
					<span><?php _e( 'Menu', 'linstar' ); ?></span>
					<button type="button"> <i class="fa fa-bars"></i></button>
	            </div>
	          </div>
	          <div id="navbar-collapse-1" class="navbar-collapse collapse pull-right">
	          		<nav><?php $king->mainmenu(); ?></nav>
	          </div>
	      </div>
	    </div>
		<!-- end Navigation Menu -->
	</div>  
</header>
<div class="clearfix margin_top8 margin_top_res18"></div>