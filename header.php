<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php the_title() ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="header" class="header">
    <div class="container">
        <div class="header__row">
            <?php if (function_exists('the_custom_logo') && has_custom_logo()): ?>
                <div class="header__logo logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>
            <div class="header__menu">
                <?php wp_nav_menu([
                    'theme_location' => 'main_header'
                ]); ?>
            </div>
        </div>
    </div>
</header>
<main class="main">