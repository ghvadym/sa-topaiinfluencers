<?php
if (empty($blocks)) {
    return;
}
?>

<div class="content_cards">
    <div class="content_cards__list">
        <?php foreach ($blocks as $block) {
            $imgUrl = $block['img'] ?? '';
            $text = $block['text'] ?? '';
            
            if (!$text) {
                continue;
            }
            ?>
            <div class="content_card__item">
                <?php if (!empty($imgUrl)) { ?>
                    <div class="content_card__img">
                        <img src="<?php echo esc_url($imgUrl); ?>">
                    </div>
                <?php } ?> 
                <div class="content_card__text">
                    <?php echo $text; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
