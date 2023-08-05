<?php
/*
 * Template Name: Collection Taxonomy Template
 * Description: A custom template for displaying all terms of the "collection" taxonomy.
 */

 get_header();
 ?>
 
 <div class="bookshelf-main-container">
     <h1>Collection Taxonomy Terms</h1>
     <?php
     $taxonomy = 'collection';
     if(is_user_logged_in(  )){
        $current_user = wp_get_current_user(  );
        $user_collection_name = $current_user->user_login;
        $user_collection = get_term_by('name', $user_collection_name, $taxonomy);
        if($user_collection) $user_collection_id = $user_collection->term_id;
     }
     $terms = get_terms(array(
         'taxonomy' => $taxonomy,
         'hide_empty' => false, // Show even if no posts are assigned to the term
         'exclude' => is_user_logged_in() && $user_collection_id ? $user_collection_id : '',
     ));
 
     if ($terms && !is_wp_error($terms)) {
        echo '<ul>';
        if (is_user_logged_in(  ) && $user_collection) {
            $term_link = esc_url(get_term_link($user_collection));
            $book_count = $user_collection->count;
            echo '<li class="bookshelf-current-collection">'. __('Your Collection') .' <a href="' . $term_link . '">' . esc_html($user_collection_name) . '</a>';
            echo '<span class="book-count">(' . $book_count . ' books)</span></li>';
        }
         foreach ($terms as $term) {
             $term_link = esc_url(get_term_link($term));
             $book_count = $term->count;
             echo '<li><a href="' . $term_link . '">' . esc_html($term->name) . '</a>';
             echo '<span class="book-count">(' . $book_count . ' books)</span></li>';
         }
         echo '</ul>';
     } else {
         echo 'No terms found for the Collection taxonomy.';
     }
     ?>
 </div>
 
 <?php
 get_footer();
 
?>
