<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&family=Hind:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title><?php echo custom_get_page_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
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
            <div class="header__burger">
                <img src="<?php img_url('Burger.svg') ?>" alt="Burger" class="header_burger_icon">
                <img src="<?php img_url('Close.svg') ?>" alt="Close" class="header_close_icon">
            </div>
        </div>
    </div>
</header>
<main class="main">
    <?php if (!is_home() && !is_front_page()) { ?>
        <div class="container">
            <?php breadcrumbs(); ?>
        </div>
    <?php } ?>