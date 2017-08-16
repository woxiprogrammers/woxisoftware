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
<!--Footer Layout 3: Location /templates/footer/-->
<footer class="footer3">
    <div class="container">
        <div class="left animated eff-fadeInLeft delay-150ms">
            <h3 class="white"><?php _e( 'CONTACT US', 'linstar' ); ?></h3>
            <p>
            	<?php if( isset($king->cfg['footer3_text']) && !empty($king->cfg['footer3_text'])){
					echo $king->esc_js($king->cfg['footer3_text']);
				}else{?>
				<?php _e( 'Feel free to talk to our online representative at any time you please using our Live Chat system on our website or one of the instant messaging programs.', 'linstar' ); ?>
				<?php }?>
            </p>
            <br>
            <br>
            <div class="one_half">
                <?php if ( is_active_sidebar( 'footer3' ) ) : ?>
					<div id="footer3" class="widget-area" role="complementary">
						<?php dynamic_sidebar( 'footer3' ); ?>
					</div><!-- #secondary -->
				<?php endif; ?>
            </div>
            <!-- end section -->
            <div class="one_half last">
                <h6 class="white uline">Get in Touch</h6>
				<?php if( !isset($king->cfg['footer_social']) || $king->cfg['footer_social'] ==1 ){?>
                <?php $king->socials('footer_social_links3'); ?>
				<?php }?>
            </div>
            <!-- end section -->
        </div>
        <!-- end left section -->
        <div class="right animated eff-fadeInRight delay-150ms">
			<div class="king-form two">
				<?php echo do_shortcode( '[contact-form-7 id="95"]' ); ?>
			</div>
        </div>
    </div>
    <!-- end footer -->
</footer>
<div class="clearfix"></div>
<div class="copyright_info3">
	<div class="container">
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
	</div>
</div>