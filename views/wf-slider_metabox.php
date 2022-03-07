<?php 
    $link_text = get_post_meta( $post->ID, 'wf_slider_link_text', true );
    $link_url = get_post_meta( $post->ID, 'wf_slider_link_url', true );
?>
<table class="form-table wf-slider-metabox"> 
<input type="hidden" name="wf_slider_nonce" value="<?php echo wp_create_nonce( "wf_slider_nonce" ); ?>">
    <tr>
        <th>
            <label for="wf_slider_link_text"><?php esc_html_e( 'Link Text', 'wf-slider' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="wf_slider_link_text" 
                id="wf_slider_link_text" 
                class="regular-text link-text"
                value="<?php echo ( isset( $link_text ) ) ? esc_html( $link_text ) : ''; ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="wf_slider_link_url"><?php esc_html_e( 'Link URL', 'wf-slider' ); ?></label>
        </th>
        <td>
            <input 
                type="url" 
                name="wf_slider_link_url" 
                id="wf_slider_link_url" 
                class="regular-text link-url"
                value="<?php echo ( isset( $link_url ) ) ? esc_url( $link_url ) : ''; ?>"
                required
            >
        </td>
    </tr>
</table>