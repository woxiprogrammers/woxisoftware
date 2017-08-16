<?php
/**
 * (c) www.devn.co
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $king;
?>
<link href="<?php echo THEME_URI; ?>/assets/js/comingsoon/animations.min.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" media="screen" href="<?php echo THEME_URI; ?>/assets/js/comingsoon/coming.css" type="text/css" />
<script src="<?php echo THEME_URI; ?>/assets/js/comingsoon/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo THEME_URI; ?>/assets/js/comingsoon/jquery.bcat.bgswitcher.js"></script>

<div id="bg-body"></div>
<!--end -->
<div class="site_wrapper">
	<div class="comingsoon_page">
		<div class="container">
			<div class="topcontsoon">
				<?php
					$logo = $king->cfg['cs_logo'];
					if($logo){
						$logo = str_replace(array('%SITE_URI%', '%HOME_URI%'), array(SITE_URI, SITE_URI), $logo);
					}else{
						$logo = THEME_URI. '/assets/images/logo.png';
					}					
				?>
				<img src="<?php echo esc_attr($logo); ?>" alt="Logo" />
				<div class="clearfix">
				</div>
				<h5>
					<?php 
						$sologan = $king->cfg['cs_text_after_logo'];
						if($sologan){
							echo esc_html($sologan);
						}else{
							_e('We\'re Launching Soon', 'linstar' ); 
						}
					?>
				</h5>
			</div>
			<!-- end section -->
			<div class="countdown_dashboard">
				<div class="dash day_dash">
					<span class="dash_title">
						days
					</span>
					<div class="digit">
						0
					</div>
					<div class="digit">
						0
					</div>
					<div class="digit">
						0
					</div>
				</div>
				<div class="dash hour_dash">
					<span class="dash_title">
						hrs
					</span>
					<div class="digit">
						0
					</div>
					<div class="digit">
						0
					</div>
				</div>
				<div class="dash min_dash">
					<span class="dash_title">
						min
					</span>
					<div class="digit">
						0
					</div>
					<div class="digit">
						0
					</div>
				</div>
				<div class="dash last sec_dash">
					<span class="dash_title">
						sec
					</span>
					<div class="digit">
						0
					</div>
					<div class="digit">
						0
					</div>
				</div>
			</div>
			<!-- end section -->
			<div class="clearfix"></div>
			<div class="socialiconssoon">
				<p>
					<?php 
						$description = $king->cfg['cs_description'];
						if($description){
							echo esc_html($description);
						}else{
							_e("Our website is under construction. We'll be here soon with our new awesome site. Get best experience with this one.", 'linstar' );
						}
					?>
				</p>
				<div class="clearfix marb4"></div>
				<form name="myForm" action="" onSubmit="return validateForm();" method="post">
					<input type="text" name="email" class="newslesoon" value="Enter email..." onFocus="if (this.value == 'Enter email...') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'Enter email...';}" >
					<input type="submit" value="Submit" class="newslesubmit">
				</form>
				<div class="clearfix"></div>
				<?php king::socials(); ?>
			</div>
			<!-- end section -->
		</div>
	</div>
</div>
<!-- ######### JS FILES ######### -->
<script type="text/javascript" src="<?php echo THEME_URI; ?>/assets/js/comingsoon/countdown.js"></script>
<!-- animations -->
<script src="<?php echo THEME_URI; ?>/assets/js/comingsoon/animations.min.js" type="text/javascript"></script>

<?php
	$srcBgArray = array();
	for($i=1; $i<=5; $i++){
		$var_name = 'cs_slider'.$i;
		if(!empty($king->cfg[$var_name])){
			array_push($srcBgArray, $king->cfg[$var_name]);
		}
	}
	
	$str_arr = array();
	if($srcBgArray){
		foreach($srcBgArray as $src){
			$str_arr[] =  str_replace(array('%SITE_URI%', '%HOME_URI%'), array(SITE_URI, SITE_URI), $src);
		}
	}


	if(empty($str_arr)){
		$str_arr = array(
		"http://gsrthemes.com/aaika/fullwidth/js/comingsoon/img-slider-1.jpg",
		"http://gsrthemes.com/aaika/fullwidth/js/comingsoon/img-slider-2.jpg",
		"http://gsrthemes.com/aaika/fullwidth/js/comingsoon/img-slider-3.jpg",
		);
	} 
?>
<?php
	$timedown = $king->cfg['cs_timedown'];
	if( empty($king->cfg['cs_timedown'])){
		$timedown = date("F d, Y H:i:s",strtotime("+1 week"));
	}
	$king_year = date('Y',strtotime($timedown));
	$king_month = date('n',strtotime($timedown));
	$king_day = date('j',strtotime($timedown));
	$king_hour = date('H',strtotime($timedown));
	$king_min = date('i',strtotime($timedown));
	$king_sec = date('s',strtotime($timedown));
?>
<script type="text/javascript">

		var timeTarget =  {
	
		/*=======Start Config Target=======*/
		
			year: <?php echo esc_attr($king_year);?>,
			month: <?php echo esc_attr($king_month);?>,
			day: <?php echo esc_attr($king_day);?>,
			hour: <?php echo esc_attr($king_hour);?>,
			min: <?php echo esc_attr($king_min);?>,
			sec: <?php echo esc_attr($king_sec);?>,
		
		
		/*=======End Config=======*/
		
		version: '@version',
		diff: null,
		refresh: 1000,
		easing: 'linear',
		dash: [
			{
				key: 'year', duration: 950}
			,
			{
				key: 'day', duration: 950}
			,
			{
				key: 'hour', duration: 950}
			,
			{
				key: 'min', duration: 950}
			,
			{
				key: 'sec', duration: 750}
		],
		// you may provide callback capabilities
		onEnd: $.noop
	};


	var srcBgArray = [<?php foreach($str_arr as $img) echo '"'.esc_html($img).'",';?>];
		   			
	$(document).ready(function() {
		$('#bg-body').bcatBGSwitcher({
			urls: srcBgArray,
			alt: 'Full screen background image',
			links: true,
			prevnext: true
		});
	}
					 );
	function validateForm() {
		var x = document.forms["myForm"]["email"].value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) {
			alert("Not a valid e-mail address");
			return false;
		}
	}

	(function($) {
		"use strict";
		$('.countdown_dashboard').countdown();
		$('.stop').on('click', function(e){
			e.preventDefault();
			$('.countdown_dashboard').data('countdown').stop();
		}
		);
	}
	)(jQuery);
</script>
