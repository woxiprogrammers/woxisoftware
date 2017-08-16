<?php

global $king, $post;
extract( $king->bag );

$style = '';

echo '<div id="breadcrumb"';
if( !empty($page_bread_bg) )
{
	$style .= 'background-image:url('.esc_url($page_bread_bg).');';
}

if( isset( $bread_padding_top ) &&  $bread_padding_top != '' )
{
	$style .= 'padding-top:'. esc_attr( (int) $bread_padding_top ) .'px;';
}

if( isset( $bread_padding_bottom ) &&  $bread_padding_bottom != '' )
{
	$style .= 'padding-bottom:'.esc_attr( (int) $bread_padding_bottom ) .'px;';
}

echo ' style="' . esc_attr( $style ) .'"';
echo ' class="container-fluid breadcrumbs page_title2">';

echo '<div class="container"><div class="col-md-12">';
echo '<div class="title"><h1>';
if( !empty( $page_title ) )
{
	echo king::esc_js( $page_title );
}
else
{

	if( is_home() )
	{
		//if current home page is blog page
		if(  get_option('page_for_posts') )
		{

			$curPost = get_post( get_option('page_for_posts') );

			echo esc_html( $curPost->post_title );
		}
		else 
			echo esc_html( get_bloginfo( 'name' ) );
		// if not, just show website name
	}
	else if(is_single() || is_page())
	{
		global $post;
		//current page is a page or single post
		echo esc_html( $post->post_title );

	}else{

		echo esc_html( $title ); 
	}
}

echo '</h1></div>';
//Show path of links

echo '<div class="pagenation">';

echo '<div class="breadcrumbs">';

if ( !is_home() ) 
{

	echo '<a href="'.home_url().'">'.__('Home', 'linstar' )."</a> ";
}

if( !empty( $post->post_type ) )
{
	$post_type_path  = str_replace( '-', '_', $post->post_type );

	$post_type_title = ( isset( $king->cfg[ $post_type_path.'_title' ] ) && !empty( $king->cfg[ $post_type_path.'_title' ] ) )? $king->cfg[ $post_type_path.'_title' ]: ucwords( str_replace( '-', ' ', $post->post_type ) );

	//show path links of custom post type
	if( $post->post_type != 'post' && $post->post_type != 'page' )
	{
		echo esc_html( $king->cfg['breadeli'] ).' '.$post_type_title;
	}

}		

if( is_home() )
{
	if(  get_option('page_for_posts') )
	{
		$curPost = get_post( get_option('page_for_posts') );

		echo esc_html( $king->cfg['breadeli'] ).' '.$curPost->post_title.' ';

	}
	else
	{
		echo 'Front Page '.esc_html( $king->cfg['breadeli'] );
	}
}


if ( is_category() ) 
{
	echo esc_html( $king->cfg['breadeli'] ).' '.single_cat_title( '', false );
}

if( is_page() )
{

	if( $post->post_parent )
	{

		$parent = get_post( $post->post_parent );

		echo esc_html( $king->cfg['breadeli'] ).' <a href="'.get_permalink( $post->post_parent ).'">'.$parent->post_title.'</a> ';
	}
}

if( ( is_single() || is_page() ) && !is_front_page() ) 
{

	echo ' '.esc_html( $king->cfg['breadeli'] )." <span>";

	the_title();

	echo "</span>";
}

if( is_tag() )
{ 
	echo esc_html( $king->cfg['breadeli'] )." <span>Tag: ".single_tag_title('',FALSE).'</span>'; 
}

if( is_404() )
{
	echo esc_html( $king->cfg['breadeli'] )." <span>404 - Page not Found</span>"; 
}

if( is_search() )
{
	echo esc_html( $king->cfg['breadeli'] )." <span>Search</span>";
}

if( is_year() )
{
	echo esc_html( $king->cfg['breadeli'] ).' '.get_the_time('Y'); 
}

echo "</div></div></div></div></div>";

echo '<div class="clearfix margin_top8"></div>';
?>