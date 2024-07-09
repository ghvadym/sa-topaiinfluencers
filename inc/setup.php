<?php

add_filter('show_admin_bar', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');

add_action('wp_enqueue_scripts', 'wp_enqueue_scripts_call');
function wp_enqueue_scripts_call()
{
    wp_enqueue_style('swiper-styles', TAI_THEME_URL . '/dest/lib/swiper-slider/swiper.css');
    wp_enqueue_script('swiper-scripts', TAI_THEME_URL . '/dest/lib/swiper-slider/swiper.js');

    wp_enqueue_style('main-style', TAI_THEME_URL . '/dest/css/app-style.css');
    wp_enqueue_script('main-scripts', TAI_THEME_URL . '/dest/js/app-scripts.js', ['jquery'], time());

    wp_localize_script('main-scripts', 'taiajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('archive-nonce')
    ]);

    if (is_home() || is_front_page()) {
        wp_enqueue_style('home-styles', TAI_THEME_URL . '/dest/css/home.css');
    }

    if (is_archive() || is_tax() || is_tag() || is_singular('blog')) {
        wp_enqueue_style('archive-styles', TAI_THEME_URL . '/dest/css/archive.css');
    }

    if (is_single()) {
        wp_enqueue_style('single-style', TAI_THEME_URL . '/dest/css/single-post.css');
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

add_shortcode('top_influencers', 'top_influencers_call');
function top_influencers_call($atts)
{
    $atts = shortcode_atts([
        'count' => 10
    ], $atts);

    $args = [
        'numberposts' => $atts['count']
    ];

    $influencers = get_field('influencers');

    if (!empty($influencers)) {
        $args['post__in'] = $influencers;
    } else {
        $args['category_name'] = 'best-ai-models';
    }

    $posts = _get_posts($args);

    ob_start();

    get_template_part_var('global/top-influencers', [
        'posts' => $posts
    ]);

    return ob_get_clean();
}

add_filter('cron_schedules', 'cron_schedules_call');
function cron_schedules_call($schedules)
{
    $schedules['ten_min'] = [
        'interval' => MINUTE_IN_SECONDS * 10,
        'display'  => 'Once every 10 minutes',
    ];

    return $schedules;
}

add_action('wp', 'schedules_setup');
function schedules_setup()
{
    if (!wp_next_scheduled('update_models_subscribers')) {
        wp_schedule_event(time(), 'ten_min', 'update_models_subscribers');
    }
}

add_action('update_models_subscribers', 'update_models_subscribers_call');
function update_models_subscribers_call()
{
    models_subscription_updates_control();
}

add_action('switch_theme', 'theme_deactivation_hook');
function theme_deactivation_hook()
{
    wp_unschedule_hook('update_models_subscribers');
}

add_filter('post_type_link', 'post_type_link_call', 10, 2);
function post_type_link_call($post_link, $post)
{
    if ('blog' === $post->post_type && 'publish' === $post->post_status) {
        $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
    }

    return $post_link;
}

add_action('pre_get_posts', 'add_cpt_post_names_to_main_query');
function add_cpt_post_names_to_main_query($query)
{
    if (!$query->is_main_query()) {
        return;
    }

    if (!isset($query->query['page']) || 2 !== count($query->query)) {
        return;
    }

    if (empty($query->query['name'])) {
        return;
    }

    $query->set('post_type', ['post', 'page', 'blog']);
}