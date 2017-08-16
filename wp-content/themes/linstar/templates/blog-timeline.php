<?php
	/**
	*
	* @author king-theme.com
	*
	*/
	
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
get_header();
global $king, $post, $cat;
$pid =  get_option( 'page_for_posts' );

$page_title = get_post_meta( $pid, '_king_page_page_title', true );

//check default background setting
if( !empty($king->cfg['breadcrumb_bg']) )
{
	$page_bread_bg = str_replace( '%HOME_URL%', HOME_URL, $king->cfg['breadcrumb_bg'] );
}

$page_brc = get_post_meta( $pid, '_king_page_breadcrumb_bg', true );

$page_desc = get_post_meta( $pid, '_king_page_description', true );

if(!empty($page_brc))
{
	$page_bread_bg = str_replace( '%HOME_URL%', HOME_URL, $page_brc );
}

$brc = get_post_meta( $pid, '_king_page_breadcrumb', true );
?>
<div class="clearfix"></div>
<?php if( $brc == 'global' ){?>
<div class="page_title1"<?php if( !empty($page_bread_bg) ){
			echo ' style="background-image:url('.esc_url($page_bread_bg).')" ';
		}?>>
	<div class="container">
	    <h1><?php if( !empty( $page_title ) ){echo king::esc_js( $page_title );}else{_e( 'History Timeline', 'linstar' );} ?></h1>
	    <div class="pagenation">
	    	&nbsp;<a href="<?php echo SITE_URI; ?>"><?php _e('Home', 'linstar' ); ?></a> 
	    	<i>/</i> <?php _e( 'History Timeline', 'linstar' ); ?>
	    </div>
	</div>
</div>
<?php 
}
else if( $brc  != 'no' )
{
	$king->breadcrumb();
}
?>
<div class="clearfix"></div>
<div class="content_fullwidth less featured_section121 blog-timeline">
	<div class="features_sec65">
		<div class="container no-touch">
			<div id="cd-timeline" class="cd-container">
				<?php king_ajax_loadPostsTimeline(); ?>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<?php get_footer(); ?>   