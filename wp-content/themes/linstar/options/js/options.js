jQuery(document).ready(function(){
	
	
	if(jQuery('#last_tab').val() == ''){

		jQuery('.nhp-opts-group-tab:first').slideDown('fast');
		jQuery('#nhp-opts-group-menu li:first').addClass('active');
	
	}else{
		
		tabid = jQuery('#last_tab').val();
		jQuery('#'+tabid+'_section_group').slideDown('fast');
		jQuery('#'+tabid+'_section_group_li').addClass('active');
		
	}
	
	
	jQuery('input[name="'+king_opts.opt_name+'[defaults]"]').click(function(){
		if(!confirm(king_opts.reset_confirm)){
			return false;
		}
	});
	
	jQuery('.nhp-opts-group-tab-link-a').click(function(){
		relid = jQuery(this).attr('data-rel');
		
		jQuery('#last_tab').val(relid);
		
		jQuery('.nhp-opts-group-tab').each(function(){
			if(jQuery(this).attr('id') == relid+'_section_group'){
				jQuery(this).delay(150).fadeIn(300);
			}else{
				jQuery(this).fadeOut(150);
			}
			
		});
		
		jQuery('.nhp-opts-group-tab-link-li').each(function(){
				if(jQuery(this).attr('id') != relid+'_section_group_li' && jQuery(this).hasClass('active')){
					jQuery(this).removeClass('active');
				}
				if(jQuery(this).attr('id') == relid+'_section_group_li'){
					jQuery(this).addClass('active');
				}
		});
	});
	
	
	
	
	if(jQuery('#nhp-opts-save').is(':visible')){
		jQuery('#nhp-opts-save').delay(4000).slideUp('slow');
	}
	
	if(jQuery('#nhp-opts-imported').is(':visible')){
		jQuery('#nhp-opts-imported').delay(4000).slideUp('slow');
	}	
	
	jQuery('input, textarea, select').change(function(){
		jQuery('#nhp-opts-save-warn').slideDown('slow');
	});
	
	
	jQuery('#nhp-opts-import-code-button').click(function(){
		if(jQuery('#nhp-opts-import-link-wrapper').is(':visible')){
			jQuery('#nhp-opts-import-link-wrapper').fadeOut('fast');
			jQuery('#import-link-value').val('');
		}
		jQuery('#nhp-opts-import-code-wrapper').fadeIn('slow');
	});
	
	jQuery('#nhp-opts-import-link-button').click(function(){
		if(jQuery('#nhp-opts-import-code-wrapper').is(':visible')){
			jQuery('#nhp-opts-import-code-wrapper').fadeOut('fast');
			jQuery('#import-code-value').val('');
		}
		jQuery('#nhp-opts-import-link-wrapper').fadeIn('slow');
	});
	
	
	
	jQuery('#theme-export-button').on( 'click', function(e){

		var form = jQuery('<form action="'+window.location.href+'" method="POST"><input name="doAction" type="hidden" value="export" /></form>');
		jQuery('body').append( form );
		form.trigger('submit');

		e.preventDefault();
		return false;

	});

	jQuery('#theme-import-button').on( 'click', function(e){

		var wrp = jQuery(this).closest('.king-file-upload');
		if( jQuery('#file-upload-to-import').val() == '' )
		{
			jQuery('#import-warning-msg')
				.html('Error! Please choose a file to import.')
				.animate({marginLeft:-10,marginRight:10}, 100)
				.animate({marginLeft:10,marginRight:-10}, 100)
				.animate({marginLeft:-5,marginRight:5}, 100)
				.animate({marginLeft:3,marginRight:-3}, 100)
				.animate({marginLeft:0,marginRight:0}, 100);
		}
		else
		{
			var form = jQuery('<form enctype="multipart/form-data" action="'+window.location.href+'" method="POST" style="display:none;"><input name="doAction" type="hidden" value="import" /><input type="text" name="option" value="'+wrp.find('input[name="import_type"]:checked').val()+'" /></form>');
			jQuery('body').append( form );
			form.append( jQuery('#file-upload-to-import') );
			form.trigger('submit');
		}

		e.preventDefault();
		return false;

	});
	

	
	
	
});