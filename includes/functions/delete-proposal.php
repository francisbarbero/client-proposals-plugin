<?php

// Handle delete proposal action
function cps_delete_proposal_action() {
    if (isset($_GET['delete_proposal'])) {
        $proposal_id = intval($_GET['delete_proposal']);

        // Check if the proposal exists and delete it
        if (get_post_type($proposal_id) === 'proposal') {
            wp_delete_post($proposal_id, true);
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('init', 'cps_delete_proposal_action');