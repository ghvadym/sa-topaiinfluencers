<?php
if (empty($fields)) {
    return;
}

$hero_bg = $fields['hero_banner'] ? sprintf(
    'style="background-image: url(%s);"',
    wp_get_attachment_image_url($fields['hero_banner'], 'large')) : '';
?>

<section class="hero_section">
    <div class="container">
        <div class="hero__content">
            <?php _get_field($fields['hero_title'], 'hero__title', 'h1'); ?>
            <?php if (!empty($fields['hero_text'])) { ?>
                <div class="hero__subtitle">
                    <?php echo $fields['hero_text']; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>