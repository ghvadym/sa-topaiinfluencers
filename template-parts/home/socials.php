<?php
if (empty($socials)) {
    return;
}
?>

<section class="socials_section">
    <div class="container">
        <div class="socials__wrap">
            <div class="socials__list">
                <?php foreach ($socials as $social) {
                    $image_url = $social['img'] ?? '';
                    $link = $social['link'] ?? '';

                    if (!$image_url || !$link) {
                        continue;
                    }
                    ?>
                    <div class="socials__list_item">
                        <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener nofollow">
                            <img src="<?php echo esc_url($image_url); ?>" alt="Social">
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>