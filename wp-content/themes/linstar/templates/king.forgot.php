<?php
/**
 * (c) www.king-theme.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $more, $king;

get_header();

?>

<div class="container-fluid breadcrumbs page_title2" id="breadcrumb">
    <div class="container">
        <div class="col-md-12">
            <div class="title">
                <h1><?php _e('Login Form', 'linstar' ); ?> </h1>
			</div>
			<div class="pagenation">
				<div class="breadcrumbs"><a href="#"><?php _e('Home', 'linstar' ); ?></a> / <?php _e('Login', 'linstar' ); ?></div>
			</div>
        </div>
    </div>
</div>


<div id="primary" class="site-content">
	<div id="content" class="container">
		<div class="entry-content blog_postcontent">
			<div class="margin_top12"></div>
			
			<div class="logregform">        
				<div class="title">        
					<h3><?php _e('Forgot your password', 'linstar' ); ?></h3>        		
					<p><?php _e('Back to login', 'linstar' ); ?> <a href="'. site_url() .'?action=login"><?php _e('Login', 'linstar' ); ?></a></p>            
				</div>
				
				<div class="feildcont">        
					<form id="king-form" method="post" name="loginform" action="" class="king-form" novalidate="novalidate">      
						<label><i class="fa fa-user"></i> <?php _e('Enter your Email', 'linstar' ); ?></label>       
						<input type="text" name="email" value="" />
						
						<p class="status"></p>
						
						<button type="button" class="fbut btn-resetpwd"><?php _e('Reset password!', 'linstar' ); ?></button>  

						<input type="hidden" name="action" value="king_user_forgot" />
						<?php wp_nonce_field( 'ajax-forgotpw-nonce', 'security_fgpw' ); ?>
					</form>        
				</div>  
			</div>
			
			<div class="margin_top8"></div>
		</div>
	</div>
</div>



<?php get_footer(); ?> 