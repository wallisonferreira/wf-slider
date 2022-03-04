<?php

if ( ! class_exists( 'WFSliderPostType' ) ){
    class WFSliderPostType{
        function __construct() {
            add_action( 'init', array( $this, 'createPostType') );
            add_action( 'add_meta_boxes', array( $this, 'addMetaBoxes' ) );
            add_action( 'save_post', array( $this, 'savePost' ), 10, 2 );
        }

        public function createPostType() {
            register_post_type(
                'wf-slider',
                array(
                    'label' => 'Slider',
                    'description' => 'Sliders',
                    'labels' => array(
                        'name' => 'Sliders',
                        'singular_name' => 'Slider'
                    ),
                    'public' => true,
                    'supports' => array(
                        'title', 
                        'editor', 
                        'thumbnail'
                    ),
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export' => true,
                    'has_archive' => false,
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true,
                    'menu_icon' => 'dashicons-slides',
                    //'register_meta_box_cb' => array( $this, 'add_meta_boxes' )
                )
            );
        }

        public function addMetaBoxes() {
            add_meta_box(
                'wf_slider_meta_box',
                'Link Options',
                array( $this, 'add_inner_meta_boxes' ),
                'wf-slider',
                'normal',
                'high',
            );
        }

        public function add_inner_meta_boxes( $post ) {
            require_once( WF_SLIDER_PATH . 'views/wf-slider_metabox.php');
        }

        public function savePost( $postID ) {
            if ( isset(  $_POST['action'] ) && $_POST['action'] == 'editpost' ) {
                $old_link_text = get_post_meta( $postID, 'wf_slider_link_text', true );
                $new_link_text = $_POST['wf_slider_link_text'];
                $old_link_url = get_post_meta( $postID, 'wf_slider_link_url', true );
                $new_link_url = $_POST['wf_slider_link_url'];

                update_post_meta( $postID, 'wf_slider_link_text', $new_link_text, $old_link_text );
                update_post_meta( $postID, 'wf_slider_link_url', $new_link_url, $old_link_url );
            }
        }
    }
}