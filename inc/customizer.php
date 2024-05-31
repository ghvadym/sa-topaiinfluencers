<?php

add_action('customize_register', 'customizer_init');

function customizer_init(WP_Customize_Manager $wp_customize)
{
    //Example of making new section in the Customizer
    if ($section = 'Footer') {
        $wp_customize->add_section($section, [
            'title'    => 'Footer',
            'priority' => 201
        ]);

        //Example of adding a new field to the created section Footer in the Customizer
        add_customizer_field(
            $wp_customize,
            $section,
            'footer_link',
            __('Footer Title', 'woplab')
        );

        //For getting this fields use: get_theme_mod('footer_link)
    }
}

function add_customizer_field($wp_customize, $section, $id, $label, $type = 'text', $transport = 'refresh')
{
    $wp_customize->add_setting($id, [
        'default'   => '',
        'transport' => $transport
    ]);

    $wp_customize->add_control($id, [
        'section' => $section,
        'label'   => $label,
        'type'    => $type
    ]);
}