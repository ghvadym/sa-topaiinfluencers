<?php
if (empty($posts)) {
    return;
}

$socials = socials();
?>

<div class="table">
    <div class="table__head">
        <div class="table__row">
            <div class="table__cell">#</div>
            <div class="table__cell col-name">
                <?php _e('Influencer', DOMAIN); ?>
            </div>
            <?php if (!empty($socials)) { ?>
                <?php foreach ($socials as $key => $field) { ?>
                    <div class="table__cell">
                        <?php get_svg($key); ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="table__body">
        <?php foreach ($posts as $i => $post) {
            $subscribers = socials();
            $fields = get_fields($post->ID); ?>
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
                <?php if (!empty($socials)) { ?>
                    <?php foreach ($socials as $key => $field) {
                        $subscribers = $fields[$field] ?? 0; ?>
                        <div class="table__cell">
                            <?php get_svg($key); ?>
                            <?php echo $subscribers ? short_number_format($subscribers) : '-'; ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div class="table__footer"></div>
</div>
