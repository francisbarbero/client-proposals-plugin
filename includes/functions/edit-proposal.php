<?php


/**
 * Shortcode to render the edit proposal form.
 */
function cps_render_edit_proposal_form() {
    if (!isset($_GET['proposal_id'])) {
        return '<p>No proposal ID provided.</p>';
    }

    $proposal_id = intval($_GET['proposal_id']);

    // Get the proposal data
    $proposal = get_post($proposal_id);

    if (!$proposal || $proposal->post_type !== 'proposal') {
        return '<p>Invalid proposal ID.</p>';
    }

    // Get proposal meta fields
    $meta_fields = get_post_meta($proposal_id);

    var_dump($meta_fields);

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and update the proposal
        $validation_errors = cps_validate_proposal_form($_POST);

        if (empty($validation_errors)) {
            // Update the proposal title and content
            wp_update_post(array(
                'ID'           => $proposal_id,
                'post_title'   => sanitize_text_field($_POST['post_title']),
                'post_content' => sanitize_textarea_field($_POST['post_content']),
            ));

            // Update meta fields
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'meta_') === 0) { // Only process meta fields
                    update_post_meta($proposal_id, substr($key, 5), sanitize_text_field($value));
                }
            }

            echo '<p>Proposal updated successfully!</p>';
        } else {
            foreach ($validation_errors as $error) {
                echo '<p class="error">' . esc_html($error) . '</p>';
            }
        }
    }

    ob_start();

    // Render the form
    ?>
    <form method="POST" class="cps-edit-proposal-form">
        <div class="form-group">
            <label for="post_title">Proposal Title</label>
            <input type="text" id="post_title" name="post_title" value="<?php echo esc_attr($proposal->post_title); ?>" required>
        </div>
        <div class="form-group">
            <label for="post_content">Proposal Description</label>
            <textarea id="post_content" name="post_content" required><?php echo esc_textarea($proposal->post_content); ?></textarea>
        </div>

        <?php foreach ($meta_fields as $key => $value) : ?>
            <div class="form-group">
                <label for="meta_<?php echo esc_attr($key); ?>"><?php echo esc_html(ucwords(str_replace('_', ' ', $key))); ?></label>
                <input type="text" id="meta_<?php echo esc_attr($key); ?>" name="meta_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value[0]); ?>">
            </div>
        <?php endforeach; ?>

        <button type="submit" class="button">Save Changes</button>
    </form>
    <?php

    return ob_get_clean();
}
add_shortcode('cps_edit_proposal', 'cps_render_edit_proposal_form');

/**
 * Validate proposal form input.
 *
 * @param array $data The submitted form data.
 * @return array List of validation errors.
 */
function cps_validate_proposal_form($data) {
    $errors = [];

    if (empty($data['post_title'])) {
        $errors[] = 'The proposal title is required.';
    }

    if (empty($data['post_content'])) {
        $errors[] = 'The proposal description is required.';
    }

    return $errors;
}



function debug_proposal_meta($proposal_id) {
    $meta_data = get_post_meta($proposal_id);
    echo '<pre>';
    print_r($meta_data);
    echo '</pre>';
}
add_action('wp_footer', function() {
    if (isset($_GET['proposal_id'])) {
        debug_proposal_meta(intval($_GET['proposal_id']));
    }
});