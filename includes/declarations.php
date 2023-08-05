<?php 


//Define book Post Type
function custom_post_type_book() {
    $labels = array(
        'name' => 'Books',
        'singular_name' => 'Book',
        'menu_name' => 'Books',
        'name_admin_bar' => 'Book',
        'archives' => 'Book Archives',
        'attributes' => 'Book Attributes',
        'parent_item_colon' => 'Parent Book:',
        'all_items' => 'All Books',
        'add_new_item' => 'Add New Book',
        'add_new' => 'Add New',
        'new_item' => 'New Book',
        'edit_item' => 'Edit Book',
        'update_item' => 'Update Book',
        'view_item' => 'View Book',
        'view_items' => 'View Books',
        'search_items' => 'Search Book',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'featured_image' => 'Featured Image',
        'set_featured_image' => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image' => 'Use as featured image',
        'insert_into_item' => 'Insert into book',
        'uploaded_to_this_item' => 'Uploaded to this book',
        'items_list' => 'Books list',
        'items_list_navigation' => 'Books list navigation',
        'filter_items_list' => 'Filter books list',
    );
    $args = array(
        'label' => 'Book',
        'description' => 'A custom post type for books',
        'labels' => $labels,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-book',
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'books'),
    );
    register_post_type('book', $args);
}
add_action('init', 'custom_post_type_book', 0);

// Register Custom Taxonomy for Author
function custom_taxonomy_author() {
    $labels = array(
        'name' => 'Authors',
        'singular_name' => 'Author',
        'menu_name' => 'Authors',
        'all_items' => 'All Authors',
        'edit_item' => 'Edit Author',
        'view_item' => 'View Author',
        'update_item' => 'Update Author',
        'add_new_item' => 'Add New Author',
        'new_item_name' => 'New Author Name',
        'parent_item' => 'Parent Author',
        'parent_item_colon' => 'Parent Author:',
        'search_items' => 'Search Authors',
        'popular_items' => 'Popular Authors',
        'separate_items_with_commas' => 'Separate authors with commas',
        'add_or_remove_items' => 'Add or remove authors',
        'choose_from_most_used' => 'Choose from the most used authors',
        'not_found' => 'No authors found.',
    );
    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('author', array('book'), $args);
}
add_action('init', 'custom_taxonomy_author', 0);

// Register Custom Taxonomy for Genre
function custom_taxonomy_genre() {
    $labels = array(
        'name' => 'Genres',
        'singular_name' => 'Genre',
        'menu_name' => 'Genres',
    );
    $args = array(
        'hierarchical' => true, 
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('genre', array('book'), $args);
}
add_action('init', 'custom_taxonomy_genre', 0);

// Register Custom Taxonomy for Publication Year
function custom_taxonomy_publication_year() {
    $labels = array(
        'name' => 'Publication Years',
        'singular_name' => 'Publication Year',
        'menu_name' => 'Publication Year',
    );
    $args = array(
        'hierarchical' => false, 
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('publication_year', array('book'), $args);
}
add_action('init', 'custom_taxonomy_publication_year', 0);

// Register Custom Taxonomy for Collections
function custom_taxonomy_collections() {
    $labels = array(
        'name' => 'Collections',
        'singular_name' => 'Collection',
        'menu_name' => 'Collections',
        // ... (add other labels as needed)
    );
    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('collection', array('book'), $args);
}
add_action('init', 'custom_taxonomy_collections', 0);

//Define collection Post Type
function custom_post_type_collection() {
    $labels = array(
        'name' => 'Collections',
        'singular_name' => 'Collection',
        'menu_name' => 'Collections',
        'name_admin_bar' => 'Collection',
        'archives' => 'Collection Archives',
        'attributes' => 'Collection Attributes',
        'parent_item_colon' => 'Parent Collection:',
        'all_items' => 'All Collections',
        'add_new_item' => 'Add New Collection',
        'add_new' => 'Add New',
        'new_item' => 'New Collection',
        'edit_item' => 'Edit Collection',
        'update_item' => 'Update Collection',
        'view_item' => 'View Collection',
        'view_items' => 'View Collections',
        'search_items' => 'Search Collection',
        'not_found' => 'Not found',
        'not_found_in_trash' => 'Not found in Trash',
        'featured_image' => 'Featured Image',
        'set_featured_image' => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image' => 'Use as featured image',
        'insert_into_item' => 'Insert into collection',
        'uploaded_to_this_item' => 'Uploaded to this collection',
        'items_list' => 'Collections list',
        'items_list_navigation' => 'Collections list navigation',
        'filter_items_list' => 'Filter collections list',
    );
    $args = array(
        'label' => 'Collection',
        'description' => 'A custom post type for collections',
        'labels' => $labels,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-image-filter',
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('collection', $args);
}
// add_action('init', 'custom_post_type_collection', 0);



?>