<?php

if ( !class_exists( 'SliderSettings' ) ) {
    class SliderSettings {
        public static $options;

        public function __construct() {
            self::$options = get_option( 'wf_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        public function admin_init() {
            
            register_setting( 'wf_slider_group', 'wf_slider_options' );

            add_settings_section(
                'wf_slider_main_section', // declara id da seção
                'How does it work?',
                null,
                'wf_slider_page1' // declara id da página
            );

            add_settings_field( 
                'wf_slider_shortcode', 
                'Shortcode', 
                array( $this, 'wf_slider_shortcode_callback' ), 
                'wf_slider_page1', // id da página que o campo deve aparecer
                'wf_slider_main_section', // id da seção que o campo deve aparecer
            );
        }

        public function wf_slider_shortcode_callback() {
            ?>
            <span>Use the shortcode [wf_slider] to display the slider in any page/post/widget</span>
            <?php
        }
    }
}