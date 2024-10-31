<?php
/**
 * WD Install
 *
 * @package     Woo_Description
 * @since       1.0.0
 */

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Run the install
 *
 * @since 1.0.0
 * @return void
 */
function wd_install() {
	
	wd_install_data();
	
}

/**
 * Install the required data
 *
 * @since 1.0.0
 * @return void
 */
function wd_install_data() {

    global $wd;
	
    /* Set the correct version */
    update_option( 'wd_version', WD_VERSION_NUM );

}
?>