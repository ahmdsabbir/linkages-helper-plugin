<?php

function raw_post_content_init() {
    register_rest_route( 'linkages/v1', '/content/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'raw_post_content_callback',
        'args' => array(
            'id' => array(
                'validate_callback' => function($param, $request, $key) {
                return is_numeric( $param );
                }
            ),
        ),
    ) );
}
function raw_post_content_callback( $data ) {
  global $wpdb;
  $post_id = $data['id'];
  $query = "SELECT post_content FROM {$wpdb->prefix}posts WHERE ID = %d";
  $raw_content = $wpdb->get_var( $wpdb->prepare( $query, $post_id ) );
  $response = new WP_REST_Response( $raw_content );
  return $response;
}
add_action( 'rest_api_init', 'raw_post_content_init' );