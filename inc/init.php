<?php

const DOMAIN = 'tai';

if (!defined('POSTS_PER_PAGE')) {
    define('POSTS_PER_PAGE', get_option('posts_per_page') ?: 16);
}

$postsInfo = wp_count_posts();
if (isset($postsInfo->publish)) {
    if (!defined('ALL_POSTS_COUNT')) {
        define('ALL_POSTS_COUNT', $postsInfo->publish);
    }
}

$files = [
    'helper',
    'custom_functions',
    'post_types',
    'sidebar',
    'setup',
    'ajax'
];

foreach ($files as $file) {
    require_once("$file.php");
}