<?php

/*
*	Loading DEVN's framework and HUBs library
*	(c) king-theme.com
*
*/

#Load core of theme
function king_load_core( $path = '', $once = false ){
	if( !file_exists( $path ) )
		$path = get_template_directory().'/'.$path;
	if( file_exists( $path ) ){
		if( $once )
			return require_once $path;
		else return include $path;	
	}
}
include 'core/king.define.php';
#
#
#	END of REGISTRATION
#
#
