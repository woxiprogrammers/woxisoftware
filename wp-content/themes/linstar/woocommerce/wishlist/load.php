<?php

/**
 * @author Tarchini Maurizio
 * @copyright 2011
 */

          
$wp_load = dirname(dirname(__FILE__));

for($i=0; $i<10; $i++)
{                  
	if(file_exists($wp_load . '/wp-load.php'))
	{                      
		king_load_core( "$wp_load/wp-load.php", true ); 
		break;
	}
	else
	{
		$wp_load = dirname($wp_load);
	}
}

?>