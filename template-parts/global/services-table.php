<?php
if (empty($services)) {
    return;
}
?>

<div class="table services">
    <div class="table__head">
        <div class="table__row">
            <div class="table__cell">
                <?php _e('Website', DOMAIN); ?>
            </div>
            <div class="table__cell">
                <?php _e('Service/Rate', DOMAIN); ?>
            </div>
            <div class="table__cell">
                <?php _e('Price', DOMAIN); ?>
            </div>
            <div class="table__cell">
                <?php _e('Unique features', DOMAIN); ?>
            </div>
            <div class="table__cell"></div>
        </div>
    </div>
    <div class="table__body">
        <?php foreach ($services as $i => $post) {
            $fields = get_fields($post->ID);
            ?>
            <div class="table__row">
                <div class="table__cell">
                    <?php if (has_post_thumbnail($post->ID)) { ?>
                        <img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>"
                             width="57" height="57"
                             alt="<?php echo esc_attr($post->post_title); ?>">
                    <?php } ?>
                </div>
                <div class="table__cell">
                    <?php if (!empty($fields['rating'])) { ?>
                        <div class="service__rating">
                            <div class="service__title">
                                <?php echo esc_attr($post->post_title); ?>
                            </div>
                            <div class="service__rating_stars">
                                <?php rating((float)$fields['rating']); ?>
                                <span>
                                    <?php echo $fields['rating']; ?>
                                </span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="table__cell">
                    <?php if (!empty($fields['price'])) {
                        echo sprintf('$%s', $fields['price']);
                    } ?>
                </div>
                <div class="table__cell">
                    <?php if (!empty($fields['unique_feautures'])) { ?>
                        <div class="service__desc">
                            <?php echo $fields['unique_feautures']; ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="table__cell">
                    <div class="service__btn_group">
                        <?php if (!empty($fields['read_review_btn_url'])) { ?>
                            <a href="<?php echo esc_url($fields['read_review_btn_url']); ?>" class="service__btn btn_dark">
                                <?php _e('Read Review', DOMAIN); ?>
                            </a>
                        <?php } else { ?>
                            <div class="service__btn btn_dark disabled">
                                <?php _e('Read Review', DOMAIN); ?>
                            </div>
                        <?php } ?>
                        <?php if (!empty($fields['view_btn_url'])) { ?>
                            <a href="<?php echo esc_url($fields['view_btn_url']); ?>" class="service__btn btn">
                                <?php _e('Visit', DOMAIN); ?>
                                <?php get_svg('link'); ?>
                            </a>
                        <?php } else { ?>
                            <div class="btn service__btn disabled">
                                <?php _e('Visit', DOMAIN); ?>
                                <?php get_svg('link'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="table__footer"></div>
</div>
