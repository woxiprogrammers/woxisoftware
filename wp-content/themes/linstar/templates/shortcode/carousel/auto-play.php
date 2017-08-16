<?php
global $king;


$atts                                   = $king->bag['atts'];
$carousel_id                            = $king->bag['carousel_id'];
$images                                 = $king->bag['images'];
$css_class                              = $king->bag['css_class'];
$custom_links                           = $king->bag['custom_links'];
$img_size                               = $atts['img_size'];
$action_click                           = $atts['action_click'];
$custom_links_target                    = $atts['custom_links_target'];
$slides_per_view                        = $atts['slides_per_view'];
$hide_pagination_control                = $atts['hide_pagination_control'];
$hide_prev_next_buttons                 = $atts['hide_prev_next_buttons'];

$navigation = 'true';
if($hide_prev_next_buttons=='yes'){
	$navigation = 'false';
}
$pagination = 'true';
if($hide_pagination_control=='yes'){
	$pagination = 'false';
}
?>
<div id="<?php echo esc_attr( $carousel_id );?>"  class="owl-carousel <?php echo esc_attr( $css_class ); ?>">
	<?php foreach ( $images as $attach_id ): ?>
		<div class="item">
		<?php
			$i=0;
			$i ++;
			if ( $attach_id > 0 ) {
				$post_thumbnail = wpb_getImageBySize( array(
					'attach_id' => $attach_id,
					'thumb_size' => $img_size
				) );
			} else {
				$post_thumbnail = array();
				$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
				$post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
			}
			$thumbnail = $post_thumbnail['thumbnail'];
		?>
		<?php if ( 'link_image' === $action_click ): ?>
			<?php $p_img_large = $post_thumbnail['p_img_large']; ?>
			<a class="prettyphoto"  rel="prettyPhoto[<?php echo esc_attr( $carousel_id );?>]"
			   href="<?php echo esc_url( $p_img_large[0] ); ?>" <?php echo king::esc_js( $pretty_rand ); ?>>
				<?php echo king::esc_js( $thumbnail ); ?>
			</a>
		<?php elseif ( 'custom_link' === $action_click && isset( $custom_links[ $i ] ) && '' !== $custom_links[ $i ] ): ?>
			<a
				href="<?php echo esc_url( $custom_links[ $i ] ); ?>"<?php echo( ! empty( $custom_links_target ) ? ' target="' . esc_attr( $custom_links_target ). '"' : '' ) ?>>
				<?php echo king::esc_js( $thumbnail ); ?>
			</a>
		<?php else: ?>
			<?php echo king::esc_js( $thumbnail ); ?>
		<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("#<?php echo esc_attr( $carousel_id );?>").owlCarousel({
		autoPlay: 3000,
		navigation: <?php echo esc_attr($navigation);?>,
		pagination: <?php echo esc_attr($pagination);?>,		
		items : <?php echo esc_attr($slides_per_view);?>,
		itemsDesktop : [1170,3],
		itemsDesktopSmall : [1170,3]
	});
});
</script>