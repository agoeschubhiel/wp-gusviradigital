<?php
// Register Custom Post Type Service
function create_service_cpt() {

	$labels = array(
		'name' => _x( 'Service', 'Post Type General Name', 'gdp' ),
		'singular_name' => _x( 'Service', 'Post Type Singular Name', 'gdp' ),
		'menu_name' => _x( 'Service', 'Admin Menu text', 'gdp' ),
		'name_admin_bar' => _x( 'Service', 'Add New on Toolbar', 'gdp' ),
		'archives' => __( 'Service Archives', 'gdp' ),
		'attributes' => __( 'Service Attributes', 'gdp' ),
		'parent_item_colon' => __( 'Parent Service:', 'gdp' ),
		'all_items' => __( 'All Service', 'gdp' ),
		'add_new_item' => __( 'Add New Service', 'gdp' ),
		'add_new' => __( 'Add New', 'gdp' ),
		'new_item' => __( 'New Service', 'gdp' ),
		'edit_item' => __( 'Edit Service', 'gdp' ),
		'update_item' => __( 'Update Service', 'gdp' ),
		'view_item' => __( 'View Service', 'gdp' ),
		'view_items' => __( 'View Service', 'gdp' ),
		'search_items' => __( 'Search Service', 'gdp' ),
		'not_found' => __( 'Not found', 'gdp' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'gdp' ),
		'featured_image' => __( 'Featured Image', 'gdp' ),
		'set_featured_image' => __( 'Set featured image', 'gdp' ),
		'remove_featured_image' => __( 'Remove featured image', 'gdp' ),
		'use_featured_image' => __( 'Use as featured image', 'gdp' ),
		'insert_into_item' => __( 'Insert into Service', 'gdp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Service', 'gdp' ),
		'items_list' => __( 'Service list', 'gdp' ),
		'items_list_navigation' => __( 'Service list navigation', 'gdp' ),
		'filter_items_list' => __( 'Filter Service list', 'gdp' ),
	);
	$args = array(
		'label' => __( 'Service', 'gdp' ),
		'description' => __( '', 'gdp' ),
		'labels' => $labels,
		'menu_icon' => '',
		'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'service', $args );

}
add_action( 'init', 'create_service_cpt', 0 );