<?php


/*
 *
 * Thanks for Leemason-NHP
 * Copyright (c) Options by Leemason-NHP 
 *
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 * Also if running on windows you may have url problems, which can be fixed by defining the framework url first
 *
 */
//define('king_options_URL', site_url('path the options folder'));
if(!class_exists('king_options')){
	global $king;
	$king->ext['rqo']( dirname( __FILE__ ) . '/options/options.php' );
}

/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook', 'linstar'),
				'desc' => __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>', 'linstar'),
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);
	
	return $sections;
	
}//function

/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}//function

/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
	
	global $king;
	
	$args = array();
	
	$args['dev_mode'] = false;
	
	$args['google_api_key'] = 'AIzaSyDAnjptHMLaO8exTHk7i8jYPLzygAE09Hg';
	
	$args['intro_text'] = __('<p>This is the HTML which can be displayed before the form, it isnt required, but more info is always better. Anything goes in terms of markup here, any HTML.</p>', 'linstar');
	
	$args['share_icons']['twitter'] = array(
											'link' => 'http://twitter.com/devnCo',
											'title' => 'Folow me on Twitter'
											);
	
	$args['show_import_export'] = false;
	
	$args['opt_name'] = KING_OPTNAME;
	
	$args['page_position'] = 1001;
	$args['allow_sub_menu'] = false;
	
	
	$import_file = dirname(__FILE__).DS.'sample'.DS.'data.xml';
	$import_html = '';		
	if ( file_exists($import_file) ){
	
		$import_html = '<h2></h2><br /><div class="nhp-opts-section-desc"><p class="description"><a style="font-style: normal;" href="admin.php?page=king-sample-data" class="btn btn_green">One-Click Importer Sample Data</a>  &nbsp; Just click and your website will look exactly our demo (posts, pages, menus, categories, tags, layouts, images, sliders, post-type) </p> <br /></div><hr style="background: #ccc;border: none;height: 1px;"/><br />';
		
	}	
	
	$sections = array();
	
	$patterns = array();
	for( $i=0; $i<34; $i++ ){
		$patterns['bg'.$i] = array('title' => 'Background '.$i, 'img' => THEME_URI.'/assets/images/patterns/bg'.$i.'.png');
	}
	
	$listHeaders = array();
	if ( $handle = opendir( THEME_PATH.DS.'templates'.DS.'header' ) ){
		while ( false !== ( $entry = readdir($handle) ) ) {
			if( $entry != '.' && $entry != '..' && strpos($entry, '.php') !== false  ){
				$title  = ucwords( str_replace( '-', ' ', basename( $entry, '.php' ) ) );
				$listHeaders[ $entry ] = array('title' => $title, 'img' => THEME_URI.'/templates/header/thumbnails/'.basename( $entry, '.php' ).'.jpg');
			}
		}
	}		

	$listFooters = array();
	if ( $handle = opendir( THEME_PATH.DS.'templates'.DS.'footer' ) ){
		while ( false !== ( $entry = readdir($handle) ) ) {
			if( $entry != '.' && $entry != '..' && strpos($entry, '.php') !== false  ){
				$title  = ucwords( str_replace( '-', ' ', basename( $entry, '.php' ) ) );
				$listFooters[ $entry ] = array('title' => $title, 'img' => THEME_URI.'/templates/footer/thumbnails/'.basename( $entry, '.php' ).'.jpg');
			}
		}
	}	
				
$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_023_cogwheels.png',
	'title' => __('General Settings', 'linstar'),
	'desc' => __('<p class="description">general configuration options for theme</p>', 'linstar'),
	'fields' => array(

		array(
			'id' => 'logo',
			'type' => 'upload',
			'title' => __('Upload Logo', 'linstar'), 
			'sub_desc' => __('This will be display as logo at header of every page', 'linstar'),
			'desc' => __('Upload new or from media library to use as your logo. We recommend that you use images without borders and throughout.', 'linstar'),
			'std' => THEME_URI.'/assets/images/logo.png'
		),
		array(
			'id' => 'logo_height',
			'type' => 'text',
			'title' => __('Logo Max Height', 'linstar'), 
			'sub_desc' => __('Limit logo\'s size. Eg: 60', 'linstar'),
			'std' => '60',
			'desc' => 'px',
			'css' => '<?php if($value!="")echo "html body .logo img{max-height: ".$value."px;}"; ?>',
		),		
		array(
			'id' => 'logo_top',
			'type' => 'text',
			'title' => __('Logo Top Spacing', 'linstar'), 
			'sub_desc' => __('The spacing from the logo to the edge of the page. Eg: 5', 'linstar'),
			'std' => '5',
			'desc' => 'px',
			'css' => '<?php if($value!="")echo "html body .logo{margin-top: ".$value."px;}"; ?>',
		),			
		array(
			'id' => 'favicon',
			'type' => 'upload',
			'title' => __('Upload Favicon', 'linstar'), 
			'sub_desc' => __('This will be display at title of browser', 'linstar'),
			'desc' => __('Upload new or from media library to use as your favicon.', 'linstar')
		),				
		array(
			'id' => 'layout',
			'type' => 'button_set',
			'title' => __('Select Layout', 'linstar'), 
			'desc' => '',
			'options' => array('wide' => 'WIDE','boxed' => 'BOXED'),
			'std' => 'wide'
		),
		array(
			'id' => 'responsive',
			'type' => 'button_set',
			'title' => __('Responsive Support', 'linstar'), 
			'desc' => __('Help display well on all screen size (smartphone, tablet, laptop, desktop...)', 'linstar'),
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'std' => '1'
		),		
		array(
			'id' => 'effects',
			'type' => 'button_set',
			'title' => __('Effects Lazy Load', 'linstar'), 
			'desc' => __('Sections\' effect displaying when scoll over.', 'linstar'),
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'std' => '1'
		),		
		array(
			'id' => 'admin_bar',
			'type' => 'button_set',
			'title' => __('Admin Bar', 'linstar'), 
			'desc' => __('The admin bar on top at Front-End when you logged in.', 'linstar'),
			'options' => array('hide' => 'Hide','show' => 'Show'),
			'std' => 'hide'
		),
		array(
			'id' => 'breadcrumb',
			'type' => 'button_set',
			'title' => __('Show Breadcrumb', 'linstar'), 
			'desc' => __('The Breadcrumb on every page', 'linstar'),
			'options' => array('yes' => 'Yes', 'no' => 'No'),
			'std' => 'enable'
		),
		array(
			'id' => 'breadeli',
			'type' => 'text',
			'title' => __('Breadcrumb Delimiter', 'linstar'), 
			'desc' => __('The symbol in beetwen your Breadcrumbs.', 'linstar'),
			'std' => '/'
		),
		array(
			'id' => 'breadcrumb_bg',
			'type' => 'upload',
			'title' => __('Breadcrumb Background Image', 'linstar'), 
			'desc' => __('Upload your background image for Breadcrumb', 'linstar'),
			'std' => '',
			'css' => '<?php if($value!="")echo "#breadcrumb.page_title1{background-image:url(".$value.");}"; ?>'
		),
		array(
			'id' => 'api_server',
			'type' => 'button_set',
			'title' => __('Select API Server', 'linstar'), 
			'desc' => __('Select API in case you have problems importing sample data or install sections', 'linstar'),
			'options' => array('api.devn.co' => 'API Server 1','api2.devn.co' => 'API Server 2'),
			'std' => 'api.devn.co'
		),
	)	
);

