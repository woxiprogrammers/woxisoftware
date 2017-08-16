<?php
global $king;

$atts = $king->bag['atts'];
extract( $atts );
$posts = $king->bag['posts'];
	if ( $posts->have_posts() ) {
		$i = 1;
		while ( $posts->have_posts() ) :
			
			if( $i > 3 ){
				break;	
			}
			
			$posts->the_post();
			global $post;
		?>
		
			<div class="one_third <?php if( $i == 3 )echo 'last'; ?> animated eff-fadeInUp delay-<?php echo ($i); ?>00ms">
				<a class="king-post-thumbnail" href="<?php the_permalink(); ?>">
				<?php 
					
					$img = king::get_featured_image( $post );
					echo '<img src="'.king_createLinkImage( $img, '359x220xc' ).'" alt="" class="rimg" />';
				?>
				</a>
		        <span class="bdate"><a href="<?php the_permalink(); ?>"><?php the_time( 'M <\s\t\r\o\n\g>d</\s\t\r\o\n\g> Y' ); ?></a></span>
			    <h4 title="<?php echo esc_attr($post->post_title); ?>">
			    	<a href="<?php the_permalink(); ?>">
			    		<?php echo wp_trim_words($post->post_title, 3); ?>
			    	</a> 	
			    </h4>
				<p><?php echo wp_trim_words($post->post_content, 12); ?></p>
	    		<a href="<?php the_permalink(); ?>" class="button two"><?php _e( 'Read More', 'linstar' ); ?></a>
		        
		    </div>
		<?php
			$i += 1;
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'linstar' ) . '</h4>';
		}
	?>
