<?php

add_filter('show_admin_bar', '__return_false');
add_filter('gutenberg_use_widgets_block_editor', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');

add_action('wp_enqueue_scripts', 'wp_enqueue_scripts_call');
function wp_enqueue_scripts_call()
{
    wp_enqueue_style('main-styles', TAI_THEME_URL . '/dest/css/app-styles.css');
    wp_enqueue_script('main-scripts', TAI_THEME_URL . '/dest/js/app-scripts.js', ['jquery'], time());

    wp_localize_script('main-scripts', 'taiajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('archive-nonce')
    ]);

    if (is_singular('blog')) {
        wp_enqueue_style('swiper-styles', TAI_THEME_URL . '/dest/lib/swiper-slider/swiper.css');
        wp_enqueue_script('swiper-scripts', TAI_THEME_URL . '/dest/lib/swiper-slider/swiper.js');
    }

    if (is_home() || is_front_page()) {
        wp_enqueue_style('home-styles', TAI_THEME_URL . '/dest/css/home.css');
    }

    if (is_archive() || is_tax() || is_tag() || is_singular('blog')) {
        wp_enqueue_style('archive-styles', TAI_THEME_URL . '/dest/css/archive.css');
    }

    if (is_single()) {
        wp_enqueue_style('single-styles', TAI_THEME_URL . '/dest/css/single.css');
    }
}

add_action('after_setup_theme', 'after_setup_theme_call');
function after_setup_theme_call()
{
    register_nav_menus([
        'main_header' => __('Main Header', DOMAIN)
    ]);

    add_post_type_support('page', 'excerpt');

    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'unlink-homepage-logo' => true
    ]);

    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => 'Options',
            'menu_title' => 'Options',
            'menu_slug'  => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
        ]);
    }

    load_theme_textdomain(DOMAIN, get_template_directory() . '/languages');
}

add_action('admin_menu', 'remove_default_post_types');
function remove_default_post_types()
{
    remove_menu_page('edit-comments.php');
}

add_filter('upload_mimes', 'upload_mimes_types');
function upload_mimes_types($types)
{
    $types['svg'] = 'image/svg+xml';
    $types['webp'] = 'image/webp';

    return $types;
}