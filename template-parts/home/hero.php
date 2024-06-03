<?php
if (empty($fields)) {
    return;
}

$hero_bg_url = !empty($fields['hero_banner']) ? wp_get_attachment_image_url($fields['hero_banner'], 'large') : '';
//$hero_bg_mobile = !empty($fields['hero_banner_mob']) ? wp_get_attachment_image_url($fields['hero_banner_mob'], 'large') : '';
$hero_bg_mobile = img_url('hero-bg-mob.png', false);
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
        <?php if ($hero_bg_url || $hero_bg_mobile) { ?>
            <div class="hero__bg">
                <picture>
                    <source media="(min-width:1024px)" srcset="<?php echo esc_url($hero_bg_url); ?>">
                    <source media="(min-width:768px)" srcset="<?php echo esc_url($hero_bg_mobile); ?>">
                    <img src="<?php echo esc_url($hero_bg_mobile); ?>" alt="Hero Image">
                </picture>
            </div>
        <?php } ?>
    </div>
</section>