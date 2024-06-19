<?php
if (empty($post)) {
    return;
}

$fields = get_fields($post->ID);
$socials = socials();

if (get_field('use_options_get_in_touch_link', 'options')) {
    $getInTouchLink = get_field('get_in_touch_link', 'options');
} else {
    $getInTouchLink = get_field('get_in_touch_link', $post->ID);
}

?>

<div class="card__img">
    <?php echo get_thumbnail_html($post->ID, $post->post_title); ?>
</div>
<div class="card__body">
    <h1 class="card__title">
        <?php echo esc_html($post->post_title); ?>
    </h1>
    <div class="card__socials">
        <?php foreach ($socials as $key => $field) {
            $subscribers = $fields[$field] ?? 0;

            if (!$subscribers) {
                continue;
            }
            ?>
            <div class="card__social">
                <?php get_svg($key); ?>
                <span><?php echo short_number_format($subscribers); ?></span>
            </div>
        <?php } ?>
        <?php if (!empty($fields['websites'])) { ?>
            <?php foreach ($fields['websites'] as $website) {
                $url = $website['url'] ?? '';
                if (!$url) {
                    continue;
                }

                $title = parse_url($url, PHP_URL_HOST);
                ?>
                <div class="card__social full btn">
                    <?php get_svg('network'); ?>
                    <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <?php if (!empty($getInTouchLink) && !empty($getInTouchLink['url'])) { ?>
        <a href="<?php echo esc_url($getInTouchLink['url'] ?? '') ?>"
           target="<?php echo esc_url($getInTouchLink['target'] ?? '_self') ?>"
           class="card__social_btn btn">
            <?php echo esc_html($getInTouchLink['title'] ?: __('Get In Touch', DOMAIN)); ?>
        </a>
    <?php } ?>
</div>
