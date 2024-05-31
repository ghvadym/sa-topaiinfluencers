<?php

function load_file_by_url(string $file_url = ''): int
{
    if (!$file_url) {
        return 0;
    }

    $upload_dir = wp_upload_dir();
    $file = file_get_contents($file_url);
    $filename = 'image-' . time() . '.png';
    $path = $upload_dir['path'] . '/' . $filename;

    if (!file_put_contents($path, $file)) {
        return 0;
    }

    return upload_file_to_attachments($path);
}

function save_file($file): int
{
    if (!$file) {
        return 0;
    }

    $upload_dir = wp_upload_dir();
    $path = $upload_dir['path'] . '/' . $file['name'];

    if (file_exists($path)) {
        return upload_file_to_attachments($path);
    }

    if (!move_uploaded_file($file['tmp_name'], $path)) {
        return 0;
    }

    return upload_file_to_attachments($path);
}

function upload_file_to_attachments(string $path = ''): int
{
    if (!$path) {
        return 0;
    }

    $upload_dir = wp_upload_dir();
    $file_name = basename($path);
    $file_type = wp_check_filetype($file_name);

    $attachment_id = get_attachment_id_by_name($file_name);
    if (!empty($attachment_id)) {
        return $attachment_id;
    }

    $attachment = [
        'guid'           => $upload_dir['url'] . '/' . $file_name,
        'post_mime_type' => $file_type['type'],
        'post_title'     => preg_replace('/\.[^.]+$/', '', $file_name),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    if (!$attachment_id = wp_insert_attachment($attachment, $path)) {
        return 0;
    }

    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $attach_data = wp_generate_attachment_metadata($attachment_id, $path);
    wp_update_attachment_metadata($attachment_id, $attach_data);

    return $attachment_id;
}

function get_attachment_id_by_name(string $file_name = '')
{
    if (!$file_name) {
        return false;
    }

    global $wpdb;

    $sql = $wpdb->prepare(
        "SELECT `post_id` FROM $wpdb->postmeta 
         WHERE `meta_key` = '_wp_attached_file' AND meta_value LIKE %s",
        '%/'.$file_name
    );

    return $wpdb->get_var($sql);
}