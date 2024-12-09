<?php 

// Register SiteMaps CPT
function cps_register_sitemaps_cpt() {
    $labels = array(
        'name'               => 'SiteMaps',
        'singular_name'      => 'SiteMap',
        'menu_name'          => 'SiteMaps',
        'name_admin_bar'     => 'SiteMap',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New SiteMap',
        'new_item'           => 'New SiteMap',
        'edit_item'          => 'Edit SiteMap',
        'view_item'          => 'View SiteMap',
        'all_items'          => 'All SiteMaps',
        'search_items'       => 'Search SiteMaps',
        'not_found'          => 'No SiteMaps found.',
        'not_found_in_trash' => 'No SiteMaps found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'site-maps'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'supports'           => array('title', 'editor'),
    );

    register_post_type('site-maps', $args);
}
add_action('init', 'cps_register_sitemaps_cpt');