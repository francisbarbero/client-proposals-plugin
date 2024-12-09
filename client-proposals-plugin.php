<?php
/**
 * Plugin Name: Client Proposals System
 * Plugin URI: https://yourwebsite.com/
 * Description: A custom plugin to manage client proposals, cost breakdowns, and more.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com/
 * License: GPL2
 */

// If this file is called directly, abort to ensure security.
if ( ! defined( 'WPINC' ) ) {
    die; // Prevent direct access to the file.
}

// Define Plugin Directory
// This defines the directory path for the plugin, which will be used for including other files.
define( 'CPS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Include CPT and Functions Files
// These files contain the definitions for Custom Post Types (CPTs) and other plugin functionalities.

// ----------------------------- START OF INCLUDES -----------------------------

// Include Schema Files
require_once CPS_PLUGIN_DIR . 'includes/schema/proposals-schema.php'; // Schema for proposals

// Include CPT Files
require_once CPS_PLUGIN_DIR . 'includes/cpt/proposals.php'; // CPT for proposals
require_once CPS_PLUGIN_DIR . 'includes/cpt/cost-breakdowns.php'; // CPT for cost breakdowns
require_once CPS_PLUGIN_DIR . 'includes/cpt/site-maps.php'; // CPT for sample page sitemaps
require_once CPS_PLUGIN_DIR . 'includes/cpt/terms-conditions.php'; // CPT for terms and conditions
require_once CPS_PLUGIN_DIR . 'includes/cpt/payment-schedules.php'; // CPT for payment schedules

// Include Meta Box Functions
require_once CPS_PLUGIN_DIR . 'includes/admin/proposal-meta-boxes.php';


// Include Frontend Functions
require_once CPS_PLUGIN_DIR . 'includes/functions/list-proposals.php'; // Functions to list proposals
require_once CPS_PLUGIN_DIR . 'includes/functions/edit-proposal.php'; // Functions to edit proposals
require_once CPS_PLUGIN_DIR . 'includes/functions/print-proposal.php'; // Functions to print proposals as PDF
require_once CPS_PLUGIN_DIR . 'includes/functions/add-proposal.php'; // Functions to add new proposals
require_once CPS_PLUGIN_DIR . 'includes/functions/delete-proposal.php'; // Functions to delete proposals

// ------------------------------ END OF INCLUDES ------------------------------




// Plugin Activation Hook
// This function runs when the plugin is activated.
function cps_activate_plugin() {
    // Trigger Custom Post Types registration during activation
    // This ensures that CPTs are registered before flushing rewrite rules.
    cps_register_proposals_cpt();
    cps_register_cost_breakdowns_cpt();
    cps_register_sitemaps_cpt();
    cps_register_terms_conditions_cpt();
    cps_register_payment_schedules_cpt();
    
    // Flush rewrite rules to avoid 404 errors on CPTs after activation.
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'cps_activate_plugin' );

// Plugin Deactivation Hook
// This function runs when the plugin is deactivated.
function cps_deactivate_plugin() {
    // Flush rewrite rules to remove CPT permalinks
    // This ensures that permalinks related to the CPTs are removed properly.
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'cps_deactivate_plugin' );

// Load Custom Post Types during Init
// This function ensures that the CPTs are registered during WordPress initialization.
function cps_init_custom_post_types() {
    cps_register_proposals_cpt(); // Register Proposals CPT
    cps_register_cost_breakdowns_cpt(); // Register Cost Breakdowns CPT
    cps_register_sitemaps_cpt(); // Register SiteMap CPT
    cps_register_terms_conditions_cpt(); // Register Terms and Conditions CPT
    cps_register_payment_schedules_cpt(); // Register Payment Schedules CPT
}
// Attach the custom post type registration to the 'init' action hook.
add_action( 'init', 'cps_init_custom_post_types' );