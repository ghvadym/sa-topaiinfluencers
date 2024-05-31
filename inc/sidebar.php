<?php

add_action('widgets_init', 'custom_sidebar');

function custom_sidebar()
{
    register_custom_sidebar('Footer Nav 1', 'footer-nav-1');
    register_custom_sidebar('Footer Nav 2', 'footer-nav-2');
}

function register_custom_sidebar($title, $slug)
{
    register_sidebar([
        'name'          => $title,
        'id'            => $slug,
        'description'   => '',
        'class'         => '',
        'before_widget' => '<div class="footer__col">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<h2 class="footer__title">',
        'after_title'   => "</h2>\n",
    ]);
}