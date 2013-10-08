<?php

// Enqueue scripts
add_action('admin_enqueue_scripts', function()
{
    if( function_exists( 'wp_enqueue_media' ) )
    {
        wp_enqueue_media();
    }

    else
    {
        wp_enqueue_style('thickbox');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
    }

    wp_enqueue_script('devdk-upload-js', '/wp-content/plugins/widgify/assets/js/script.js', null, null, true);
});