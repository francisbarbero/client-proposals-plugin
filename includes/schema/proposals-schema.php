<?php
// ------------------------ START OF FILE: proposals-schema.php ------------------------

/**
 * Proposal Schema
 * Defines all fields for the Proposal CPT.
 *
 * Note: 'repeater' is not a native WordPress field type. This is a conceptual label.
 * We will manually handle these fields in the meta box code.
 */

function cps_get_proposal_schema() {
    return [
        'client_name' => [
            'type'        => 'text',
            'label'       => 'Client Name',
            'description' => 'The name of the client for this proposal.',
            'required'    => true,
            'sanitize_callback' => 'sanitize_text_field',
        ],
        'project_description' => [
            'type'        => 'textarea',
            'label'       => 'Project Description',
            'description' => 'A brief description of the project.',
            'required'    => false,
            'sanitize_callback' => 'sanitize_textarea_field',
        ],
        'cost_breakdowns' => [
            'type'        => 'group', // Changed from 'group' to 'repeater'
            'label'       => 'Cost Breakdown',
            'description' => 'A breakdown of the costs for the project.',
            'add_button_label' => 'Add Cost Line',
            'remove_button_label' => 'Remove',
            'fields' => [
                'product' => [
                    'type'              => 'text',
                    'label'             => 'Product/Service',
                    'required'          => true,
                    'sanitize_callback' => 'sanitize_text_field',
                ],
                'description' => [
                    'type'              => 'textarea',
                    'label'             => 'Description',
                    'required'          => false,
                    'sanitize_callback' => 'sanitize_textarea_field',
                ],
                'cost' => [
                    'type'              => 'number',
                    'label'             => 'Cost',
                    'required'          => true,
                    'sanitize_callback' => 'floatval',
                ],
            ],
        ],
        'payment_schedule' => [
            'type'        => 'textarea',
            'label'       => 'Payment Schedule',
            'description' => 'Details about the payment schedule or terms.',
            'required'    => false,
            'sanitize_callback' => 'sanitize_textarea_field',
        ],
        'terms_conditions' => [
            'type'        => 'select',
            'label'       => 'Terms and Conditions',
            'description' => 'Select the terms and conditions applicable to this proposal.',
            'options'     => [
                'standard' => 'Standard Terms',
                'custom'   => 'Custom Terms',
            ],
            'required'    => false,
            'sanitize_callback' => 'sanitize_text_field',
        ],
    ];
}

// ------------------------- END OF FILE: proposals-schema.php -------------------------
