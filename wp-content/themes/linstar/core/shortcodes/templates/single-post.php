<?php
global $king;

$atts = $king->bag['atts'];
extract( $atts );
$posts = $king->bag['posts'];
?>
<div class="king-posts king-posts-single-post">
	<?php
		// Prepare marker to show only one post
		$first = true;
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;

				// Show oly first post
				if ( $first ) {
					$first = false;
					?>
					<div id="king-post-<?php the_ID(); ?>" class="king-post">
						<h1 class="king-post-title"><?php the_title(); ?></h1>
						<div class="king-post-meta"><?php _e( 'Posted', 'linstar' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?> | <a href="<?php comments_link(); ?>" class="king-post-comments-link"><?php comments_number( __( '0 comments', 'linstar' ), __( '1 comment', 'linstar' ), __( '%n comments', 'linstar' ) ); ?></a></div>
						<div class="king-post-content">
							<?php the_content(); ?>
						</div>
					</div>
					<?php
				}
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'linstar' ) . '</h4>';
		}
	?>
</div>