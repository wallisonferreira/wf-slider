<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
    <?php 
        settings_fields( 'wf_slider_group' ); // cria hiddens fields e nonces de verificação
        do_settings_sections( 'wf_slider_page1' ); // referencia a page na qual será mostrada no formulário
        do_settings_sections( 'wf_slider_page2' ); // referencia a page na qual será mostrada no formulário
        submit_button( 'Save Settings' );
    ?>
    </form>
</div>