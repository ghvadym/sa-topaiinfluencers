<?php

add_action('init', 'create_post_types');

function create_post_types()
{
    create_taxonomy('social_media', 'post', [
        'labels' => [
            'name'              => __('Socials', DOMAIN),
            'singular_name'     => __('Socials', DOMAIN),
            'search_items'      => __('Search Social', DOMAIN),
            'all_items'         => __('All Socials', DOMAIN),
            'view_item '        => __('View Language', DOMAIN),
            'parent_item'       => __('Parent Social', DOMAIN),
            'parent_item_colon' => __('Parent Social:', DOMAIN),
            'edit_item'         => __('Edit Social', DOMAIN),
            'update_item'       => __('Update Social', DOMAIN),
            'add_new_item'      => __('Add New Social media', DOMAIN),
            'new_item_name'     => __('New Social Name', DOMAIN),
            'menu_name'         => __('Socials', DOMAIN),
            'back_to_items'     => __('← Back to Socials', DOMAIN)
        ],
    ]);

    create_taxonomy('niche', 'post', [
        'labels' => [
            'name'              => __('Niches', DOMAIN),
            'singular_name'     => __('Niches', DOMAIN),
            'search_items'      => __('Search Niche', DOMAIN),
            'all_items'         => __('All Niches', DOMAIN),
            'view_item '        => __('View Language', DOMAIN),
            'parent_item'       => __('Parent Niche', DOMAIN),
            'parent_item_colon' => __('Parent Niche:', DOMAIN),
            'edit_item'         => __('Edit Niche', DOMAIN),
            'update_item'       => __('Update Niche', DOMAIN),
            'add_new_item'      => __('Add New Niche', DOMAIN),
            'new_item_name'     => __('New Niche Name', DOMAIN),
            'menu_name'         => __('Niches', DOMAIN),
            'back_to_items'     => __('← Back to Niches', DOMAIN)
        ],
    ]);

    create_taxonomy('language', 'post', [
        'labels' => [
            'name'              => __('Language', DOMAIN),
            'singular_name'     => __('Language', DOMAIN),
            'search_items'      => __('Search Language', DOMAIN),
            'all_items'         => __('All Languages', DOMAIN),
            'view_item '        => __('View Language', DOMAIN),
            'parent_item'       => __('Parent Language', DOMAIN),
            'parent_item_colon' => __('Parent Language:', DOMAIN),
            'edit_item'         => __('Edit Language', DOMAIN),
            'update_item'       => __('Update Language', DOMAIN),
            'add_new_item'      => __('Add New Language', DOMAIN),
            'new_item_name'     => __('New Niche Language', DOMAIN),
            'menu_name'         => __('Languages', DOMAIN),
            'back_to_items'     => __('← Back to Languages', DOMAIN)
        ],
    ]);
}


function create_post_type($post_type, $args = [])
{
    $args = array_merge([
        'public'        => true,
        'show_ui'       => true,
        'has_archive'   => true,
        'menu_position' => 20,
        'hierarchical'  => true,
        'supports'      => ['title', 'excerpt', 'thumbnail', 'editor'],
    ], $args);

    register_post_type($post_type, $args);
}

function create_taxonomy($taxonomy, $post_type, $args = [])
{
    $args = array_merge([
        'description'  => '',
        'public'       => true,
        'hierarchical' => true,
        'has_archive'  => true,
    ], $args);

    register_taxonomy($taxonomy, $post_type, $args);
}