<?php

const DOMAIN = 'tai';

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