<?php
/**
 * Plugin Name: Auto Embed BunnyCDN
 * Description: Automatically embed BunnyCDN content using WP_oEmbed.
 * Version: 1.1
 * Author: Ivars Gmizo
 */

 function register_bunnycdn_oembed_handler() {
    wp_embed_register_handler( 
        'bunnycdn', 
        '#https?://video\.bunnycdn\.com/.*#i', 
        'bunnycdn_oembed_handler' 
    );
    wp_embed_register_handler( 
        'mediadelivery', 
        '#https?://iframe\.mediadelivery\.net/.*#i', 
        'bunnycdn_oembed_handler' 
    );
}

add_action( 'init', 'register_bunnycdn_oembed_handler' );


function bunnycdn_oembed_handler( $matches, $attr, $url, $rawattr ) {

    $url = str_replace('https://video.bunnycdn.com/play/', 'https://iframe.mediadelivery.net/embed/', $url);
    $url = str_replace('https://iframe.mediadelivery.net/play/', 'https://iframe.mediadelivery.net/embed/', $url);

    $output = '<div style="position: relative; padding-top: 56.25%; margin-bottom: 20px; margin-left: 0; margin-right: 0">';
    $output .= '<iframe src="'.esc_url( $url ).'" loading="lazy" style="border: none; position: absolute; top: 0; height: 100%; width: 100%;" allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;" allowfullscreen="true">';
    $output .= '</iframe>';
    $output .= '</div>';
    
    // The returned string will be used as the content of the embedded post.
    return apply_filters( 'embed_bunnycdn', $output, $matches, $attr, $url, $rawattr );
}
