<?php

function breadcrumbs()
{
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">', '</p>');
    }
}

function custom_get_page_title(): string
{
    if (is_archive() || is_tax()) {
        $taxonomy = get_queried_object();
        $title = $taxonomy->name;
    } else {
        $title = get_the_title();
    }

    return $title . ' - ' . get_bloginfo('name');
}