<?php
/**
 * Ajax wishlist
 */


header( "Cache-Control: no-cache, must-revalidate" ); // HTTP/1.1
header( "Expires: Sat, 26 Jul 1997 05:00:00 GMT" ); // Date in the past

global $king;
include  dirname( __FILE__ ).DS.'functions-wishlist.php';

if( !isset( $king_wishlist ) ) {
	$king_wishlist = new king_WISHLIST( $_REQUEST );
}

// Remove product from the wishlist
if( $_GET['action'] == 'remove_from_wishlist' ) {
    $count = king_wishlist_count_products();
        
    if( $king_wishlist->remove( $_GET['wishlist_item_id'] ) )
        { _e( 'Product successfully removed.', 'linstar' ); }
    else {
        echo '#' . $count . '#';
        _e( 'Error. Unable to remove the product from the wishlist.', 'linstar' );
    }
    
    if( !$count )
        { _e( 'No products were added to the wishlist', 'linstar' ); }
    
    wp_redirect( $king_wishlist->get_wishlist_url() );
    die();
}
// Add product in the wishlist
elseif( $_GET['action'] == 'add_to_wishlist' ) {
    $return = $king_wishlist->add();
    
    if( $return == 'true'  )
        { print( $return ) . '##' . __( 'Product added!', 'linstar' ); }
    elseif( $return == 'exists' )
        { print( $return ) . '##' . __( 'Product already in the wishlist.', 'linstar' ); }
    elseif( count( $king_wishlist->errors ) > 0 )
        { print( $king_wishlist->get_errors() ); }
    
    wp_redirect( get_permalink( intval( $_GET['add_to_wishlist'] ) ) ); 
    die();
}
// Check if a product exists in the wishlist in case of variations
elseif( $_GET['action'] == 'prod_find' ) {
    if( $king_wishlist->is_product_in_wishlist( $_POST['prod_id'] ) ) {
		echo "exists";
	}
}