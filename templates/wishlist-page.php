<?php
/**
 * Template Name: Wishlist Page
 * Description: A custom template for the specific page.
 */

get_header(); ?>
<div class="bookshelf-main-container"><?php

    $user_id = get_current_user_id();
    if(!$user_id){
        echo '<p> '. __('Please Login or Register') .' </p>';
        return;
    }
    $ids_in_wishlist = get_user_meta($user_id, 'bookshelf_wishlist_books' , true);
    
    if($ids_in_wishlist){ ?>
        <div class="bookshelf-books-loop-wrapper wishlist"> <?php
            foreach($ids_in_wishlist as $book_id){
                 ?>
                <div id="bookshelf-book-loop-container-<?php echo $book_id;?>" class="bookshelf-book-loop-container" data-post-id="<?php echo $book_id ?>">
                <div class="bookshelf-book-loop-wrapper">
                    <div class="bookshelf-book-loop-head"><?php
                        $featured_image_url = get_the_post_thumbnail_url($book_id)?: bookshelf_placeholder_image_url();
                        if($featured_image_url){ ?>
                            <img class="bookshelf-book-loop-img" src="<?php echo esc_url($featured_image_url) ?>" alt="<?php echo esc_attr(get_the_title()) ?>" loading="lazy" width="300" height="300">
                        <?php } ?>
                        <div class="bookshelf-book-loop-title bookshelf-flex-center bookshelf-title-wishlist-section">
                            <h3> <?php echo get_the_title($book_id)?></h3> <?php
                            add_to_wishlist_form($book_id); 
                            bookshelf_add_book_to_collection_form($book_id)
                        ?></div>
                    </div>
                    
                    <div class="bookshelf-book-loop-terms-container bookshelf-hidden">
                        <?php $tax_array = array('collection', 'genre', 'publication_year', 'author');
                        foreach($tax_array as $tax){?>
                            <div class="bookshelf-book-loop-<?php echo $tax ?>-terms bookshelf-book-loop-terms-wrapper">
                                <?php bookshelf_get_terms($book_id, $tax, true, true); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="bookshelf-book-loop-excerpt bookshelf-text-in-center"> <?php
                        echo get_the_excerpt($book_id);
                        
                    ?></div>
                    <div class="bookshelf-book-loop-button-wrapper bookshelf-flex-center">
                        <button class="bookshelf-book-loop-button button bookshelf-text-in-center">
                            <a href="<?php echo get_permalink($book_id) ?>">
                                <?php _e('Discover') ?>
                            </a>
                        </button>
                    </div>
                </div>
            </div><?php
            } ?>
        </div><?php
    }
    else _e('You did not add books to your wishlist.');

    
    ?>


</div>
<?php get_footer(); ?>
