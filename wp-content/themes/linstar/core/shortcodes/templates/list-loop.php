<?php
global $king;

$atts = $king->bag['atts'];
extract( $atts );
$posts = $king->bag['posts'];
?>
<ul class="king-posts king-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>
<li id="king-post-<?php the_ID(); ?>" class="king-post"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
	}
}
// Posts not found
else {
?>
<li><?php _e( 'Posts not found', 'linstar' ) ?></li>
<?php
}
?>
</ul>
