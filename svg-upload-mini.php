<?php
/*
Plugin name: SVG Upload Mini
Description: Allow WordPress to upload SVG format files
Version: 0.0.1
Author: Luís Carvalho
Author URI: https://luis.pt
*/

if (!defined('ABSPATH')) {
    exit;
}

if ( ! function_exists( 'svg_upload_mini_check_filetype_and_ext' ) ) {
    function svg_upload_mini_check_filetype_and_ext($data, $file, $filename, $mimes) {
        $filetype = wp_check_filetype($filename, $mimes);
        return [
            'type'             => $filetype['type'],
            'ext'              => $filetype['ext'],
            'proper_filename'  => sanitize_file_name($data['proper_filename']),
        ];
    }
}

add_filter('wp_check_filetype_and_ext', 'svg_upload_mini_check_filetype_and_ext', 10, 4);

if ( ! function_exists( 'svg_upload_mini_mime_types' ) ) {
    function svg_upload_mini_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
}

add_filter('upload_mimes', 'svg_upload_mini_mime_types');

if ( ! function_exists( 'svg_upload_mini_allow_svg_in_media_uploader' ) ) {
    function svg_upload_mini_allow_svg_in_media_uploader() {
        if (!current_user_can('upload_files')) {
            return;
        }

        echo '<style type="text/css">
            .media-frame select.attachment-filters [value="image/svg+xml"], 
            .attachment-266x266, .thumbnail img { 
                width: 100% !important; 
                height: auto !important; 
                display: block !important; 
            }
        </style>';
    }
}

add_action('admin_head', 'svg_upload_mini_allow_svg_in_media_uploader');