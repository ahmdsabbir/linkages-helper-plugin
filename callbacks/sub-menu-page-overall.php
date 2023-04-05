<?php
function linkages_overall_report_callback(){

    // echo '<div id="preloader"><div class="loader"></div></div>';

    $domain = get_site_url();
    // $domain = 'https://anikyusuf.com';

    $api_key = get_option('linkages_api_key');
    $resp = get_response('http://127.0.0.1:5000/wp/plugin/get-report', $domain, $api_key);

    // Add JavaScript code to hide the preloader when the page is fully loaded
    // echo '<script>
    //         window.addEventListener("load", function(){
    //             document.getElementById("preloader").style.display = "none";
    //         });
    //     </script>';

    $data = json_decode($resp);

    // var_dump($data);wp_die();

    if ( $data->status == 'success' ) :

        $status = 'success';

        $num_internal_link = $data->domain_data->num_internal_link;
        $num_outbound_link = $data->domain_data->num_outbound_link;
        $num_total_link = $data->domain_data->num_total_links;
        $date = $data->domain_data->date_added;
        $domain = $data->domain_data->domain;

        $num_internal_404 = $data->domain_data->num_internal_404;
        $num_outbound_404 = $data->domain_data->num_outbound_404;

        $num_orphan = $data->domain_data->num_orphan;
        $num_all_posts = $data->domain_data->num_all_posts;
        $orphan_links = $data->domain_data->orphan_links;

        $time_ago = time_elapsed_string($date);

        $num_internal_404 = $data->domain_data->num_internal_404;
        $num_outbound_404 = $data->domain_data->num_outbound_404;

        $internal_404_links = $data->domain_data->internal_404_links;
        $outbound_404_links = $data->domain_data->outbound_404_links;

        $outbound_domains = $data->domain_data->outbound_domains;
        $num_outbound_domains = count($outbound_domains);
    
    elseif ( $data->status == 'invalid_api_key' ) :
        $status = 'invalid_api_key';
    
    elseif ( $data->status == 'domain_mismatch' ) :
        $status = 'domain_mismatch';
    
    elseif ( $data->status == 'no_report_yet' ) :
        $status = 'no_report_yet';

    endif;

    if ($status == 'success'):
        // 404 source requests
        $resp = get_response('http://127.0.0.1:5000/wp/plugin/internal-404', $domain, $api_key);
        $data = json_decode($resp);
        $source_internal_404 = $data->links;
    endif;
    
    if ($status == 'success'):
        // 404 source requests
        $resp = get_response('http://127.0.0.1:5000/wp/plugin/external-404', $domain, $api_key);
        $data = json_decode($resp);
        $source_external_404 = $data->links;
    endif;
?>


<div class="linkages-container">


<div class="wrap">
    <h1>Site Report</h1>
</div>

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
    
        <div class="chart-card">
            <div class="head">
                <h2>Domain report on: <em><?php echo $domain; ?></em></h2>
            </div>
            <div class="body">
                <h2>This report was created <span style='color: #6192b3'><?php echo $time_ago; ?></span>.</h2>
                <p>Head over to <a href="https://linkages.io" target="_blank">linkages.com</a> to update site report.</p>
            </div>
        </div>

    </div><!-- ./wrap -->

    <div class="wrap" id="total">
        <div class="small-cards">
            
            <div class="small-card color1">
                <div class="body">
                    <div class="left">
                        <h3><?php echo $num_all_posts ?></h3>
                        <p class="a">Total Posts</p>
                        <p class="b">Latest post on <?php latest_post_date(); ?></p>
                    </div>
                    <div class="right">
                        <span class="dashicons dashicons-admin-post"></span>
                    </div>
                </div>
            </div>
            
            <div class="small-card color2">
                <div class="body">
                    <div class="left">
                        <h3><?php echo $num_orphan ?></h3>
                        <p class="a">Orphan posts</p>
                        <?php if ($num_orphan == 0): ?>
                            <p class="a">Good Job!</p>
                        <?php else: ?>
                            <p class="b"><a href="https://linkages.com" target="_blank">Linkages</a> is here to help!</p>
                        <?php endif; ?>
                    </div>
                    <div class="right">
                        <span class="dashicons dashicons-dismiss"></span>
                    </div>
                </div>
            </div>

            <div class="small-card color3">
                <div class="body">
                    <div class="left">
                        <h3><?php echo $num_internal_link ?></h3>
                        <p class="a">Internal links</p>
                        <p class="b">Follow a stratgy.</p>
                    </div>
                    <div class="right">
                        <span class="dashicons dashicons-networking"></span>
                    </div>
                </div>
            </div>
            
            <div class="small-card color4">
                <div class="body">
                    <div class="left">
                        <h3><?php echo $num_outbound_link ?></h3>
                        <p class="a">External links</p>
                        <p class="b">Include relevant external links</p>
                    </div>
                    <div class="right">
                        <span class="dashicons dashicons-external"></span>
                    </div>
                </div>
            </div>
            
            <div class="small-card color5">
                <div class="body">
                    <div class="left">
                        <h3><?php echo count($outbound_domains) ?></h3>
                        <p class="a">Outbound domains</p>
                        <p class="b">Mo' relevant domains... mo' money!</p>
                    </div>
                    <div class="right">
                        <span class="dashicons dashicons-external"></span>
                    </div>
                </div>
            </div>
            
            

        </div>    
    </div><!-- ./wrap -->
        
    <div class="wrap" id="quick">

        <h2>Quick Glance</h2>

        <div class="chart-cards">

            <div class="chart-card">
                <div class="head">
                    <h3>Post Report</h3>
                </div>
                <div>
                    <div class="body">
                        <canvas id="linkReport"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <div class="head">
                    <h3>Internal and External Links</h3>
                </div>
                <div>
                    <div class="body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <div class="head">
                    <h3>Internal Link Report</h3>
                </div>
                <div>
                    <div class="body">
                        <canvas id="internal404"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <div class="head">
                    <h3>External Link Report</h3>
                </div>
                <div>
                    <div class="body">
                        <canvas id="outbound404"></canvas>
                    </div>
                </div>
            </div>
            
            
            <div class="chart-card">
                <div class="head">
                    <h3>Orphan Links</h3>
                </div>
                <div>
                    <div class="body">
                        <canvas id="orphanLinks"></canvas>
                    </div>
                </div>
            </div>
            
        </div>

    </div><!-- ./wrap -->

    <div class="wrap" id="link">
        <h2>404 Links</h2>
        <p>
            We found <?php echo $num_internal_404 + $num_outbound_404; ?> links that returns 404 status code. <?php if ($num_internal_404 + $num_outbound_404 == 0) {echo 'Good Job!';} else {echo 'Fix it.';} ?>
        </p>
        
        <?php if ($num_internal_404 != 0) : ?>
            
            <div class="chart-card">
                <div class="head">
                    <h3>Internal 404 Links</h3>
                </div>
                <div class="body">
                    <table class="linkages-table">
                        <thead>
                            <tr>
                                <td>Post Url</td>
                                <td>Source Post</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $source_internal_404 as $link ) : ?>
                                <tr>
                                <td><?php echo $link->post ?></td>
                                <td>
                                    <?php foreach ( $link->source as $source ) : ?>
                                        <p>
                                            <a href="<?php echo $source; ?>" target="_blank"><?php echo $source; ?></a>
                                    </p>
                                    <?php endforeach; ?>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        <?php endif; ?>
        
        <?php if ($num_outbound_404 != 0) : ?>

            <br>

            <div class="chart-card">
                <div class="head">
                    <h3>External 404 Links</h3>
                </div>
                <div class="body">

                    <table class="linkages-table">
                            <thead>
                                <tr>
                                    <td>Post Url</td>
                                    <td>Source Post</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $source_external_404 as $link ) : ?>
                                    <tr>
                                    <td><?php echo $link->post ?></td>
                                    <td>
                                        <?php foreach ( $link->source as $source ) : ?>
                                            <p>
                                                <a href="<?php echo $source; ?>" target="_blank"><?php echo $source; ?></a>
                                        </p>
                                        <?php endforeach; ?>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                </div>
            </div>
            
        <?php endif; ?>

    </div><!-- ./wrap -->

    <div class="wrap" id="orphan">
        <h2>Orphan Post Report</h2>
        <div class="chart-card">
            <div class="head">
                <h3>Orphan Posts</h3>
            </div>
            <div class="body">

                <?php if ($num_orphan == 0): ?>
                    Excellent work! We found No Orphan Posts.
                <?php else: ?>
                    <p><strong>[<?php echo $num_orphan; ?> Orphan Post/s found]</strong></p>
                    <ul id="orphanList">
                        <?php foreach($orphan_links as $link): ?>
                            <li><a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if($num_orphan > 5): ?>
                        <button id="expandBtn" class="button button-primary">See all <?php echo $num_orphan; ?></button>
                        <button id="hideBtn" style="display:none;" class="button button-secondary">Hide</button>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </div><!-- ./wrap -->

    <div class="wrap" id="outbound-domains">
        <div class="chart-card">
            <div class="head">
                <h2>Outbound Domains</h2>
            </div>
            <div class="body">
                <?php if ( $num_outbound_domains == 0 ) : ?>
                    Number of Outbound Domains: 0
                <?php else: ?>
                    <table class="linkages-table">
                        <thead>
                            <tr>
                                <td>Domain</td><td>Count</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $outbound_domains as $od ) : ?>
                                <tr><td><?php echo $od->domain; ?></td><td><?php echo $od->count; ?></td></tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div><!-- ./wrap -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const link_report = document.getElementById('linkReport');

        new Chart(link_report, {
        type: 'doughnut',
        data: {
        labels: [
                    'Correct Internal Links' + '(' + <?php echo $num_internal_link - $num_internal_404; ?> + ')',
                    'Faulty Internal Links' + '(' + <?php echo $num_internal_404; ?> + ')',
                    'Correct Internal Links' + '(' + <?php echo $num_outbound_link - $num_outbound_404; ?> + ')',
                    'Faulty Internal Links' + '(' + <?php echo $num_outbound_404; ?> + ')',

                ],
        datasets: [{
            label: 'out of ' + <?php echo $num_total_link; ?> + ' Links',
            data: [
                    <?php echo $num_internal_link - $num_internal_404; ?>,
                    <?php echo $num_internal_404; ?>,
                    <?php echo $num_outbound_link - $num_outbound_404; ?>,
                    <?php echo $num_outbound_404; ?>
                ],
            borderWidth: 1
        }]
        },
        });
        
        
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
        type: 'doughnut',
        data: {
        labels: ['Internal Links' + '(' + <?php echo $num_internal_link; ?> + ')', 'Outbound Links' + '(' + <?php echo $num_outbound_link; ?> + ')'],
        datasets: [{
            label: 'out of ' + <?php echo $num_total_link; ?> + ' Links',
            data: [<?php echo $num_internal_link; ?>, <?php echo $num_outbound_link; ?>],
            borderWidth: 2
        }]
        },
        });


        const outbound404 = document.getElementById('outbound404');

        new Chart(outbound404, {
            type: 'pie',
            data: {
            labels: ['Total Outbound Links' + '(' + <?php echo $num_outbound_link; ?> + ')', 'Number of 404 Outbound Links' + '(' + <?php echo $num_outbound_404; ?> + ')'],
            datasets: [{
                label: 'out of ' + <?php echo $num_outbound_link; ?> + ' Links',
                data: [<?php echo $num_outbound_link; ?>, <?php echo $num_outbound_404; ?>],
                borderWidth: 2
            }]
            },

        });


        const internal404 = document.getElementById('internal404');

        new Chart(internal404, {
            type: 'pie',
            data: {
            labels: ['Total Internal Links' + '(' + <?php echo $num_internal_link; ?> + ')', 'Number of 404 Internal Links' + '(' + <?php echo $num_internal_404; ?> + ')'],
            datasets: [{
                label: 'out of ' + <?php echo $num_internal_link; ?> + ' Links',
                data: [<?php echo $num_internal_link; ?>, <?php echo $num_internal_404; ?>],
                borderWidth: 2
            }]
            },
        });

        const orphanLinks = document.getElementById('orphanLinks');

        new Chart(orphanLinks, {
            type: 'pie',
            data: {
            labels: ['Posts with Interlinks' + '(' + <?php echo $num_all_posts - $num_orphan; ?> + ')', 'Number of Orphan Posts' + '(' + <?php echo $num_orphan; ?> + ')'],
            datasets: [{
                label: 'out of ' + <?php echo $num_all_posts; ?> + ' Links',
                data: [<?php echo $num_all_posts - $num_orphan; ?>, <?php echo $num_orphan; ?>],
                borderWidth: 2
            }]
            },
        });

    </script>


<?php endif; ?>

</div>

<?php
}