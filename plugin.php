<?php
/**
 * Plugin Name: JSON REST API Yoast routes
 * Description: Adds Yoast fields to page and post metadata
 * Author: jmfurlott<jmfurlott@gmail.com>
 * Author URI: https://jmfurlott.com
 * Version: 1.1.0
 * Plugin URI: https://github.com/jmfurlott/wp-api-yoast
 */
function wp_api_encode_yoast($data, $post, $context) {
    $bk_metadesc = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
    $bk_metatitle = get_post_meta($post->ID, '_yoast_wpseo_title', true);

    $post_type = 'post';
    if ( is_object( $post ) && ( isset( $post->post_type ) && $post->post_type !== '' ) ) {
			$post_type = $post->post_type;
		}
    $bk_titles = get_option( 'wpseo_titles' );

    if(empty($bk_metadesc)) {
      $meta_key = 'metadesc-'.$post_type;
      $bk_metadesc = $bk_titles[$meta_key];
      $bk_metadesc = wpseo_replace_vars($bk_metadesc, $post);
    }
    if(empty($bk_metatitle)) {
      $meta_key = 'title-'.$post_type;
      $bk_metatitle = $bk_titles[$meta_key];
      $bk_metatitle = wpseo_replace_vars($bk_metatitle, $post);
    }

    $yoastMeta = array(
        'yoast_wpseo_focuskw' => get_post_meta($post->ID, '_yoast_wpseo_focuskw', true),
        'yoast_wpseo_title' => esc_html($bk_metatitle),
        'yoast_wpseo_metadesc' => esc_html($bk_metadesc),
        'yoast_wpseo_linkdex' => get_post_meta($post->ID, '_yoast_wpseo_linkdex', true),
        'yoast_wpseo_metakeywords' => get_post_meta($post->ID, '_yoast_wpseo_metakeywords', true),
        'yoast_wpseo_meta-robots-noindex' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-noindex', true),
        'yoast_wpseo_meta-robots-nofollow' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-nofollow', true),
        'yoast_wpseo_meta-robots-adv' => get_post_meta($post->ID, '_yoast_wpseo_meta-robots-adv', true),
        'yoast_wpseo_canonical' => get_post_meta($post->ID, '_yoast_wpseo_canonical', true),
        'yoast_wpseo_redirect' => get_post_meta($post->ID, '_yoast_wpseo_redirect', true),
        'yoast_wpseo_opengraph-title' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-title', true),
        'yoast_wpseo_opengraph-description' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-description', true),
        'yoast_wpseo_opengraph-image' => get_post_meta($post->ID, '_yoast_wpseo_opengraph-image', true),
        'yoast_wpseo_twitter-title' => get_post_meta($post->ID, '_yoast_wpseo_twitter-title', true),
        'yoast_wpseo_twitter-description' => get_post_meta($post->ID, '_yoast_wpseo_twitter-description', true),
        'yoast_wpseo_twitter-image' => get_post_meta($post->ID, '_yoast_wpseo_twitter-image', true)
    );

    $data->data['yoast_meta'] = (array) $yoastMeta;

    return $data;
}

add_filter('rest_prepare_post', 'wp_api_encode_yoast', 10, 3);
add_filter('rest_prepare_page', 'wp_api_encode_yoast', 10, 3);
