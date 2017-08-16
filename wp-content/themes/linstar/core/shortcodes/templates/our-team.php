<?php
global $king;

$atts = $king->bag['atts'];
extract( $atts );
$posts = $king->bag['posts'];
$i = 1;
$eff = rand(0,10);
if( $eff <= 2 ){
	$eff = 'eff-fadeInUp';
}else if( $eff > 2 && $eff <=4 ){
	$eff = 'eff-fadeInRight';
}else if( $eff > 4 && $eff <=8 ){
	$eff = 'eff-fadeInLeft';
}else{
	$eff = 'eff-flipInY';
}
if ( $posts->have_posts() ){
	
	
	echo '<div class="team-wrapper">';
	
	while ( $posts->have_posts() ) :
		$posts->the_post();
		global $post;
		
		$options = get_post_meta( $post->ID , 'king_staff' );
		$options = shortcode_atts( array(
			'position'	=> 'position',
			'facebook'	=> '',
			'twitter'	=> '',
			'gplus'	=> '',
			'skype'	=> '',
			'linkedin'	=> '',
		), $options[0], false );
		
switch( $style ){		
	
	case '2-columns' : 	
	
?>	

	<div class="one_half <?php if( $i % 2 != 0 )echo 'left';else echo 'right';?> animated eff-fadeIn<?php if( $i % 2 != 0 )echo 'Left';else echo 'Right';?> delay-<?php echo esc_attr( $i );?>00ms">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    	<?php @the_post_thumbnail(''); ?>
        </a>
        <br>
        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<p class="smtfont"><?php echo esc_html( $options['position'] ); ?></p>
        <div class="hsmline2 <?php if( $i % 2 == 0 )echo 'two'; ?>"></div>
        <br><br>
        <p><?php echo wp_trim_words( $post->post_content, $words ); ?></p>
    	<br>
        <?php if(!empty($options['facebook'])):?><a href="https://facebook.com/<?php echo esc_attr( $options['facebook'] ); ?>"><i class="fa fa-facebook"></i></a> <?php endif;?>
	    <?php if(!empty($options['twitter'])):?><a href="https://twitter.com/<?php echo esc_attr( $options['twitter'] ); ?>"><i class="fa fa-twitter"></i></a> <?php endif;?>
	    <?php if(!empty($options['gplus'])):?><a href="https://plus.google.com/u/0/+<?php echo esc_attr( $options['gplus'] ); ?>"><i class="fa fa-google-plus"></i></a><?php endif;?>
	    <?php if(!empty($options['linkedin'])):?><a href="<?php echo esc_attr( $options['linkedin'] ); ?>"><i class="fa fa-linkedin"></i></a><?php endif;?>
       
        <br><br>
        <a href="<?php the_permalink(); ?>" class="button four"><?php _e('Read More', 'linstar' ); ?></a>
        
    </div>

<?php

	break;		
	
	case 'grids' : 	
?>		
	<div class="one_fourth_less animated <?php echo esc_attr( $eff ); ?> delay-<?php echo esc_attr( $i ); ?>00ms<?php if( ($i)%4 == 0 )echo ' last'; ?>">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    	<?php @the_post_thumbnail('king rimg'); ?>
		</a>
        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p><?php echo esc_html( $options['position'] ); ?></p>
	</div>

<?php
	
	if( ($i)%4 == 0 && $i < $items ){
		echo '<div class="clearfix margin_top1"></div>';
	}
	
	break;	
	
	case 'grids-2' : 	
?>		
	<div class="one_fourth animated <?php echo esc_attr( $eff ); ?> delay-<?php echo esc_attr( $i ); ?>00ms<?php if( ($i)%4 == 0 )echo ' last'; ?>">
        <div class="attbox">
            <div class="box">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php 
			    	$img = king::get_featured_image( $post );
					echo '<img src="'.king_createLinkImage( $img, '245x245xc' ).'" alt="" class="cirimg" />';
		    	?>
				</a>
                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
				<em><?php echo esc_html( $options['position'] ); ?></em>
                
                <p><?php echo wp_trim_words( $post->post_content, $words ); ?></p>

            	<a href="<?php echo get_the_permalink(); ?>" class="button1"><?php _e('Read More', 'linstar' ); ?></a>
				
            </div>
        </div>
    </div>

<?php


	if( ($i)%4 == 0 && $i < $items )echo '<div class="margin_top9"></div><div class="clearfix"></div>';
	
	break;
		
	case 'grids-3' : 	
?>		
	<div class="one_fourth animated <?php echo esc_attr( $eff ); ?> delay-<?php echo esc_attr( $i ); ?>00ms<?php if( ($i)%4 == 0 )echo ' last'; ?>">
        <div class="attbox">
            <div class="box">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php 
			    	$img = king::get_featured_image( $post );
					echo '<img src="'.king_createLinkImage( $img, '270x257xc' ).'" alt="" class="cirimg" />';
		    	?>
				</a>
                <h5 class="roboto caps"><a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a></h5>
				<p><?php echo esc_html( $options['position'] ); ?></p>
				<?php if(!empty($options['facebook'])):?><a href="https://facebook.com/<?php echo esc_attr( $options['facebook'] ); ?>"><i class="fa fa-facebook"></i></a> <?php endif;?>
				<?php if(!empty($options['twitter'])):?><a href="https://twitter.com/<?php echo esc_attr( $options['twitter'] ); ?>"><i class="fa fa-twitter"></i></a> <?php endif;?>
	    		<?php if(!empty($options['gplus'])):?><a href="https://plus.google.com/u/0/+<?php echo esc_attr( $options['gplus'] ); ?>"><i class="fa fa-google-plus"></i></a><?php endif;?>
	    		<?php if(!empty($options['linkedin'])):?><a href="<?php echo esc_attr( $options['linkedin'] ); ?>"><i class="fa fa-linkedin"></i></a><?php endif;?>
            </div>
        </div>
    </div>

<?php


	if( ($i)%4 == 0 && $i < $items )echo '<div class="margin_top9"></div><div class="clearfix"></div>';
	
	break;
			
	case 'grids-4' : 	
?>		
	<div class="one_fourth animated <?php echo esc_attr( $eff ); ?> delay-<?php echo esc_attr( $i ); ?>00ms<?php if( ($i)%4 == 0 )echo ' last'; ?>">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
        <?php 
	    	$img = king::get_featured_image( $post );
			echo '<img src="'.king_createLinkImage( $img, '257x285xc' ).'" alt="" />';
    	?>
		</a>
    	<span><strong><?php the_title(); ?></strong> <?php echo esc_html( $options['position'] ); ?></span>
    	<div class="persoci">
        	<a href="<?php the_permalink(); ?>"><i class="fa fa-plus"></i></a>
            
            <?php if(!empty($options['facebook'])):?><a href="https://facebook.com/<?php echo esc_attr( $options['facebook'] ); ?>"><i class="fa fa-facebook two"></i></a> <?php endif;?>
			<?php if(!empty($options['twitter'])):?><a href="https://twitter.com/<?php echo esc_attr( $options['twitter'] ); ?>"><i class="fa fa-twitter two"></i></a> <?php endif;?>
			<?php if(!empty($options['gplus'])):?><a href="https://plus.google.com/u/0/+<?php echo esc_attr( $options['gplus'] ); ?>"><i class="fa fa-google-plus two"></i></a><?php endif;?>
			<?php if(!empty($options['linkedin'])):?><a href="<?php echo esc_attr( $options['linkedin'] ); ?>"><i class="fa fa-linkedin two"></i></a><?php endif;?>
		</div>
    </div>

<?php


	if( ($i)%4 == 0 && $i < $items )echo '<div class="margin_top9"></div><div class="clearfix"></div>';
	
	break;
	
	
	case '2-columns-2' : 

?>	
<div class="one_half <?php if( $i % 2 == 0 && $i != 0 )echo 'last';?> animated eff-fadeIn<?php if( $i % 2 != 0 )echo 'Left';else echo 'Right';?> delay-<?php echo esc_attr( $i );?>00ms">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    	<?php 
	    	$img = king::get_featured_image( $post );
			echo '<img src="'.king_createLinkImage( $img, '278x180xc' ).'" alt="" />';
    	?>
		</a>
        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><em><?php echo esc_html( $options['position'] ); ?></em></h5>
        <p><?php echo wp_trim_words( $post->post_content, $words ); ?></p>
        <br />
        <a href="<?php the_permalink(); ?>" class="button four"><?php _e('Read More', 'linstar' ); ?></a>
        
    </div>
<?php

	if( $i%2 == 0 && $i != 0 && $i < $items )echo '<div class="clearfix margin_top5"></div>';
	break;
		
	case 'circle-1' : 

?>	
	<div class="one_fourth animated <?php echo esc_attr( $eff ); ?> delay-<?php echo esc_attr( $i ); ?>00ms<?php if( ($i)%4 == 0 )echo ' last'; ?>">
    	<?php 
	    	$img = king::get_featured_image( $post );
			echo '<img src="'.king_createLinkImage( $img, '250x250xc' ).'" class="cirimg" alt="" />';
    	?>
        <div class="cinfo">
            <img src="<?php echo esc_url( THEME_URI.'/assets/images/shape1.jpg' ); ?>" alt="" class="shape1">
        	<h5><?php the_title(); ?></h5>
			<em><?php echo esc_html( $options['position'] ); ?></em>
            <p class="des"><?php echo wp_trim_words( $post->post_content, $words ); ?></p>
           <?php if(!empty($options['facebook'])):?> <a href="https://facebook.com/<?php echo esc_attr( $options['facebook'] ); ?>"><i class="fa fa-facebook"></i></a> <?php endif;?>
			<?php if(!empty($options['twitter'])):?><a href="https://twitter.com/<?php echo esc_attr( $options['twitter'] ); ?>"><i class="fa fa-twitter"></i></a> <?php endif;?>
	    	<?php if(!empty($options['gplus'])):?><a href="https://plus.google.com/u/0/+<?php echo esc_attr( $options['gplus'] ); ?>"><i class="fa fa-google-plus"></i></a><?php endif;?>
			<?php if(!empty($options['linkedin'])):?><a href="<?php echo esc_attr( $options['linkedin'] ); ?>"><i class="fa fa-linkedin"></i></a><?php endif;?>
            <br>
            <a href="<?php the_permalink(); ?>" class="button four"><?php _e( 'Read Full Bio', 'linstar' ); ?></a>   
        </div>
    </div>
<?php

	if( $i%4 == 0 && $i != 0 && $i < $items )echo '<div class="clearfix margin_top5"></div>';
	break;
	
}	


	$i++;
	endwhile;

	echo '</div>';
	
}else {
	echo '<h4>' . __( 'Teams not found', 'linstar' ) . '</h4> <a href="'.admin_url('post-new.php?post_type=our-team').'"><i class="fa fa-plus"></i> Add New Staff</a>';
}
	
?>