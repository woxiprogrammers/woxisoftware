(function($){
	"use strict";
	$(document).ready(function($){
	
	
		/*$('iframe').remove();*/
		
		$(
				'.king-sidebar .widget_categories,.king-sidebar .widget_archive,'+
				'.king-sidebar .widget_pages,.king-sidebar .widget_meta,'+
				'.king-sidebar .widget_recent_entries,'+
				'.king-sidebar .widget_product_categories,'+
				'.king-sidebar .widget_nav_menu').each(function(){
				
			$(this).find('ul').addClass('arrows_list1');
			$(this).find('li a').prepend('<i class="fa fa-long-arrow-right"></i>');
		
		});
		
		$('ul.nav>li.current-menu-item>a').addClass('active');
		
		$('.king-sidebar h3.widget-title,.footer h3.widget-title').each(function(){
			var html = this.innerHTML;
			if( html.indexOf(' ') > -1 && html.indexOf('<') < 0){
				var title = html.substring( 0 , html.indexOf(' ') );
				title += '<i>'+html.substring( html.indexOf(' '), html.length )+'</i>';
				this.innerHTML = title;
			}
		});
			
		$('#tabs ul.tabs li').click(function(e){
			$('#tabs .tab_container').css({display:'none'});
			$( $(this).find('a').attr('href') ).css({display:'block'});
			$('#tabs ul.tabs li.active').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		
		$('.king-portfolio-item a.lightbox').attr({ 'rel': 'lb[portfolio]' });
		
		$("a[rel^='lb']").prettyPhoto({
			animation_speed:'normal',
			theme:'pp_default',
			slideshow:5000, 
			hideflash: true,
			autoplay_slideshow: false,
			social_tools: '',
			show_title: true
		});	
		
		$('#scrollup').click(function(e){
			$('html,body').animate({ 'scroll-top' : 0 });
			e.preventDefault();
		});

		$('.navbar-toggle').click(function(){
			var targ = $(this).attr('data-target');
			if( $( targ ).get(0) ){
				$( targ ).slideToggle();
			}
		});
		
		$('a').click(function(e){
			if( $(this).attr('href') == '#' ){
				e.preventDefault();
			}
		});
		
		$('.flexslider').flexslider({
			animation:"slide",
			animationLoop:true,
			itemWidth:1170,
			itemMargin:5,
			pausePlay:true,
			start:function(slider){
				$('body').removeClass('loading');
			}
		});
		
		document.mainMenu = $('body');
		
		$(window).scroll(function () {

		    if ($(window).scrollTop() > 30 ) {
		        $('#scrollup').show();
		        document.mainMenu.addClass('compact');
		    } else {
		        $('#scrollup').hide();
		        document.mainMenu.removeClass('compact');
		    }
		});
		
		$('.close-but').click(function(){
			$(this).parent().parent().hide('slow',function(){$(this).remove();});
		});
		
		$('.king-preload').each(function(){
			
			var rel = $(this).attr('data-option').split('|');
			
			(function( elm ){
				$.post( site_uri+'/index.php', {
						'control'	: 'ajax',
						'task'		: rel[0], 
						'id'		: rel[1],
						'amount'	: rel[2]
					}, function (result) {
					
					elm.innerHTML = result;
					$(elm).addClass('animated fadeIn');
						
				})
			})(this);
			
		});
		
		
		// detached tabs
		$('.detached').each(function(){
			$( this ).find('.detached-nav li').click(function(){
				var index = $(this.parentNode).find('li').index( this );
				$(this).parent().find('.current').removeClass('current');
				$(this).addClass('current');
				$(this).closest('.detached').find('section').attr({'aria-expanded':'false'});
				$(this).closest('.detached').find('section').eq( index ).attr({'aria-expanded':'true'});
			}).eq(0).click();
		});
		
		$('.navbar-nav li.yamm-fw a.active').each(function(){
			$(this).closest('li.yamm-fw').find('>a').addClass('active');
		});
		
		// Menu OnePage
		$('#menu-onepage .nav-toggle').click(function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this.parentNode).find('.nav-collapse').removeClass('opened').addClass('closed');
			}
			else{
				$(this).addClass('active');
				$(this.parentNode).find('.nav-collapse').removeClass('closed').addClass('opened');
			}
			$(this).next().slideToggle();
		});
		
		$('#menu-onepage a').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				if (target.length) {
					$('#menu-onepage li.active').removeClass('active');
					$(this).parent().addClass('active');
					$('.nav-collapse').attr({style:''});
					//$('.nav-toggle').removeClass('active');
					
					if( $(this).closest('.float-menu').get(0) ){
						$('html,body').animate({
							scrollTop: target.offset().top-10
						}, 1000);
					}else{
						$('html,body').animate({
							scrollTop: target.offset().top-100
						}, 1000);
					}	
					return false;
				}
			}
		});
		
		
		$('#king-mainmenu li a').click(function(e){
			if( !$(this.parentNode).find('ul').get(0) || $('body').width() > 1000 ){
				return true;
			}
			if( $(this.parentNode).hasClass('open') ){
				$(this.parentNode).removeClass('open');
				return true;
			}else $(this.parentNode).addClass('open');

			e.preventDefault();
			
			return false;
		});
		//enable scroll for map
		$('.fgmapfull').click(function () {
		    $('.fgmapfull iframe').css("pointer-events", "auto");
		});
		
		videos_gallery( jQuery );
		

		$(function() {
			$('#sidebar ul.children').hide();
			$('#sidebar .arrows_list1 > li > a').click(function(event) {
				if($(this).parent().hasClass('page_item_has_children')){
					event.preventDefault();
					$(this).next('.children').slideToggle("slow");
				}
			});
		});
		if(jQuery('#wpadminbar').length > 0){
		   jQuery('#main>.header').css('margin-top', 32);
		   jQuery('#main>.opstycky1').css('margin-top', 32);
		}
	});
	
	
	$(window).load(function(){
		$('.flexslider').flexslider({
			animation:"slide",
			animationLoop:true,
			itemWidth:1170,
			itemMargin:5,
			pausePlay:true,
			start:function(slider){
				$('body').removeClass('loading');
			}
		});
	});
	
})(jQuery);	


function timelineLoadmore( index, cat, btn ){
	
	jQuery( btn ).html('<i class="fa fa-spinner fa-spin"></i>').get(0).disabled = true;
	jQuery.post( site_uri+'/wp-admin/admin-ajax.php', {
			'action' : 'loadPostsTimeline',
			'index'  : index,
			'cat'    : cat,
		}, function (result) {
			jQuery( btn ).remove();
			jQuery('#cd-timeline').append( result );
	});
}


function videos_gallery($){ 
	
	$('.videos-gallery-list').each(function(){
		$(this).find('iframe').each(function(){
			$(this).parent().find('br').remove();
			var yid = this.src;
			yid = yid.split('embed')[1].replace(/\//g,'');
			$(this).closest('.wpb_text_column').attr({'data-yid':yid}).click(function(){
				var yid = $(this).attr('data-yid');
				$(this).closest('.wpb_row').find('.videos-gallery-player .wpb_wrapper').html('<iframe src="https://www.youtube.com/embed/'+yid+'?autoplay=1"></iframe>');
			});
			$(this).after('<img src="https://i.ytimg.com/vi/'+yid+'/default.jpg" />').remove();
		});
	});
	
}