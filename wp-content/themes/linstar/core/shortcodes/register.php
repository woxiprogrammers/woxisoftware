<?php

class king_shortcodes {
	
	static $youTubePlayerReady = false;
	static $elements;
	
	public static function register() {
	
		global $king;
		
		include dirname(__FILE__).DS.'assets.php';
		include dirname(__FILE__).DS.'tools.php';
		include dirname(__FILE__).DS.'elements.php';
		
		self::$elements = new king_elements();
		
		foreach( array(
			'margin',
			'faq',
			'king_loop',
			'king_posts',
			'king_carousel',
			'team',
			'work',
			'testimonials',
			'php',
			'piechart',
			'pricing',
			'progress',
			'flex_sliders',
			'fslider',
			'videobg',
			'divider',
			'titles',
			'flip_clients',
			'elements',
			'posts',
			'cf7'
		) as $name ){
			$king->ext['asc']( $name, array( __CLASS__, $name ) );
		}
	}
	
	public static function get_posts( $atts ){
	
		$args = array(
			'posts_per_page'   => intval($atts['items']),
			'orderby'          => 'menu_order post_date date title',
			'order'            => $atts['order'],
			'post_type'        => $atts['post_type'],
			'post_status'      => 'publish',
			'offset' 		   => intval($atts['offset']),
			'suppress_filters' => true,
		);
		
		if( !empty( $atts['category'] ) ){
			$args['tax_query'] = array(
	            array(
	                'taxonomy' => $atts['taxonomy'],
	                'field' => 'slug',
	                'terms' => explode( ',', $atts['category'] )
	            )
	        );
		}
		
		return get_posts( $args );
		
	}
	
	public static function margin( $atts = null, $content = null ) {

		$atts = shortcode_atts( array( 'margin_top' => '', 'margin_bottom' => '' ), $atts, 'margin' );
		$class = 'clearfix';
		if( !empty( $atts['margin_top'] ) ){
			$class .= ' margin_top'.str_replace( '0px', '', $atts['margin_top'] );
		}
		if( !empty( $atts['margin_bottom'] ) ){
			$class .= ' margin_bottom'.str_replace( '0px', '', $atts['margin_bottom'] );
		}

		if( $class != 'clearfix' ){
			return '<div class="'.$class.'"></div>';
		}else{
			return '';
		}
	
	}
		
