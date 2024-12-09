<?php

function cps_register_cost_breakdowns_cpt() {
    $labels = array(
        'name'               => _x( 'Cost Breakdowns', 'post type general name', 'cps' ),
        'singular_name'      => _x( 'Cost Breakdown', 'post type singular name', 'cps' ),
        'menu_name'          => _x( 'Cost Breakdowns', 'admin menu', 'cps' ),
        'name_admin_bar'     => _x( 'Cost Breakdown', 'add new on admin bar', 'cps' ),
        'add_new'            => _x( 'Add New', 'cost breakdown', 'cps' ),
        'add_new_item'       => __( 'Add New Cost Breakdown', 'cps' ),
        'new_item'           => __( 'New Cost Breakdown', 'cps' ),
        'edit_item'          => __( 'Edit Cost Breakdown', 'cps' ),
        'view_item'          => __( 'View Cost Breakdown', 'cps' ),
        'all_items'          => __( 'All Cost Breakdowns', 'cps' ),
        'search_items'       => __( 'Search Cost Breakdowns', 'cps' ),
        'not_found'          => __( 'No cost breakdowns found.', 'cps' ),
        'not_found_in_trash' => __( 'No cost breakdowns found in Trash.', 'cps' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'cost-breakdown' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
    );

    register_post_type( 'cost_breakdown', $args );

}
