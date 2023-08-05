<?php
// archive-book.php
get_header(); ?>

<div class="bookshelf-main-container">
<h1 class="archive-title"><?php echo get_the_archive_title(); ?></h1> <?php
    
    if (have_posts()) { ?>
        <div class="bookshelf-books-loop-wrapper archive"><?php
        while (have_posts()) {
            the_post(); 
            $post_id = get_the_ID(); ?>
            <div id="bookshelf-book-loop-container-<?php echo $post_id;?>" class="bookshelf-book-loop-container" data-post-id="<?php echo $post_id ?>">
                <div class="bookshelf-book-loop-wrapper">
                    <div class="bookshelf-book-loop-head"><?php
                        $featured_image_url = get_the_post_thumbnail_url($post_id)?: bookshelf_placeholder_image_url();
                        if($featured_image_url){ ?>
                            <img class="bookshelf-book-loop-img" src="<?php echo esc_url($featured_image_url) ?>" alt="<?php echo esc_attr(get_the_title()) ?>" loading="lazy" width="300" height="300">
                        <?php } ?>
                        <div class="bookshelf-book-loop-title bookshelf-flex-center bookshelf-title-wishlist-section"><?php
                            the_title('<h3>', '</h3>');
                            add_to_wishlist_form($post_id); 
                            bookshelf_add_book_to_collection_form($post_id)
                        ?></div>
                    </div>
                    
                    <div class="bookshelf-book-loop-terms-container bookshelf-hidden">
                        <?php $tax_array = array('collection', 'genre', 'publication_year', 'author');
                        foreach($tax_array as $tax){?>
                            <div class="bookshelf-book-loop-<?php echo $tax ?>-terms bookshelf-book-loop-terms-wrapper">
                                <?php bookshelf_get_terms($post_id, $tax, true, true); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="bookshelf-book-loop-excerpt bookshelf-text-in-center"> <?php
                        the_excerpt();
                    ?></div>
                    <div class="bookshelf-book-loop-button-wrapper bookshelf-flex-center">
                        <button class="bookshelf-book-loop-button button bookshelf-text-in-center">
                            <a href="<?php the_permalink() ?>">
                                <?php _e('Discover') ?>
                            </a>
                        </button>
                    </div>
                </div>
            </div><?php
        } ?>
        </div>
        <?php 
        the_posts_pagination(array(
            'prev_text' => __('Previous', 'textdomain'),
            'next_text' => __('Next', 'textdomain'),
        ));
        
        if(is_tax('collection')){ ?>
            <div class="bookshelf-share-buttons">
                <a class="bookshelf-facebook-share" href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i> Share on Facebook</a>
                <a class="bookshelf-twitter-share" href="#"><i class="fa fa-twitter" aria-hidden="true"></i> Share on Twitter</a>
                <button class="bookshelf-copy-url "><i class="fa fa-clipboard" aria-hidden="true"></i> Copy URL</button>
            </div> <?php 
        }
    } else {
        // No content found
        echo '<p>No books found.</p>';
    }
?></div><?php

get_footer(); // Load the footer template
