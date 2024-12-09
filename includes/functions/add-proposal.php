<?php

// Function to add a new proposal when triggered by a GET request
function cps_add_new_proposal_via_get() {
    if (isset($_GET['add_proposal']) && $_GET['add_proposal'] == '1') {
        // Insert new proposal post with a default title "New Proposal"
        $proposal_id = wp_insert_post(array(
            'post_title'    => 'New Proposal',
            'post_content'  => '',
            'post_status'   => 'draft', // Save as draft initially
            'post_type'     => 'proposal',
            'post_author'   => 0 // Author ID 0 since we are not requiring login
        ));

        // Check for errors
        if (!is_wp_error($proposal_id)) {
            // Redirect back to the homepage
            wp_redirect(home_url());
            exit;
        }
    }
}
add_action('init', 'cps_add_new_proposal_via_get');

// Shortcode to display the "Add New Proposal" button
function cps_add_new_proposal_button() {
    // Display button to add new proposal
    ob_start();
    ?>
    <a href="?add_proposal=1" class="button">Add New Proposal</a>
    <?php
    return ob_get_clean();
}
add_shortcode('cps_add_proposal_button', 'cps_add_new_proposal_button');
