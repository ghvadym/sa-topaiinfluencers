<?php

const DOMAIN = 'tai';
const EVENT_COUNT_POSTS_PER_CALL = 5;
const EVENT_TIME_TO_CHECK = HOUR_IN_SECONDS * 12;

if (!defined('POSTS_PER_PAGE')) {
    define('POSTS_PER_PAGE', get_option('posts_per_page') ?: 16);
}

$files = [
    'helper',
    'custom_functions',
    'api',
    'post_types',
    'sidebar',
    'setup',
    'ajax'
];

foreach ($files as $file) {
    require_once("$file.php");
}