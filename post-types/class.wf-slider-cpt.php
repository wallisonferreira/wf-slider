<?php

if ( ! class_exists( 'WFSliderPostType' ) ){
    class WFSliderPostType{
        function __construct() {
            add_action( 'init', array( $this, 'createPostType') );
            add_action( 'add_meta_boxes', array( $this, 'addMetaBoxes' ) );
            add_action( 'save_post', array( $this, 'savePost' ), 10, 2 );
            add_filter( 'manage_wf-slider_posts_columns', array( $this, 'sliderCptColumns') );
            add_action( 'manage_wf-slider_posts_custom_column', array( $this, 'sliderCustomColumns' ), 10, 2 );
            add_action( 'manage_edit-wf-slider_sortable_columns', array( $this, 'sliderSortableColumns') );
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
                    'show_in_menu' => false, // aparecer ou não diretamente no menu
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

        public function sliderCustomColumns( $column, $postID) {
            switch( $column ) {
                case 'wf_slider_link_text':
                    echo esc_html( get_post_meta( $postID, 'wf_slider_link_text', true ) );
                break;
                case 'wf_slider_link_url':
                    echo esc_url( get_post_meta( $postID, 'wf_slider_link_url', true ) );
                break;
            }
        }

        public function sliderSortableColumns( $columns ) {
            $columns['wf_slider_link_text'] = 'wf_slider_link_text';
            $columns['wf_slider_link_url'] = 'wf_slider_link_url';
            return $columns;
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

        public function sliderCptColumns( $columns ) {
            $columns['wf_slider_link_text'] = esc_html__( 'Link Text', 'wf-slider' );
            $columns['wf_slider_link_url'] = esc_html__( 'Link URL', 'wf-slider' );
            return $columns;
        }

        public function add_inner_meta_boxes( $post ) {
            require_once( WF_SLIDER_PATH . 'views/wf-slider_metabox.php');
        }

        public function savePost( $postID ) {
            // verify if nonce key in the form is as expected, cause false return nothing
            if ( isset( $_POST['wf_slider_nonce'] ) ) {
                if ( ! wp_verify_nonce( $_POST['wf_slider_nonce'], 'wf_slider_nonce' ) ) {
                    return;
                }
            }

            // verify if wordpress form is doing autosave, cause true return nothing
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            // verify if user have permissions to edit post type wf-slider
            if ( isset ($_POST['post_type'] ) && $_POST['post_type'] === 'wf-slider' ) {
                if ( ! current_user_can( 'edit_page', $postID ) ) {
                    return;
                } elseif ( ! current_user_can( 'edit_page', $postID ) ) {
                    return;
                }
            }

            if ( isset(  $_POST['action'] ) && $_POST['action'] == 'editpost' ) {
                $old_link_text = get_post_meta( $postID, 'wf_slider_link_text', true );
                $new_link_text = $_POST['wf_slider_link_text'];
                $old_link_url = get_post_meta( $postID, 'wf_slider_link_url', true );
                $new_link_url = $_POST['wf_slider_link_url'];

                if ( empty ( $new_link_text ) ) {
                    update_post_meta( $postID, 'wf_slider_link_text', 'Add some text' );
                } else {
                    update_post_meta( $postID, 'wf_slider_link_text', sanitize_text_field( $new_link_text ), $old_link_text );
                }

                if ( empty( $new_link_url ) ) {
                    update_post_meta( $postID, 'wf_slider_link_url', '#' );
                } else {
                    update_post_meta( $postID, 'wf_slider_link_url', esc_url_raw( $new_link_url ), $old_link_url );
                }
            }
        }
    }
}