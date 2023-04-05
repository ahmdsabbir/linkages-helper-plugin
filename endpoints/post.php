<?php
// new endpoint for getting post id and title when slug is supplied

add_action( 'rest_api_init', function () {
  register_rest_route( 'linkages/v1', '/post/(?P<slug>\S+)', array(
    'methods' => 'GET',
    'callback' => 'my_get_post_by_slug',
  ) );
} );

function my_get_post_by_slug( $data ) {
  $slug = $data['slug'];
  $post = get_page_by_path( $slug, OBJECT, 'post' );

  if ( ! $post ) {
    return new WP_Error( 'not_found', 'Post not found', array( 'status' => 404 ) );
  }

  return array(
    'id' => $post->ID,
    'title' => $post->post_title,
  );
}
