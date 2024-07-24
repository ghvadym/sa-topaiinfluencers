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

add_action('admin_enqueue_scripts', 'admin_scripts_call');
function admin_scripts_call()
{
    $post = get_post();
    if (!empty($post) && $post->post_type === 'post') {
        wp_enqueue_style('post-custom-styles', TAI_THEME_URL . '/dest/css/admin-style.css');
        wp_enqueue_script('post-custom-scripts', TAI_THEME_URL . '/dest/js/admin.js');
    }

    wp_localize_script('post-custom-scripts', 'admintaiajax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('admin-nonce')
    ]);
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

add_action('add_meta_boxes', 'register_meta_boxes_call');
function register_meta_boxes_call()
{
    add_meta_box(
        'subscribers-fields',
        __('Social Subscribers', DOMAIN),
        'subscribers_metabox_call',
        'post',
        'side',
        'high'
    );
}

function subscribers_metabox_call($post)
{
    echo sprintf(
        '<small class="get_subscribers_text">%1$s</small><div id="subscribers-get-by-api" class="components-button is-primary get_subscribers_btn" data-id="%2$s">%3$s</div>',
        __('Make sure all the usernames for socials filled.', DOMAIN),
        $post->ID,
        __('Get Subscribers By API', DOMAIN)
    );
}

