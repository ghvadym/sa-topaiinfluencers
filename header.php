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

<?php
//$response = file_get_contents('https://graph.facebook.com/v20.0/17841453170571388?fields=business_discovery.username(nasa){followers_count}&access_token=EABv2GZALb40QBOyTTi13giW5ol8iTInFyLAp9u3uN3imnVa05t0TjYR0myqRlhcpaDJIq0ZB7nPEboujgpLyIkAAxJdVS2ump5EI9IG9Nm8tSHWGBDVewxp4LZBSrAKyQJun5oAualQT5LMNd4trRes8DdlHHvZB161SZAuJQvpZAEk1aJ1XtwUPBo1AcPH1RHstiDK2NsV4IzZBfLFQQZDZD');
echo ("<pre>");
//var_dump(TAI_Twitch_API::updateSubscribers('gust_taid', 1096));
//var_dump(TAI_Google_API::updateSubscribers('MusicLabChill', 1096));
//var_dump(TAI_Instagram_API::updateSubscribers('therock', 1096));
//EAAKQzmcMDVoBO30xVNHyhkbpC5e25LGoxEt4hpjIBu4mOZAtpFfV6S9IMtpqZBdpZBLaikiZA28AgZALhin81AdZBZAOT4WEcIlk0ChKNS9LAagTJOAHipZCKLdQOxImc6m5B7C9NETOkQHgiWFQ8rwibUWmizkm7dZA2jxcnNpZCHbYgd5MniOrfqch5F1L4CIGpcWnrdiWwf4tgtWOR2kAZDZD
echo ("</pre>");

if (is_my_ip()) {
//    var_dump(facebook_auth_token());
//    var_dump(get_facebook_long_term_token());
//    echo '<a href="'.facebook_auth_url().'">Login FB</a>';
//    echo '<a href="'.tiktok_token_auth_url().'">Login TikTok</a>';
//    echo ("<pre>");
//    var_dump(facebook_auth_token());
//    var_dump(tiktok_auth_token());
//    echo ("</pre>");
//    return;
}
?>