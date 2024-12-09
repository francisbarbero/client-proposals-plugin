<?php 

function cps_register_terms_conditions_cpt() {
    $labels = array(
        'name'               => _x( 'Terms and Conditions', 'post type general name', 'cps' ),
        'singular_name'      => _x( 'Terms and Condition', 'post type singular name', 'cps' ),
        'menu_name'          => _x( 'Terms & Conditions', 'admin menu', 'cps' ),
        'name_admin_bar'     => _x( 'Terms & Condition', 'add new on admin bar', 'cps' ),
        'add_new'            => _x( 'Add New', 'terms condition', 'cps' ),
        'add_new_item'       => __( 'Add New Terms & Condition', 'cps' ),
        'new_item'           => __( 'New Terms & Condition', 'cps' ),
        'edit_item'          => __( 'Edit Terms & Condition', 'cps' ),
        'view_item'          => __( 'View Terms & Condition', 'cps' ),
        'all_items'          => __( 'All Terms & Conditions', 'cps' ),
        'search_items'       => __( 'Search Terms & Conditions', 'cps' ),
        'not_found'          => __( 'No terms and conditions found.', 'cps' ),
        'not_found_in_trash' => __( 'No terms and conditions found in Trash.', 'cps' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'terms-condition' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
    );

    register_post_type( 'terms_condition', $args );
}