add_filter('manage_post_posts_columns', 'manage_posts_columns_call');
function manage_posts_columns_call($columns)
{
    return array_merge($columns, [
        'youtube_subscribers'   => '<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 8.25L10.3925 6L6.5 3.75V8.25ZM15.17 2.3775C15.2675 2.73 15.335 3.2025 15.38 3.8025C15.4325 4.4025 15.455 4.92 15.455 5.37L15.5 6C15.5 7.6425 15.38 8.85 15.17 9.6225C14.9825 10.2975 14.5475 10.7325 13.8725 10.92C13.52 11.0175 12.875 11.085 11.885 11.13C10.91 11.1825 10.0175 11.205 9.1925 11.205L8 11.25C4.8575 11.25 2.9 11.13 2.1275 10.92C1.4525 10.7325 1.0175 10.2975 0.83 9.6225C0.7325 9.27 0.665 8.7975 0.62 8.1975C0.5675 7.5975 0.545 7.08 0.545 6.63L0.5 6C0.5 4.3575 0.62 3.15 0.83 2.3775C1.0175 1.7025 1.4525 1.2675 2.1275 1.08C2.48 0.9825 3.125 0.915 4.115 0.87C5.09 0.8175 5.9825 0.795 6.8075 0.795L8 0.75C11.1425 0.75 13.1 0.87 13.8725 1.08C14.5475 1.2675 14.9825 1.7025 15.17 2.3775Z" fill="#000"/></svg>',
        'twitch_subscribers'    => '<svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.58035 3.6975H7.65285V6.9075H6.58035M9.52785 3.6975H10.6004V6.9075H9.52785M3.10035 0.75L0.422852 3.4275V13.0725H3.63285V15.75L6.31785 13.0725H8.45535L13.2779 8.25V0.75M12.2054 7.7175L10.0679 9.855H7.92285L6.04785 11.73V9.855H3.63285V1.8225H12.2054V7.7175Z" fill="#000"/></svg>',
        'instagram_subscribers' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.77094 0.5C9.61469 0.50225 10.0429 0.50675 10.4127 0.51725L10.5582 0.5225C10.7262 0.5285 10.8919 0.536 11.0922 0.545C11.8902 0.5825 12.4347 0.7085 12.9124 0.89375C13.4074 1.08425 13.8244 1.34225 14.2414 1.7585C14.6228 2.13342 14.9179 2.58694 15.1062 3.0875C15.2914 3.56525 15.4174 4.10975 15.4549 4.9085C15.4639 5.108 15.4714 5.27375 15.4774 5.4425L15.4819 5.588C15.4932 5.957 15.4977 6.38525 15.4992 7.229L15.4999 7.7885V8.771C15.5018 9.31805 15.496 9.86511 15.4827 10.412L15.4782 10.5575C15.4722 10.7262 15.4647 10.892 15.4557 11.0915C15.4182 11.8903 15.2907 12.434 15.1062 12.9125C14.9185 13.4133 14.6233 13.867 14.2414 14.2415C13.8664 14.6227 13.4129 14.9178 12.9124 15.1063C12.4347 15.2915 11.8902 15.4175 11.0922 15.455C10.9142 15.4634 10.7362 15.4709 10.5582 15.4775L10.4127 15.482C10.0429 15.4925 9.61469 15.4978 8.77094 15.4993L8.21144 15.5H7.22969C6.68239 15.5019 6.13509 15.4961 5.58794 15.4827L5.44244 15.4783C5.2644 15.4715 5.0864 15.4638 4.90844 15.455C4.11044 15.4175 3.56594 15.2915 3.08744 15.1063C2.58695 14.9183 2.13361 14.6231 1.75919 14.2415C1.37748 13.8667 1.08211 13.4132 0.893694 12.9125C0.708445 12.4347 0.582444 11.8903 0.544944 11.0915C0.536589 10.9135 0.529088 10.7355 0.522444 10.5575L0.518695 10.412C0.504874 9.86511 0.498623 9.31806 0.499944 8.771V7.229C0.497851 6.68195 0.503352 6.1349 0.516445 5.588L0.521694 5.4425C0.527695 5.27375 0.535194 5.108 0.544194 4.9085C0.581694 4.10975 0.707694 3.566 0.892944 3.0875C1.08128 2.58643 1.37723 2.13277 1.75994 1.7585C2.13426 1.37711 2.5873 1.08199 3.08744 0.89375C3.56594 0.7085 4.10969 0.5825 4.90844 0.545C5.10794 0.536 5.27444 0.5285 5.44244 0.5225L5.58794 0.518C6.13484 0.504675 6.68189 0.498924 7.22894 0.50075L8.77094 0.5ZM7.99994 4.25C7.00538 4.25 6.05156 4.64509 5.34829 5.34835C4.64503 6.05161 4.24994 7.00544 4.24994 8C4.24994 8.99456 4.64503 9.94839 5.34829 10.6517C6.05156 11.3549 7.00538 11.75 7.99994 11.75C8.99451 11.75 9.94833 11.3549 10.6516 10.6517C11.3549 9.94839 11.7499 8.99456 11.7499 8C11.7499 7.00544 11.3549 6.05161 10.6516 5.34835C9.94833 4.64509 8.99451 4.25 7.99994 4.25ZM7.99994 5.75C8.29542 5.74995 8.58801 5.8081 8.86101 5.92113C9.13401 6.03416 9.38208 6.19985 9.59104 6.40874C9.80001 6.61764 9.96579 6.86565 10.0789 7.13862C10.192 7.41158 10.2503 7.70415 10.2503 7.99963C10.2504 8.2951 10.1922 8.58769 10.0792 8.86069C9.96616 9.13369 9.80047 9.38176 9.59157 9.59072C9.38268 9.79969 9.13467 9.96547 8.8617 10.0786C8.58874 10.1917 8.29617 10.25 8.00069 10.25C7.40396 10.25 6.83166 10.0129 6.4097 9.59099C5.98775 9.16903 5.75069 8.59674 5.75069 8C5.75069 7.40326 5.98775 6.83097 6.4097 6.40901C6.83166 5.98705 7.40396 5.75 8.00069 5.75M11.9382 3.125C11.6896 3.125 11.4511 3.22377 11.2753 3.39959C11.0995 3.5754 11.0007 3.81386 11.0007 4.0625C11.0007 4.31114 11.0995 4.5496 11.2753 4.72541C11.4511 4.90123 11.6896 5 11.9382 5C12.1868 5 12.4253 4.90123 12.6011 4.72541C12.7769 4.5496 12.8757 4.31114 12.8757 4.0625C12.8757 3.81386 12.7769 3.5754 12.6011 3.39959C12.4253 3.22377 12.1868 3.125 11.9382 3.125Z" fill="#000"/></svg>',
        'tiktok_subscribers'    => '<svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.37541 2.115C8.86273 1.52972 8.5802 0.778074 8.58041 0H6.26291V9.3C6.24504 9.80327 6.03256 10.28 5.67023 10.6297C5.30791 10.9794 4.824 11.1749 4.32041 11.175C3.25541 11.175 2.37041 10.305 2.37041 9.225C2.37041 7.935 3.61541 6.9675 4.89791 7.365V4.995C2.31041 4.65 0.0454102 6.66 0.0454102 9.225C0.0454102 11.7225 2.11541 13.5 4.31291 13.5C6.66791 13.5 8.58041 11.5875 8.58041 9.225V4.5075C9.52016 5.18239 10.6484 5.54449 11.8054 5.5425V3.225C11.8054 3.225 10.3954 3.2925 9.37541 2.115Z" fill="#000"/></svg>',
        'x_subscribers'         => '<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.6028 0.363281H15.0182L9.74196 6.40903L15.9497 14.6373H11.0897L7.28046 9.64791L2.92671 14.6373H0.509082L6.15208 8.16853L0.199707 0.364406H5.18346L8.62146 4.92403L12.6028 0.363281ZM11.7535 13.1883H13.0922L4.45221 1.73691H3.01671L11.7535 13.1883Z" fill="#000"/></svg>',
        'fanvue_subscribers'    => '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><mask id="mask0_439_2252" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="18" height="18"><path d="M13.3328 0.666626H4.99943C2.69824 0.666626 0.832764 2.53211 0.832764 4.83329V13.1666C0.832764 15.4678 2.69824 17.3333 4.99943 17.3333H13.3328C15.634 17.3333 17.4994 15.4678 17.4994 13.1666V4.83329C17.4994 2.53211 15.634 0.666626 13.3328 0.666626Z" fill="black"/></mask><g mask="url(#mask0_439_2252)"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.1661 0.666626C0.982002 0.666626 0.832764 0.815864 0.832764 0.999959V17C0.832764 17.184 0.982002 17.3333 1.1661 17.3333H5.06122V20.756L3.74115 22.3475V22.375H11.6067V22.3475L10.2866 20.756V17.3333H17.1661C17.3502 17.3333 17.4994 17.184 17.4994 17V0.999959C17.4994 0.815864 17.3502 0.666626 17.1661 0.666626H1.1661ZM10.2866 17.3333V9.83467H15.3194V9.20354H8.85651C7.09639 9.20354 5.69376 8.32542 5.69376 6.56925C5.69376 4.8405 7.06889 3.79776 8.82897 3.79776H9.76406V7.11804H12.6793L15.3744 3.16663H8.82897C6.73885 3.16663 5.06122 4.51121 5.06122 6.56925V9.20354H2.9161V9.83467H5.06122V17.3333H10.2866Z" fill="#000"/></g></svg>',
    ]);
}

