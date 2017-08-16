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
<!--Footer Layout 4: Location /templates/footer/-->
<footer class="footer4">
    <div class="container">
        <div class="fmlinks">
        	<?php 
        		if ( has_nav_menu( 'footer' ) ){
		        	wp_nav_menu( array( 
						'theme_location' 	=> 'footer', 
						'menu_class' 		=> '',
						'menu_id'			=> 'king-footer-nav',
						'walker' 			=> new king_Walker_Footer_Nav_Menu()
						)
					);
				}	
        	?>
        </div>
        <?php echo king::esc_js( $king->cfg['footerText'] ); ?> 
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
        <?php 
		if( !isset($king->cfg['footer_social']) || $king->cfg['footer_social'] ==1 ){
			$king->socials('footer_social_links4', 5, false);
		}
		?>
    </div>
    <!-- end footer -->
</footer>