$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_263_bank.png',
	'title' => __('Header Settings', 'linstar'),
	'desc' => __('<p class="description">Select header & footer layouts, Add custom meta tags, hrefs and scripts to header.</p>', 'linstar'),
	'fields' => array(
		
		array(
			'id' => 'header',
			'type' => 'radio_img',
			'title' => __('Select Header', 'linstar'),
			'sub_desc' => '<br /><br />'.__('Overlap: The header will cover up anything beneath it. <br /> <br />Select header for all pages, You can also go to each page to select specific. This path has located /templates/header/__file__', 'linstar'),
			'options' => $listHeaders,
			'std' => 'default.php'
		),			
		array(
			'id' => 'topInfoEmail',
			'type' => 'text',
			'title' => __('Top Info Email', 'linstar'),
			'sub_desc' => __('Infomation email at top which will need for some of header layouts', 'linstar'),
			'std' => 'hi@king-theme.com'
		),		
		array(
			'id' => 'topInfoPhone',
			'type' => 'text',
			'title' => __('Top Info Phone', 'linstar'),
			'sub_desc' => __('Infomation phone at top which will need for some of header layouts', 'linstar'),
			'std' => '+1 123-456-7890'
		),
		array(
			'id' => 'header_social',
			'type' => 'button_set',
			'title' => __('Display Social Icons', 'linstar'), 
			'desc' => __('Display list of social icon and link on header - just for header support social icons', 'linstar'),
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'stickymenu',
			'type' => 'button_set',
			'title' => __('Disable Sticky Header', 'linstar'),
			'desc' => '<br />'.__('Disable floading header when scrolldown.', 'linstar'),
			'options' => array( '1' => 'Yes', '0' => 'No' ),
			'css' => '<?php if($value=="1")echo "body .header, body .opstycky1, body .menu-link, body .fixednav4, body.compact .header, body .fixednav3{position:absolute;}"; ?>',
			'std' => '0'
		),
	)
);
		
$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_303_temple_islam.png',
	'title' => __('Footer Settings', 'linstar'),
	'desc' => __('<p class="description">Select footer layouts, Add analytics embed..etc.. to footer</p>', 'linstar'),
	'fields' => array(
			
		array(
			'id' => 'footer',
			'type' => 'radio_img',
			'title' => __('Select Footer', 'linstar'),
			'sub_desc' => __('<br /><br />Select footer for all pages, You can also go to each page to select specific. This path has located /templates/footer/__file__', 'linstar'),
			'options' => $listFooters,
			'std' => 'default.php'
		),	
		array(
			'id' => 'footerTerms',
			'type' => 'text',
			'title' => __('Footer Terms\'s Link', 'linstar'), 
			'std' => '#'
		),
		array(
			'id' => 'footerPrivacy',
			'type' => 'text',
			'title' => __('Footer Privacy\'s Link', 'linstar'), 
			'std' => '#'
		),
		array(
			'id' => 'footer_social',
			'type' => 'button_set',
			'title' => __('Display Social Icons', 'linstar'), 
			'desc' => __('Display list of social icon and link on footer - just for footer support social icons', 'linstar'),
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'footerMap',
			'type' => 'textarea',
			'title' => __('Map Address', 'linstar'), 
			'sub_desc' => __('Display on Footer 5', 'linstar'), 
			'std' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d99367.70628197653!2d-77.01937306855469!3d38.895607927030454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7c6de5af6e45b%3A0xc2524522d4885d2a!2sWashington%2C+DC%2C+USA!5e0!3m2!1sen!2sin!4v1425716353976'
		),		
		array(
			'id' => 'footerText',
			'type' => 'textarea',
			'title' => __('Footer Copyrights', 'linstar'), 
			'std' => 'Copyright &copy; 2015 Linstar <sup>TM</sup> - By <a href="http://king-theme.com">King-Theme</a>.'
		),			
		array(
			'id' => 'GAID',
			'type' => 'text',
			'title' => __('Google Analytics ID', 'linstar'),
			'sub_desc' => __( 'Example: UA-61147719-3', 'linstar'),
			'desc' => '<br />'.__('Add the tracking code directly to your site', 'linstar'),

		),
		array(
			'id' => 'footer3_text',
			'type' => 'text',
			'title' => __('Footer 3 Contact Text', 'linstar'),
			'desc' => '<br />'.__('Replace text for text on  the footer 3 "Feel free to talk to our online representative at any time you please using our Live Chat system on our website or one of the instant messaging programs."', 'linstar'),

		)
		
	)
);		

