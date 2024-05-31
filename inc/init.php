<?php

$files = [
    'helper',
    'custom_functions',
    'post_types',
    'metabox',
    'customizer',
    'sidebar',
    'setup',
    'ajax'
];

foreach ($files as $file) {
    require_once("$file.php");
}