	public static function faq( $atts = null, $content = null ) {

		$error = null;
		$atts = shortcode_atts( array( 'amount' => 20, 'category' => '' ), $atts, 'faq' );
		
		$args = array(
			'posts_per_page'   => intval($atts['amount']),
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'menu_order post_date date title',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'faq',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		);
		
		if( !empty( $atts['category'] ) ){
			$args['tax_query'] = array(
	            array(
	                'taxonomy' => 'faq-category',
	                'field' => 'slug',
	                'terms' => split( ',', $atts['category'] )
	            )
	        );
		}
		
		$faqs = get_posts( $args );
		
		$out = '[vc_accordion collapsible="" disable_keyboard="" style="1" icon="icon-arrow"]';
		if( count( $faqs ) ){
			foreach( $faqs as $faq ){
				$title = $faq->post_title;
				$title = str_replace( array('&','"'), array('&amp; ','&quot;'), $title );
				$out .= '[vc_accordion_tab title="'.$title.'"]';
				$content = $faq->post_content;
				$content = str_replace( array('[',']'), array('{','}'), $content );
				$out .= $content.'[/vc_accordion_tab]';
			}
		}
		$out .= '[/vc_accordion]';
		
		return do_shortcode( $out );	
			
	}
	
	
	public static function king_loop( $atts = null, $content = null ) {
		
		global $king;
		
		$atts = shortcode_atts( array( 
			'items' => 20, 
			'category' => '', 
			'showing' => '', 
			'per_row' => 4, 
			'class' => '', 
			'odd_class' => '', 
			'even_class' => '', 
			'words' => 20,
			'img_size' => '245x245',
			'format' => '',
			'highlight' => 3,
			
			'post_type' => 'post',
			'taxonomy' => 'category',
			'offset' => 0,
			
			'order' => 'DESC' ), $atts, 'faq' );
	
		if( !empty( $atts['category'] ) ){
			$cats = explode( ',', $atts['category'] );
			$tax = array();
			foreach( $cats as $k => $v ){
				$v = explode( ':', $v );
				if( !empty($v[1]) ){
					array_push( $tax , str_replace( '&#58;', ':', $v[1] ) );
				}	
			}
			
			$atts['category'] = implode( ',', $tax );
			
			if( !empty( $cats[0] ) ){
				$cats[0] = explode( ':', $cats[0] );
				$atts['post_type'] = $cats[0][0];	
				if( $cats[0][0] != 'post' )$atts['taxonomy'] = $cats[0][0].'-category';
			}
		}
			
		$atts['format'] = rawurldecode($king->ext['bd'](strip_tags( $atts['format'] ) ) );
		
		$posts = self::get_posts( $atts );
		
		if( !count( $posts ) ){
			return '<h4>'.$atts['post_type'].' not found</h4> <a href="'.admin_url('post-new.php?post_type='.$atts['post_type']).'"><i class="fa fa-plus"></i> Add New Item</a>';
		}
		
		$eff = rand(0,10);
		if( $eff < 3 ){$eff = 'eff-fadeInUp';}else if( $eff >= 3 && $eff <=5 ){$eff = 'eff-fadeInRight';}
		else if( $eff > 5 && $eff <=8 ){$eff = 'eff-fadeInLeft';}else{$eff = 'eff-fadeIn';}
		
		$columns = array( '1' => 'one_full', '2' => 'one_half', '3' => 'one_third', '4' => 'one_fourth', '5' => 'one_fifth' );
		
		$_return = '';
		
		if( $atts['showing'] == 'slider' ){
			$_return = '<div class="slider nosidearrows centernav '.$atts['class'].'">';
			$_return .= '<div class="flexslider carousel">';
				$_return .= '<ul class="slides">';
		}else if( !empty( $atts['class'] ) ){
			$_return = '<div class="'.esc_attr( $atts['class'] ).'">';
		}
		
		/*{title}, {position}, {img}, {des}, {link}, {social}, {des_ul-li}, {submit-link}, {submit-text}*/
		$i = 1;$_end = true;
		foreach( $posts as $post ){
		
			if( $atts['showing'] == 'slider' ){
				if( ($i-1) % $atts['per_row'] == 0 ){
					$_return .= '<li>';	
					$_end = false;
				}
			}
		
			$options = get_post_meta( $post->ID , 'king_staff' );
			if( !empty( $options ) ){
			
				$options = shortcode_atts( array(
					'position'	=> 'position',
					'facebook'	=> 'king',
					'twitter'	=> 'king',
					'gplus'	=> 'king',
				), $options[0], false );
				
				$position = esc_html( $options['position'] );
				
				$social = '<a href="https://facebook.com/'.esc_attr( $options['facebook'] ).'"><i class="fa fa-facebook"></i></a> '.
					  '<a href="https://twitter.com/'.esc_attr( $options['twitter'] ).'"><i class="fa fa-twitter"></i></a> '.
					  '<a href="https://plus.google.com/u/0/+/'.esc_attr( $options['gplus'] ).'"><i class="fa fa-google-plus"></i></a>';
			}else{
				$social = '';
				$position = '';
			}
			
			$pricing = get_post_meta( $post->ID , 'king_pricing' );
			
			if( !empty( $pricing ) ){
				$pricing  = str_replace( '$', '', $pricing[0] );
				$price = $pricing['price'];
	            $per = esc_html( $pricing['per'] );
	            $submit_link = esc_url( $pricing['linksubmit'] );
	            $submit_text = esc_html( $pricing['textsubmit'] );
	            $des_ul_li = '<ul>';
	            $des_br    = '';
	            $pros = explode( "\n", $pricing['attr'] );
            	if( count( $pros ) ){
	            	
	            	foreach( $pros as $pro ){
		            	$des_br .= $pro.'<br />';
		            	$des_ul_li .= '<li>'.$pro.'</li>';
	            	}
            	}
            	$des_ul_li .= '</ul>';
			}else{
				$price = '';
	            $per = '';
	            $submit_link = '';
	            $submit_text = '';
	            $des_ul_li = '';
	            $des_br    = '';
			}
			
			
			$title = esc_html( $post->post_title );
			$des = esc_html( wp_trim_words( $post->post_content, $atts['words'] ) );
			
			$date = get_the_date('d F, Y', $post);
			$day = get_the_date('d');
			$month = get_the_date('F');
			
			$categories_list = get_the_category_list( __( ', ', 'linstar' ), '', $post->ID );
			$category = explode( ',', $categories_list );
			if( count( $category ) == 1 ){
				$category = $categories_list;
			}else if( count( $category ) > 1 ){
				$categories_list = '';	
				foreach( $category as $categorie ){
					if( strpos( $categorie, 'Uncategorized' ) === false ){
						$categories_list .= $categorie.', ';
					}
				}
				$categories_list .= '.';
				$category = str_replace( ', .', '', $categories_list );
			}else{
				$category = $categories_list;
			}
			
			$author = get_the_author_link( $post );
			
			$img_size = explode( 'x', $atts['img_size'] );
			$_w = intval( !empty( $img_size[0] ) ? $img_size[0] : 245 );
			$_h = intval( !empty( $img_size[1] ) ? $img_size[1] : 245 );
			$_a = !empty( $img_size[2] ) ? esc_attr($img_size[2] ) : 'c';

			$img = king_createLinkImage( king::get_featured_image($post), $_w.'x'.$_h.'x'.$_a );
			
			$link = get_permalink( $post->ID );
			
			$comment = $post->comment_count;
					  
			if( $atts['showing'] == 'slider' )$_return .= '<div class="';
			else $_return .= '<div class="animated delay-'.$i.'00ms '.$eff;
			if( $i % $atts['per_row'] == 0 )$_return .= ' last';
			if( $i%2 != 0 && !empty($atts['odd_class']) ){
				$_return .= ' '.$atts['odd_class'];
			}
			if( $i%2 == 0 && !empty($atts['even_class']) ){
				$_return .= ' '.$atts['even_class'];
			}
			if( $atts['odd_class'] == $atts['even_class'] && !empty($atts['odd_class']) && !empty($atts['even_class']) ){
			
			}else{
				$_return .= ' '.esc_attr( $columns[ $atts['per_row'] ] );
			}
			if( $i == $atts['highlight'] ){
				$_return .= ' highlight';
			}
			$_return .= '">';	  
			
			$_return .= str_replace( 
				array('{title}', '{position}', '{img}', '{des}', '{link}', '{social}', '{date}', '{category}', '{author}', '{comment}',
					'{price}','{per}', '{submit-link}', '{submit-text}', '{des-li}', '{des-br}', '{day}', '{month}' ), 
				array( $title  ,  $position  ,  $img  ,  $des  ,  $link  ,  $social  ,  $date  ,  $category, $author, $comment,
					$price, $per, $submit_link, $submit_text, $des_ul_li, $des_br, $day, $month  ) ,
			$atts['format'] );
			
			$_return .= '</div>';
			
			if( $atts['showing'] == 'slider' ){
				if( $i % $atts['per_row'] == 0 ){
					$_return .= '</li>';	
					$_end = true;
				}
			}
						
			$i++;
						
		}
		
		if( $atts['showing'] == 'slider' ){
			if( $_end == false )$_return .= '</li>';
			$_return .= '</ul></div></div>';
		}else if( !empty( $atts['class'] ) ){
			$_return .= '</div>';
		}
		
		return do_shortcode( $_return );	
			
	}

		
	public static function king_carousel( $atts = null, $content = null ){
		global $king;
		$atts = shortcode_atts( array(
			'images'                        => array(),
			'img_size'                      => 'full',
			'action_click'                       => '',
			'custom_links'                  => '',
			'custom_links_target'           => '_self',
			'slides_per_view'               => '1',
			'hide_pagination_control'       => '',
			'hide_prev_next_buttons'        => '',
			'wrap'                          => '',
			'el_class'                      => '',
			'template'                      => '',
		), $atts, 'king_carousel' );
		
		
		$pretty_rand = $atts['action_click'] == 'link_image' ? ' rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"' : '';
		if ( 'link_image' === $atts['action_click'] ) {
			wp_enqueue_script( 'prettyphoto' );
			wp_enqueue_style( 'prettyphoto' );
		}
				
				
		if ( '' === $atts['images'] ) {
			$atts['images'] = '-1,-2,-3';
		}
		$custom_links ='';
		if ( 'custom_link' === $atts['action_click'] ) {
			$custom_links = explode( ',', $atts['custom_links'] );
		}

		$images = explode( ',', $atts['images'] );
		$i = - 1;
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $atts['el_class'], $atts );

		$carousel_id = 'carousel_' . time(). '_' . rand(1,100);

		$img_size = $atts['img_size'];
		$onclick = $atts['action_click'];
		
		
		
		$king->bag = array(
			'carousel_id' => $carousel_id,
			'css_class' => $css_class,
			'atts' => $atts,
			'images' => $images,
			'custom_links' => $custom_links,
		);

		ob_start();
		
			if ( locate_template( 'templates'.DS.'shortcodes'.DS.$atts['template'] ) != '' ){
				get_template_part( 'templates'.DS.'shortcodes'.DS.str_replace( '.php', '', $atts['template']) );
			}else echo '<p class="king-error">Carousel : ' .$atts['template'].' - '. __( 'template not found', 'linstar' ) . '</p>';
			
			$_return = ob_get_contents();
			
