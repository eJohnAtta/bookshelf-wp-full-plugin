<?php

function bookshelf_add_book_to_collection_form($post_id){
    if(!is_user_logged_in(  )) return;
    $current_user = wp_get_current_user();
    $current_user_name = $current_user -> user_login;
    
    if(is_tax('collection' , $current_user_name) ) return;
    if(has_term($current_user_name, 'collection')) return;
    if($current_user_name){ ?>
        <a href="#" class="bookshelf-add-to-taxonomy" data-book-id="<?php echo esc_attr($post_id); ?>">
            <i class="fa fa-bookmark-o" aria-hidden="true"></i>
        </a>
    <?php }
}



add_action('wp_ajax_add_book_to_taxonomy', 'add_book_to_collection');
add_action('wp_ajax_nopriv_add_book_to_taxonomy', 'add_book_to_collection');

function add_book_to_collection() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $taxonomy = 'collection';
        $user = wp_get_current_user();
        $user_term_name = $user->user_login;
        
        // Check if the term exists, create it if it doesn't
        $term = term_exists($user_term_name, $taxonomy);
        if (!$term) {
            $term = wp_insert_term($user_term_name, $taxonomy);
        }
            
        // Add the book to the term
        if (!is_wp_error($term) && isset($term['term_id'])) {
            $term1 = get_term($term['term_id'], 'collection');
            wp_set_post_terms($post_id, $term1->name, $taxonomy, true);
            echo 'success';
        } else {
            echo 'error';
        }
    }

    wp_die();
}


?>
