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
        $socials = socials();

        if (!empty($socials)) {
            foreach ($socials as $socialKey) {
                $args['category_name'] = 'best-ai-models';
            }
        }
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

//add_action('wp_insert_post_data', 'wp_insert_post_data_call', 99, 2);
function wp_insert_post_data_call($postData, $postDataFull)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    $postId = $postDataFull['ID'] ?? '';

    if (!$postId) {
        return;
    }

    if (!current_user_can('edit_post', $postId)) {
        return;
    }

    if ($postData['post_type'] !== 'post') {
        return;
    }

    $updatesData = get_option('subscription_updates_data', []);
    $fields = get_fields($postId);
    $socials = socials_data();

    foreach ($socials as $social => $className) {
        if (!class_exists($className)) {
            continue;
        }

        $acfFieldChannelObject = get_field_object('youtube_channel_name', $postId);
        $acfFieldChannelKey = $acfFieldChannelObject['key'] ?? '';

        if (!$acfFieldChannelKey) {
            return;
        }

        $socialNameOld = $fields[$social] ?? '';
        $socialNameNew = $postData['acf'][$acfFieldChannelKey] ?? '';

        if (!$socialNameNew) {
            $acfFieldSubscriptionsObject = get_field_object('youtube_subscribers', $postId);
            $acfFieldSubscriptionsKey = $acfFieldSubscriptionsObject['key'] ?? '';

            if ($acfFieldSubscriptionsKey) {
                $postData['acf'][$acfFieldSubscriptionsKey] = '';
            }

            continue;
        }

        if (trim($socialNameOld) === trim($socialNameNew)) {
            continue;
        }

        $subscribers = '';

        try {
            $subscribers = $className::updateSubscribers($socialNameNew, $postId);
        } catch (Exception $exception) {}

        if (!$subscribers) {
            continue;
        }

        if (empty($updatesData)) {
            $updatesData = [
                $postId => time() + EVENT_TIME_TO_CHECK
            ];
        } else {
            $updatesData[$postId] = time() + EVENT_TIME_TO_CHECK;
        }

        update_post_meta($postId, 'subscription_update_time', time() + EVENT_TIME_TO_CHECK);
    }
}