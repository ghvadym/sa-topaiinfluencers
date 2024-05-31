<?php

add_action('widgets_init', 'custom_sidebar');

function custom_sidebar()
{
    //Example of creating new Sidebar - Footer nav 1
    register_custom_sidebar('Footer nav 1', 'footer-nav-1');
}

function register_custom_sidebar($title, $slug)
{
    register_sidebar([
        'name'          => $title,
        'id'            => $slug,
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div class="footer-column col-md-4 col-lg-3">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<h2 class="widget__title">',
        'after_title'   => "</h2>\n",
    ]);
}