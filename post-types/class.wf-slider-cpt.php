<?php

if ( ! class_exists( 'WFSliderPostType' ) ){
    class WFSliderPostType{
        function __construct() {
            add_action( 'init', array( $this, 'createPostType') );
        }

        public function createPostType(){
            register_post_type(
                'wf-slider',
                array(
                    'label' => 'Slider',
                    'description' => 'Sliders',
                    'labels' => array(
                        'name' => 'Sliders',
                        'singular_name' => 'Slider'
                    ),
                    'public' => true
                )
            );
        }
    }
}