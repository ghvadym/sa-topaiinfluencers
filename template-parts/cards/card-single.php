<?php
if (empty($post)) {
    return;
}

$socials = [
    'instagram' => '2.3',
    'tiktok'    => '2.3',
    'F'         => '2.3',
    'X'         => '2.3',
    'youtube'   => '2.3',
    'twitch'    => '2.3'
];
?>

<div class="card__img">
    <?php echo get_thumbnail_html($post->ID, $post->post_title); ?>
</div>
<div class="card__body">
    <h1 class="card__title">
        <?php echo esc_html($post->post_title); ?>
    </h1>
    <div class="card__socials">
        <?php foreach ($socials as $svg => $value) { ?>
            <div class="card__social">
                <?php get_svg($svg); ?>
                <span>2.3M</span>
            </div>
        <?php } ?>
        <div class="card__social full">
            <?php get_svg('network'); ?>
            <span>123_xcopy_xcopy-123.com</span>
        </div>
    </div>
    <div class="card__social_btn btn">
        <?php _e('Get in touch', DOMAIN); ?>
    </div>
</div>