		ob_end_clean();
		return $_return;
		
		
	}
	
	public static function king_posts( $atts = null, $content = null ) {
		
		global $king;
		
		$atts = shortcode_atts( array( 
			'items' => 20, 
			'category' => '', 
			'per_row' => 4, 
			'class' => '',
			'cl_class' => '',
			'words' => 20,
			'img_size' => '245x245',
			'format' => '', 
			
			'post_type' => 'post',
			'taxonomy' => 'category',
			
			'order' => 'DESC' ), $atts, 'faq' );
		
		$atts['format'] = rawurldecode($king->ext['bd'](strip_tags( $atts['format'] ) ) );

		$posts = self::get_posts( $atts );

		if( !count( $posts ) ){
			return '<h4>' . __( 'Article not found', 'linstar' ) . '</h4> <a href="'.admin_url('post-new.php').'"><i class="fa fa-plus"></i> Add New Article</a>';
		}
		
		$eff = rand(0,10);
		if( $eff <= 2 ){$eff = 'eff-fadeInUp';}else if( $eff > 2 && $eff <=4 ){$eff = 'eff-fadeInRight';}
		else if( $eff > 4 && $eff <=8 ){$eff = 'eff-fadeInLeft';}else{$eff = 'eff-flipInY';}
		
		$columns = array( '1' => 'one_full', '2' => 'one_half', '3' => 'one_third', '4' => 'one_fourth', '5' => 'one_fifth' );
		
		$_return = '';
		
		if( !empty( $atts['class'] ) ){
			$_return = '<div class="'.esc_attr( $atts['class'] ).'">';
		}
		$i = 1;
		foreach( $posts as $post ){
		
			$title = esc_html( $post->post_title );
			$des = esc_html( wp_trim_words( $post->post_content, $atts['words'] ) );
			
			$img_size = explode( 'x', $atts['img_size'] );
			$_w = intval( !empty( $img_size[0] ) ? $img_size[0] : 245 );
			$_h = intval( !empty( $img_size[1] ) ? $img_size[1] : 245 );
			$_a = !empty( $img_size[2] ) ? esc_attr($img_size[2] ) : 'c';
			
			$categories_list = get_the_category_list( __( ', ', 'linstar' ), '', $post->ID );
			$categories = explode( ',', $categories_list );
			if( count( $categories ) == 1 ){
				$categories = $categories_list;
			}else if( count( $categories ) > 1 ){
				$categories_list = '';	
				foreach( $categories as $categorie ){
					if( strpos( $categorie, 'Uncategorized' ) === false ){
						$categories_list .= $categorie.', ';
					}
				}
				$categories_list .= '.';
				$categories = str_replace( ', .', '', $categories_list );
			}else{
				$categories = $categories_list;
			}
			
			$img = king_createLinkImage( king::get_featured_image($post ), $_w.'x'.$_h.'x'.$_a );
			
			$link = get_permalink( $post->ID );
		  
			$_return .= '<div class="animated delay-'.$i.'00ms '.$eff;
			if( $i % $atts['per_row'] == 0 )$_return .= ' last ';
			if( empty( $atts['cl_class'] ) ){
				$_return .= ' '.esc_attr( $columns[ $atts['per_row'] ] );
			}else{
				$_return .= ' '.$atts['cl_class'];
			}
			$_return .= '">';	  
			
			$_return .= str_replace( 
							array('{title}', '{img}', '{des}', '{link}', '{category}'), 
							array( $title, $img, $des, $link, $categories ), $atts['format'] );
			
			$_return .= '</div>';
			
			$i++;
						
		}
		
		if( !empty( $atts['class'] ) ){
			$_return .= '</div>';
		}
		
		return do_shortcode( $_return );	
			
	}
	
	public static function team( $atts = null, $content = null ) {

		$error = null;

		$atts = shortcode_atts( array(
				'template'            => 'our-team.php',
				'id'                  => false,
				'items'     	 	  => get_option( 'posts_per_page' ),
				'style'     	 	  => 'grids',
				'post_type'           => 'our-team',
				'taxonomy'            => 'our-team-category',
				'words'       		  => 30,
				'category'            => false,
				'order'               => 'DESC',
				'orderby'             => 'menu_order post_date date title',
				'post_parent'         => false,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 'no'
			), $atts, 'team' );

		$original_atts = $atts;

		$author = '';
		$id = $atts['id'];
		$ignore_sticky_posts = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$meta_key = '';
		$offset = '';
		$order = sanitize_key( $atts['order'] );
		$orderby =  $atts['orderby'] ;
		$post_parent = $atts['post_parent'];
		$post_status = $atts['post_status'];
		$style = $atts['style'];
		$post_type = sanitize_text_field( $atts['post_type'] );
		$posts_per_page = intval( $atts['items'] );
		$items = $posts_per_page;
		$tag = '';
		$tax_operator = '';
		$tax_term = sanitize_text_field( $atts['category'] );
		$taxonomy = sanitize_key( $atts['taxonomy'] );
		$words = sanitize_key( $atts['words'] );

		$args = array(
			'category_name'  => '',
			'order'          => $order,
			'orderby'        => $orderby,
			'post_type'      => explode( ',', $post_type ),
			'posts_per_page' => $posts_per_page
		);

		if ( $ignore_sticky_posts ) $args['ignore_sticky_posts'] = true;

		if ( !empty( $meta_key ) ) $args['meta_key'] = $meta_key;

		if ( $id ) {
			$posts_in = array_map( 'intval', explode( ',', $id ) );
			$args['post__in'] = $posts_in;
		}

		$post_status = explode( ', ', $post_status );
		$validated = array();
		$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) ) $validated[] = $unvalidated;
		}
		if ( !empty( $validated ) ) $args['post_status'] = $validated;

		if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {

			$tax_term = explode( ',', $tax_term );
			// Validate operator
			if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) $tax_operator = 'IN';
			$tax_args = array( 'tax_query' => array( array(
						'taxonomy' => $taxonomy,
						'field' => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
						'terms' => $tax_term,
						'operator' => $tax_operator ) ) );
			// Check for multiple taxonomy queries
			$count = 2;
			$more_tax_queries = false;
			while ( isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
				isset( $original_atts['tax_' . $count . '_term'] ) &&
				!empty( $original_atts['tax_' . $count . '_term'] ) ) {
				// Sanitize values
				$more_tax_queries = true;
				$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
				$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . $count . '_term'] ) );
				$tax_operator = isset( $original_atts['tax_' . $count . '_operator'] ) ? $original_atts[
				'tax_' . $count . '_operator'] : 'IN';
				$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array( 'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $terms,
					'operator' => $tax_operator );
				$count++;
			}
			if ( $more_tax_queries ):
				$tax_relation = 'AND';
			if ( isset( $original_atts['tax_relation'] ) &&
				in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
			) $tax_relation = $original_atts['tax_relation'];
			$args['tax_query']['relation'] = $tax_relation;
			endif;
			$args = array_merge( $args, $tax_args );
		}


		global $posts, $king;
		
		
		$original_posts = $posts;

		$posts = new WP_Query( $args );
		$king->bag = array(
			'atts' => $atts,
			'posts' => $posts,
		);
		ob_start();

			if ( locate_template( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .$atts['template'] ) != '' ){
				get_template_part( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .str_replace( '.php', '',  $atts['template']) );
			}else echo '<p class="king-error">Our team : ' .$atts['template'].' - '. __( 'template not found', 'linstar' ) . '</p>';

		$output = ob_get_contents();
		ob_end_clean();

		$posts = $original_posts;

		wp_reset_postdata();

		return $output;
	}
	
	public static function work( $atts = null, $content = null ) {
		// Prepare error var
		$error = null;
		// Parse attributes
		
		$atts = shortcode_atts( array(
				'template'            => 'works-loop.php',
				'id'                  => false,
				'items'     		  => get_option( 'posts_per_page' ),
				'post_type'           => 'our-works',
				'taxonomy'            => 'our-works-category',
				'column'           	  => 'three',
				'tax_term'            => false,
				'order'               => 'DESC',
				'orderby'             => 'menu_order post_date date title',
				'filter'			  => 'Yes',
				'post_parent'         => false,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 'no'
			), $atts, 'work' );
			
		if( !empty( $_REQUEST['column'] ) ){
			$atts['column'] = $_REQUEST['column'];
		}	
			
		$original_atts = $atts;

		$author = '';
		$id = $atts['id']; // Sanitized later as an array of integers
		$ignore_sticky_posts = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$meta_key = '';
		$offset = '';
		$order = sanitize_key( $atts['order'] );
		$orderby = sanitize_key( $atts['orderby'] );
		$post_parent = $atts['post_parent'];
		$post_status = $atts['post_status'];
		$post_type = sanitize_text_field( $atts['post_type'] );

		$posts_per_page = intval( $atts['items'] );
		$tag = '';
		$tax_operator = '';
		$tax_term = sanitize_text_field( $atts['tax_term'] );
		$taxonomy = sanitize_key( $atts['taxonomy'] );
		
		$args = array(
			'category_name'  => '',
			'order'          => $order,
			'orderby'        => $orderby,
			'post_type'      => explode( ',', $post_type ),
			'posts_per_page' => $posts_per_page
		);

		if ( $ignore_sticky_posts ) $args['ignore_sticky_posts'] = true;

		if ( !empty( $meta_key ) ) $args['meta_key'] = $meta_key;

		if ( $id ) {
			$posts_in = array_map( 'intval', explode( ',', $id ) );
			$args['post__in'] = $posts_in;
		}

		$post_status = explode( ', ', $post_status );
		$validated = array();
		$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) ) $validated[] = $unvalidated;
		}
		if ( !empty( $validated ) ) $args['post_status'] = $validated;

		if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
		
			$tax_term = explode( ',', $tax_term );

			if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) $tax_operator = 'IN';
			$tax_args = array( 'tax_query' => array( array(
						'taxonomy' => $taxonomy,
						'field' => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
						'terms' => $tax_term,
						'operator' => $tax_operator ) ) );

			$count = 2;
			$more_tax_queries = false;
			while ( isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
				isset( $original_atts['tax_' . $count . '_term'] ) &&
				!empty( $original_atts['tax_' . $count . '_term'] ) ) {

				$more_tax_queries = true;
				$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
				$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . $count . '_term'] ) );
				$tax_operator = isset( $original_atts['tax_' . $count . '_operator'] ) ? $original_atts[
				'tax_' . $count . '_operator'] : 'IN';
				$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array( 'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $terms,
					'operator' => $tax_operator );
				$count++;
			}
			if ( $more_tax_queries ):
				$tax_relation = 'AND';
			if ( isset( $original_atts['tax_relation'] ) &&
				in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
			) $tax_relation = $original_atts['tax_relation'];
			$args['tax_query']['relation'] = $tax_relation;
			endif;
			$args = array_merge( $args, $tax_args );
		}


		global $posts, $king;
		
		
		$original_posts = $posts;
		$posts = new WP_Query( $args );
		$king->bag = array(
			'atts' => $atts,
			'posts' => $posts,
		);

		ob_start();
		
		if( $king->vars( 'action', 'king_Shortcode_Generator_preview' ) ){
			echo '<script type="text/javascript" src="'.THEME_URI .'/js/jquery/jquery-1.9.1.min.js"></script>';
		}	

		wp_enqueue_script('king-portfolio');
		
	
		if ( locate_template( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .$atts['template'] ) != '' ){
			get_template_part( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .str_replace( '.php', '',  $atts['template']) );
		}else echo '<p class="king-error">Our work : ' .$atts['template'].' - '. __( 'template not found', 'linstar' ) . '</p>';


		
		$output = ob_get_contents();
		ob_end_clean();
		$posts = $original_posts;
		wp_reset_postdata();
		
		return $output;
	}
	
	public static function testimonials( $atts = null, $content = null ) {

		$error = null;

		$atts = shortcode_atts( array(
				'template'            => 'testimonials.php',
				'id'                  => false,
				'layout'     		  => 'slide',
				'items'        		  => get_option( 'posts_per_page' ),
				'post_type'           => 'testimonials',
				'taxonomy'            => 'testimonials-category',
				'words'          	  => 100,
				'category'            => false,
				'order'               => 'DESC',
				'orderby'             => 'menu_order post_date date title',
				'post_parent'         => false,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 'no'
			), $atts, 'testimonials' );

		$original_atts = $atts;

		$author = '';
		$id = $atts['id'];
		$ignore_sticky_posts = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$meta_key = '';
		$offset = '';
		$order = sanitize_key( $atts['order'] );
		$orderby = sanitize_key( $atts['orderby'] );
		$post_parent = $atts['post_parent'];
		$post_status = $atts['post_status'];
		$post_type = sanitize_text_field( $atts['post_type'] );
		$posts_per_page = intval( $atts['items'] );
		$tag = '';
		$tax_operator = '';
		$tax_term = sanitize_text_field( $atts['category'] );
		$taxonomy = sanitize_key( $atts['taxonomy'] );
		
		$words = sanitize_key( $atts['words'] );
		$items = sanitize_key( $atts['items'] );
		$layout = sanitize_key( $atts['layout'] );

		$args = array(
			'category_name'  => '',
			'order'          => $order,
			'orderby'        => $orderby,
			'post_type'      => explode( ',', $post_type ),
			'posts_per_page' => $posts_per_page
		);

		if ( $ignore_sticky_posts ) $args['ignore_sticky_posts'] = true;

		if ( !empty( $meta_key ) ) $args['meta_key'] = $meta_key;

		if ( $id ) {
			$posts_in = array_map( 'intval', explode( ',', $id ) );
			$args['post__in'] = $posts_in;
		}
	

		$post_status = explode( ', ', $post_status );
		$validated = array();
		$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) ) $validated[] = $unvalidated;
		}
		if ( !empty( $validated ) ) $args['post_status'] = $validated;

		if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {

			$tax_term = explode( ',', $tax_term );
			// Validate operator
			if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) $tax_operator = 'IN';
			$tax_args = array( 'tax_query' => array( array(
						'taxonomy' => $taxonomy,
						'field' => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
						'terms' => $tax_term,
						'operator' => $tax_operator ) ) );
			// Check for multiple taxonomy queries
			$count = 2;
			$more_tax_queries = false;
			while ( isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
				isset( $original_atts['tax_' . $count . '_term'] ) &&
				!empty( $original_atts['tax_' . $count . '_term'] ) ) {
				// Sanitize values
				$more_tax_queries = true;
				$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
				$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . $count . '_term'] ) );
				$tax_operator = isset( $original_atts['tax_' . $count . '_operator'] ) ? $original_atts[
				'tax_' . $count . '_operator'] : 'IN';
				$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array( 'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $terms,
					'operator' => $tax_operator );
				$count++;
			}
			if ( $more_tax_queries ):
				$tax_relation = 'AND';
			if ( isset( $original_atts['tax_relation'] ) &&
				in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
			) $tax_relation = $original_atts['tax_relation'];
			$args['tax_query']['relation'] = $tax_relation;
			endif;
			$args = array_merge( $args, $tax_args );
		}

		global $posts, $king;
		
	
		$original_posts = $posts;

		$posts = new WP_Query( $args );
		$king->bag = array(
			'atts' => $atts,
			'posts' => $posts,
		);
		ob_start();

	
		if ( locate_template( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .$atts['template'] ) != '' ){
			get_template_part( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .str_replace( '.php', '',  $atts['template']) );
		}else echo '<p class="king-error">Testimonial : ' .$atts['template'].' - '. __( 'template not found', 'linstar' ) . '</p>';

		
		$output = ob_get_contents();
		
		ob_end_clean();
		
		$posts = $original_posts;
		
		wp_reset_postdata();

		return $output;
	}

	public static function php( $atts = null, $content = null ) {
		global $king;
		ob_start();
		$king->ext['ev']( $content );
		$text =  do_shortcode( ob_get_contents() );
		ob_end_clean();    
		return $text;
	}
	
	public static function piechart( $atts = null, $content = null ) {
	
		
		$atts = shortcode_atts( array(
				'size'   => 7,
				'style' => 'piechart1',
				'percent'  => '75',
				'color' => '#333',
				'text'  => '',
				'class'  => '',
				'rand'	=> rand(354345,2353465),
				'fx'	=> array(15,16,18,22,27,30,35,40,50)
			), $atts, 'piechart' );

		if( $atts['style'] == 'piechart3' ){
			$atts['color'] = '#fff';
		}
		
		$_action = $atts['percent'].'|'.$atts['fx'][ $atts['size'] ].'px|'.(($atts['size']+2)*10).'|'.$atts['color'].'|'.($atts['size']+2);
		
		
		ob_start();
		
		$atts['class'] .= ' s'.$atts['size'].' '.$atts['style'];
			
		echo '<div class="'.$atts['class'].' piechart" data-option="'.str_replace( array( '"', "'" ), array( '', '' ), $_action ).'">';
		echo '<canvas class="loader'.$atts['rand'].'"></canvas>';
		if( $atts['text'] != '' )echo ' <br /> '.$atts['text'];
		echo '</div>';
		
		$_return = ob_get_contents();
		ob_end_clean();
		
		su_query_asset( 'js', 'classyloader' );
		
		return $_return;	
		
	}
		
	public static function pricing( $atts = null, $content = null ) {
		
		global $wpdb;		
		$atts = shortcode_atts( array(
				'template'  => 'pricing-table.php',
				'amount'	=> 4,
				'category'	=> '',
				'active'	=> 4,
				'icon'		=> '',
				'style'		=> 1,
				'class'		=> ''
			), $atts, 'pricing' );
			
		$args = array(
			'posts_per_page'   => intval($atts['amount']),
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'menu_order post_date title',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'pricing-tables',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		);
		
		if( !empty( $atts['category'] ) ){
			$args['tax_query'] = array(
	            array(
	                'taxonomy' => 'pricing-tables-category',
	                'field' => 'slug',
	                'terms' => explode( ',', $atts['category'] )
	            )
	        );
		}
		
		$prcs = get_posts( $args );
		
		
		
		$_return = '';

		
		if( $atts['icon'] != '' ){
			$atts['icon'] = '<i class="fa fa-'.str_replace( 'icon: ', '', $atts['icon'] ).'"></i> ';
		}
		
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
		
		global $posts, $king;
		$king->bag = array(
			'atts' => $atts,
			'eff' => $eff,
			'prcs' => $prcs,
		);

		ob_start();
		

	
		if ( locate_template( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .$atts['template'] ) != '' ){
			get_template_part( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .str_replace( '.php', '',  $atts['template']) );
		}else echo '<p class="king-error">Pricing : ' .$atts['template'].' - '. __( 'template not found', 'linstar' ) . '</p>';

		
		
		$_return = ob_get_contents();
		ob_end_clean();
		
		return $_return;	
		
	}


	public static function progress( $atts = null, $content = null ) {
	
		
		$atts = shortcode_atts( array(
				'style'   => 1,
				'percent'  => '75',
				'color' => '',
				'text'  => 'Website Design',
				'class'  => '',
			), $atts, 'piechart' );
		
		ob_start();
		
		$colour = '';
		
		if( $atts['color'] != '' ){
			if( $atts['style'] != 4 ){
				$colour = 'border-bottom: 10px solid '.$atts['color'].'';
			}else{
				$colour = 'background: '.$atts['color'].'';
			}	
		}	
		?>
		
		<h5><?php echo esc_html( $atts['text'] ); ?></h5>
        <div class="ui-progress-bar ui-progress-bar<?php echo esc_attr( $atts['style'] ); ?> king-progress-bar ui-container <?php echo esc_attr( $atts['class'] ); ?>">
       		<div class="ui-progress ui-progress<?php echo esc_attr( $atts['style'] ); ?>"  style="<?php echo esc_attr( $colour ); ?>;">
       			<span class="ui-label">
       				<b class="value"><?php echo esc_html( $atts['percent'] ); ?>%</b>
       			</span>
       		</div>
        </div>
		<br />
		
		<?php
		
		$_return = ob_get_contents();
		ob_end_clean();
		
		su_query_asset( 'js', 'progress-bar' );
		su_query_asset( 'css', 'progress-bar' );
		
		return $_return;	
		
	}
	

	public static function flex_sliders( $atts = null, $content = null ) {
	
		$atts = shortcode_atts( array(
				'paging'   => 'yes',
				'nav' => 'yes',
				'class'    => ''
			), $atts, 'flex_sliders' );
		
		if( $atts['nav'] == 'no' ){
			$atts['class'] .= ' nosidearrows';
		}		
		if( $atts['paging'] == 'no' ){
			$atts['class'] .= ' nosidepaging';
		}
	
		$content = str_replace( array('] ',"]<br />"), array(']',']'), $content);
	
		$return = '<div class="slider '.$atts['class'].'"><div class="flexslider carousel"><ul class="slides">';
		
		$return .= do_shortcode( $content );
		
		$return .= '</ul></div></div>';
		
		su_query_asset( 'js', 'jquery' );
		su_query_asset( 'js', 'king-flex-slider' );
		su_query_asset( 'css', 'king-flex-slider-css' );
		
		return $return;
	}

	public static function fslider( $atts = null, $content = null ) {
	
		$atts = shortcode_atts( array(
				'title'    => __( 'Flex child slider', 'linstar' ),
				'disabled' => 'no',
				'anchor' => '',
				'class'    => ''
			), $atts, 'fslider' );
		
		return '<li class="'.$atts['class'].'">'.do_shortcode( $content ).'</li>';

	}

	public static function divider( $atts = null, $content = null ) {
	
		$atts = shortcode_atts( array(
				'style'   => 1,
				'icon'	 => '',
				'class'    => ''
			), $atts, 'dediver' );
		
		if( $atts['icon'] != '' ){
			$atts['style'] = $atts['style'].' divider-icon';
		}
			
		$_return = '<div class="divider_line'.esc_attr($atts['style']).' '.esc_attr($atts['class']).'">';
		switch( $atts['style'] ){
			
			case 3: 
				if( $atts['icon'] == '' )$_return .= '<i class="fa fa-paper-plane"></i>';
				else $_return .= '<i class="fa fa-'.esc_attr($atts['icon']).'"></i>';
			break;
			case 4: 
				if( $atts['icon'] == '' )$_return .= '<i class="fa fa-heart"></i>';
				else $_return .= '<i class="fa fa-'.esc_attr($atts['icon']).'"></i>';
			break;			
			case 5: 
				if( $atts['icon'] == '' )$_return .= '<i class="fa fa-trophy"></i>';
				else $_return .= '<i class="fa fa-'.esc_attr($atts['icon']).'"></i>';
			break;
			
		}
		$_return .= '</div>';	
		
		return $_return;
		
	}
	
	public static function titles( $atts = null, $content = null ) {
		
		global $king;
		
		$atts = shortcode_atts( array(
				'type'   => 'h1',
				'text' => 'Sample title',
				'class'    => ''
			), $atts, 'titles' );
		
		$_return = '<'.esc_attr($atts['type']);
		if( !empty( $atts['class'] ) ){
			$_return .= ' class="'.esc_attr($atts['class']).'"';
		}
		$_return .= '>';
		$_return .= do_shortcode( rawurldecode( $king->ext['bd'](strip_tags( $atts['text'] ) ) ) );
		$_return .= '</'.esc_attr($atts['type']).'>';
		
		return 	$_return;
			
	}
				
	public static function titles2( $atts = null, $content = null ) {
	
		$atts = shortcode_atts( array(
				'style'   => '1',
				'text' => '',
				'boldtext'	 => '',
				'subtext'	 => '',
				'icon' => 'umbrella',
				'class'    => ''
			), $atts, 'dediver' );
		
		if( $atts['boldtext'] != '' ){
			$atts['text'] = str_replace( esc_html($atts['boldtext']), '<strong>'.esc_html($atts['boldtext']).'</strong>', esc_html( $atts['text'] ) );
		}		
		
		$atts['class'] .= ' stcode_title'.$atts['style'];
		
		if( $atts['style'] == 'sec1' ){
			return '<h2 class="title21 '.esc_attr($atts['class']).'">'.esc_html($atts['text']).' <em>'.$atts['subtext'].'</em></h2>';
		}		
		if( $atts['style'] == 'sec2' ){
			return '<h1 class="title22 '.esc_attr($atts['class']).'">'.esc_html($atts['text']).' <em>'.$atts['subtext'].'</em></h1>';
		}
		if( $atts['style'] == 'page' ){
			$atts['class'] .= ' title';
		}	
		
		$_return = '<div class="'.esc_attr($atts['class']).'">';
		
		switch( $atts['style'] ){
			case 1 : 
				$_return .= '<h3><span class="line"></span><span class="text">'.$atts['text'].'</span></h3>';
			break;
			case 2 : 
				$_return .= '<h3><span class="line"></span><span class="line2"></span><span class="text">'.$atts['text'].'</span></h3>';
			break;
			case 3 : 
				$_return .= '<h3><span class="line"></span><span class="text">'.$atts['text'].'</span></h3>';
			break;
			case 4 : 
				$_return .= '<h3><span class="line"></span><span class="text">'.$atts['text'].'</span></h3>';
			break;
			case 5 : 
				$_return .= '<h3><span class="line2"></span><span class="line"></span><span class="text">'.$atts['text'].'</span></h3>';
			break;
			case 6 : 
				$_return .= '<h2>'.$atts['text'].'</h2>';
			break;
			case 7 : 
				$_return .= '<h2>'.$atts['text'].'<br><em>'.esc_html($atts['subtext']).'</em><span class="line"></span></h2>';
			break;
			case 8 : 
				$_return .= '<h2><span class="line"></span><span class="text">'.$atts['text'].'</span></h2>';
			break;		
			case 9 : 
				$_return .= '<h2>'.$atts['text'].'<br>';
				if( $atts['subtext'] != '' )$_return .= '<em>'.esc_html($atts['subtext']).'</em><br>';
				$_return .= '<span class="line"></span></h2>';
			break;
			case 10 : 
				$_return .= '<h2>'.$atts['text'].'<br><em>'.esc_html($atts['subtext']).'</em><br><span class="line"><i class="fa fa-'.esc_attr($atts['icon']).'"></i></span></h2>';
			break;
			case 11 : 
				$_return .= '<h2>'.$atts['text'].'<br><em>'.esc_html($atts['subtext']).'</em><br><span class="line"></span></h2>';
			break;
			case 12 : 
				$_return .= '<h2><strong>'.strtoupper($atts['text']).'</strong></h2>';
			break;			
			case 'page' : 
				$_return .= '<h1>'.esc_html($atts['text']).'</h1>';
			break;			
			case 'sec2' : 
				$_return .= '<h2><span class="line"></span><span class="text">'.$atts['text'].'</span><em>'.esc_html($atts['subtext']).'</em></h2>';
			break;			
			case 'sec1' : 
				$_return .= '<h2><span class="line"></span><span class="text">'.$atts['text'].'</span><em>'.esc_html($atts['subtext']).'</em></h2>';
			break;
			case 'sec3' : 
				return '<h3 class="unline"><i class="fa fa-'.esc_attr($atts['icon']).'"></i>'.esc_html($atts['text']).'</h3>';
			break;

		}
		
		$_return .= '</div>';
		
		return $_return;
		
	}	
	
	public static function flip_clients( $atts = null, $content = null ) {
		
		$atts = shortcode_atts( array(
			'img'   => '',
			'title'	 => '',
			'link'	 => '#',
			'des'	 => '',
			'class'    => ''
		), $atts, 'flip_clients' );
		ob_start();
		?>
		
		<div class="one_fifth <?php echo esc_attr($atts['class']); ?>">
			<div class="flips4">
				<div class="flips4_front flipscont4">
				    <?php echo wp_get_attachment_image( $atts['img'], 'full' ); ?>
				</div>
				<div class="flips4_back flipscont4">
					<h5>
						<strong>
							<a href="<?php echo esc_url( $atts['link'] ); ?>"><?php echo esc_html( $atts['title'] ); ?></a>
						</strong>
					</h5>
					<p><?php echo esc_html( $atts['des'] ); ?></p>
				</div>
			</div>
		</div>
	
		<?php
		$_return = ob_get_contents();
		ob_end_clean();
		
		return $_return;
		
	}

	public static function videobg( $atts = null, $content = null ) {
	
		$atts = shortcode_atts( array(
				'id'  => 'qGctxicOaxg',
				'sound' => 'no',
				'height' => '',
				'class' => ''
			), $atts, 'videoBg' );
			
		$rand = rand(4345,76788);	
		
		ob_start();
			
		?>
			
			<div class="section-videobg" <?php if( is_numeric( $atts['height'] ) )echo 'style="height:'.$atts['height'].'px"'; ?>>
				<div id="videoBackground<?php echo esc_attr( $rand ); ?>"></div>
					<script>
					
						if( document.createElement('youtubeApi') ){
						
							var tag = document.createElement('script');
							tag.src = "http://www.youtube.com/player_api";
							tag.id = 'youtubeApi';
							var firstScriptTag = document.getElementsByTagName('script')[0];
							firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
							var playerReadyFunctions = [];
						}
						playerReadyFunctions[playerReadyFunctions.length] = function() {
						
							new YT.Player('videoBackground<?php echo esc_attr( $rand ); ?>', {
								playerVars: {
									'autoplay': 1, 
									'controls': 0,
									'loop':1,
									'rel':0,
									'showinfo':0,
									'autohide':1,
									'hd':1,
									'enablejsapi':1,
									'wmode':'transparent' 
								}
								,videoId: '<?php echo esc_attr( $atts['id'] ); ?>',
								events: {
									'onReady': function( event ){
									
										document.getElementById('videoBackground<?php echo esc_attr( $rand ); ?>')._player = event.target;
									
										<?php if( $atts['sound'] == 'no' ){ ?>
											event.target.mute();
										<?php }else{ ?>
											event.target.unMute();
										<?php } ?>	
										<?php if( is_numeric( $atts['height'] ) ){ ?>
										document.getElementById('videoBackground<?php echo esc_attr( $rand ); ?>').style.marginTop = '<?php echo ($atts['height']/2.5); ?>px';
										<?php } ?>
									},
									'onStateChange': function( st ){
										if( st.data == 0 ){
											document.getElementById('videoBackground<?php echo esc_attr( $rand ); ?>')._player.playVideo();
										}
									}
								}
							});
							
						}
						
					</script>
				<div class="overlay-on-video <?php echo esc_attr( $atts['class'] ); ?>"><?php echo do_shortcode( $content ); ?></div>
			</div>
			
		<?php	
		
		
		
		$_return = ob_get_contents();
		ob_end_clean();
		
		if( self::$youTubePlayerReady != true ){
		
			function onYouTubePlayerAPIReady() {
			?>
				<script type="text/javascript">
					function onYouTubePlayerAPIReady(){
						for( var i=0; i < playerReadyFunctions.length; i++  ){
							playerReadyFunctions[i]();
						}
					}	
				</script>
			<?php
			}
			add_action('wp_footer', 'onYouTubePlayerAPIReady');
			self::$youTubePlayerReady = true;
		}	
		
		
		return $_return;
		
		
	}

	public static function elements( $atts = null, $content = null ) {
		
		global $king;
		$atts = shortcode_atts( array(
			'image' => '',
			'icon_awesome' => 'star empty',
			'icon_simple_line' => 'badge empty',
			'icon_etline' => 'badge empty',
			'icon_class' => '',
			'des' => '',
			'link' => '',
			'linkclass' => '',
			'class' => '',
			'icon_clickable' => '',
			'hidden_readmore' => '',
			'readmore_text' => '',
			'target' => ''
		), $atts, 'posts' );

		$atts['des'] = do_shortcode( rawurldecode($king->ext['bd'](strip_tags( $atts['des'] ) ) ) );
		
		$_out = '';
		ob_start();
				
			self::$elements->display( $atts );
			$_out = ob_get_contents();

		ob_end_clean();
		
		return $_out;
			
	}		


	public static function posts( $atts = null, $content = null ) {

		$error = null;
		
		$atts = shortcode_atts( array(
				'template'            => 'default-loop.php',
				'id'                  => false,
				'posts_per_page'      => get_option( 'posts_per_page' ),
				'items'				  => '',
				'post_type'           => 'post',
				'taxonomy'            => 'category',
				'tax_term'            => false,
				'tax_operator'        => 'IN',
				'author'              => '',
				'tag'                 => '',
				'meta_key'            => '',
				'offset'              => 0,
				'order'               => 'DESC',
				'orderby'             => 'date',
				'post_parent'         => false,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 'no'
			), $atts, 'posts' );

		$original_atts = $atts;

		$author		= sanitize_text_field( $atts['author'] );
		$id			= $atts['id'];
		$ignore_sticky_posts = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$meta_key	= sanitize_text_field( $atts['meta_key'] );
		$offset		= intval( $atts['offset'] );
		$order		= sanitize_key( $atts['order'] );
		$orderby	= sanitize_key( $atts['orderby'] );
		$post_parent = $atts['post_parent'];
		$post_status = $atts['post_status'];
		$items		= $atts['items'];
		$post_type	= sanitize_text_field( $atts['post_type'] );
		$posts_per_page = intval( $atts['posts_per_page'] );
		
		if( $atts['items'] != '' ){
			$posts_per_page = $atts['items'];
		}
		
		$tag = sanitize_text_field( $atts['tag'] );
		$tax_operator = $atts['tax_operator'];
		$tax_term = sanitize_text_field( $atts['tax_term'] );
		$taxonomy = sanitize_key( $atts['taxonomy'] );


		$args = array(
			'category_name'  => '',
			'order'          => $order,
			'orderby'        => $orderby,
			'post_type'      => explode( ',', $post_type ),
			'posts_per_page' => $posts_per_page,
			'tag'            => $tag
		);

		if ( $ignore_sticky_posts ) $args['ignore_sticky_posts'] = true;

		if ( !empty( $meta_key ) ) $args['meta_key'] = $meta_key;

		if ( $id ) {
			$posts_in = array_map( 'intval', explode( ',', $id ) );
			$args['post__in'] = $posts_in;
		}

		if ( !empty( $author ) ) $args['author'] = $author;

		if ( !empty( $offset ) ) $args['offset'] = $offset;

		$post_status = explode( ', ', $post_status );
		$validated = array();
		$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
		
		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) ) $validated[] = $unvalidated;
		}
		if ( !empty( $validated ) ) $args['post_status'] = $validated;

		if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {

			$tax_term = explode( ',', $tax_term );

			if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) $tax_operator = 'IN';
			$tax_args = array( 'tax_query' => array( array(
						'taxonomy' => $taxonomy,
						'field' => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
						'terms' => $tax_term,
						'operator' => $tax_operator ) ) );

			$count = 2;
			$more_tax_queries = false;
			while ( isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
				isset( $original_atts['tax_' . $count . '_term'] ) &&
				!empty( $original_atts['tax_' . $count . '_term'] ) ) {

				$more_tax_queries = true;
				$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
				$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . $count . '_term'] ) );
				$tax_operator = isset( $original_atts['tax_' . $count . '_operator'] ) ? $original_atts[
				'tax_' . $count . '_operator'] : 'IN';
				$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array( 'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $terms,
					'operator' => $tax_operator );
				$count++;
			}
			if ( $more_tax_queries ):
				$tax_relation = 'AND';
			if ( isset( $original_atts['tax_relation'] ) &&
				in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
			) $tax_relation = $original_atts['tax_relation'];
				$args['tax_query']['relation'] = $tax_relation;
			endif;
			
			$args = array_merge( $args, $tax_args );
		}

		if ( $post_parent ) {
			if ( 'current' == $post_parent ) {
				global $post;
				$post_parent = $post->ID;
			}
			$args['post_parent'] = intval( $post_parent );
		}

		global $posts, $king;

		$original_posts = $posts;

		$posts = new WP_Query( $args );
		$king->bag = array(
			'atts' => $atts,
			'posts' => $posts,
		);
		ob_start();

	
		if ( locate_template( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .$atts['template'] ) != '' ){
			get_template_part( 'core' . DS . 'shortcodes'. DS . 'templates' . DS .str_replace( '.php', '',  $atts['template']) );
		}else echo '<p class="king-error">Posts : ' .$atts['template'].' - '. __( 'template not found', 'linstar' ) . '</p>';

		
		$output = ob_get_contents();
		ob_end_clean();

		$posts = $original_posts;

		wp_reset_postdata();
		
		return $output;
	}
	public static function cf7( $atts = null, $content = null ) {
		
		global $wpdb;
		
		$atts = shortcode_atts( array(
				'title' => 'Contact Form',
				'slug'       => '',
			), $atts, 'cf7' );
		
		$form = $wpdb->get_results("SELECT `ID` FROM `".$wpdb->posts."` WHERE `post_type` = 'wpcf7_contact_form' AND `post_name` = '".esc_attr(sanitize_title($atts['slug']))."' LIMIT 1");
		
		if( !empty( $form ) ){
			return do_shortcode('[contact-form-7 id="'.$form[0]->ID.'" title="'.esc_attr($atts['title']).'"]');
		}else{
			return '[contact-form-7 not found slug ('.esc_attr($atts['slug']).') ]';
		}
	}

}