$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_236_zoom_in.png',
	'title' => __('SEO', 'linstar'),
	'desc' => __('<p class="description">Help your site more friendly with Search Engine<br /> After active theme, we will enable all <strong>permalinks</strong> and meta descriptions.</p>', 'linstar'),
	'fields' => array(
		
		array(
			'id' => 'ogmeta',
			'type' => 'button_set',
			'title' => __('Open Graph Meta', 'linstar'), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'std' => '1',
			'sub_desc' => __('elements that describe the object in different ways and are represented by meta tags included on the object page', 'linstar'),
		),
		
		array(
			'id' => 'metatag',
			'type' => 'button_set',
			'title' => __('Meta Tag', 'linstar'), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'std' => '1',
			'sub_desc' => __('Show meta tags into head of website.', 'linstar'),
		),
		
		array(
			'id' => 'homeTitle',
			'type' => 'text',
			'title' => __('Homepage custom title', 'linstar'), 
			'desc' => __('<br />Default is:  <strong>%Site Title% - %Tagline%</strong> from General Settings', 'linstar'),
			'sub_desc' => __('The title will be displayed in homepage between &lt;title>&lt;/title> tags', 'linstar'),
		),	
		
		array(
			'id' => 'homeTitleFm',
			'type' => 'select',
			'title' => __('Home Title Format', 'linstar'), 
			'options' => array('1' => 'Blog Name | Blog description','2' => 'Blog description | Blog Name', '3' => 'Blog Name only'),
			'desc' => __('<br />If <b>Homepage custom title</b> not set', 'linstar'),
			'std' => '1'
		),		
		
		array(
			'id' => 'postTitleFm',
			'type' => 'select',
			'title' => __('Single Post Page Title Format', 'linstar'), 
			'options' => array('1' => 'Post title | Blog Name','2' => 'Blog Name | Post title', '3' => 'Post title only'),
			'std' => '1'
		),	
		array(
			'id' => 'blogTitle',
			'type' => 'text',
			'title' => __('Blog page custom title', 'linstar'), 
			'desc' => wp_kses( __('<br />Support tags:  <strong>%Site Title%, %Tagline%</strong>', 'linstar'), array('br'=>array())),
			'sub_desc' => __('The title will be displayed in blog page between &lt;title>&lt;/title> tags', 'linstar'),
		),			
		array(
			'id' => 'archivesTitleFm',
			'type' => 'select',
			'title' => __('Archives Title Format', 'linstar'), 
			'options' => array('1' => 'Category name | Blog Name','2' => 'Blog Name | Category name', '3' => 'Category name only'),
			'std' => '1'
		),
		
		array(
			'id' => 'titleSeparate',
			'type' => 'text',
			'title' => __('Separate Character', 'linstar'), 
			'sub_desc' => __('a Character to separate BlogName and Post title', 'linstar'),
			'std' => '|'
		),			
		
		array(
			'id' => 'homeMetaKeywords',
			'type' => 'textarea',
			'title' => __('Home Meta Keywords', 'linstar'), 
			'sub_desc' => __('Add  tags for the search engines and especially Google', 'linstar'),
		),			
		array(
			'id' => 'homeMetaDescription',
			'type' => 'textarea',
			'title' => __('Home Meta Description', 'linstar'), 

		),			
		array(
			'id' => 'authorMetaKeywords',
			'type' => 'textarea',
			'title' => __('Author Meta Description', 'linstar'), 
			'std' => 'king-theme.com'
		),		
		array(
			'id' => 'contactMetaKeywords',
			'type' => 'textarea',
			'title' => __('Contact Meta Description', 'linstar'), 
			'std' => 'contact@king-theme.com'
		),		
		array(
			'id' => 'otherMetaKeywords',
			'type' => 'textarea',
			'title' => __('Other Page Meta Keywords', 'linstar'), 

		),			
		array(
			'id' => 'otherMetaDescription',
			'type' => 'textarea',
			'title' => __('Other Page Meta Description', 'linstar'), 

		),	
	)

);


$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_087_log_book.png',
	'title' => __('Blog', 'linstar'),
	'desc' => __('Blog Settings', 'linstar'),	
	'fields' => array(
		array(
			'id' => 'blog',
			'type' => 'blog'
		)
	)
);


