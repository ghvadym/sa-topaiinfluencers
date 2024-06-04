<?php
if (empty($options)) {
    return;
}
?>

<div class="custom_select">
    <div class="select__head">
        <div class="select__selected">
            <div class="select__selected_title">
                <?php echo $title; ?>
            </div>
            <?php get_svg('arrow-down'); ?>
        </div>
    </div>
    <div class="select__list">
        <?php foreach ($options as $id => $name) { ?>
            <div class="select__item checkbox_item" data-order="10">
                <input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $id; ?>">
                <label for="<?php echo $name; ?>">
                    <?php echo esc_attr($name); ?>
                </label>
            </div>
        <?php } ?>
    </div>
</div>