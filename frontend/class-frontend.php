<?php
/**
 * Frontend class
 *
 * @package     Woo_Description
 * @since       1.0.0
 */

if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'WD_Frontend' ) ) {
    
    /**
     * Handle the frontend
     *
     * @since 1.0.0
     */
    class WD_Frontend {

        /**
         * Class constructor
         */
		public function __construct() {
            add_action( 'wp_enqueue_scripts',          array( $this, 'add_frontend_styles' ) );
            add_action( 'wp_footer',                   array( $this, 'add_frontend_scripts' ) );
			/**
			 * Add Quick View Button
			 */
			//add_action( 'woocommerce_after_shop_loop_item', array( $this, 'add_quick_view_button' ), 15 );
			/**
			 * Get product description from ID
			 */
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'add_hidden_div' ), 9 );
			
			add_action( 'wp_ajax_get_product_description', array($this, 'get_product_description') );
			add_action( 'wp_ajax_nopriv_get_product_description', array($this, 'get_product_description') );
		
		}
		
        /**
         * Load the required css styles.
         *
         * @since 1.0.0
         * @return void
         */
		public function add_frontend_styles() {
            
            $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
            
            wp_enqueue_style( 'wd-tooltip-style', WD_URL . 'assets/css/tooltipster'. $min .'.css', '', WD_VERSION_NUM );
        }
		
        /**
         * Load the required js scripts.
         *
         * @since 1.0.0
         * @return void
         */
		public function add_frontend_scripts() {
			
			$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			/**
			 * Load scripts only in shop page
			 */
			if ( function_exists( 'is_shop' ) && is_shop() ) {
				wp_enqueue_script( 'wd-tooltip-script', WD_URL . 'assets/js/jquery.tooltipster'. $min .'.js', array( 'jquery' ), WD_VERSION_NUM, true );
				
				wp_enqueue_script( 'wd-custom-script', WD_URL . 'assets/js/custom'. $min .'.js', array( 'jquery' ), WD_VERSION_NUM, true );
				
				wp_localize_script( 'wd-custom-script', 'custom_values', array(
					'ajaxurl'   => admin_url( 'admin-ajax.php' ),
					'token'     => wp_create_nonce( 'get_product_nonce' )
				));
			}
			echo "<style>.hidden{display:none;}</style>";
		}
		
		/**
		 * Add Quick Button below to the add to cart button
		 *
		 * @since 1.0.0
		 * @return anchor tag
		 */
		//public function add_quick_view_button(){
			//global $product;
		//}
		
		/*
		 * AJAX - Give Response to the AJAX Request
		 */
		public function get_product_description(){
			global $product;
			
			if(isset($_POST)){
				if(intval($_POST['productId'])){
					$result = array(
						'description' => $this->get_product_description_from_id(intval($_POST['productId']))
					);
				}
				else{
					$result = array(
						'error' => true
					);
				}
			}
			wp_send_json($result);
		}
		
		/*
		 * Add hidden input type to store Product ID
		 */
		public function add_hidden_div(){
			global $product;
			echo "<input type='text' class='hidden wdDescription' value='".$product->id."' readonly/>";
		}
		
		/*
		 * Get Description from the product ID
		 */
		public function get_product_description_from_id($id){
			$content_post = get_post($id);
			$content = $content_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			return $content;
		}
	}
	
	new WD_Frontend();
}
