<?php
// ------------------------ START OF FILE: proposal-meta-boxes.php ------------------------

/**
 * This file sets up and manages the proposal meta box for the `proposal` CPT.
 */

// Require the proposals schema file (if not already included by the main plugin file).
// Adjust the path as necessary based on your plugin structure.
// require_once plugin_dir_path(__FILE__) . '../schema/proposals-schema.php';

function cps_register_meta_boxes() {
    add_meta_box(
        'proposal_meta_box',
        __('Proposal Details', 'cps'),
        'cps_render_meta_box',
        'proposal', // Ensure this matches the CPT slug registered in proposals.php
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'cps_register_meta_boxes');

/**
 * Render the meta box fields.
 */
function cps_render_meta_box($post) {
    // Use nonce for verification
    wp_nonce_field('cps_save_meta_box', 'cps_meta_box_nonce');

    // Load the schema
    $schema = cps_get_proposal_schema();

    // Retrieve existing metadata
    $meta = get_post_meta($post->ID, 'cps_proposal_meta', true);
    $meta = is_array($meta) ? $meta : [];

    echo '<table class="form-table">';
    foreach ($schema as $field_key => $field) {
        $value = isset($meta[$field_key]) ? $meta[$field_key] : '';
        echo '<tr>';
        echo '<th><label for="' . esc_attr($field_key) . '">' . esc_html($field['label']) . '</label></th>';
        echo '<td>';
        cps_render_meta_box_field($field_key, $field, $value);
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';

    // Include the JavaScript for adding/removing group rows
    cps_add_group_field_script();
}

/**
 * Render individual fields based on their type.
 */
function cps_render_meta_box_field($field_key, $field, $value) {
    switch ($field['type']) {
        case 'text':
            echo '<input type="text" id="' . esc_attr($field_key) . '" name="cps_proposal_meta[' . esc_attr($field_key) . ']" value="' . esc_attr($value) . '" class="regular-text">';
            break;

        case 'textarea':
            echo '<textarea id="' . esc_attr($field_key) . '" name="cps_proposal_meta[' . esc_attr($field_key) . ']" rows="5" class="large-text">' . esc_textarea($value) . '</textarea>';
            break;

        case 'number':
            echo '<input type="number" id="' . esc_attr($field_key) . '" name="cps_proposal_meta[' . esc_attr($field_key) . ']" value="' . esc_attr($value) . '" class="small-text">';
            break;

        case 'select':
            echo '<select id="' . esc_attr($field_key) . '" name="cps_proposal_meta[' . esc_attr($field_key) . ']">';
            foreach ($field['options'] as $option_value => $option_label) {
                echo '<option value="' . esc_attr($option_value) . '"' . selected($value, $option_value, false) . '>' . esc_html($option_label) . '</option>';
            }
            echo '</select>';
            break;

        case 'checkbox':
            echo '<input type="checkbox" id="' . esc_attr($field_key) . '" name="cps_proposal_meta[' . esc_attr($field_key) . ']" value="1"' . checked($value, 1, false) . '>';
            break;

        case 'group':
            if (isset($field['fields']) && is_array($field['fields'])) {
                // Render group fields (repeater-like)
                echo '<div class="cps-group-fields">';
                echo '<button type="button" class="button add-group-row">' . esc_html($field['add_button_label'] ?? 'Add Row') . '</button>';
                
                if (is_array($value) && !empty($value)) {
                    foreach ($value as $index => $group_values) {
                        cps_render_group_fields($field['fields'], $group_values, $index, $field_key);
                    }
                } else {
                    // Render an initial empty row if no data
                    cps_render_group_fields($field['fields'], [], 0, $field_key);
                }
                echo '</div>';
            }
            break;

        default:
            echo '<p>Unsupported field type: ' . esc_html($field['type']) . '</p>';
            break;
    }

    if (!empty($field['description'])) {
        echo '<p class="description">' . esc_html($field['description']) . '</p>';
    }
}

/**
 * Render a single set of group fields (one row).
 */

function cps_render_group_fields($fields, $values, $index, $parent_key) {
    echo '<div class="cps-group-row" style="margin-bottom:20px; border:1px solid #ccc; padding:10px;">';

    foreach ($fields as $sub_key => $sub_field) {
        $field_value = isset($values[$sub_key]) ? $values[$sub_key] : '';
        
        // Build the correct name attribute with full nested indexing:
        $field_name = 'cps_proposal_meta[' . $parent_key . '][' . $index . '][' . $sub_key . ']';

        // Render the field with a new helper function that doesn't add `cps_proposal_meta[]` again
        cps_render_meta_box_subfield($field_name, $sub_field, $field_value);
    }

    echo '<button type="button" class="button remove-group-row">' . esc_html__('Remove', 'cps') . '</button>';
    echo '</div>';
}

function cps_render_meta_box_subfield($name, $field, $value) {
    // Determine input type and print accordingly. 
    // Note: Do not prepend 'cps_proposal_meta[]' here since $name already includes it.
    switch ($field['type']) {
        case 'text':
            echo '<input type="text" name="' . esc_attr($name) . '" value="' . esc_attr($value) . '" class="regular-text">';
            break;

        case 'textarea':
            echo '<textarea name="' . esc_attr($name) . '" rows="5" class="large-text">' . esc_textarea($value) . '</textarea>';
            break;

        case 'number':
            echo '<input type="number" name="' . esc_attr($name) . '" value="' . esc_attr($value) . '" class="small-text">';
            break;

        // Add handling for other field types if needed

        default:
            echo '<p>Unsupported field type: ' . esc_html($field['type']) . '</p>';
            break;
    }

    if (!empty($field['description'])) {
        echo '<p class="description">' . esc_html($field['description']) . '</p>';
    }
}


/**
 * Save the meta box data when the post is saved.
 */
function cps_save_meta_box($post_id) {
    // Check nonce
    if (!isset($_POST['cps_meta_box_nonce']) || !wp_verify_nonce($_POST['cps_meta_box_nonce'], 'cps_save_meta_box')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save metadata
    if (isset($_POST['cps_proposal_meta'])) {
        $meta = cps_sanitize_meta($_POST['cps_proposal_meta']);
        update_post_meta($post_id, 'cps_proposal_meta', $meta);
    }
}
add_action('save_post', 'cps_save_meta_box');

/**
 * Recursively sanitize metadata arrays.
 */
function cps_sanitize_meta($meta) {
    foreach ($meta as $key => $value) {
        if (is_array($value)) {
            $meta[$key] = cps_sanitize_meta($value);
        } else {
            $meta[$key] = sanitize_text_field($value);
        }
    }
    return $meta;
}

/**
 * Add the JavaScript snippet for handling add/remove group rows.
 */
function cps_add_group_field_script() {
    ?>
    <script>
        (function($) {
            $(document).ready(function() {
                $(document).on('click', '.add-group-row', function() {
                    var $container = $(this).closest('.cps-group-fields');
                    var $lastRow = $container.find('.cps-group-row').last().clone();

                    // Clear the values of input, textarea, and select fields
                    $lastRow.find('input[type="text"], input[type="number"], textarea, select').val('');

                    // Increment the index for the new row
                    var regex = new RegExp('(\\[\\d+\\])', 'g');
                    var lastIndexMatch = $container.find('.cps-group-row').last().find('input, textarea, select').first().attr('name').match(/(\d+)/);
                    var newIndex = lastIndexMatch ? parseInt(lastIndexMatch[0]) + 1 : 1;

                    // Update the field names with the new index
                    $lastRow.find('input, textarea, select').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            var updatedName = name.replace(/\[\d+\]/, '[' + newIndex + ']');
                            $(this).attr('name', updatedName);
                            $(this).attr('id', updatedName);
                        }
                    });

                    // Append the new row
                    $container.append($lastRow);
                });

                $(document).on('click', '.remove-group-row', function() {
                    var $row = $(this).closest('.cps-group-row');
                    var $container = $row.closest('.cps-group-fields');
                    // Only remove if there's more than one row
                    if ($container.find('.cps-group-row').length > 1) {
                        $row.remove();
                    } else {
                        // If only one row, just clear the values instead of removing
                        $row.find('input[type="text"], input[type="number"], textarea, select').val('');
                    }
                });
            });
        })(jQuery);
    </script>
    <?php
}

// ------------------------- END OF FILE: proposal-meta-boxes.php -------------------------
