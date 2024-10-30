<?php
// Register Custom Post Type Portfolio
function create_portfolio_cpt() {

	$labels = array(
		'name' => _x( 'Portfolio', 'Post Type General Name', 'gdp' ),
		'singular_name' => _x( 'Portfolio', 'Post Type Singular Name', 'gdp' ),
		'menu_name' => _x( 'Portfolio', 'Admin Menu text', 'gdp' ),
		'name_admin_bar' => _x( 'Portfolio', 'Add New on Toolbar', 'gdp' ),
		'archives' => __( 'Portfolio Archives', 'gdp' ),
		'attributes' => __( 'Portfolio Attributes', 'gdp' ),
		'parent_item_colon' => __( 'Parent Portfolio:', 'gdp' ),
		'all_items' => __( 'All Portfolio', 'gdp' ),
		'add_new_item' => __( 'Add New Portfolio', 'gdp' ),
		'add_new' => __( 'Add New', 'gdp' ),
		'new_item' => __( 'New Portfolio', 'gdp' ),
		'edit_item' => __( 'Edit Portfolio', 'gdp' ),
		'update_item' => __( 'Update Portfolio', 'gdp' ),
		'view_item' => __( 'View Portfolio', 'gdp' ),
		'view_items' => __( 'View Portfolio', 'gdp' ),
		'search_items' => __( 'Search Portfolio', 'gdp' ),
		'not_found' => __( 'Not found', 'gdp' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'gdp' ),
		'featured_image' => __( 'Featured Image', 'gdp' ),
		'set_featured_image' => __( 'Set featured image', 'gdp' ),
		'remove_featured_image' => __( 'Remove featured image', 'gdp' ),
		'use_featured_image' => __( 'Use as featured image', 'gdp' ),
		'insert_into_item' => __( 'Insert into Portfolio', 'gdp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Portfolio', 'gdp' ),
		'items_list' => __( 'Portfolio list', 'gdp' ),
		'items_list_navigation' => __( 'Portfolio list navigation', 'gdp' ),
		'filter_items_list' => __( 'Filter Portfolio list', 'gdp' ),
	);
	$args = array(
		'label' => __( 'Portfolio', 'gdp' ),
		'description' => __( '', 'gdp' ),
		'labels' => $labels,
		'menu_icon' => '',
		'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
		'taxonomies' => array('portfolio_category'),
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
	register_post_type( 'portfolio', $args );

}
add_action( 'init', 'create_portfolio_cpt', 0 );

// Register Taxonomy Portfolio Category
function create_portfoliocategory_tax() {

	$labels = array(
		'name'              => _x( 'Portfolio Category', 'taxonomy general name', 'gdp' ),
		'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name', 'gdp' ),
		'search_items'      => __( 'Search Portfolio Category', 'gdp' ),
		'all_items'         => __( 'All Portfolio Category', 'gdp' ),
		'parent_item'       => __( 'Parent Portfolio Category', 'gdp' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:', 'gdp' ),
		'edit_item'         => __( 'Edit Portfolio Category', 'gdp' ),
		'update_item'       => __( 'Update Portfolio Category', 'gdp' ),
		'add_new_item'      => __( 'Add New Portfolio Category', 'gdp' ),
		'new_item_name'     => __( 'New Portfolio Category Name', 'gdp' ),
		'menu_name'         => __( 'Portfolio Category', 'gdp' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( '', 'gdp' ),
		'hierarchical' => false,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
	);
	register_taxonomy( 'portfolio_category', array('portfolio'), $args );

}
add_action( 'init', 'create_portfoliocategory_tax' );