<?php
if (empty($terms) || empty($name)) {
    return;
}
?>

<div class="custom_select">
    <div class="select__head">
        <div class="select__selected">
            <div class="select__selected_title">
                <?php echo $title ?? __('Select', DOMAIN); ?>
            </div>
            <?php get_svg('arrow-down'); ?>
        </div>
    </div>
    <div class="select__list">
        <?php foreach ($terms as $term) { ?>
            <div class="select__item checkbox_item">
                <input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $term->term_id; ?>">
                <label for="<?php echo $name; ?>">
                    <?php echo esc_attr($term->name); ?>
                </label>
            </div>
        <?php } ?>
    </div>
</div>