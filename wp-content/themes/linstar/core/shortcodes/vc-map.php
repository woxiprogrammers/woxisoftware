<?php

/*
*	Register extend component for Visual Composer
*	king-theme.com
*/


if (function_exists('vc_map')) {

	if(!function_exists('king_extend_visual_composer')){
		
		//define new array width columns. Fixing for Visual Composer 4.9.2
		global $vc_column_width_list;
		$vc_column_width_list = array(
			__( '1 column - 1/12', 'linstar' )    => '1/12',
			__( '2 columns - 1/6', 'linstar' )    => '1/6',
			__( '3 columns - 1/4', 'linstar' )    => '1/4',
			__( '4 columns - 1/3', 'linstar' )    => '1/3',
			__( '5 columns - 5/12', 'linstar' )   => '5/12',
			__( '6 columns - 1/2', 'linstar' )    => '1/2',
			__( '7 columns - 7/12', 'linstar' )   => '7/12',
			__( '8 columns - 2/3', 'linstar' )    => '2/3',
			__( '9 columns - 3/4', 'linstar' )    => '3/4',
			__( '10 columns - 5/6', 'linstar' )   => '5/6',
			__( '11 columns - 11/12', 'linstar' ) => '11/12',
			__( '12 columns - 1/1', 'linstar' )   => '1/1',
		);

		add_action( 'init', 'king_extend_visual_composer' );
		function king_extend_visual_composer(){
			
			global $vc_column_width_list, $king;
			$vc_is_wp_version_3_6_more = version_compare( preg_replace( '/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo( 'version' ) ), '3.6' ) >= 0;
			 
			vc_map( array(
		    
		        "name" => __("Row", 'linstar'),
		        "base" => "vc_row",
		        "is_container" => true,
		        "icon" => "icon-wpb-row",
		        "show_settings_on_create" => true,
		        "category" => THEME_NAME.' Theme',
		        "description" => __('Place content elements inside the row', 'linstar'),
		        "params" => array(
		          array(
		            "type" => "textfield",
		            "heading" => __("ID Name for Navigation", 'linstar'),
		            "param_name" => "king_id",
		            "description" => __("If this row wraps the content of one of your sections, set an ID. You can then use it for navigation. Ex: work", 'linstar')
		          ),
		           array(
		            "type" => "attach_image",
		            "heading" => __("Background Image", 'linstar'),
		            "param_name" => "bg_image",
		            "description" => __("Select backgound color for the row.", 'linstar')
		          ),
		          array(
		            "type" => "dropdown",
		            "heading" => __('Background Repeat', 'linstar'),
		            "param_name" => "king_bg_repeat",
		            "value" => array(
		              __("Repeat-Y", 'linstar') => 'repeat-y',
		              __("Repeat", 'linstar') => 'repeat',
		              __('No Repeat', 'linstar') => 'no-repeat',
		              __('Repeat-X', 'linstar') => 'repeat-x',
		              __('Background Size Cover', 'linstar') => 'cover',
		              __('Background Center', 'linstar') => 'center',
		            )
		          ),
		          array(
		            "type" => "colorpicker",
		            "heading" => __('Background Color', 'linstar'),
		            "param_name" => "bg_color",
		            "description" => __("You can set a color over the background image. You can make it more or less opaque, by using the next setting. Default: white ", 'linstar')
		          ),
		          array(
		            "type" => "textfield",
		            "heading" => __('Background Color Opacity', 'linstar'),
		            "param_name" => "king_color_opacity",
		            "description" => __("Set an opacity value for the color(values between 0-100). 0 means no color while 100 means solid color. Default: 70 ", 'linstar')
		          ),
		          array(
		            "type" => "textfield",
		            "heading" => __("Padding Top", 'linstar'),
		            "param_name" => "king_padding_top",
		            "description" => __("Enter a value and it will be used for padding-top(px). As an alternative, use the 'Space' element.", 'linstar')
		          ),
		          array(
		            "type" => "textfield",
		            "heading" => __("Padding Bottom", 'linstar'),
		            "param_name" => "king_padding_bottom",
		            "description" => __("Enter a value and it will be used for padding-bottom(px). As an alternative, use the 'Space' element.", 'linstar')
		          ),
		          array(
		            "type" => "textfield",
		            "heading" => __("Container class name", 'linstar'),
		            "param_name" => "king_class_container",
		            "description" => __("Custom class name for container of this row", 'linstar')
		          ),		          
		          array(
		            "type" => "textfield",
		            "heading" => __("Section class name", 'linstar'),
		            "param_name" => "king_class",
		            "description" => __("Custom class for outermost wrapper.", 'linstar')
		          ),
		          array(
		            "type" => "dropdown",
		            "heading" => __('Type', 'linstar'),
		            "param_name" => "king_row_type",
		            "description" => __("Select template full-width if you want to background full of screen", 'linstar'),
		            "value" => array(
		              __("Content In Container", 'linstar') => 'container',
		              __("Fullwidth All", 'linstar')    => 'container_full',
		              __("Parallax", 'linstar')     => 'parallax'
		            )
		          ),
		        ),
		        "js_view" => 'VcRowView'
		      ) );
		      
		      
		      vc_map( array(
				'name' => __( 'Row', 'linstar' ), //Inner Row
				'base' => 'vc_row_inner',
				'content_element' => false,
				'is_container' => true,
				'icon' => 'icon-wpb-row',
				'weight' => 1000,
				'show_settings_on_create' => false,
				'description' => __( 'Place content elements inside the row', 'linstar' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'linstar' ),
						'param_name' => 'king_class',
						'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'linstar' )
					)
				),
				'js_view' => 'VcRowView'
			) );
		      
		      
		      vc_map( array(
				'name' => __( 'Column', 'linstar' ),
				'base' => 'vc_column',
				'is_container' => true,
				'content_element' => false,
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'linstar' ),
						'param_name' => 'el_class',
						'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'linstar' )
					),					
					array(
						'type' => 'dropdown',
						'heading' => __( 'Animate Effect', 'linstar' ),
						'param_name' => 'el_animate',
						'value' => array(
							'---Select an animate---' => '',
							'Fade In' => 'animated eff-fadeIn',
							'From bottom up' => 'animated eff-fadeInUp',
							'From top down' => 'animated eff-fadeInDown',
							'From left' => 'animated eff-fadeInLeft',
							'From right' => 'animated eff-fadeInRight',
							'Zoom In' => 'animated eff-zoomIn',
							'Bounce In' => 'animated eff-bounceIn',
							'Bounce In Up' => 'animated eff-bounceInUp',
							'Bounce In Down' => 'animated eff-bounceInDown',
							'Bounce In Out' => 'animated eff-bounceInOut',
							'Flip In X' => 'animated eff-flipInX',
							'Flip In Y' => 'animated eff-flipInY',
						),
						'description' => __( 'Select animate effects to show this column when port-viewer scroll over', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Animate Delay', 'linstar' ),
						'param_name' => 'el_delay',
						'description' => __( 'Delay animate effect after number of mili seconds, e.g: 200 ', 'linstar' )
					),
					array(
						'type' => 'css_editor',
						'heading' => __( 'Css', 'linstar' ),
						'param_name' => 'css',
						'group' => __( 'Design options', 'linstar' )
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Width', 'linstar' ),
						'param_name' => 'width',
						'value' => $vc_column_width_list,
						'group' => __( 'Width & Responsiveness', 'linstar' ),
						'description' => __( 'Select column width.', 'linstar' ),
						'std' => '1/1'
					),
					array(
						'type' => 'column_offset',
						'heading' => __( 'Responsiveness', 'linstar' ),
						'param_name' => 'offset',
						'group' => __( 'Width & Responsiveness', 'linstar' ),
						'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'linstar' )
					)
				),
				'js_view' => 'VcColumnView'
			) );
			
			
			vc_map( array(
				"name" => __( "Column", 'linstar' ),
				"base" => "vc_column_inner",
				"class" => "",
				"icon" => "",
				"wrapper_class" => "",
				"controls" => "full",
				"allowed_container_element" => false,
				"content_element" => false,
				"is_container" => true,
				"params" => array(
					array(
						"type" => "textfield",
						"heading" => __( "Extra class name", 'linstar' ),
						"param_name" => "el_class",
						"value" => "",
						"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'linstar' )
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Animate Effect', 'linstar' ),
						'param_name' => 'el_animate',
						'value' => array(
							'---Select an animate---' => '',
							'Fade In' => 'animated eff-fadeIn',
							'From bottom up' => 'animated eff-fadeInUp',
							'From top down' => 'animated eff-fadeInDown',
							'From left' => 'animated eff-fadeInLeft',
							'From right' => 'animated eff-fadeInRight',
							'Zoom In' => 'animated eff-zoomIn',
							'Bounce In' => 'animated eff-bounceIn',
							'Bounce In Up' => 'animated eff-bounceInUp',
							'Bounce In Down' => 'animated eff-bounceInDown',
							'Bounce In Out' => 'animated eff-bounceInOut',
							'Flip In X' => 'animated eff-flipInX',
							'Flip In Y' => 'animated eff-flipInY',
						),
						'description' => __( 'Select animate effects to show this column when port-viewer scroll over', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Animate Delay', 'linstar' ),
						'param_name' => 'el_delay',
						'description' => __( 'Delay animate effect after number of mili seconds, e.g: 200 ', 'linstar' )
					),
					array(
						"type" => "css_editor",
						"heading" => __( 'Css', 'linstar' ),
						"param_name" => "css",
						// "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'linstar'),
						"group" => __( 'Design options', 'linstar' )
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Width', 'linstar' ),
						'param_name' => 'width',
						'value' => $vc_column_width_list,
						'group' => __( 'Width & Responsiveness', 'linstar' ),
						'description' => __( 'Select column width.', 'linstar' ),
						'std' => '1/1'
					)
				),
				"js_view" => 'VcColumnView'
			) );
			
		    vc_map( array(
				'name' => __( 'X-Code Editor', 'linstar' ),
				'base' => 'vc_raw_html',
				'icon' => 'icon-wpb-raw-html',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Custom code php, html, javascript, css, shortcodes', 'linstar' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __( 'Title', 'linstar' ),
						'param_name' => 'title',
						'holder' => 'i',
						'description' => __( 'Label will display at VisualComposer admin', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'type' => 'textarea_raw_html',
						'heading' => __( 'X-Code - PHP, HTML, Javascript, CSS, ShortCodes', 'linstar' ),
						'param_name' => 'content',
						'holder' => 'div',
						'value' => $king->ext['be']( '<p>I am X-Code Editor (king-theme.com)<br/>Click edit button to change this code</p>' ),
						'description' => __( 'Enter your HTML, PHP, JavaScript, Css, Shortcodes.', 'linstar' )
					),
				)
			));	
				      
		    vc_map( array(
				'name' => __( 'FAQs', 'linstar' ),
				'base' => 'faq',
				'icon' => 'fa fa-question-circle',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Output FAQs as accordion from faqs post type.', 'linstar' ),
				'params' => array(
					array(
						'type' => 'multiple',
						'heading' => __( 'Select Categories ( hold ctrl or shift to select multiple )', 'linstar' ),
						'param_name' => 'category',
						'values' => Su_Tools::get_terms( 'faq-category', 'slug' ),
						'admin_label' => true,
						'description' => __( 'Select category which you chosen for FAQs', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Amount', 'linstar' ),
						'param_name' => 'amount',
						'value' => 20,
						'admin_label' => true,
						'description' => __( 'Enter number of FAQs that you want to display. To edit FAQs, go to ', 'linstar' ).'/wp-admin/edit.php?post_type=faq'
					),
				)
			));
			
			
			/* Empty Space Element
			---------------------------------------------------------- */
			$mrt = array( '---Select Margin Top---' => '' );
			$mrb = array( '---Select Margin Bottom---' => '');
			for( $i=1; $i <=15; $i++ ){
				$mrt[ $i.'0px'] =  $i.'0px';
				$mrb[ $i.'0px'] =  $i.'0px';
			}
			vc_map( array(
				'name' => __( 'Margin Spacing', 'linstar' ),
				'base' => 'margin',
				'icon' => 'fa fa-arrows-v',
				'show_settings_on_create' => true,
				'category' => THEME_NAME.' Theme',
				'description' => __( 'Blank spacing', 'linstar' ),
				'params' => array(
					array(
						'type' => 'dropdown',
						'heading' => __( 'Margin Top', 'linstar' ),
						'param_name' => 'margin_top',
						'admin_label' => true,
						'value' => $mrt
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Margin Bottom', 'linstar' ),
						'param_name' => 'margin_bottom',
						'admin_label' => true,
						'value' => $mrb
					),
				),
			) );
				      										      
		    vc_map( array(
				'name' => __( 'King Loop', 'linstar' ),
				'base' => 'king_loop',
				'icon' => 'fa fa-star-o',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Output list of item template', 'linstar' ),
				'params' => array(
					array(
						'type' => 'taxonomy',
						'heading' => __( 'Categories', 'linstar' ),
						'param_name' => 'category',
						'values' => '',
						'admin_label' => true,
						'description' => __( 'Select Post type & categories  (Hold ctrl or command to select multiple)', 'linstar' )
					),
					array(
						'type' => 'radio',
						'heading' => __( 'How showing', 'linstar' ),
						'param_name' => 'showing',
						'value' => array(
							'Normal as Grids &nbsp; &nbsp; ' => 'grid',
							'Showing As Sliders' => 'slider',
						),
						'description' => ''
					),
					array(
						'type' => 'textarea_raw_html',
						'heading' => __( 'Item Format', 'linstar' ),
						'param_name' => 'format',
						'description' => __( 'Available params: {title}, {position}, {img}, {des}, {link}, {social}, {date}, {category}, {author}, {comment}, {price}, {per}, {submit-link}, {submit-text}, {des-li}, {des-br}, {day}, {month}', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Number of items', 'linstar' ),
						'param_name' => 'items',
						'value' => 20,
						'admin_label' => true,
						'description' => __( 'Enter number of people to show', 'linstar' )
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Number per row', 'linstar' ),
						'param_name' => 'per_row',
						'value' => array(
							'Four' => 4,
							'One' => 1,
							'Two' => 2,
							'Three' => 3,
							'Five' => 5,
						),
						'admin_label' => true,
						'description' => 'Number people display on 1 row'
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Class of Wrapper', 'linstar' ),
						'param_name' => 'class',
						'value' => '',
						'description' => __( 'Custom class name for wrapper', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Class of Odd Columns', 'linstar' ),
						'param_name' => 'odd_class',
						'value' => '',
						'description' => __( 'Custom class name for odd columns', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Class of Even Columns', 'linstar' ),
						'param_name' => 'even_class',
						'value' => '',
						'description' => __( 'Custom class name for even columns', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Image Size ( width x height )', 'linstar' ),
						'param_name' => 'img_size',
						'value' => '245x245',
						'description' => __( 'Set thumbnail size e.g: 245x245', 'linstar' )
					),	
					array(
						'type' => 'dropdown',
						'heading' => __( 'Hightlight Column', 'linstar' ),
						'param_name' => 'highlight',
						'value' => array(
							'Three' => 3,
							'None' => 0,
							'One' => 1,
							'Two' => 2,
							'Four' => 4,
							'Five' => 5,
						),
						'description' => 'Select column to set highlight (using for pricing table)'
					),				
					array(
						'type' => 'textfield',
						'heading' => __( 'Words Limit', 'linstar' ),
						'param_name' => 'words',
						'value' => 20,
						'description' => __( 'Limit words you want show as short description', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Offset', 'linstar' ),
						'param_name' => 'offset',
						'value' => 0,
						'description' => __( 'Set offset to start select sql from', 'linstar' )
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Order By', 'linstar' ),
						'param_name' => 'order',
						'value' => array(
							'Descending' => 'DESC',
							'Ascending' => 'ASC'
						),
						'description' => ' &nbsp; '
					)
				)
			));
			
						
			 vc_map( array(
				'name' => __( 'Our Team', 'linstar' ),
				'base' => 'team',
				'icon' => 'fa fa-group',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Output our team template', 'linstar' ),
				'params' => array(
					array(
						'type' => 'multiple',
						'heading' => __( 'Select Category ( hold ctrl or shift to select multiple )', 'linstar' ),
						'param_name' => 'category',
						'values' => Su_Tools::get_terms( 'our-team-category', 'slug' ),
						'height' => '150px',
						'description' => __( 'Select category to display team', 'linstar' )
					),					
					array(
						'type' => 'dropdown',
						'heading' => __( 'Choose Style', 'linstar' ),
						'param_name' => 'style',
						'admin_label' => true,
						'value' => array(
							'Grids'				=> 'grids',
							'Grids Style 2'		=> 'grids-2',
							'Grids Style 3'		=> 'grids-3',
							'Grids Style 4'		=> 'grids-4',							
							'2 Columns'		=> '2-columns',
							'2 Columns 2'		=> '2-columns-2',
							'Circle' 			=> 'circle-1',

						),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Amount', 'linstar' ),
						'param_name' => 'items',
						'value' => 20,
						'description' => __( 'Enter number of people to show', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Words Limit', 'linstar' ),
						'param_name' => 'words',
						'value' => 20,
						'description' => __( 'Limit words you want show as short description', 'linstar' )
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Order By', 'linstar' ),
						'param_name' => 'order',
						'value' => array(
							'Descending' => 'desc',
							'Ascending' => 'asc'
						),
						'description' => ' &nbsp; '
					)
				)
			));
			
			vc_map( array(
				'name' => __( 'Our Work (Portfolio)', 'linstar' ),
				'base' => 'work',
				'icon' => 'fa fa-send-o',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Our work for portfolio template.', 'linstar' ),
				'params' => array(
					array(
						'type' => 'multiple',
						'heading' => __( 'Select Categories ( hold ctrl or shift to select multiple )', 'linstar' ),
						'param_name' => 'tax_term',
						'values' => Su_Tools::get_terms( 'our-works-category', 'slug' ),
						'height' => '120px',
						'admin_label' => true,
						'description' => __( 'Select category which you chosen for Team items', 'linstar' )
					),					
					array(
						'type' => 'dropdown',
						'heading' => __( 'Show Filter', 'linstar' ),
						'param_name' => 'filter',
						'value' => array(
							'Yes'	=> 'Yes',
							'No'	=> 'No',
						),
					),
					array(
						'type' => 'select',
						'heading' => __( 'Items on Row', 'linstar' ),
						'param_name' => 'column',
						'values' => array(
							'two' => 2,
							' ' => 3,
							'four' => 4,
							'five' => 5,
							'masonry' => 'Masonry Layout',
							'sliders' => 'Sliders',
							'titleup' => 'Grids - Title up on hover',
							
						),
						'description' => __( 'Choose number of items display on a row', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Items Limit', 'linstar' ),
						'param_name' => 'items',
						'value' => get_option( 'posts_per_page' ),
						'description' => __( 'Specify number of team that you want to show. Enter -1 to get all team', 'linstar' )
					),
					array(
						'type' => 'select',
						'heading' => __( 'Order By', 'linstar' ),
						'param_name' => 'order',
						'values' => array(
								'desc' => __( 'Descending', 'linstar' ),
								'asc' => __( 'Ascending', 'linstar' )
						),
						'description' => ' &nbsp; '
					)
				)
			));
			
			vc_map( array(
				'name' => __( 'Testimonials', 'linstar' ),
				'base' => 'testimonials',
				'icon' => 'fa fa-group',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Out testimonians post type.', 'linstar' ),
				'params' => array(
					array(
						'type' => 'multiple',
						'heading' => __( 'Select Categories ( hold ctrl or shift to select multiple )', 'linstar' ),
						'param_name' => 'category',
						'values' => Su_Tools::get_terms( 'testimonials-category', 'slug' ),
						'height' => '120px',
						'admin_label' => true,
						'description' => __( 'Select category which you chosen for Team items', 'linstar' )
					),	
					array(
						'type' => 'select',
						'heading' => __( 'Select Layout', 'linstar' ),
						'param_name' => 'layout',
						'values' => array(
							'slider-1' => 'Slider Style 1',
							'slider-2' => 'Slider Style 2',
							'slider-3' => 'Slider Style 3',
							'slider-4' => 'Slider Style 4',
							'slider-5' => 'Slider Style 5',
							'slider-6' => 'Slider Style 6',
							'slider-ms' => 'MS Slider',
							'2-columns' => '2 Columns',
							'3-columns' => '3 Columns',
						),
						'admin_label' => true,
						'description' => __( 'Select layout to display testimonials', 'linstar' )
					),	
					array(
						'type' => 'textfield',
						'heading' => __( 'Items Limit', 'linstar' ),
						'param_name' => 'items',
						'value' => get_option( 'posts_per_page' ),
						'description' => __( 'Specify number of team that you want to show. Enter -1 to get all', 'linstar' )
					),						
					array(
						'type' => 'textfield',
						'heading' => __( 'Limit Words', 'linstar' ),
						'param_name' => 'words',
						'value' => 20,
						'description' => __( 'Limit words you want show as short description', 'linstar' )
					),
					array(
						'type' => 'select',
						'heading' => __( 'Order By', 'linstar' ),
						'param_name' => 'order',
						'values' => array(
								'desc' => __( 'Descending', 'linstar' ),
								'asc' => __( 'Ascending', 'linstar' )
						),
						'description' => ' &nbsp; '
					)
				)
			));
						
			vc_map( array(
			
				'name' => __( 'Pie Chart', 'linstar' ),
				'base' => 'piechart',
				'icon' => 'fa fa-pie-chart',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Out testimonians post type.', 'linstar' ),
				'params' => array(

					array(
						'type' => 'select',
						'param_name' => 'size',
						'values' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
							'8' => '8',
						),
						'value' => 7,
						'heading' => __( 'Size', 'linstar' ),
						'description' => __( 'Size of chart', 'linstar' )
					),
					
					array(
						'type' => 'select',
						'param_name' => 'style',
						'values' => array(
							'piechart1' => 'Pie Chart 1',
							'piechart2' => 'Pie Chart 2 (auto width by size)',
							'piechart3' => 'Pie Chart 3 (white color)'
						),
						'value' => 7,
						'heading' => __( 'Size', 'linstar' ),
						'description' => __( 'Size of chart', 'linstar' )
					),
					array(
						'param_name' => 'percent',
						'type' 	=> 'textfield',
						'value' => 75,
						'admin_label' => true,
						'heading' => __( 'Percent', 'linstar' ),
						'description' => __( 'Percent value of chart', 'linstar' )
					),
					array(
			            "type" => "colorpicker",
			            "heading" => __('Color', 'linstar'),
			            "param_name" => "color",
			            "description" => __("Color of chart", 'linstar')
			        ),
					array(
						'param_name' => 'text',
						'type' 	=> 'textfield',
						'heading' => __( 'Text', 'linstar' ),
						'description' => __( 'The text bellow chart', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'param_name' => 'class',
						'type' 	=> 'textfield',
						'heading' => __( 'Class', 'linstar' ),
						'description' => __( 'Extra CSS class', 'linstar' )
					)
					
				)
			));

			vc_map( array(
			
				'name' => __( 'Pricing Table', 'linstar' ),
				'base' => 'pricing',
				'icon' => 'fa fa-table',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Display Pricing Plan Table', 'linstar' ),
				'params' => array(
					array(
						'type' => 'select',
						'heading' => __( 'Select Categories ( hold ctrl or shift to select multiple )', 'linstar' ),
						'param_name' => 'category',
						'values' => Su_Tools::get_terms( 'pricing-tables-category', 'slug', null, '---Select Category---' ),
						'admin_label' => true,
						'description' => __( 'Select category which you chosen for Pricing Table', 'linstar' )
					),
					array(
						'type' => 'select',
						'param_name' => 'amount',
						'values' => array(
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4',
						),
						'value' => 4,
						'heading' => __( 'Amount', 'linstar' ),
						'description' => __( 'Number of columns', 'linstar' )
					),	
					array(
						'type' => 'select',
						'param_name' => 'active',
						'values' => array(
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4',
						),
						'value' => 3,
						'heading' => __( 'Active Column', 'linstar' ),
						'description' => __( 'Select column to highlight', 'linstar' )
					),
					array(
						'type' => 'select',
						'param_name' => 'style',
						'values' => array(
								'1' => 'Style 1 - 4 columns',
								'2' => 'Style 2 - 3 columns',
								'3' => 'Style 3 - 3 columns',
								'4' => 'Style 4 Cyan- 4 columns',
								'5' => 'Style 5 with label'
						),
						'heading' => __( 'Style', 'linstar' ),
						'description' => __( 'Select style for pricing table', 'linstar' )
					),
					array(
						'param_name' => 'icon',
						'type' 	=> 'icon',
						'heading' => __( 'Icon', 'linstar' ),
						'description' => __( 'the icon display on per row', 'linstar' )
					),
					array(
						'param_name' => 'class',
						'type' 	=> 'textfield',
						'heading' => __( 'Class', 'linstar' ),
						'description' => __( 'Extra CSS class', 'linstar' )
					)
					
				)
			));

			vc_map( array(
			
				'name' => __( 'Progress Bars', 'linstar' ),
				'base' => 'progress',
				'icon' => 'fa fa-line-chart',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Display Progress Bars', 'linstar' ),
				'params' => array(

					array(
						'type' => 'select',
						'param_name' => 'style',
						'values' => array(
								'1' => '1',
								'2' => '2',
								'3' => '3',
								'4' => '4',
						),
						'heading' => __( 'Style', 'linstar' ),
						'description' => __( 'Style of progress bar', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'param_name' => 'percent',
						'value' => 75,
						'admin_label' => true,
						'heading' => __( 'Percent', 'linstar' ),
						'description' => __( 'Percent value of progress bar', 'linstar' )
					),
					array(
						'type' => 'colorpicker',
						'param_name' => 'color',
						'value' => '#333333',
						'heading' => __( 'Color', 'linstar' ),
						'description' => __( 'Color of progress bar', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'param_name' => 'text',
						'admin_label' => true,
						'heading' => __( 'Text', 'linstar' ),
						'description' => __( 'The text bellow chart', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'param_name' => 'class',
						'heading' => __( 'Class', 'linstar' ),
						'description' => __( 'Extra CSS class', 'linstar' )
					)
					
				)
			));
			
			vc_map( array(
			
				'name' => __( 'Divider', 'linstar' ),
				'base' => 'divider',
				'icon' => 'icon-wpb-ui-separator',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'List of horizontal divider line', 'linstar' ),
				'params' => array(

					array(
						'type' => 'select',
						'param_name' => 'style',
						'values' => array(
								'1' => 'Style 1',
								'2' => 'Style 2',
								'3' => 'Style 3',
								'4' => 'Style 4',
								'5' => 'Style 5',
								'6' => 'Style 6',
								'7' => 'Style 7',
								'8' => 'Style 8',
								'9' => 'Style 9',
								'10' => 'Style 10',
								'11' => 'Style 11',
								'12' => 'Style 12',
								'13' => 'Style 13',
								' ' => 'Divider Line',
						),
						'admin_label' => true,
						'heading' => __( 'Style', 'linstar' ),
						'description' => __( 'Style of divider', 'linstar' )
					),
					array(
						'type' => 'icon',
						'param_name' => 'icon',
						'heading' => __( 'Icon', 'linstar' ),
						'description' => __( 'Select icon on divider', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'param_name' => 'class',
						'heading' => __( 'Class', 'linstar' ),
						'description' => __( 'Extra CSS class', 'linstar' )
					)
					
				)
			));
					
			vc_map( array(
			
				'name' => __( 'Title Styles', 'linstar' ),
				'base' => 'titles',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'icon' => 'fa fa-university',
				'description' => __( 'List of Title Styles', 'linstar' ),
				'params' => array(

					array(
						'type' => 'select',
						'param_name' => 'type',
						'values' => array(
								'h1' => 'H1',
								'h2' => 'H2',
								'h3' => 'H3',
								'h4' => 'H4',
								'h5' => 'H5',
								'h6' => 'H6',
						),
						'admin_label' => true,
						'heading' => __( 'Head Tag', 'linstar' ),
						'description' => __( 'Select Header Tag', 'linstar' )
					),
					array(
						'type' => 'textarea_raw_html',
						'param_name' => 'text',
						'heading' => __( 'Title Text', 'linstar' ),
						'holder' => 'div'
					),
					array(
						'type' => 'textfield',
						'param_name' => 'class',
						'heading' => __( 'Class', 'linstar' ),
						'description' => __( 'Extra CSS class', 'linstar' )
					)
					
				)
			));
			
			vc_map( array(
			
				'name' => __( 'Flip Clients', 'linstar' ),
				'base' => 'flip_clients',
				'icon' => 'fa fa-apple',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'Display clients with flip styles', 'linstar' ),
				'params' => array(

					array(
						'type' => 'attach_image',
						'param_name' => 'img',
						'heading' => __( 'Logo Image', 'linstar' ),
						'description' => __( 'Upload the client\'s logo', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'param_name' => 'title',
						'heading' => __( 'Title', 'linstar' ),
						'admin_label' => true,
						'description' => __( 'The name of client', 'linstar' )
					),						
					array(
						'type' => 'textfield',
						'param_name' => 'link',
						'heading' => __( 'Link', 'linstar' ),
						'description' => __( 'Link to client website', 'linstar' )
					),					
					array(
						'type' => 'textfield',
						'param_name' => 'des',
						'heading' => 'Description',
						'description' => __( 'Short Descript will show when hover', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'param_name' => 'class',
						'heading' => __( 'Class', 'linstar' ),
						'description' => __( 'Extra CSS class', 'linstar' )
					)
					
				)
			));
						
			vc_map( array(
			
				'name' => __( 'Posts - '.THEME_NAME, 'linstar' ),
				'base' => 'posts',
				'icon' => 'fa fa-th-list',
				'category' => THEME_NAME.' Theme',
				'wrapper_class' => 'clearfix',
				'description' => __( 'List posts by other layouts of theme', 'linstar' ),
				'params' => array(

					array(
						'type' => 'select', 
						'param_name' => 'template',
						'values' => array(
								'default-loop.php' => 'Default Loop',
								'single-post.php' => 'Single Post',
								'list-loop.php' => 'List Loop',
								'home-news-4-columns.php' => 'Home News 4 columns',
								'home-news-3-columns.php' => 'Home News 3 columns',
								'home-news-3-columns-2.php' => 'Home News 3 columns Style 2',
								'home-news-3-columns-3.php' => 'Home News 3 columns Style 3',
								'home-news-2-columns.php' => 'Home News 2 columns',
								'home-news-1-column.php' => 'Home News 1 column',
								'home-news-slider.php' => 'Home News Slider',
								'home-onepage-news-list.php' => 'Latest news 3 columns (6 posts)',
																
						),
						'admin_label' => true,
						'heading' => __( 'Template', 'linstar' ),
						'description' => __( 'List posts under templates of theme', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'param_name' => 'id',
						'heading' => __( 'Post ID\'s', 'linstar' ),
						'description' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'linstar' )
					),				
					array(
						'type' => 'textfield',
						'param_name' => 'posts_per_page',
						'value' => get_option( 'posts_per_page' ),
						'heading' => __( 'Posts per page', 'linstar' ),
						'description' => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'linstar' )
					),					
					array(
						'type' => 'select',
						'param_name' => 'post_type',
						'values' => Su_Tools::get_types(),
						'value' => 'post',
						'heading' => __( 'Post types', 'linstar' ),
						'description' => __( 'Select post types. Hold Ctrl key to select multiple post types', 'linstar' )
					),					
					array(
						'type' => 'select',
						'param_name' => 'taxonomy',
						'values' => Su_Tools::get_taxonomies(),
						'value' => 'category',
						'heading' => __( 'Taxonomy', 'linstar' ),
						'description' => __( 'Select taxonomy to show posts from', 'linstar' )
					),
					array(
						'type' => 'multiple',
						'param_name' => 'tax_term',
						'values' => Su_Tools::get_terms( 'category', 'slug' ),
						'heading' => __( 'Terms', 'linstar' ),
						'description' => __( 'Select terms to show posts from', 'linstar' )
					),					
					array(
						'type' => 'select',
						'param_name' => 'tax_operator',
						'values' => array( 'IN' => 'IN', 'NOT IN' => 'NOT IN', 'AND' => 'AND' ),
						'value' => 'IN',
						'heading' => __( 'Taxonomy term operator', 'linstar' ),
						'description' => __( 'IN - posts that have any of selected categories terms<br/>NOT IN - posts that is does not have any of selected terms<br/>AND - posts that have all selected terms', 'linstar' )
					),					
					array(
						'type' => 'multiple',
						'param_name' => 'author',
						'values' => Su_Tools::get_users(),
						'value' => 'default',
						'heading' => __( 'Authors', 'linstar' ),
						'description' => __( 'Choose the authors whose posts you want to show', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'param_name' => 'meta_key',
						'heading' => __( 'Meta key', 'linstar' ),
						'description' => __( 'Enter meta key name to show posts that have this key', 'linstar' )
					),					
					array(
						'type' => 'textfield',
						'param_name' => 'offset',
						'value' => '0',
						'heading' => __( 'Offset', 'linstar' ),
						'description' => __( 'Specify offset to start posts loop not from first post', 'linstar' )
					),
					array(
						'type' => 'select',
						'values' => array(
							'desc' => __( 'Descending', 'linstar' ),
							'asc' => __( 'Ascending', 'linstar' )
						),
						'param_name' => 'order',
						'heading' => __( 'Offset', 'linstar' ),
						'description' => __( 'Posts order', 'linstar' )
					),
					array(
						'type' => 'select',
						'values' => array(
							'none' => __( 'None', 'linstar' ),
							'id' => __( 'Post ID', 'linstar' ),
							'author' => __( 'Post author', 'linstar' ),
							'title' => __( 'Post title', 'linstar' ),
							'name' => __( 'Post slug', 'linstar' ),
							'date' => __( 'Date', 'linstar' ), 'modified' => __( 'Last modified date', 'linstar' ),
							'parent' => __( 'Post parent', 'linstar' ),
							'rand' => __( 'Random', 'linstar' ), 'comment_count' => __( 'Comments number', 'linstar' ),
							'menu_order' => __( 'Menu order', 'linstar' ), 'meta_value' => __( 'Meta key values', 'linstar' ),
						),
						'value' => 'date',
						'param_name' => 'orderby',
						'heading' => __( 'Order by', 'linstar' ),
						'description' => __( 'Order posts by', 'linstar' )
					),					
					array(
						'type' => 'textfield',
						'param_name' => 'post_parent',
						'heading' => __( 'Post parent', 'linstar' ),
						'description' => __( 'Show childrens of entered post (enter post ID)', 'linstar' )
					),					
					array(
						'type' => 'select',
						'values' => array(
							'publish' => __( 'Published', 'linstar' ),
							'pending' => __( 'Pending', 'linstar' ),
							'draft' => __( 'Draft', 'linstar' ),
							'auto-draft' => __( 'Auto-draft', 'linstar' ),
							'future' => __( 'Future post', 'linstar' ),
							'private' => __( 'Private post', 'linstar' ),
							'inherit' => __( 'Inherit', 'linstar' ),
							'trash' => __( 'Trashed', 'linstar' ),
							'any' => __( 'Any', 'linstar' ),
						),
						'value' => 'publish',
						'param_name' => 'post_status',
						'heading' => __( 'Post status', 'linstar' ),
						'description' => __( 'Show only posts with selected status', 'linstar' )
					),					
					array(
						'type' => 'select',
						'values' => array( 'no' => 'no', 'yes' => 'yes' ),
						'param_name' => 'ignore_sticky_posts',
						'heading' => __( 'Ignore sticky', 'linstar' ),
						'description' => __( 'Select Yes to ignore posts that is sticked', 'linstar' )
					),
					
				)
			));

			vc_map( array(
				'name' => __( 'Accordion', 'linstar' ),
				'base' => 'vc_accordion',
				'show_settings_on_create' => false,
				'is_container' => true,
				'icon' => 'icon-wpb-ui-accordion',
				'category' => THEME_NAME.' Theme',
				'description' => __( 'Collapsible content panels', 'linstar' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __( 'Widget title', 'linstar' ),
						'param_name' => 'title',
						'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'linstar' )
					),
					array(
						'type' => 'select',
						'heading' => __( 'Style', 'linstar' ),
						'param_name' => 'style',
						'values' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'2 white' => 'white color',
						),
						'description' => __( 'Select style of accordion.', 'linstar' )
					),
					array(
						'type' => 'select',
						'heading' => __( 'Icon', 'linstar' ),
						'param_name' => 'icon',
						'values' => array(
							'icon-plus' => 'Icon Plus',
							'icon-plus-circle' => 'Plus Circle',
							'icon-plus-square-1' => 'Plus Square 1',
							'icon-plus-square-2' => 'Plus Square 2',
							'icon-arrow' => 'Icon Arrow',
							'icon-arrow-circle-1' => 'Arrow Circle 1',
							'icon-arrow-circle-2' => 'Arrow Circle 2',
							'icon-chevron' => 'Icon Chevron',
							'icon-chevron-circle' => 'Icon Chevron Circle',
							'icon-caret' => 'Icon Caret',
							'icon-caret-square' => 'Icon Caret Square',
							'icon-folder-1' => 'Icon Folder 1',
							'icon-folder-2' => 'Icon Folder 2',
						),
						'description' => __( 'Select icon display on each spoiler', 'linstar' )
					),	
					array(
						'type' => 'textfield',
						'heading' => __( 'Active section', 'linstar' ),
						'param_name' => 'active_tab',
						'description' => __( 'Enter section number to be active on load or enter false to collapse all sections.', 'linstar' )
					),
					array(
						'type' => 'checkbox',
						'heading' => __( 'Allow collapsible all', 'linstar' ),
						'param_name' => 'collapsible',
						'description' => __( 'Select checkbox to allow all sections to be collapsible.', 'linstar' ),
						'value' => array( __( 'Allow', 'linstar' ) => 'yes' )
					),
					array(
						'type' => 'checkbox',
						'heading' => __( 'Disable keyboard interactions', 'linstar' ),
						'param_name' => 'disable_keyboard',
						'description' => __( 'Disables keyboard arrows interactions LEFT/UP/RIGHT/DOWN/SPACES keys.', 'linstar' ),
						'value' => array( __( 'Disable', 'linstar' ) => 'yes' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'linstar' ),
						'param_name' => 'el_class',
						'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'linstar' )
					)
				),
				'custom_markup' => '
					<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
					%content%
					</div>
					<div class="tab_controls">
					    <a class="add_tab" title="' . __( 'Add section', 'linstar' ) . '"><span class="vc_icon"></span> <span class="tab-label">' . __( 'Add section', 'linstar' ) . '</span></a>
					</div>
				',
					'default_content' => '
				    [vc_accordion_tab title="' . __( 'Section 1', 'linstar' ) . '"][/vc_accordion_tab]
				    [vc_accordion_tab title="' . __( 'Section 2', 'linstar' ) . '"][/vc_accordion_tab]
				',
				'js_view' => 'VcAccordionView'
			));

			
			$tab_id_1 = 'def' . time() . '-1-' . rand( 0, 100 );
			$tab_id_2 = 'def' . time() . '-2-' . rand( 0, 100 );
			vc_map( array(
				"name" => __( 'Tabs - Sliders', 'linstar' ),
				'base' => 'vc_tabs',
				'show_settings_on_create' => false,
				'is_container' => true,
				'icon' => 'icon-wpb-ui-tab-content',
				'category' => THEME_NAME.' Theme',
				'description' => __( 'Custom Tabs, Sliders', 'linstar' ),
				'params' => array(
					array(
						'type' => 'select',
						'heading' => __( 'Display as', 'linstar' ),
						'values' => array(
							'tabs' => 'Display as Tabs',
							'vertical' => 'Vertical Style',
							'detached' => 'Display as Tabs Detached',
							'ipad-sliders' => 'Display as iPad Sliders',
							'sliders' => 'Display as Flex Sliders'
						),
						'admin_label' => true,
						'param_name' => 'type',
						'description' => __( 'You can choose to display as tabs or sliders', 'linstar' )
					),					
					array(
						'type' => 'dropdown',
						'heading' => __( 'Auto rotate tabs', 'linstar' ),
						'param_name' => 'interval',
						'value' => array( __( 'Disable', 'linstar' ) => 0, 3, 5, 10, 15 ),
						'std' => 0,
						'description' => __( 'Auto rotate tabs each X seconds.', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'linstar' ),
						'param_name' => 'el_class',
						'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'linstar' )
					)
				),
				'custom_markup' => '
			<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
			<ul class="tabs_controls">
			</ul>
			%content%
			</div>'
			, 
			'default_content' => '
			[vc_tab title="' . __( 'Tab 1', 'linstar' ) . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
			[vc_tab title="' . __( 'Tab 2', 'linstar' ) . '" tab_id="' . $tab_id_2 . '"][/vc_tab]
			',
				'js_view' => $vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35'
			) );


			vc_map( array(
				'name' => __( 'Tab', 'linstar' ),
				'base' => 'vc_tab',
				'allowed_container_element' => 'vc_row',
				'is_container' => true,
				'content_element' => false,
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __( 'Title', 'linstar' ),
						'param_name' => 'title',
						'description' => __( 'Tab title.', 'linstar' )
					),
					array(
						'type' => 'icon',
						'param_name' => 'icon',
						'heading' => __( 'Awesome Icon ', 'linstar' ),
						'description' => __( 'Select Icon for service box', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'type' => 'icon-simple',
						'param_name' => 'icon_simple_line',
						'heading' => __( 'Simple-line Icon ', 'linstar' ),
						'description' => __( 'Select Icon for service box', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'type' => 'icon-etline',
						'param_name' => 'icon_etline',
						'heading' => __( 'Etline Icon ', 'linstar' ),
						'description' => __( 'Select Icon for service box', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'type' => 'tab_id',
						'heading' => __( 'Tab ID', 'linstar' ),
						'param_name' => "tab_id"
					)
				),
				'js_view' => $vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35'
			) );

			vc_map( array(
				'name' => __( 'Video Background', 'linstar' ),
				'base' => 'videobg',
				
				'allowed_container_element' => 'vc_row',
				'content_element' => true,
				'is_container' => true,
				'show_settings_on_create' => false,
				
				'icon' => 'fa fa-file-video-o',
				'category' => THEME_NAME.' Theme',
				
				'description' => __( 'Background video for sections', 'linstar' ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __( 'Background Video ID', 'linstar' ),
						'param_name' => 'id',
						'admin_label' => true,
						'description' => __( 'Imput video id from you, E.g: cUhPA5qIxDQ', 'linstar' )
					),					
					array(
						'type' => 'select',
						'heading' => __( 'Sound', 'linstar' ),
						'param_name' => 'sound',
						'values' => array(
							'no' => 'No, Thanks!',
							'yes' => 'Yes, Please!',
						),
						'admin_label' => true,
						'description' => __( 'Play sound or mute mode when video playing', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => __( 'Height', 'linstar' ),
						'param_name' => "height",
						'description' => __( 'Height of area video. E.g: 500', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'linstar' ),
						'param_name' => 'class',
						'description' => __( 'Use this field to add a class name and then refer to it in your css file.', 'linstar' )
					)
				),
				'js_view' => 'VcColumnView'
				
			) );

			vc_map( array(
			
				'name' => THEME_NAME.' Elements',
				'base' => 'elements',
				'icon' => 'fa fa-graduation-cap',
				'category' => THEME_NAME.' Theme',
				'description' => __( 'All elements use in theme', 'linstar' ),
				'params' => array(

					array(
						'type' => 'attach_image',
						'param_name' => 'image',
						'heading' => __( 'Image ', 'linstar' ),
						'description' => __( 'Select image for service box', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'type' => 'icon',
						'param_name' => 'icon_awesome',
						'heading' => __( 'Awesome Icon ', 'linstar' ),
						'description' => __( 'Select Icon for service box', 'linstar' ),
						'admin_label' => true,
					),					
					array(
						'type' => 'icon-simple',
						'param_name' => 'icon_simple_line',
						'heading' => __( 'Simple-line Icon ', 'linstar' ),
						'description' => __( 'Select Icon for service box', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'type' => 'icon-etline',
						'param_name' => 'icon_etline',
						'heading' => __( 'Etline Icon ', 'linstar' ),
						'description' => __( 'Select Icon for service box', 'linstar' ),
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Icon Class name', 'linstar' ),
						'param_name' => "icon_class"
					),
					
					array(
						'type' => 'textarea_raw_html',
						'heading' => __( 'Short Description', 'linstar' ),
						'param_name' => 'des'
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'External link', 'linstar' ),
						'param_name' => 'link',
						'description' => __( 'External link read more', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'External link class name', 'linstar' ),
						'param_name' => 'linkclass'
					),
					array(
						'type' => 'checkbox',
						'heading' => __("Icon Clickable?",'linstar'),
						'param_name' => 'icon_clickable',
						'value' => array(  __('Yes','linstar')  => 'yes' ),
						'description' => __("Select if you want to icon clickable",'linstar'),
					),
					array(
						'type' => 'checkbox',
						'heading' => __("Open new tab?",'linstar'),
						'param_name' => 'target',
						'value' => array(  __('Yes','linstar')  => 'yes' ),
						'description' => __("Select if you want to open new tab for link and icon",'linstar'),
					),
					array(
						'type' => 'checkbox',
						'heading' => __("Hidden Readmore?",'linstar'),
						'param_name' => 'hidden_readmore',
						'value' => array(  __('Yes','linstar')  => 'yes' ),
						'description' => __("Select if you want to hidden readmore button",'linstar'),
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Read More Text', 'linstar' ),
						'param_name' => 'readmore_text',
						'description' => __( 'Text replace for Read More.', 'linstar' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'linstar' ),
						'param_name' => 'class',
						'description' => __( 'Use this field to add a class name and then refer to it in your css file.', 'linstar' )
					)
				)
			) );
			
			
			/* Owl Image Carousel
			---------------------------------------------------------- */
			
			vc_map( array(
				'name' => __( 'Carousel Photos', 'linstar' ),
				'base' => 'king_carousel',
				'icon' => 'icon-wpb-images-carousel',
				'category' => THEME_NAME.' Theme',
				'description' => __( 'Animated carousel with images', 'linstar' ),
				'params' => array(
					array(
						'type' => 'attach_images',
						'heading' => __( 'Images', 'linstar' ),
						'param_name' => 'images',
						'value' => '',
						'description' => __( 'Select images from media library.', 'linstar' )
					),
					array(
						'type' => 'select',
						'heading' => __( 'Select Template', 'linstar' ),
						'param_name' => 'template',
						'admin_label' => true,
						'values' => Su_Tools::get_templates( 'carousel' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Carousel size', 'linstar' ),
						'param_name' => 'img_size',
						'value' => 'thumbnail',
						'description' => __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size. If used slides per view, this will be used to define carousel wrapper size.', 'linstar' )
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'On click action', 'linstar' ),
						'param_name' => 'action_click',
						'value' => array(
							__( 'None', 'linstar' ) => 'link_no',
							__( 'Open prettyPhoto', 'linstar' ) => 'link_image',							
							__( 'Open custom links', 'linstar' ) => 'custom_link'
						),
						'description' => __( 'Select action for click event.', 'linstar' )
					),
					array(
						'type' => 'exploded_textarea',
						'heading' => __( 'Custom links', 'linstar' ),
						'param_name' => 'custom_links',
						'description' => __( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'linstar' ),
						'dependency' => array(
							'element' => 'action_click',
							'value' => array( 'custom_link' )
						)
					),
					array(
						'type' => 'dropdown',
						'heading' => __( 'Custom link target', 'linstar' ),
						'param_name' => 'custom_links_target',
						'description' => __( 'Select how to open custom links.', 'linstar' ),
						'dependency' => array(
							'element' => 'action_click',
							'value' => array( 'custom_link' )
						),
						'value' => array(
							__( 'Same window', 'linstar' ) => '_self',
							__( 'New window', 'linstar' ) => '_blank'
						),
					),

					array(
						'type' => 'textfield',
						'heading' => __( 'Slides per view', 'linstar' ),
						'param_name' => 'slides_per_view',
						'value' => '1',
						'description' => __( 'Enter number of slides to display at the same time. Just for auto-play, lazy-load templates', 'linstar' )
					),

					array(
						'type' => 'checkbox',
						'heading' => __( 'Hide pagination control', 'linstar' ),
						'param_name' => 'hide_pagination_control',
						'description' => __( 'If checked, pagination controls will be hidden.', 'linstar' ),
						'value' => array( __( 'Yes', 'linstar' ) => 'yes' )
					),
					array(
						'type' => 'checkbox',
						'heading' => __( 'Hide prev/next buttons', 'linstar' ),
						'param_name' => 'hide_prev_next_buttons',
						'description' => __( 'If checked, prev/next buttons will be hidden.', 'linstar' ),
						'value' => array( __( 'Yes', 'linstar' ) => 'yes' )
					),
					array(
						'type' => 'textfield',
						'heading' => __( 'Extra class name', 'linstar' ),
						'param_name' => 'el_class',
						'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'linstar' )
					),
				)
			) );
			
		}
	}

}
      