<?php
if (empty($posts)) {
    return;
}

$socials = [
    'instagram',
    'tiktok',
    'F',
    'X',
    'youtube',
    'twitch'
];
?>

<div class="table">
    <div class="table__head">
        <div class="table__row">
            <div class="table__cell">#</div>
            <div class="table__cell col-name">
                <?php _e('Influencer', DOMAIN); ?>
            </div>
            <?php foreach ($socials as $social) { ?>
                <div class="table__cell">
                    <?php get_svg($social); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="table__body">
        <?php foreach ($posts as $i => $post) { ?>
            <div class="table__row">
                <div class="table__cell">
                    <?php echo $i + 1; ?>
                </div>
                <div class="table__cell col-name">
                    <a href="<?php echo get_the_permalink($post->ID) ?>">
                        <?php if (has_post_thumbnail($post->ID)) { ?>
                            <img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>"
                                 width="57" height="57"
                                 alt="<?php echo esc_attr($post->post_title); ?>">
                        <?php } ?>
                        <?php echo esc_html($post->post_title); ?>
                    </a>
                </div>
                <div class="table__cell">
                    <?php get_svg('instagram'); ?>
                    189K
                </div>
                <div class="table__cell">
                    <?php get_svg('tiktok'); ?>
                    189K
                </div>
                <div class="table__cell">
                    <?php get_svg('F'); ?>
                    189K
                </div>
                <div class="table__cell">
                    <?php get_svg('X'); ?>
                    189K
                </div>
                <div class="table__cell">
                    <?php get_svg('youtube'); ?>
                    189K
                </div>
                <div class="table__cell">
                    <?php get_svg('twitch'); ?>
                    189K
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="table__footer"></div>
</div>
