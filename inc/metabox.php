<?php

add_action('add_meta_boxes', 'add_meta_boxes_call');
add_action('save_post', 'save_post_call');

function add_meta_boxes_call()
{
    //Example of creating a new metabox
    add_meta_box(
        'default_data',
        'Default Data',
        'default_data_call',
        'post',
        'side'
    );
}

function default_data_call($post)
{
    //Example callback for a created metabox
    $subtitle = get_post_meta($post->ID, 'default_post_subtitle', true); ?>

    <div id="default-post-data">
        <div class="default-post-data-row">
            <label for="default-post-subtitle">
                <?php _e('Subtitle'); ?>
            </label>
            <input type="text"
                   id="default-post-subtitle"
                   name="default-post-subtitle"
                   value="<?php echo $subtitle; ?>">
        </div>
    </div>
    <?php
}

function save_post_call($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    //Example of saving data from a created metabox.
    if (isset($_POST['default-post-subtitle'])) {
        update_post_meta($post_id, 'default_post_subtitle', $_POST['default-post-subtitle'] ?? '');
    }
}