<?php
/**
 * Plugin Name: Product Description on Hover - WooCommerce AddOn
 * Plugin URI: http://stackoverflow.com/users/2778929/rohil-phpbeginner
 * Description: It will show product description when user hover product image from the shop area.
 * Version: 1.0.1
 * Author: rohilmistry
 * Author URI: http://stackoverflow.com/users/2778929/rohil-phpbeginner
 * License: GPLv3
 */

if(!class_exists('Woo_Description')){

	Class Woo_Description{
		
		/**
         * Class constructor
		 */          
		function __construct(){
			
			/*
			 * Check whether WooCommerce is active or not
			 */
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				$this->define_constants();
				$this->includes();
			
				register_activation_hook( __FILE__, array( $this, 'install' ) );
			}
			else{
				add_action('admin_notices', array($this, 'woocommerce_disabled'));
			}
		}
		
		/**
         * Setup plugin constants
         *
         * @since 1.0.0
         * @return void
         */
        public function define_constants() {

            if ( !defined( 'WD_VERSION_NUM' ) )
                define( 'WD_VERSION_NUM', '1.0.0' );

            if ( !defined( 'WD_URL' ) )
                define( 'WD_URL', plugin_dir_url( __FILE__ ) );

            if ( !defined( 'WD_BASENAME' ) )
                define( 'WD_BASENAME', plugin_basename( __FILE__ ) );

            if ( !defined( 'WD_PLUGIN_DIR' ) )
                define( 'WD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        }
		
		/**
         * Include the required files
         *
         * @since 1.0.0
         * @return void
         */
        public function includes() {
            require_once( WD_PLUGIN_DIR . 'frontend/class-frontend.php' );
			
        }		
		
		/**
         * Install the plugin data
         *
         * @since 1.0.0
         * @return void
         */
        public function install() {
            require_once( WD_PLUGIN_DIR . 'inc/install.php' );
			wd_install();
        }
		
		/**
		 * Handle admin notices
		 *
		 * @since 1.0.0
		 * @return void
		 */
		 
		public function woocommerce_disabled(){
			echo '<div class="error"><p><strong>Error: </strong> We have found that you have not installed or activated WooCommerce. Please <a href="https://wordpress.org/plugins/woocommerce/">install</a>/activate it.</p></div>';
		}
		 
		
	}
	
	$GLOBALS['wd'] = new Woo_Description();	
}
 
?>