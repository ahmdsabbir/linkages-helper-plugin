<?php

function get_response($endpoint, $domain, $api_key) {


    // Set the URL of the API endpoint to send the POST request to
    $url = $endpoint;
    
    // Set the data to be sent in the POST request
    $data = array(
        // 'domain' => 'example.com'
        'domain' => $domain
    );
    
    // Set the headers for the request, including the Authorization header
    $headers = array(
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json'
    );
    
    // Create the context options for the stream context
    $opts = array(
        'http' => array(
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => json_encode($data)
        )
    );
    
    // Create the stream context with the options
    $context = stream_context_create($opts);
    
    $response = file_get_contents($url, false, $context);
    
    
    // Display the response from the API endpoint
    return $response;

}

function linkages_plugin_enqueue_scripts() {
    wp_enqueue_style( 'linkages-plugin-style', plugins_url( '/enqueues/style.css', __FILE__ ) );
    wp_enqueue_script( 'linkages-chart-script', plugins_url( '/enqueues/chart.js', __FILE__ ), array(), '1.0.0', true );
    wp_enqueue_script( 'linkages-plugin-script', plugins_url( '/enqueues/script.js', __FILE__ ), array(), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'linkages_plugin_enqueue_scripts' );


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function linkages_get_option_value() {
    $option_name = 'linkages_api_key';
    $option_value = get_option( $option_name );
    return $option_value;
}

function latest_post_date() {
    $latest_post = get_posts( array(
        'numberposts' => 1, // get only one post
        'orderby' => 'date', // order by date
        'order' => 'DESC' // newest first
    ) );
    
    if ( $latest_post ) {
        $latest_post_date = get_the_date( 'd/m/Y', $latest_post[0]->ID );
        echo $latest_post_date;
    }
}