add_action('manage_posts_custom_column', 'action_custom_columns_content', 10, 2);
function action_custom_columns_content($columnId, $postId)
{
    $meta = get_post_meta($postId);

    if (empty($meta)) {
        return;
    }
    
    $socials = [
        'youtube'   => [
            'username'    => 'youtube_channel_name',
            'subscribers' => 'youtube_subscribers'
        ],
        'twitch'    => [
            'username'    => 'twitch_username',
            'subscribers' => 'twitch_subscribers'
        ],
        'instagram' => [
            'username'    => 'instagram_username',
            'subscribers' => 'instagram_subscribers',
        ],
        'tiktok'    => [
            'username'    => 'tiktok_username',
            'subscribers' => 'tiktok_subscribers'
        ],
        'X'         => [
            'username'    => 'x_username',
            'subscribers' => 'x_subscribers'
        ],
        'F'         => [
            'username'    => 'fanvue_username',
            'subscribers' => 'fanvue_subscribers'
        ]
    ];

    foreach ($socials as $social) {
        if ($columnId !== $social['subscribers']) {
            continue;
        }

        $username = !empty($meta[$social['username']]) ? $meta[$social['username']][0] : '';
        $subscribers = !empty($meta[$social['subscribers']]) ? $meta[$social['subscribers']][0] : '';

        if ($subscribers) {
            echo '<i class="subscribers_status status_true"></i>';
            return;
        }

        if ($username) {
            echo '<i class="subscribers_status status_false"></i>';
            return;
        }

        echo '<i class="subscribers_status status_empty"></i>';
    }
}