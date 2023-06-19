<?php
function linkages_404_report_callback(){

    $api_key = get_option('linkages_api_key');
    $domain = get_site_url();

    // $resp = get_response('http://127.0.0.1:5000/wp/plugin/get-report', $domain, $api_key);
    $resp = get_response('https://linkages.io/api/plugin/get-report', $domain, $api_key);

    $data = json_decode($resp);

    if ( $data->status == 'success' ) :

    // var_dump($data);wp_die();

        $status = 'success';

        $num_internal_link = $data->domain_data->num_internal_link;
        $num_outbound_link = $data->domain_data->num_outbound_link;
        
        $num_internal_404 = $data->domain_data->num_internal_404;
        $num_outbound_404 = $data->domain_data->num_outbound_404;

        $internal_404_links = $data->domain_data->internal_404_links;
        $outbound_404_links = $data->domain_data->outbound_404_links;
    
    elseif ( $data->status == 'invalid_api_key' ) :
        $status = 'invalid_api_key';
    
    elseif ( $data->status == 'domain_mismatch' ) :
        $status = 'domain_mismatch';
    
    elseif ( $data->status == 'no_report_yet' ) :
        $status = 'no_report_yet';

    endif;
?>

<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
<hr />

<?php if ($status == 'invalid_api_key') : ?>
    <div class="notice notice-error">
        <p>The API key you provided is not a valid one.</p>
    </div>

<?php elseif ($status == 'domain_mismatch') : ?>
    <div class="notice notice-error">
        <p>The API key is not for this domain. Check again.</p>
    </div>

<?php elseif ($status == 'no_report_yet') : ?>
    <div class="notice notice-alert">
        <p>No report to show. Generate a report first.</p>
    </div>

<?php elseif ($status == 'success') : ?>


    <div class="wrap">
        <h2 class="">Internal Links</h2>
        <div>
            <div class="card">
                <canvas id="internal404"></canvas>
            </div>
        </div>
    </div>

    <?php if ($num_internal_404 == 0) {?>
        <p>Good Job! Looks like you've done an awesome job.</p>
        <?php } else { 
            foreach ($inernal_404_links as $int) {
                echo '<p>'. $int . '</p>';
            }
        } ?>

    <div class="wrap">
        <h2 class="">Outbound Links</h2>
        <div>
            <div class="card">
                <canvas id="outbound404"></canvas>
            </div>
        </div>
    </div>

    <?php if ($num_outbound_404 == 0) {?>
        <p>Nice! There's no outbound link that returns 404.</p>
    <?php } else { 
        foreach ($outbound_404_links as $out) {
            echo '<p>'. $out . '</p>';
        }
    } ?>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const internal404 = document.getElementById('internal404');

        new Chart(internal404, {
        type: 'doughnut',
        data: {
        labels: ['Total Internal Links', 'Number of 404 Internal Links'],
        datasets: [{
            label: 'out of ' + <?php echo $num_internal_link; ?> + ' Links',
            data: [<?php echo $num_internal_link; ?>, <?php echo $num_internal_404; ?>],
            borderWidth: 1
        }]
        },
        });
        
        
        
        const ctx2 = document.getElementById('outbound404');

        new Chart(ctx2, {
        type: 'doughnut',
        data: {
        labels: ['Total Outbound Links', 'Number of 404 Outbound Links'],
        datasets: [{
            label: 'out of ' + <?php echo $num_outbound_link; ?> + ' Links',
            data: [<?php echo $num_outbound_link; ?>, <?php echo $num_outbound_404; ?>],
            borderWidth: 1
        }]
        },

        });

    </script>

<?php endif; ?>

<?php
}