add_action( 'init', array( 'king_shortcodes', 'register') );

global $king;
if ( function_exists( $king->ext['ascp'] ) || function_exists( $king->ext['vcascp'] ) ){
	
	function king_custom_param_taxonomy( $settings, $value ){
	
		if( !is_array( $value ) ){
			$value = explode( ',', $value );
		}
		
		$pert = explode( ':', $value[0] );
		$pert = $pert[0];
		
		$args = array(
			'post' =>  Su_Tools::get_terms( 'category', 'slug' ),
			'our-team' => Su_Tools::get_terms( 'our-team-category', 'slug' ),
			'pricing-tables' => Su_Tools::get_terms( 'pricing-tables-category', 'slug' ),
		);
		$_out = 'Select Type: ';
		foreach( $args as $k => $v ){
			$_out .= '<button onclick="king_filter_terms(this)" class="vc_btn';
			if( $pert == $k ){
				$_out .= ' vc_btn-grace';
			}else{
				$_out .= ' vc_btn-gray';
			}
			$_out .= '">'.$k.'</button> ';
		}
		$_out .= '<p><select style="height: 150px" ';
		$_out .=  'multiple class="wpb_vc_param_value king-multiple-field" name="' . esc_attr( $settings['param_name'] ) . '">';
		
		foreach( $args as $type => $arg ){
			$_out .= '<option class="'.$type.'-st" value="'.$type.'" style="display:none;" ';
			if( $pert == $type ){
				$_out .= ' selected';
			}
			$_out .= '>'.$type.'</option>';
			foreach( $arg as $k => $v ){
			
				$k = $type.':'.str_replace( ':', '&#58;', $k );
				
				$_out .= '<option class="'.$type.' '.$k.'" value="'.$k.'"';
				if( $pert !== $type ){
					$_out .= ' style="display:none;" ';
				}
				if( in_array( $k, $value ) ){
					$_out .= ' selected';
				}
				$_out .= '>'.$v.'</option>';
			}
		}
		$_out .= '</select>';
		
		return $_out;
		
	}
	
	
	function king_custom_param_multiple( $settings, $value ){
	
		if( !is_array( $value ) ){
			$value = explode( ',', $value );
		}
	
		$_out = '<select ';
		if( !empty( $settings['height'] ) ){
			$_out .= 'style="height:'.$settings['height'].'" ';
		}
		$_out .=  'multiple class="wpb_vc_param_value king-multiple-field" name="' . esc_attr( $settings['param_name'] ) . '">';
		
		foreach( $settings['values'] as $k => $v ){
			$_out .= '<option value="'.$k.'"';
			if( in_array( $k, $value ) ){
				$_out .= ' selected';
			}
			$_out .= '>'.$v.'</option>';
		}
		
		$_out .= '</select><br /><button class="button" onclick="jQuery(this.parentNode).find(\'.king-multiple-field option:selected\').removeAttr(\'selected\');"><i class="fa fa-times"></i> Clear Selected</button>';
		
		return $_out;
		
	}
	
	
	function king_custom_param_select( $settings, $value ){

		$_out = '<select class="wpb_vc_param_value" name="' . esc_attr( $settings['param_name'] ) . '">';
		
		foreach( $settings['values'] as $k => $v ){
			$_out .= '<option value="'.$k.'"';
			if( $k == $value ){
				$_out .= ' selected';
			}
			$_out .= '>'.$v.'</option>';
		}
		
		$_out .= '</select>';
		
		return $_out;
		
	}

	
	function king_custom_param_icon( $settings, $value ){

		$id = rand( 3445456, 35346436 );
		
		$_out = '<i id="icon-preview-'.$id.'" class="icon-preview fa fa-'.esc_attr($value).'"></i>';
		
		$_out .= '<input  onblur="king_shortcode_hideIcon(\'picker-'.$id.'\')" onfocus="king_shortcode_showIcon(\'picker-'.$id.'\')" type="text" id="color-'.$id.'" class="wpb_vc_param_value icon-fields" name="' . esc_attr( $settings['param_name'] ) . 
				'" value="'. esc_attr($value). '" />';
		$_out .= '<div onclick="king_shortcode_setIcon(\'color-'.$id.'\', 1)" id="picker-'.$id.'" class="king-generator-icon-picker king-generator-icon-picker-visible">'.Su_Tools::icons().'</div>';
		
		return $_out;
		
	}
	
	
	function king_custom_param_icon_simple( $settings, $value ){

		$id = rand( 3445456, 35346436 );
		
		$_out = '<i id="icon-preview-'.$id.'" class="icon-preview icon-'.esc_attr($value).'"></i>';
		
		$_out .= '<input onblur="king_shortcode_hideIcon(\'picker-'.$id.'\')" onfocus="king_shortcode_showIcon(\'picker-'.$id.'\')" type="text" id="color-'.$id.'" class="wpb_vc_param_value icon-fields" name="' . esc_attr( $settings['param_name'] ) . 
				'" value="'. esc_attr($value). '" />';
		$_out .= '<div onclick="king_shortcode_setIcon(\'color-'.$id.'\', 2)" id="picker-'.$id.'" class="king-generator-icon-picker king-generator-icon-picker-visible">'.Su_Tools::iconsSimple().'</div>';
		
		return $_out;
		
	}
		
	
	function king_custom_param_icon_etline( $settings, $value ){

		$id = rand( 3445456, 35346436 );
		
		$_out = '<i id="icon-preview-'.$id.'" class="icon-preview et-'.esc_attr($value).'"></i>';
		
		$_out .= '<input onblur="king_shortcode_hideIcon(\'picker-'.$id.'\')" onfocus="king_shortcode_showIcon(\'picker-'.$id.'\')" type="text" id="color-'.$id.'" class="wpb_vc_param_value icon-fields" name="' . esc_attr( $settings['param_name'] ) . 
				'" value="'. esc_attr($value). '" />';
		$_out .= '<div onclick="king_shortcode_setIcon(\'color-'.$id.'\', 3)" id="picker-'.$id.'" class="king-generator-icon-picker king-generator-icon-picker-visible">'.Su_Tools::iconsEtline().'</div>';
		
		return $_out;
		
	}
	
	
	function king_custom_param_radio( $settings, $value ){
		$_out = '<input class="king-radio-val wpb_vc_param_value" name="' . esc_attr( $settings['param_name'] ) .'" type="hidden" value="'.esc_attr( $value ).'" />';
		if( is_array($settings['value']) ){
			foreach( $settings['value'] as $key => $val ){
				$_out .= '<input onclick="king_shortcode_radioChoose(this)" style="width:auto" type="radio" ';
				if( $val == $value )$_out .= ' checked ';
				$_out .= ' value="'.esc_attr($val).'" name="' . esc_attr( $settings['param_name'] ) .'-show" /> '.$key.' ';
			}
		}
		
		return $_out;
		
	}
	
	if ( defined( 'WPB_VC_VERSION' ) ) {
		
		if(version_compare(WPB_VC_VERSION, '4.8.0.1', '<')){
			$king->ext['ascp']( 'taxonomy' , 'king_custom_param_taxonomy' );
			$king->ext['ascp']( 'multiple' , 'king_custom_param_multiple' );
			$king->ext['ascp']( 'select' , 'king_custom_param_select' );
			$king->ext['ascp']( 'icon' , 'king_custom_param_icon' );
			$king->ext['ascp']( 'icon-simple' , 'king_custom_param_icon_simple' );
			$king->ext['ascp']( 'icon-etline' , 'king_custom_param_icon_etline' );
			$king->ext['ascp']( 'radio' , 'king_custom_param_radio' );
		}else{
			//user vc_add_shortcode_parram
			$king->ext['vcascp']( 'taxonomy' , 'king_custom_param_taxonomy' );
			$king->ext['vcascp']( 'multiple' , 'king_custom_param_multiple' );
			$king->ext['vcascp']( 'select' , 'king_custom_param_select' );
			$king->ext['vcascp']( 'icon' , 'king_custom_param_icon' );
			$king->ext['vcascp']( 'icon-simple' , 'king_custom_param_icon_simple' );
			$king->ext['vcascp']( 'icon-etline' , 'king_custom_param_icon_etline' );
			$king->ext['vcascp']( 'radio' , 'king_custom_param_radio' );
		}
	}
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	    class WPBakeryShortCode_videobg extends WPBakeryShortCodesContainer {
	    
	    }
	}

}
