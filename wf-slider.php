<?php

/**
 * Plugin Name: WF Slider
 * Plugin URI: https://www.wordpress.org/wf-slider
 * Description: Slider for pages and posts
 * Version: 1.0
 * Requires at least: 5.9
 * Author: Wallison Ferreira
 * Author URI: https://wallisonferreira.github.io
 * License: GLP v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wf-slider
 * Domain Path: /languages
 */

 /*
WF Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
WF Slider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with WF Slider. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if( ! defined('ABSPATH') ) {
    exit;
}

if ( ! class_exists( 'WFSlider' ) ) {
    class WFSlider{
        function __construct(){
            $this->defineConstants();

            add_action( 'admin_menu', array( $this, 'addMenu' ) );

            require_once( WF_SLIDER_PATH . 'post-types/class.wf-slider-cpt.php');
            $WFSliderPostType = new WFSliderPostType();
        }

        public function defineConstants() {
            define('WF_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
            define('WF_SLIDER_URL', plugin_dir_url( __FILE__ ) );
            define('WF_SLIDER_VERSION', '1.0.0' );
        }

        public static function activate() {
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate() {
            flush_rewrite_rules();
            unregister_post_type( 'wf-slider' );
        }

        public static function uninstall() {

        }

        // 'add_menu_page','add_options_page', 'add_theme_page'
        public function addMenu() {
            add_menu_page(
                'WF Slider Options',
                'WF Slider',
                'manage_options',
                'wf_slider_admin', // slug do menu pai
                array( $this, 'wf_slider_settings_page' ),
                'dashicons-images-alt2',
            );

            add_submenu_page(
                'wf_slider_admin', // vínculo ao menu pai
                'Manage Slides',
                'Manage Slides',
                'manage_options',
                'edit.php?post_type=wf-slider', // carregando uma página de gerenciamento de slide
                null,
                null
            );

            add_submenu_page(
                'wf_slider_admin', // vínculo ao menu pai
                'Add New Slide',
                'Add New Slide',
                'manage_options',
                'post-new.php?post_type=wf-slider', // carregando uma página de adição de slide
                null,
                null
            );
        }

        public function wf_slider_settings_page() {
            echo "This is a test page";
        }
    }
}

if ( class_exists( 'WFSlider' ) ) {
    register_activation_hook( __FILE__, array( 'WFSlider', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'WFSlider', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'WFSlider', 'uninstall' ) );
    $wfSlider = new WFSlider();
}