<?php

if ( !class_exists( 'SliderSettings' ) ) {
    class SliderSettings {
        public static $options;

        public function __construct() {
            self::$options = get_option( 'wf_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        # Gerencia o slider
        public function admin_init() {

            register_setting( 'wf_slider_group', 'wf_slider_options' );

            add_settings_section(
                'wf_slider_main_section', // declara id da seção
                'How does it work?',
                null,
                'wf_slider_page1' // declara id da página
            );

            add_settings_section(
                'wf_slider_second_section', // declara id da seção
                'Other Plugin Options',
                null,
                'wf_slider_page2' // declara id da página
            );

            # Observação do shortcode do slider
            add_settings_field( 
                'wf_slider_shortcode', 
                'Shortcode', 
                array( $this, 'wf_slider_shortcode_callback' ), 
                'wf_slider_page1', // id da página que o campo deve aparecer
                'wf_slider_main_section', // id da seção que o campo deve aparecer
            );

            # Campo do título do slider
            add_settings_field( 
                'wf_slider_title', 
                'Slider Title', 
                array( $this, 'wf_slider_title_callback' ), 
                'wf_slider_page2', // id da página que o campo deve aparecer
                'wf_slider_second_section', // id da seção que o campo deve aparecer
                array(
                    'label_for' => 'wf_slider_title'
                )
            );

            # Mostrar bullets do slider
            add_settings_field( 
                'wf_slider_bullets', 
                'Display Bullets', 
                array( $this, 'wf_slider_bullets_callback' ), 
                'wf_slider_page2', // id da página que o campo deve aparecer
                'wf_slider_second_section', // id da seção que o campo deve aparecer
                array(
                    'label_for' => 'wf_slider_bullets'
                )
            );

            # Escolher estilo do slider
            add_settings_field( 
                'wf_slider_style', 
                'Slider Style', 
                array( $this, 'wf_slider_style_callback' ), 
                'wf_slider_page2', // id da página que o campo deve aparecer
                'wf_slider_second_section', // id da seção que o campo deve aparecer
                array( // passa um array como parâmetro para a função callback
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'wf_slider_style'
                )
            );
        }

        public function wf_slider_shortcode_callback() {
            ?>
            <span>Use the shortcode [wf_slider] to display the slider in any page/post/widget</span>
            <?php
        }

        public function wf_slider_title_callback( $args ) {
            ?>
                <input 
                type="text"
                name="wf_slider_options[wf_slider_title]"
                id="wf_slider_title"
                value="<?php echo isset( self::$options['wf_slider_title'] ) ? esc_attr( self::$options['wf_slider_title'] ) : ''; ?>">
            <?php
        }

        public function wf_slider_bullets_callback( $args ) {
            ?>
                <input 
                    type="checkbox"
                    name="wf_slider_options[wf_slider_bullets]"
                    id="wf_slider_bullets"
                    value="1"
                    <?php
                        if ( isset( self::$options['wf_slider_bullets'] ) ) {
                            checked( "1", self::$options['wf_slider_bullets'], true );
                        }
                    ?>
                />
                <label for="mv_slider_bullets">Whether to display bullets or not</label>
            <?php
        }

        public function wf_slider_style_callback( $args ) {
            ?>
                <select 
                    name="wf_slider_options[wf_slider_style]" 
                    id="wf_slider_style">
                    <?php foreach ( $args['items'] as $item): ?>
                        <option value="<?php echo esc_attr( $item ); ?>"
                            <?php
                            isset( self::$options['wf_slider_style'] ) ? selected($item, self::$options['wf_slider_style'], true) : '';
                            ?>
                        >
                            <?php echo esc_html( ucfirst( $item ) ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php
        }
    }
}