<?php

//add_action('init', 'create_post_types');

function create_post_types()
{
    //Example of creating a new post type - collection
    create_post_type('collection', [
        'menu_icon' => 'post',
        'supports'  => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'labels'    => [
            'name'          => __('Collection', 'woplab'),
            'singular_name' => __('Collection', 'woplab'),
            'add_new'       => __('Add New Item', 'woplab'),
            'add_new_item'  => __('Add New Item', 'woplab'),
            'view_item'     => __('View Item', 'woplab'),
            'search_items'  => __('Find Item', 'woplab'),
            'not_found'     => __('Item isn\'t found', 'woplab'),
            'menu_name'     => __('Collection', 'woplab')
        ],
    ]);

    //Example of creating a new taxonomy - collection_categories
    create_taxonomy('collection_categories', 'collection', [
        'labels' => [
            'name'              => __('Collection Categories', 'woplab'),
            'singular_name'     => __('Collection Categories', 'woplab'),
            'search_items'      => __('Search Category', 'woplab'),
            'all_items'         => __('All Categories', 'woplab'),
            'parent_item'       => __('Parent Category', 'woplab'),
            'parent_item_colon' => __('Parent Category:', 'woplab'),
            'edit_item'         => __('Edit Category', 'woplab'),
            'update_item'       => __('Update Category', 'woplab'),
            'add_new_item'      => __('Add New Category', 'woplab'),
            'new_item_name'     => __('New Category Name', 'woplab'),
            'menu_name'         => __('Collection Categories', 'woplab')
        ],
    ]);
}


function create_post_type($postType, $args = [])
{
    $args = array_merge([
        'public'        => true,
        'show_ui'       => true,
        'has_archive'   => true,
        'menu_position' => 20,
        'hierarchical'  => true,
        'supports'      => ['title', 'excerpt', 'thumbnail', 'editor'],
    ], $args);

    register_post_type($postType, $args);
}

function create_taxonomy($taxonomy, $postType, $args = [])
{
    $args = array_merge([
        'description'  => '',
        'public'       => true,
        'hierarchical' => true,
        'has_archive'  => true,
    ], $args);

    register_taxonomy($taxonomy, $postType, $args);
}