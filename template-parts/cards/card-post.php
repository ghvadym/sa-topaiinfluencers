<?php
if (empty($post)) {
    return;
}

$subtitle = get_post_meta($post->ID, 'default_post_subtitle', true);
?>

<div class="card">
    <div class="card__head">
        <img src="<?php echo get_thumbnail_url($post->ID); ?>"
             alt="<?php echo $post->post_title; ?>">
    </div>
    <div class="card__body">
        <h3 class="card__title">
            <?php cut_str($post->post_title, 20); ?>
        </h3>
        <div class="card__text">
            <?php cut_str($post->post_content, 200); ?>
        </div>
    </div>
    <?php _get_field($subtitle, 'card__footer'); ?>
</div>
