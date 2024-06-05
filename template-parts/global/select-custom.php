<?php
if (empty($options) || empty($name)) {
    return;
}

$typeRadio = !empty($type) && $type === 'radio';
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
        <?php foreach ($options as $id => $title) { ?>
            <?php if ($typeRadio) { ?>
                <div class="select__item checkbox_item">
                    <input type="radio" name="<?php echo $name; ?>" value="<?php echo $id; ?>">
                    <label for="<?php echo $name; ?>">
                        <?php echo esc_attr($title); ?>
                    </label>
                </div>
            <?php } else { ?>
                <div class="select__item checkbox_item">
                    <input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $id; ?>">
                    <label for="<?php echo $name; ?>">
                        <?php echo esc_attr($title); ?>
                    </label>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>