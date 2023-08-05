<?php 

// Enqueue Wishlist Ajax Call
function bookshelf_enqueue_my_scripts() {
    $plugin_url = plugin_dir_url(__FILE__);
    wp_enqueue_style( 'bookshelf-style', $plugin_url . 'css/style.css' );
    wp_enqueue_script('add-book-to-wishlist', $plugin_url . 'scripts/ajax-add-to-wishlist.js', array('jquery'), '1.0', true);
    wp_enqueue_script('add-book-to-collection', $plugin_url . 'scripts/ajax-add-to-collection.js', array('jquery'), '1.0', true);
    if(is_tax('collection')) wp_enqueue_script('social-share', $plugin_url . 'scripts/social-share.js', array('jquery'), '1.0', true);
    wp_enqueue_script('book-info-ajax', $plugin_url . 'scripts/book-info.js', array('jquery'), '1.0', true);

    wp_localize_script('add-book-to-wishlist', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    wp_localize_script('add-book-to-collection', 'my_book_ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php'),));

    if (!wp_style_is('font-awesome', 'enqueued')) {
        // If not enqueued, enqueue the Font Awesome stylesheet
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
    }
}
add_action('wp_enqueue_scripts', 'bookshelf_enqueue_my_scripts');


// Register the book single template
function bookshelf_custom_book_template($template) {
    if (is_singular('book')) {
        $template_path = plugin_dir_path(__FILE__) . 'templates/single-book.php';
        if (file_exists($template_path)) {
            return $template_path;
        }
    }
    return $template;
}
add_filter('single_template', 'bookshelf_custom_book_template');

// Register the book archive template
function bookshelf_custom_book_archive_template($template) {
    if (is_archive('book') ) {
        $template_path = plugin_dir_path(__FILE__) . 'templates/archive-book.php';
        if (file_exists($template_path)) {
            return $template_path;
        }
    }
    return $template;
}
add_filter('archive_template', 'bookshelf_custom_book_archive_template');

// Register pages template
function bookshelf_custom_template_for_page($template) {
    $page_id = get_the_ID();
    if($page_id && is_page($page_id)) {
            // Get the path to the custom template file in the plugin directory
            $custom_template = plugin_dir_path(__FILE__);
            if($page_id == get_option('bookshelf_collection_page'))  $custom_template .= 'templates/collections-page.php';
            elseif($page_id == get_option('bookshelf_wishlist_page')) $custom_template .= 'templates/wishlist-page.php';
            else return $template;
            // Check if the custom template file exists
            if (file_exists($custom_template)) {
                // Return the path to the custom template file
                return $custom_template;
            }
        
    }
    return $template;
}
// add_filter('template_include', 'bookshelf_custom_template_for_page');

function bookshelf_load_collections_template($template) {
    if (get_query_var('bookshelf-collections')) {
        $template = plugin_dir_path(__FILE__) . 'templates/taxonomy-collection.php';
    }
    elseif (get_query_var('bookshelf-wishlist')) {
        $template = plugin_dir_path(__FILE__) . 'templates/wishlist-page.php';
    }
    elseif (get_query_var('bookshelf-add-book')) {
        $template = plugin_dir_path(__FILE__) . 'templates/add-book-page.php';
    }
    return $template;
}
add_filter('template_include', 'bookshelf_load_collections_template');

// Placeholder Image URL
function bookshelf_placeholder_image_url() {
    return plugin_dir_url(__FILE__) . 'assets/placeholder.png';
}

//Book Excerpt Length
function bookshelf_custom_book_excerpt_length($length) {
    global $post;
    if(get_post_type( $post ) == "book" || get_query_var('bookshelf-collections') ||get_query_var('bookshelf-wishlist') ){
        return 20; // Change 50 to your preferred length
    }
    else return $length;
}
add_filter('excerpt_length', 'bookshelf_custom_book_excerpt_length', 999);

function bookshelf_get_terms($post_id, $taxonomy, $show_names , $show_icons){
    $show_names = boolval($show_names);
    if($show_icons = boolval($show_icons)){
        $icons_array = array( 
            'collection' => 'fa-address-book-o',
            'genre' => 'fa-file-text-o',
            'publication_year' => 'fa-calendar-o',
            'author' => 'fa-user-o',
        );
    }
    $terms = get_the_terms($post_id, $taxonomy);
    if ($terms && !is_wp_error($terms)) {
        if ($show_icons && isset($icons_array[$taxonomy])) {
            echo '<span class="bookshelf-term-name-wrapper '. $taxonomy .'">';
                echo '<i class="fa ' . $icons_array[$taxonomy] .'" aria-hidden="true"></i> ';
                if($show_names) echo '<span class="bookshelf-term-name">'. str_replace('_', ' ', $taxonomy  ) .'</span>';
            echo '</span> ';
        }
        $i = 0;
        foreach ($terms as $term) {
            echo '<a href="' . esc_url(get_term_link($term)) . '">'. (!$i ? esc_html($term->name): esc_html(' - '.$term->name)) . '</a>';
            $i++;
        } 
    }
}

?>