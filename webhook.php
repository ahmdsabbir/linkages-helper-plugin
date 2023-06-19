<?php
// Trigger the webhook when a post is created or updated
function webhook_notifier_send_data($post_ID) {
    $post = get_post($post_ID);

    // Prepare the data to be sent as JSON
    $data = array(
        'id' => $post->ID,
        'url' => get_permalink($post->ID),
        'title' => $post->post_title,
        'content' => $post->post_content
    );

    // Convert data to JSON format
    $json_data = json_encode($data);

    // URL where the JSON data should be sent
    $webhook_url = 'http://127.0.0.1:5000/api/plugin/webhook';

    // Send the JSON data via a POST request
    $response = wp_remote_post($webhook_url, array(
        'body' => $json_data,
        'headers' => array('Content-Type' => 'application/json'),
        'timeout' => 10,
        'sslverify' => false // Only if your webhook endpoint uses self-signed SSL certificate
    ));
}
add_action('save_post', 'webhook_notifier_send_data');
