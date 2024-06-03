<?php
/*
* Template name: Home
*/

get_header();

$post_id = get_the_ID();
$fields = get_fields($post_id);

get_template_part_var('home/hero', [
    'fields' => $fields
]);

get_template_part_var('home/socials', [
    'socials' => get_field('socials', 'options')
]);

get_template_part_var('home/influencers');
get_template_part_var('home/vtubers');
get_template_part_var('home/topai');

get_footer();
