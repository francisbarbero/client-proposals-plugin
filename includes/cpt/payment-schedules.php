<?php 

function cps_register_payment_schedules_cpt() {
    $labels = array(
        'name'               => _x( 'Payment Schedules', 'post type general name', 'cps' ),
        'singular_name'      => _x( 'Payment Schedule', 'post type singular name', 'cps' ),
        'menu_name'          => _x( 'Payment Schedules', 'admin menu', 'cps' ),
        'name_admin_bar'     => _x( 'Payment Schedule', 'add new on admin bar', 'cps' ),
        'add_new'            => _x( 'Add New', 'payment schedule', 'cps' ),
        'add_new_item'       => __( 'Add New Payment Schedule', 'cps' ),
        'new_item'           => __( 'New Payment Schedule', 'cps' ),
        'edit_item'          => __( 'Edit Payment Schedule', 'cps' ),
        'view_item'          => __( 'View Payment Schedule', 'cps' ),
        'all_items'          => __( 'All Payment Schedules', 'cps' ),
        'search_items'       => __( 'Search Payment Schedules', 'cps' ),
        'not_found'          => __( 'No payment schedules found.', 'cps' ),
        'not_found_in_trash' => __( 'No payment schedules found in Trash.', 'cps' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'payment-schedule' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
    );

    register_post_type( 'payment_schedule', $args );
}
