<?php 
/**
 * Plugin Name: Niko Sum Custom Post Type and Taxonomies
 * Description: A simple plugin that adds custom post types and taxonomies
 * Version 0.1
 * Author: Niko Sum
 * License: GPL2
 **/

function my_custom_posttypes() {

    // Testimonials
    $labels = array(
        'name'               => 'Testimonials',
        'singular_name'      => 'Testimonial',
        'menu_name'          => 'Testimonials',
        'name_admin_bar'     => 'Testimonial',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Testimonial',
        'new_item'           => 'New Testimonial',
        'edit_item'          => 'Edit Testimonial',
        'view_item'          => 'View Testimonial',
        'all_items'          => 'All Testimonials',
        'search_items'       => 'Search Testimonials',
        'parent_item_colon'  => 'Parent Testimonials:',
        'not_found'          => 'No testimonials found.',
        'not_found_in_trash' => 'No testimonials found in Trash.',
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-id-alt',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'testimonials' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type('testimonials', $args);

    // Reviews
    $labels = array(
        'name'               => 'Reviews',
        'singular_name'      => 'Review',
        'menu_name'          => 'Reviews',
        'name_admin_bar'     => 'Review',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Review',
        'new_item'           => 'New Review',
        'edit_item'          => 'Edit Review',
        'view_item'          => 'View Review',
        'all_items'          => 'All Reviews',
        'search_items'       => 'Search Reviews',
        'parent_item_colon'  => 'Parent Reviews:',
        'not_found'          => 'No reviews found.',
        'not_found_in_trash' => 'No reviews found in Trash.',
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-star-half',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'reviews' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'author', 'excerpt', 'comments' ),
        'taxonomies'         => array('category', 'post_tag')
    );
    register_post_type('reviews', $args);
}
add_action('init', 'my_custom_posttypes');

function my_rewrite_flush() {

    my_custom_posttypes();

    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'my_rewrite_flush');

function my_custom_taxonomies() {
     // Type of Product/Service taxonomy
     $labels = array(
        'name'              => 'Type of Products/Services',
        'singular_name'     => 'Type of Product/Service',
        'search_items'      => 'Search Types of Products/Services',
        'all_items'         => 'All Types of Products/Services',
        'parent_item'       => 'Parent Type of Product/Service',
        'parent_item_colon' => 'Parent Type of Product/Service:',
        'edit_item'         => 'Edit Type of Product/Service',
        'update_item'       => 'Update Type of Product/Service',
        'add_new_item'      => 'Add New Type of Product/Service',
        'new_item_name'     => 'New Type of Product/Service Name',
        'menu_name'         => 'Type of Product/Service',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'product-types' ),
    );

    register_taxonomy( 'product-type', array( 'reviews' ), $args );

    $labels = array(
        'name'              => 'Price Ranges',
        'singular_name'     => 'Price Range',
        'search_items'      => 'Search Price Ranges',
        'all_items'         => 'All Price Ranges',
        'parent_item'       => 'Parent Price Range',
        'parent_item_colon' => 'Parent Price Ranges:',
        'edit_item'         => 'Edit Price Ranges',
        'update_item'       => 'Update Price Ranges',
        'add_new_item'      => 'Add New Price Ranges',
        'new_item_name'     => 'New Price Ranges Name',
        'menu_name'         => 'Price Ranges',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'prices' ),
    );

    register_taxonomy( 'price', array( 'reviews' ), $args );

    // Mood taxonomy (non-hierarchical)
    $labels = array(
        'name'                       => 'Moods',
        'singular_name'              => 'Mood',
        'search_items'               => 'Search Moods',
        'popular_items'              => 'Popular Moods',
        'all_items'                  => 'All Moods',
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit Mood',
        'update_item'                => 'Update Mood',
        'add_new_item'               => 'Add New Mood',
        'new_item_name'              => 'New Mood Name',
        'separate_items_with_commas' => 'Separate moods with commas',
        'add_or_remove_items'        => 'Add or remove moods',
        'choose_from_most_used'      => 'Choose from the most used moods',
        'not_found'                  => 'No moods found.',
        'menu_name'                  => 'Moods',
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'moods' ),
    );

    register_taxonomy( 'mood', array( 'reviews', 'post' ), $args );
}
add_action('init', 'my_custom_taxonomies');