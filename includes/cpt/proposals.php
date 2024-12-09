<?php


// Register Proposals Custom Post Type
function cps_register_proposals_cpt() {
    $labels = array(
        'name'               => _x( 'Proposals', 'post type general name', 'cps' ),
        'singular_name'      => _x( 'Proposal', 'post type singular name', 'cps' ),
        'menu_name'          => _x( 'Proposals', 'admin menu', 'cps' ),
        'name_admin_bar'     => _x( 'Proposal', 'add new on admin bar', 'cps' ),
        'add_new'            => _x( 'Add New', 'proposal', 'cps' ),
        'add_new_item'       => __( 'Add New Proposal', 'cps' ),
        'new_item'           => __( 'New Proposal', 'cps' ),
        'edit_item'          => __( 'Edit Proposal', 'cps' ),
        'view_item'          => __( 'View Proposal', 'cps' ),
        'all_items'          => __( 'All Proposals', 'cps' ),
        'search_items'       => __( 'Search Proposals', 'cps' ),
        'not_found'          => __( 'No proposals found.', 'cps' ),
        'not_found_in_trash' => __( 'No proposals found in Trash.', 'cps' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'proposal' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
    );

    register_post_type( 'proposal', $args );
}
