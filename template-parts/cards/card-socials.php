<?php
if (empty($post_id)) {
    return;
}

$fields = get_fields($post_id);
$socials = socials();
?>

<div class="article__socials">
    <?php foreach ($socials as $key => $field) {
        $subscribers = $fields[$field] ?? 0;

        if (!$subscribers) {
            continue;
        }
        ?>
        <div class="article__social">
            <?php get_svg($key); ?>
            <span><?php echo short_number_format($subscribers); ?></span>
        </div>
    <?php } ?> 
</div>
