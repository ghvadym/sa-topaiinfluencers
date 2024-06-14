<?php
if (empty($post)) {
    return;
}

$thumbnail = get_thumbnail_html($post->ID, $post->post_title);
$author_id = $post->post_author;
$author_name = get_the_author_meta('display_name', $author_id);
$author_avatar = get_avatar_url($author_id);
?>

<div class="article<?php echo !empty($full_card_info) ? ' full-card' : ''; ?><?php echo !empty($slider) ? ' swiper-slide' : ''; ?>">
    <div class="article__body">
        <a href="<?php echo get_the_permalink($post); ?>"
           class="article__img<?php echo empty($full_card_info) ? ' cropped-img' : ''; ?>">
            <?php echo $thumbnail; ?>
            <?php if ($post->post_type === 'post') {
                get_template_part_var('cards/card-socials', [
                    'post_id' => $post->ID
                ]);
            } ?>
        </a>
        <div class="article__content">
            <h3 class="article__title">
                <a href="<?php echo get_the_permalink($post); ?>">
                    <?php echo esc_html($post->post_title); ?>
                </a>
            </h3>
            <?php if (!empty($full_card_info)) { ?>
                <?php if ($post->post_content) { ?>
                    <div class="article__text">
                        <?php echo wp_trim_words($post->post_content, 25, '...') ?>
                    </div>
                <?php } ?>
                <div class="article__author">
                    <?php if ($author_avatar) { ?>
                        <img src="<?php echo $author_avatar; ?>"
                             alt="<?php echo esc_html($author_name); ?>">
                    <?php } ?>
                    <span>
                        <?php echo esc_html($author_name); ?>
                    </span>
                </div>
                <div class="article__date">
                    <?php echo date('M d, Y', strtotime($post->post_date)); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
