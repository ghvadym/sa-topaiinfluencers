<?php

const DOMAIN = 'tai';

if (!defined('POSTS_PER_PAGE')) {
    define('POSTS_PER_PAGE', get_option('posts_per_page') ?: 16);
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