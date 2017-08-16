<?php
/**
 * Main class
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'king_FILTER' ) ) {

    class king_RESET_FILTER_Widget extends WP_Widget {

        function king_RESET_FILTER_Widget() {
            $widget_ops  = array( 'classname' => 'king-filter-ajax-reset-navigation king-filter-ajax-navigation woocommerce widget_layered_nav', 'description' => __( 'Reset all filters setted by DEVN Filter Widget', 'linstar' ) );
            $control_ops = array( 'width' => 400, 'height' => 350 );
            parent::__construct( 'king-filter-ajax-reset-navigation', __( 'DEVN Woo Reset Filter Widget', 'linstar' ), $widget_ops, $control_ops );
        }


        function widget( $args, $instance ) {
            global $_chosen_attributes, $woocommerce, $_attributes_array;

            extract( $args );

            if ( ! is_post_type_archive( 'product' ) && ! is_tax( array_merge( (array) $_attributes_array, array( 'product_cat', 'product_tag' ) ) ) ) {
                return;
            }

            // Price
            $min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : 0;
            $max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : 0;

            ob_start();

            if ( count( $_chosen_attributes ) > 0 || $min_price > 0 || $max_price > 0 ) {
                $title = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) : '';
                $label = isset( $instance['label'] ) ? apply_filters( 'king-filter-reset-navigation-label', $instance['label'], $instance, $this->id_base ) : '';

                //clean the url
                $link = king_curPageURL();
                foreach ( (array) $_chosen_attributes as $taxonomy => $data ) {
                    $taxonomy_filter = str_replace( 'pa_', '', $taxonomy );
                    $link            = remove_query_arg( 'filter_' . esc_attr( $taxonomy_filter ), $link );
                }
                if ( isset( $_GET['min_price'] ) ) {
                    $link = remove_query_arg( 'min_price', $link );
                }
                if ( isset( $_GET['max_price'] ) ) {
                    $link = remove_query_arg( 'max_price', $link );
                }

                print( $before_widget );
                if ( $title ) {
                    print( $before_title . $title . $after_title );
                }

                echo "<div class='king-filter'><a class='king-filter-reset-navigation button' href='{$link}'>" .$label. "</a></div>";
                print( $after_widget );
                echo ob_get_clean();
            }
            else {
                ob_end_clean();
                echo substr( $before_widget, 0, strlen( $before_widget ) - 1 ) . ' style="display:none">' . $after_widget;
            }
        }


        function form( $instance ) {
            global $woocommerce;

            $defaults = array(
                'title' => '',
                'label' => __( 'Reset All Filters', 'linstar' )
            );

            $instance = wp_parse_args( (array) $instance, $defaults ); ?>

            <p>
                <label>
                    <strong><?php _e( 'Title', 'linstar' ) ?>:</strong><br />
                    <input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo  esc_attr( $instance['title'] ); ?>" />
                </label>
            </p>
            <p>
                <label>
                    <strong><?php _e( 'Button Label', 'linstar' ) ?>:</strong><br />
                    <input class="widefat" type="text" id="<?php echo  esc_attr( $this->get_field_id( 'label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>" value="<?php echo esc_attr( $instance['label'] ); ?>" />
                </label>
            </p>

        <?php
        }

        function update( $new_instance, $old_instance ) {
            global $woocommerce;

            $instance = $old_instance;

            if ( empty( $new_instance['title'] ) ) {
                $new_instance['title'] = function_exists( 'wc_attribute_label' ) ? wc_attribute_label( $new_instance['attribute'] ) : $woocommerce->attribute_label( $new_instance['attribute'] );
            }

            $instance['label'] = strip_tags( $new_instance['label'] );

            return $instance;
        }

    }
}