<?php
/**
 * (c) king-theme.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $king, $cat;

get_header();

?>

	<?php $king->breadcrumb(); ?>

	<div id="primary" class="site-content container-content content ">
		<div id="content" class="row row-content container blog-2-columns featured_section121">
			<div class="col-md-12">
				<div id="cd-timeline" class="cd-container">
				<?php
					
					$i = 0;
					$limit = get_option('posts_per_page');
					while ( have_posts() ) : the_post();
					
						
						$img = esc_url( king_createLinkImage( $king->get_featured_image( $post, true ), '120x120xc' ) );

					?>
					<div class="cd-timeline-block animated fadeInUp">
						<div class="cd-timeline-img cd-picture animated eff-bounceIn delay-200ms">
							<img src="<?php echo esc_url( $img ); ?>" alt=""> 
						</div>
						
						<div class="cd-timeline-content animated eff-<?php if( $i%2 != 0 )echo 'fadeInRight';else echo 'fadeInLeft'; ?> delay-100ms">
							<a href="<?php echo get_the_permalink($post->ID); ?>"><h2><?php echo esc_html( $post->post_title ); ?></h2></a>
							<p class="text"><?php echo substr($post->post_content,0,150); ?>...</p>
							<a href="<?php echo get_the_permalink($post->ID); ?>" class="cd-read-more">Read more</a> 
							<span class="cd-date">
								<?php 
									$date = esc_html( get_the_date('M d Y', $post->ID ) ); 
									if( $i%2 == 0 ){
										echo '<strong>'.$date.'</strong>';
									}else{
										echo '<b>'.$date.'</b>';
									}
								?>
							</span> 
						</div>
					</div>
					<?php
					$i++;
					endwhile;

					if( $i >= $limit ){
						echo '<a href="#" onclick="timelineLoadmore(' . $limit . ', ' . $cat . ', this)" class="btn btn-info aligncenter" style="margin-bottom: -110px;">Load more <i class="fa fa-angle-double-down"></i></a>';
					}
				?>
				</div>
			</div>
		</div>
	</div>
				
<?php get_footer(); ?>		



		