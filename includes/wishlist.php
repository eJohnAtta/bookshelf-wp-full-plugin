<?php 
// Register wishlist meta
function register_wishlist_user_meta() {
    register_meta('user', 'wishlist_books', array(
        'type' => 'array',
        'description' => 'Wishlist Books',
        'single' => false,
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_wishlist_user_meta');

// Add to Wishlist Form
function add_to_wishlist_form($post_id){
    if(!is_user_logged_in(  )) return;
    $wishlist_checker = is_current_book_in_wishlist($post_id);  ?>
    <div class="shoplift-add-to-wishlist-container"> 
        <a href="#" title="<?php echo $wishlist_checker ? __('Add to Wishlist') : __('Remove from Wishlist') ?>" class="bookshelf-add-to-wishlist <?php echo $wishlist_checker ? 'active' : '' ?>" data-post-id="<?php echo $post_id ?>">
            <i class="fa fa-heart-o"></i>
        </a>
    </div> <?php
}

// Define Wishlist Ajax Callback
function add_to_wishlist() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $user_id = get_current_user_id();

        if ($user_id) {
            $wishlist_books = get_user_meta($user_id, 'bookshelf_wishlist_books', true);
            if (!$wishlist_books || !is_array($wishlist_books)) {
                $wishlist_books = array();
            }
            //Add to wishlist
            if (!in_array($post_id, $wishlist_books)) {
                $wishlist_books[] = $post_id;
                update_user_meta($user_id, 'bookshelf_wishlist_books', $wishlist_books);
            }
            //remove from wishlist
            else{
                $wishlist_books = array_diff($wishlist_books, array($post_id) );
                update_user_meta($user_id, 'bookshelf_wishlist_books', $wishlist_books);
            }

            wp_send_json_success();
        }
    }

    wp_send_json_error();
}
add_action('wp_ajax_add_to_wishlist', 'add_to_wishlist');
add_action('wp_ajax_nopriv_add_to_wishlist', 'add_to_wishlist');

function is_current_book_in_wishlist($current_book_id){
    $user_id = get_current_user_id();
    if( $books_in_wishlist = get_user_meta( $user_id , 'bookshelf_wishlist_books' , true) ){
        if(in_array($current_book_id , $books_in_wishlist)) return true;
        else false;
    }
}

?>