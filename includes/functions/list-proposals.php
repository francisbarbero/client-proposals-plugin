<?php

// Shortcode to display frontend table view of proposals
function cps_display_proposals_table() {
    // Query all proposals
    $query = new WP_Query(array(
        'post_type'      => 'proposal',
        'post_status'    => array('draft', 'publish'),
        'posts_per_page' => -1, // Display all proposals (update if pagination is needed)
    ));

    // Start output buffer
    ob_start();

    // Table styling
    echo '<style>
        .cps-proposals-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .cps-proposals-table th, .cps-proposals-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .cps-proposals-table th {
            background-color: #f4f4f4;
            text-align: left;
        }
        .cps-proposals-table tr:hover {
            background-color: #f1f1f1;
        }
    </style>';

    // Check if there are any proposals
    if ($query->have_posts()) {
        echo '<table class="cps-proposals-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Title</th>';
        echo '<th>Status</th>';
        echo '<th>Created</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Loop through proposals
        while ($query->have_posts()) {
            $query->the_post();

            $proposal_id = get_the_ID();
            $title = get_the_title();
            $status = get_post_status($proposal_id);
            $created_date = get_the_date('Y-m-d', $proposal_id);
            $edit_link = add_query_arg(array('proposal_id' => $proposal_id), home_url('/edit-proposal/'));
            $delete_link = add_query_arg(array('delete_proposal' => $proposal_id), home_url('/'));

            echo '<tr>';
            echo '<td>' . esc_html($title) . '</td>';
            echo '<td>' . esc_html($status) . '</td>';
            echo '<td>' . esc_html($created_date) . '</td>';
            echo '<td>';
            echo '<a href="' . esc_url($edit_link) . '" class="button">Edit</a> ';
            echo '<a href="' . esc_url($delete_link) . '" class="button" onclick="return confirm(\'Are you sure you want to delete this proposal?\')">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No proposals found.</p>';
    }

    // Reset post data
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('cps_proposals_table', 'cps_display_proposals_table');
