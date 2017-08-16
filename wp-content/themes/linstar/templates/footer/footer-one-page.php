<?php
/*
*	(c) king-theme.com
*/	
	
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
	global $king;
	if( empty( $king->cfg['footerText'] ) ){
		$king->cfg['footerText'] = 'Add footer copyrights text via <a href="'.admin_url('admin.php?page='.strtolower(THEME_NAME).'-panel').'"><strong>theme-panel</strong></a>';
	}
	
?>
<!--Footer Layout 8: Location /templates/footer/-->
<div class="featured_section82 two" id="contact">
	<div class="container">
	
		<div class="box">
			<span class="icon-screen-smartphone animated eff-zoomIn delay-200ms"></span>
	        <b class="animated eff-fadeInRight delay-300ms"><?php _e( 'CALL US', 'linstar' ); ?></b>
			<strong class="animated eff-fadeInRight delay-300ms"><?php echo esc_attr( $king->cfg['topInfoPhone'] ); ?></strong>
	    </div><!-- end section -->
	    
	    <div class="box">
			<span class="icon-envelope-letter animated eff-zoomIn delay-200ms"></span>
	        <b class="animated eff-fadeInRight delay-300ms"><?php _e( 'Mail Us', 'linstar' ); ?></b>
			<strong class="animated eff-fadeInRight delay-300ms">
				<a href="mailto:<?php echo esc_attr( $king->cfg['topInfoEmail'] ); ?>">
					<?php echo esc_attr( $king->cfg['topInfoEmail'] ); ?>
				</a>
			</strong>
	    </div><!-- end section -->
	    
	    <?php 
		if( !isset($king->cfg['footer_social']) || $king->cfg['footer_social'] ==1 ){
			$king->socials( 'box last', 4 );
		}
		?>
	
	</div>
</div>
<div class="clearfix"></div>
<div class="featured_section207 two">
	<div class="fgmapfull3">
    	<?php echo '<ifr'.'ame src="'.esc_url( $king->cfg['footerMap'] ).'" frameborder="0" style="border:0"></ifr'.'ame>'; ?>
	</div><!-- end google map -->
    <div class="ongmp_contact"></div>
    <div class="container">
        <div class="box">
            <h1 class="roboto caps white"><b>Contact</b></h1>
            <div class="cforms four">
            <div id="form_status"></div>
            	<div class="king-form two">
					<?php echo do_shortcode( '[contact-form-7 id="95"]' ); ?>
				</div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="featured_section208 two">
    <div class="ctmidarea ovfull_container">
    	<?php echo king::esc_js( $king->cfg['footerText'] ); ?>
    	<span>
			<?php if( !empty( $king->cfg['footerTerms'] ) ){ ?>
			<a href="<?php echo esc_url( $king->cfg['footerTerms'] ); ?>"> 
				<?php _e('Terms of Use', 'linstar' ); ?>
			</a> 
			<?php }
			if( !empty( $king->cfg['footerPrivacy'] ) ){
			?>
			| 
			<a href="<?php echo esc_url( $king->cfg['footerPrivacy'] ); ?>">
				<?php _e('Privacy Policy', 'linstar' ); ?>
			</a>
			<?php }?>
    	</span>
	</div>
</div>