$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_061_keynote.png',
	'title' => __('Article Settings', 'linstar'),
	'desc' => __('<p class="description">Settings for Single post or Page</p>', 'linstar'),
	'fields' => array(

		array(
			'id' => 'display_single_sidebar',
			'type' => 'button_set',
			'title' => __('Display Sidebar', 'linstar'),
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'post_breadcrumb',
			'type' => 'select',
			'title' => __('Display Post Single Breadcrumb', 'linstar'), 
			'options' => array( 'global' => 'Use Global Settings', 'yes' => 'Yes, Please! &nbsp; ','no' => 'No, Thanks! '),
			'sub_desc' => 'Set for show or dont show breadcrumb for only this page.'
		),
		array(
			'id' => 'post_bread_padding_top',
			'type' => 'text',
			'title' => __('Post Single Breadcrumb Padding Top', 'linstar'), 
			'sub_desc' => __('Set the padding top with content of the breadcrumb. Ex: 10', 'linstar'),
			'std' => ''
		),
		array(
			'id' => 'post_bread_padding_bottom',
			'type' => 'text',
			'title' => __('Post Single Breadcrumb Padding Bottom', 'linstar'), 
			'sub_desc' => __('Set the padding bottom with content of the breadcrumb. Ex: 10', 'linstar'),
			'std' => ''
		),
		array(
			'id' => 'post_breadcrumb_bg',
			'type' => 'upload',
			'title' => __('Upload Post Single Breadcrumb Background Image', 'linstar'), 
			'std' => '',
			'sub_desc' => __( 'Upload your Breadcrumb background image for this page.', 'linstar' )
		),
		array(
			'id' => 'excerptImage',
			'type' => 'button_set',
			'title' => __('Featured Image', 'linstar'), 
			'sub_desc' => __('Display Featured image before of content', 'linstar'),
			'options' => array('1' => 'Display','2' => 'Hide'),
			'std' => '1'
		),		
		array(
			'id' => 'navArticle',
			'type' => 'button_set',
			'title' => __('Next/Prev Article Direction', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showMeta',
			'type' => 'button_set',
			'title' => __('Meta Box', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showAuthorMeta',
			'type' => 'button_set',
			'title' => __('Author Meta', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showDateMeta',
			'type' => 'button_set',
			'title' => __('Date Meta', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showCateMeta',
			'type' => 'button_set',
			'title' => __('Categories Meta', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showCommentsMeta',
			'type' => 'button_set',
			'title' => __('Comments Meta', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showTagsMeta',
			'type' => 'button_set',
			'title' => __('Tags Meta', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showShareBox',
			'type' => 'button_set',
			'title' => __('Share Box', 'linstar'), 
			'sub_desc' => __('Display box socials button below', 'linstar'),
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showShareFacebook',
			'type' => 'button_set',
			'title' => __('Facebook Button', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showShareTwitter',
			'type' => 'button_set',
			'title' => __('Tweet Button', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showShareGoogle',
			'type' => 'button_set',
			'title' => __('Google Button', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showSharePinterest',
			'type' => 'button_set',
			'title' => __('Pinterest Button', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'showShareLinkedin',
			'type' => 'button_set',
			'title' => __('LinkedIn Button', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'archiveAboutAuthor',
			'type' => 'button_set',
			'title' => __('About Author', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'sub_desc' => __('About author box with avatar and description', 'linstar'),
			'std' => '1'
		),
		array(
			'id' => 'archiveRelatedPosts',
			'type' => 'button_set',
			'title' => __('Related Posts', 'linstar'), 
			'options' => array('1' => 'Show','0' => 'Hide'),
			'sub_desc' => __('List related posts after the content.', 'linstar'),
			'std' => '1'
		),
		array(
			'id' => 'archiveNumberofPosts',
			'type' => 'text',
			'title' => __('Number of posts related to show', 'linstar'), 
			'validate' => 'numeric',
			'std' => '3'
		),
		array(
			'id' => 'archiveRelatedQuery',
			'type' => 'button_set',
			'title' => __('Related Query Type', 'linstar'), 
			'options' => array('category' => 'Category','tag' => 'Tag','author'=>'Author'),
			'std' => 'category'
		)
	)

);

$sections[] = array('divide'=>true);	


$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_037_credit.png',
	'title' => __('Dynamic Sidebars', 'linstar'),
	'desc' => __('You can create unlimited sidebars and use it in any page you want.','linstar'),
	'fields' => array(
		array(
			'id' => 'sidebars',
			'type' => 'multi_text',
			'title' => __('List of Sidebars Created', 'linstar'),
			'sub_desc' => __('Add name of sidebar', 'linstar'),
			'std' => array('Nav Sidebar')
		),
	)

);
 
$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_273_drink.png',
	'title' => __('Styling', 'linstar'),
	'desc' => __('<p class="description">Setting up global style and background</p>', 'linstar'),
	'fields' => array(
		array(
			'id' => 'colorStyle',
			'type' => 'colorStyle',
			'title' => __('Color Style', 'linstar'), 
			'sub_desc' => __('Predefined Color Skins', 'linstar'),
			'desc' => __( 'Primary css file has been located at: /wp_content/themes/__name__/assets/css/colors/color-primary.css', 'linstar' ),
			'std'	=> ''
		),
		array(
			'type' => 'color',
			'id' => 'backgroundColor',
			'title' =>  __('Background Color', 'linstar'),
			'desc' =>  __(' Background body for layout wide and background box for layout boxed', 'linstar'), 
			'css' => '<?php if($value!="")echo "body{background-color: ".$value.";}"; ?>',
			'std' => '#cccccc'
		),	
		array(
			'type' => 'upload',
			'id' => 'backgroundCustom',
			'title' =>  __('Custom Background Image', 'linstar'),
			'sub_desc' => __('Only be used for Boxed Type.', 'linstar'),
			'desc' =>  __(' Upload your custom background image, or you can also use the Pattern available below.', 'linstar'),
			'std' => '',
			'css' => '<?php if($value!="")echo "body{background-image: url(".$value.") !important;}"; ?>'
		
		),
		array(
			'id' => 'useBackgroundPattern',
			'type' => 'checkbox_hide_below',
			'title' => __('Use Pattern for background', 'linstar'), 
			'sub_desc' => __('Tick on checkbox to show list of Patterns', 'linstar'),
			'desc' => __('If you do not have background image, you can also use our Pattern.', 'linstar'),
			'std' => 1
		),
		array(
			'id' => 'backgroundImage',
			'type' => 'radio_img',
			'title' => __('Select background', 'linstar'), 
			'sub_desc' => __('Only be used for Boxed Type.', 'linstar'),
			'options' => $patterns,
			'std' => 'bg23',
			'css' => '<?php if($value!="")echo "body{background-image: url('.THEME_URI.'/assets/images/patterns/".$value.".png);}"; ?>'
		),		
		array(
			'id' => 'linksDecoration',
			'type' => 'select',
			'title' => __('Links Decoration', 'linstar'), 
			'sub_desc' => __('Set decoration for all links.', 'linstar'),
			'options' => array('default'=>'Default','none'=>'None','underline'=>'Underline','overline'=>'Overline','line-through'=>'Line through'),
			'std' => 'default',
			'css' => '<?php if($value!="")echo "a{text-decoration: ".$value.";}"; ?>'
		),		
		array(
			'id' => 'linksHoverDecoration',
			'type' => 'select',
			'title' => __('Links Hover Decoration', 'linstar'), 
			'sub_desc' => __('Set decoration for all links when hover.', 'linstar'),
			'options' => array('default'=>'Default','none'=>'None','underline'=>'Underline','overline'=>'Overline','line-through'=>'Line through'),
			'std' => 'default',
			'css' => '<?php if($value!="")echo "a:hover{text-decoration: ".$value.";}"; ?>'
		),		
		array(
			'id' => 'cssGlobal',
			'type' => 'textarea',
			'title' => __('Global CSS', 'linstar'), 
			'sub_desc' => __('CSS for all screen size, only CSS without &lt;style&gt; tag', 'linstar'),
			'css' => '<?php if($value!="")print( $value ); ?>'
		),
		array(
			'id' => 'cssTablets',
			'type' => 'textarea',
			'title' => __('Tablets CSS', 'linstar'), 
			'sub_desc' => __('Width from 768px to 985px, only CSS without &lt;style&gt; tag', 'linstar'),
			'css' => '<?php if($value!="")echo "@media (min-width: 768px) and (max-width: 985px){".$value."}"; ?>'
		),
		array(
			'id' => 'cssPhones',
			'type' => 'textarea',
			'title' => __('Wide Phones CSS', 'linstar'), 
			'sub_desc' => __('Width from 480px to 767px, only CSS without &lt;style&gt; tag', 'linstar'),
			'css' => '<?php if($value!="")echo "@media (min-width: 480px) and (max-width: 767px){".$value."}"; ?>'
		),
		
	)

);

$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_107_text_resize.png',
	'title' => __('Typography', 'linstar'),
	'desc' => __('<p class="description">Set the color, font family, font size, font weight and font style.</p>', 'linstar'),
	'fields' => array(
		array(
			'id' => 'generalTypography',
			'type' => 'typography',
			'title' => __('General Typography', 'linstar'), 
			'std' => array(),
			'css' => 'body,.dropdown-menu,body p{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),				
		array(
			'id' => 'generalHoverTypography',
			'type' => 'typography',
			'title' => __('General Link Hover', 'linstar'), 
			'css' => 'body * a:hover, body * a:active, body * a:focus{<?php if($value[color]!="")echo "color:".$value[color]." !important;"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),		
		array(
			'id' => 'mainMenuTypography',
			'type' => 'typography',
			'title' => __('Main Menu', 'linstar'),
			'css' => 'body .navbar-default .navbar-nav>li>a{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\' !important;"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight]." !important;"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),		
		array(
			'id' => 'mainMenuHoverTypography',
			'type' => 'typography',
			'title' => __('Main Menu Hover', 'linstar'), 
			'css' => 'body .navbar-default .navbar-nav>li>a:hover,.navbar-default .navbar-nav>li.current-menu-item>a{<?php if($value[color]!="")echo "color:".$value[color]." !important;"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\' !important;"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),			
		array(
			'id' => 'mainMenuSubTypography',
			'type' => 'typography',
			'title' => __('Sub Main Menu', 'linstar'), 
			'css' => '.dropdown-menu>li>a{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),			
		array(
			'id' => 'mainMenuSubHoverTypography',
			'type' => 'typography',
			'title' => __('Sub Main Menu Hover', 'linstar'), 
			'css' => '.dropdown-menu>li>a:hover{<?php if($value[color]!="")echo "color:".$value[color]." !important;"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),	
		array(
			'id' => 'postMetaTypography',
			'type' => 'typography',
			'title' => __('Post Meta', 'linstar'), 
			'std' => array(),
			'css' => '.post_meta_links{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'postMatalinkTypography',
			'type' => 'typography',
			'title' => __('Post Meta Link', 'linstar'), 
			'css' => '.post_meta_links li a{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'postTitleTypography',
			'type' => 'typography',
			'title' => __('Post Title', 'linstar'), 
			'css' => '.blog_post h3.entry-title a{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'postEntryTypography',
			'type' => 'typography',
			'title' => __('Post Entry', 'linstar'), 
			'css' => 'article .blog_postcontent,article .blog_postcontent p{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'widgetTitlesTypography',
			'type' => 'typography',
			'title' => __('Widget Titles', 'linstar'),
			'css' => 'h3.widget-title,#reply-title,#comments-title{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'footerWidgetTitlesTypography',
			'type' => 'typography',
			'title' => __('Footer Widgets Titles', 'linstar'), 
			'std'	=> array('color'=>'#fff'),
			'css' => '.footer h3.widget-title{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'h1Typography',
			'type' => 'typography',
			'title' => __('H1 Typography', 'linstar'), 
			'std' => array(),
			'css' => '.entry-content h1{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'h2Typography',
			'type' => 'typography',
			'title' => __('H2 Typography', 'linstar'), 
			'std' => array(),
			'css' => '.entry-content h2{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'h3Typography',
			'type' => 'typography',
			'title' => __('H3 Typography', 'linstar'), 
			'std' => array(),
			'css' => '.entry-content h3{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'h4Typography',
			'type' => 'typography',
			'title' => __('H4 Typography', 'linstar'), 
			'std' => array(),
			'css' => '.entry-content h4{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'h5Typography',
			'type' => 'typography',
			'title' => __('H5 Typography', 'linstar'), 
			'std' => array(),
			'css' => '.entry-content h5{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		),
		array(
			'id' => 'h6Typography',
			'type' => 'typography',
			'title' => __('H6 Typography', 'linstar'), 
			'std' => array(),
			'css' => '.entry-content h6{<?php if($value[color]!="")echo "color:".$value[color].";"; ?><?php if($value[font]!="")echo "font-family:\'".$value[font]."\';"; ?><?php if($value[size]!="")echo "font-size:".$value[size]."px;"; ?><?php if($value[weight]!="")echo "font-weight:".$value[weight].";"; ?><?php if($value[style]!="")echo "font-style:".$value[style].";"; ?>}'
		)
		
	)

);


$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_050_link.png',
	'title' => __('Social Accounts', 'linstar' ),
	'desc' => __('Set your socials and will be displayed icons at header and footer, Leave blank to hide icons from front-end', 'linstar' ),
	'fields' => array(
		array(
			'id' => 'feed',
			'type' => 'text',
			'title' => __('Your Feed RSS', 'linstar' ),
			'sub_desc' => __('Enter full link e.g: http://yoursite.com/feed', 'linstar' ),
			'std' => 'feed'
		),
		array(
			'id' => 'facebook',
			'type' => 'text',
			'title' => __('Your Facebook Account', 'linstar' ),
			'sub_desc' => __('Social icon will not display if you leave empty', 'linstar' ),
			'std' => 'king'
		),
		array(
			'id' => 'twitter',
			'type' => 'text',
			'title' => __('Your Twitter Account', 'linstar' ),
			'sub_desc' => __('Social icon will not display if you leave empty', 'linstar' ),
			'std' => 'king'
		),
		array(
			'id' => 'google',
			'type' => 'text',
			'title' => __('Your Google+ Account', 'linstar' ),
			'sub_desc' => __('Social icon will not display if you leave empty', 'linstar' ),
			'std' => 'king'
		),
		array(
			'id' => 'linkedin',
			'type' => 'text',
			'title' => __('Your LinkedIn Account', 'linstar' ),
			'sub_desc' => __('Social icon will not display if you leave empty', 'linstar' ),
			'std' => 'king'
		),
		array(
			'id' => 'flickr',
			'type' => 'text',
			'title' => __('Your Flickr Account', 'linstar' ),
			'sub_desc' => __('Social icon will display if you leave empty', 'linstar' ),
			'std' => 'king'
		),
		array(
			'id' => 'pinterest',
			'type' => 'text',
			'title' => __('Your Pinterest Account', 'linstar' ),
			'sub_desc' => __('Social icon will not display if you leave empty', 'linstar' ),
			'std' => 'king'
		),
		array(
			'id' => 'instagram',
			'type' => 'text',
			'title' => __('Your Instagram Account', 'linstar' ),
			'sub_desc' => __('Social icon will not display if you leave empty', 'linstar' ),
			'std' => 'king'
		),
		array(
			'id' => 'youtube',
			'type' => 'text',
			'title' => __('Your Youtube Chanel', 'linstar' ),
			'sub_desc' => __('Social icon will not display if you leave empty', 'linstar' ),
			'std' => 'king'
		)
		
	)

);


//  coming soon

$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_022_fire.png',
	'title' => __('Coming soon', 'linstar' ),
	'desc' => __('Set your socials and will be displayed icons at header and footer, Leave blank to hide icons from front-end', 'linstar' ),
	'fields' => array(
		array(
			'id' => 'cs_logo',
			'type' => 'upload',
			'title' => __('Upload Logo', 'linstar' ), 
			'sub_desc' => __('This will be display as logo at header of every page', 'linstar' ),
			'desc' => __('Upload new or from media library to use as your logo. We recommend that you use images without borders and throughout.', 'linstar' ),
			'std' => THEME_URI.'/assets/images/logo.png'
		),
		array(
			'id' => 'cs_text_after_logo',
			'type' => 'text',
			'title' => __('Text after logo', 'linstar' ),
			'sub_desc' => __('Will show "We\'re Launching Soon" if you leave empty', 'linstar' ),
			'std' => 'We\'re Launching Soon'
		),
		array(
			'id' => 'cs_timedown',
			'type' => 'text',
			'title' => __('Date time for countdown', 'linstar' ),
			'sub_desc' => __('Format  "F d, Y H:i:s" for example "October 18, 2015 08:30:30"', 'linstar' ),
			'std' => 'October 18, 2025 08:30:30'
		),
		array(
			'id' => 'cs_description',
			'type' => 'textarea',
			'title' => __('Description', 'linstar' ), 
			'std' => 'Our website is under construction. We\'ll be here soon with our new awesome site. Get best experience with this one.'
		),
		array(
			'id' => 'cs_slider1',
			'type' => 'upload',
			'title' => __('Background Slider image 1', 'linstar' ), 
			'sub_desc' => __('This will be display as slide at coming soon slider ', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'cs_slider2',
			'type' => 'upload',
			'title' => __('Background Slider image 2', 'linstar' ), 
			'sub_desc' => __('This will be display as slide at coming soon slider ', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'cs_slider3',
			'type' => 'upload',
			'title' => __('Background Slider image 3', 'linstar' ), 
			'sub_desc' => __('This will be display as slide at coming soon slider ', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'cs_slider4',
			'type' => 'upload',
			'title' => __('Background Slider image 4', 'linstar' ), 
			'sub_desc' => __('This will be display as slide at coming soon slider ', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'cs_slider5',
			'type' => 'upload',
			'title' => __('Background Slider image 5', 'linstar' ), 
			'sub_desc' => __('This will be display as slide at coming soon slider ', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		
	)

);

//  Post Types
$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_145_folder_plus.png',
	'title' => __('Custom Post Types', 'linstar' ),
	'desc' => __('Setting title, slugs for post types', 'linstar' ),
	'fields' => array(
		array(
			'id' => 'our_works_title',
			'type' => 'text',
			'title' => __('Our Works Title', 'linstar' ), 
			'sub_desc' => __('This will replace \'Our Works\' menu, breadcrumb text', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'our_works_slug',
			'type' => 'text',
			'title' => __('Our Works Slug', 'linstar' ), 
			'sub_desc' => __('This will replace /our-works/ on url', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'our_works_show_link',
			'type' => 'button_set',
			'title' => __('Our Work Read More Links', 'linstar' ), 
			'sub_desc' => __('Show/Hiden read more link on projects page', 'linstar' ),
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'our_works_show_category',
			'type' => 'button_set',
			'title' => __('Our Work Category Links', 'linstar' ), 
			'sub_desc' => __('Show/Hiden categories link on project details page', 'linstar' ),
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),
		array(
			'id' => 'our_works_visit_link',
			'type' => 'button_set',
			'title' => __('Our Work Visit Site Link', 'linstar' ), 
			'sub_desc' => __('Show/Hiden Viset Site link on project detail page', 'linstar' ),
			'options' => array('1' => 'Show','0' => 'Hide'),
			'std' => '1'
		),

		array(
			'id' => 'our_works_breadcrumb',
			'type' => 'select',
			'title' => __('Display Our Work Breadcrumb', 'linstar'), 
			'options' => array( 'global' => 'Use Global Settings', 'yes' => 'Yes, Please! &nbsp; ','no' => 'No, Thanks! '),
			'sub_desc' => 'Set for show or dont show breadcrumb for only this page.'
		),
		array(
			'id' => 'our_works_bread_padding_top',
			'type' => 'text',
			'title' => __('Our Work Breadcrumb Padding Top', 'linstar'), 
			'sub_desc' => __('Set the padding top with content of the breadcrumb. Ex: 10', 'linstar'),
			'std' => ''
		),
		array(
			'id' => 'our_works_bread_padding_bottom',
			'type' => 'text',
			'title' => __('Our Work Breadcrumb Padding Bottom', 'linstar'), 
			'sub_desc' => __('Set the padding bottom with content of the breadcrumb. Ex: 10', 'linstar'),
			'std' => ''
		),
		array(
			'id' => 'our_works_breadcrumb_bg',
			'type' => 'upload',
			'title' => __('Upload Our Work Breadcrumb Background Image', 'linstar'), 
			'std' => '',
			'sub_desc' => __( 'Upload your Breadcrumb background image for this page.', 'linstar' )
		),

		array(
			'id' => 'our_works_main_page',
			'type' => 'pages_select',
			'title' => __('Our Work Main Page', 'linstar'),
			'sub_desc' => __('Select the page which listing all portfolio items', 'linstar'),
		),

		array(
			'id' => 'our_team_title',
			'type' => 'text',
			'title' => __('Our Team Title', 'linstar' ), 
			'sub_desc' => __('This will replace \'Our Team\' menu, breadcrumb text', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'our_team_slug',
			'type' => 'text',
			'title' => __('Our Team Slug', 'linstar' ), 
			'sub_desc' => __('This will replace /our-team/ on url', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),		
		array(
			'id' => 'faq_title',
			'type' => 'text',
			'title' => __('FAQ Title', 'linstar' ), 
			'sub_desc' => __('This will replace \'FAQ\' menu, breadcrumb text', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'faq_slug',
			'type' => 'text',
			'title' => __('FAQ Slug', 'linstar' ), 
			'sub_desc' => __('This will replace /faq/ on url', 'linstar' ),
			'desc' => __('', 'linstar' ),
			'std' => ''
		),	
	)

);

$sections[] = array('divide'=>true);	

//  Woo Admin
$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_202_shopping_cart.png',
	'title' => __('WooEcommerce', 'linstar' ),
	'desc' => __('Setting for your Shop!', 'linstar' ),
	'fields' => array(
		array(
			'id' => 'product_number',
			'type' => 'text',
			'title' => __('Number of Products per Page', 'linstar' ),
			'desc' => __('Insert the number of products to display per page.', 'linstar' ),
			'std' => '12'
		),
		array(
			'id' => 'woo_grids',
			'type' => 'select',
			'title' => __('Items per row', 'linstar' ), 
			'desc' => __('Set number products per row (for Grids layout)', 'linstar' ),
			'options' => array('4'=>'4 (Shop layout without sidebar)','3'=>'3 (Shop layout with sidebar)'),
			'std' => '3'
		),			
		array(
			'id' => 'woo_layout',
			'type' => 'select',
			'title' => __('Shop Layout', 'linstar' ), 
			'desc' => __('Set layout for your shop page.', 'linstar' ),
			'options' => array('full'=>'No sidebar - Full width', 'left'=>'With Sidebar on Left', 'right'=>'With Sidebar on Right'),
			'std' => 'right'
		),		
		array(
			'id' => 'woo_product_layout',
			'type' => 'select',
			'title' => __('Product Layout', 'linstar' ), 
			'desc' => __('Set layout for your product detail page.', 'linstar' ),'options' => array('full'=>'No sidebar - Full width', 'left'=>'With Sidebar on Left', 'right'=>'With Sidebar on Right'),
			'std' => 'single-product'
		),	
		array(
			'id' => 'woo_product_display',
			'type' => 'select',
			'title' => __('Product Display', 'linstar' ), 
			'desc' => __('Display products by grid or list.', 'linstar' ),
			'options' => array('grid'=>'Grid','list'=>'List'),
			'std' => 'grid'
		),	
		array(
			'id' => 'woo_filter',
			'type' => 'button_set',
			'title' => __('Filter Products', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Enable filter products by price, categories, attributes..', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_cart',
			'type' => 'button_set',
			'title' => __('Show Woocommerce Cart Icon in Top Menu', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Enable Woocommerce Cart show on top menu', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_social',
			'type' => 'button_set',
			'title' => __('Show Woocommerce Social Icons', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Show Woocommerce Social Icons in Single Product Page', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_message_1',
			'type' => 'textarea',
			'title' => __('Account Message 1', 'linstar' ), 
			'desc' => __('Insert your message to appear in the first message box on the acount page.', 'linstar' ),
			'std' => 'Call us in 000-000-000 If you need our support. Happy to help you !'
		),
		array(
			'id' => 'woo_message_2',
			'type' => 'textarea',
			'title' => __('Account Message 2', 'linstar' ), 
			'desc' => __('Insert your message to appear in the second message box on the acount page.', 'linstar' ),
			'std' => 'Send us a email in devn@support.com'
		),
		
	)

);
// Woo Compare Products
$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/compare.png',
	'title' => __('Compare Products', 'linstar' ),
	'desc' => __('Setting compare product features!', 'linstar' ),
	'fields' => array(
		array(
			'id' => 'woo_comp_active',
			'type' => 'button_set',
			'title' => __('Compare Products Active', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Enable compare product feature.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_button',
			'type' => 'select',
			'title' => __('Link or Button', 'linstar' ), 
			'desc' => __('Set link or button compare products.', 'linstar' ),
			'options' => array( 'button' =>'Button','link'=>'Link'),
			'std' => 'button'
		),	
		array(
			'id' => 'woo_comp_button_label',
			'type' => 'text',
			'title' => __('Link/Button label', 'linstar' ),
			'desc' => __('Set label for compare button/link.', 'linstar' ),
			'std' => 'Compare'
		),
		array(
			'id' => 'woo_comp_single',
			'type' => 'button_set',
			'title' => __('Show button in single product page', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __(' Enable to show the button in the single product page.', 'linstar' ),
			'std' => '1',
			'default' => '1'
		),
		array(
			'id' => 'woo_comp_pos_list',
			'type' => 'button_set',
			'title' => __('Show button in products list', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __(' Enable to show the button in the list product page.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_lightbox',
			'type' => 'button_set',
			'title' => __('Compare lightbox', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Pop-up lightbox when click to compare button.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_table_title',
			'type' => 'text',
			'title' => __('Compare table title', 'linstar' ),
			'desc' => __('Set title for comparison table.', 'linstar' ),
			'std' => 'Compare products'
		),
		array(
			'id' => 'woo_comp_p_title',
			'type' => 'button_set',
			'title' => __('Title', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Display product title in comparison table.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_p_image',
			'type' => 'button_set',
			'title' => __('Image', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Display product image in comparison table.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_p_price',
			'type' => 'button_set',
			'title' => __('Price', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Display product price in comparison table.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_p_des',
			'type' => 'button_set',
			'title' => __('Description', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Display description in comparison table.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_p_stock',
			'type' => 'button_set',
			'title' => __('In Stock', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Display "In Stock" in comparison table.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_p_attribute',
			'type' => 'button_set',
			'title' => __('Attributes', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Display attributes were created for products ( color, size, etc... ).', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'woo_comp_p_addtc',
			'type' => 'button_set',
			'title' => __('Add to cart', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Display add to cart in comparison table.', 'linstar' ),
			'std' => '1'
		),	
		array(
			'id' => 'woo_comp_image_width',
			'type' => 'text',
			'title' => __('Image width', 'linstar' ),
			'desc' => __('Set width for product image (px).', 'linstar' ),
			'std' => '220'
		),
		array(
			'id' => 'woo_comp_image_height',
			'type' => 'text',
			'title' => __('Image height', 'linstar' ),
			'desc' => __('Set height for product image (px).', 'linstar' ),
			'std' => '154'
		),
		array(
			'id' => 'woo_comp_i_crop',
			'type' => 'button_set',
			'title' => __('Image hard crop', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Hard crop product image in comparision table.', 'linstar' ),
			'std' => '1'
		)
		
	)

);
// Woo Magnifier
$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_027_search.png',
	'title' => __('Woo Magnifier', 'linstar' ),
	'desc' => __('Setting Magnifier effect for images product in single product page!', 'linstar' ),
	'fields' => array(
		array(
			'id' => 'mg_active',
			'type' => 'button_set',
			'title' => __('Magnifier Active', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Enable magnifier for product images/ Disable magnifier to use default lightbox for product images', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'mg_zoom_width',
			'type' => 'text',
			'title' => __('Zoom Width', 'linstar' ),
			'desc' => __('Set width of magnifier box ( default: auto )', 'linstar' ),
			'std' => 'auto'
		),
		array(
			'id' => 'mg_zoom_height',
			'type' => 'text',
			'title' => __('Zoom Height', 'linstar' ),
			'desc' => __('Set height of magnifier box ( default: auto )', 'linstar' ),
			'std' => 'auto'
		),
		array(
			'id' => 'mg_zoom_position',
			'type' => 'select',
			'title' => __('Zoom Position', 'linstar' ), 
			'desc' => __('Set magnifier position ( default: Right )', 'linstar' ),
			'options' => array('right'=>'Right','inside'=>'Inside'),
			'std' => 'right'
		),	
		array(
			'id' => 'mg_zoom_position_mobile',
			'type' => 'select',
			'title' => __('Zoom Position on Mobile', 'linstar' ), 
			'desc' => __('Set magnifier position on mobile devices (iPhone, Android, etc.)', 'linstar' ),
			'options' => array('default'=>'Default','inside'=>'Inside','disable'=>'Disable'),
			'std' => 'default'
		),	
		array(
			'id' => 'mg_loading_label',
			'type' => 'text',
			'title' => __('Loading Label', 'linstar' ),
			'desc' => __('Set text for magnifier loading...', 'linstar' ),
			'std' => 'Loading...'
		),
		array(
			'id' => 'mg_lens_opacity',
			'type' => 'text',
			'title' => __('Lens Opacity', 'linstar' ),
			'desc' => __('Set opacity for Lens (0 - 1)', 'linstar' ),
			'std' => '0.5'
		),
		array(
			'id' => 'mg_blur',
			'type' => 'button_set',
			'title' => __('Blur Effect', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Blur effect when Lens hover on product images', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'mg_thumbnail_slider',
			'type' => 'button_set',
			'title' => __('Active Slider', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Enable slider for product thumbnail images', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'mg_slider_item',
			'type' => 'text',
			'title' => __('Items', 'linstar' ),
			'desc' => __('Number items of Slide', 'linstar' ),
			'default' => 3
		),
		array(
			'id' => 'mg_thumbnail_circular',
			'type' => 'button_set',
			'title' => __('Circular Thumbnail', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Continue slide as a circle', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'mg_thumbnail_infinite',
			'type' => 'button_set',
			'title' => __('Infinite Thumbnail', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Back to first image when end of list', 'linstar' ),
			'std' => '1'
		),
		
		
		
		
	)

);

// Woo Wishlist

$sections[] = array(
	'icon' => king_options_URL.'img/glyphicons/glyphicons_012_heart.png',
	'title' => __('Woo WishList', 'linstar' ),
	'desc' => __('Setting Wishlist features for your Shop page!', 'linstar' ),
	'fields' => array(
		array(
			'id' => 'wl_actived',
			'type' => 'button_set',
			'title' => __('WishList Active', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Enable WishList features. Be sure that the wishlist page is selected in Admin > Pages Manager', 'linstar' ),
			'std' => '1',
			'default' => '1'
		),
		array(
			'id' => 'wl_cookies',
			'type' => 'button_set',
			'title' => __('Cookies Enable', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Use cookies instead of sessions. If cookies actived, the wishlist will be available for each not logged user for 30 days. Use the filter king_wcwl_cookie_expiration_time to change the expiration time ( needs timestamp ).', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'wl_title',
			'type' => 'text',
			'title' => __('WishList Title', 'linstar' ),
			'desc' => __('Set WishList page Title for your Shop', 'linstar' ),
			'std' => 'My Wishlist on '.THEME_NAME.' Shop'
		),
		array(
			'id' => 'wl_label',
			'type' => 'text',
			'title' => __('Add to cart label', 'linstar' ),
			'desc' => __('Set label for add to cart button in WishList page.', 'linstar' ),
			'std' => 'Add to Cart'
		),
		array(
			'id' => 'wl_w_label',
			'type' => 'text',
			'title' => __('Add to wishlist label', 'linstar' ),
			'desc' => __('Set label for add to wishlist button in WishList page.', 'linstar' ),
			'std' => 'Add to wishlist'
		),
		array(
			'id' => 'wl_position',
			'type' => 'select',
			'title' => __('Position', 'linstar' ), 
			'desc' => __('Set Wishlist position ( default: After Add to Cart )', 'linstar' ),
			'options' => array( 'after-cart' =>'After "Add to cart"','after-thumbnails'=>'After thumbnails', 'after-summary'=>'After summary', 'use-shortcode' => 'Use shortcode'),
			'std' => 'after-cart'
		),	
		
		array(
			'id' => 'wl_redirect',
			'type' => 'button_set',
			'title' => __('Redirect to Cart page', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Go to Cart page if user click "Add to cart" button in the Wishlist page.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'wl_remove',
			'type' => 'button_set',
			'title' => __('Remove Wishlist items added to Cart', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Remove the products from the wishlist if is been added to the Cart.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'wl_facebook',
			'type' => 'button_set',
			'title' => __('Share on Facebook', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Share your Wishlist products on Facebook.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'wl_twitter',
			'type' => 'button_set',
			'title' => __('Tweet on Twitter', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Tweet your Wishlist products on Twitter.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'wl_pinterest',
			'type' => 'button_set',
			'title' => __('Pin on Pinterest', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Pin your Wishlist products on Pinterest.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'wl_google',
			'type' => 'button_set',
			'title' => __('Share on Google+', 'linstar' ), 
			'options' => array('1' => 'Enable','0' => 'Disable'),
			'desc' => __('Share your Wishlist products on Google+.', 'linstar' ),
			'std' => '1'
		),
		array(
			'id' => 'wl_stitle',
			'type' => 'text',
			'title' => __('Socials title', 'linstar' ),
			'desc' => __('Set Social title when sharing.', 'linstar' ),
			'std' => 'My Wishlist on '.THEME_NAME.' Shop'
		),
		array(
			'id' => 'wl_stext',
			'type' => 'text',
			'title' => __('Socials text', 'linstar' ),
			'desc' => __('Facebook, Twitter and Pinterest. Use %wishlist_url% where you want the URL of your wishlist to appear.', 'linstar' ),
			'std' => ''
		),
		array(
			'id' => 'wl_simage',
			'type' => 'text',
			'title' => __('Socials image URL', 'linstar' ),
			'desc' => __('Set socials image URL when sharing.', 'linstar' ),
			'std' => ''
		)
	)

);

$sections[] = array('divide'=>true);

$sections[] = array(
	'id' => 'import-export',
	'icon' => king_options_URL.'img/glyphicons/glyphicons_082_roundabout.png',
	'title' => __('Import / Export', 'linstar'),
	'desc' => __('Import or Export theme options and widgets data', 'linstar'),
	'fields' => array(
		array(
			'id' => 'import_data',
			'type' => 'import_data',
			'title' => __('Import From File', 'linstar'),
			'warning_text' => __( 'WARNING! This will overwrite all existing option values, please proceed with caution!', 'linstar' ),
			'desc' => __('', 'linstar')
		),
		array(
			'id' => 'export_data',
			'type' => 'export_data',
			'title' => __('Export To File', 'linstar'),
			'desc' => __('Here you can copy/download your current option settings. Keep this safe as you can use it as a backup should anything go wrong, or you can use it to restore your settings on this site (or any other site).', 'linstar')
		),
	)
);

			
	$tabs = array();
			
	if (function_exists('wp_get_theme')){
		$theme_data = wp_get_theme();
		$theme_uri = $theme_data->get('ThemeURI');
		$description = $theme_data->get('Description');
		$author = $theme_data->get('Author');
		$version = $theme_data->get('Version');
		$tags = $theme_data->get('Tags');
	}else{
		$theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()).'style.css');
		$theme_uri = $theme_data['URI'];
		$description = $theme_data['Description'];
		$author = $theme_data['Author'];
		$version = $theme_data['Version'];
		$tags = $theme_data['Tags'];
	}	
	
	
	
	if(file_exists(trailingslashit(get_stylesheet_directory()).'README.html')){
		$tabs['theme_docs'] = array(
						'icon' => king_options_URL.'img/glyphicons/glyphicons_071_book.png',
						'title' => __('Documentation', 'linstar'),
						'content' => nl2br(devnExt::file( 'get', trailingslashit(get_stylesheet_directory()).'README.html'))
						);
	}//if

	global $king_options, $king;
	
	$king_options = new king_options($sections, $args, $tabs);
	$king->cfg = get_option( $args['opt_name'] );

}//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function video_get_start($field, $value){
	
	switch( $field['id'] ){
		case 'inspector':
		  echo '<ifr'.'ame width="560" height="315" src="http://www.youtube.com/embed/rO8HYqUUbL8?vq=hd720&rel=0&start=76" frameborder="0" allowfullscreen></ifr'.'ame>';
		break;
		case 'grid':
			echo '<ifr'.'ame width="560" height="315" src="http://www.youtube.com/embed/rO8HYqUUbL8?vq=hd720&rel=0" frameborder="0" allowfullscreen></ifr'.'ame>';
		break;
	}

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';	
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function
?>