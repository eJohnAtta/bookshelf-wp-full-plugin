<?php
// single-book.php
get_header(); ?> 
<div class="bookshelf-main-container"><?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $post_id = get_the_ID(); ?>
        <div id="bookshelf-book-single-container-<?php echo $post_id;?>" class="bookshelf-book-single-container" data-post-id="<?php echo $post_id ?>">
                <div class="bookshelf-book-single-wrapper">
                    <div class="bookshelf-book-single-col1 bookshelf-flex-center"><?php
                        $featured_image_url = get_the_post_thumbnail_url($post_id)?: bookshelf_placeholder_image_url();
                        if($featured_image_url){ ?>
                            <img class="bookshelf-book-single-img" src="<?php echo esc_url($featured_image_url) ?>" alt="<?php echo esc_attr(get_the_title()) ?>" loading="lazy" width="300" height="300">
                        <?php } ?>
                    </div>
                    
                    <div class='bookshelf-book-single-col2'>
                        <div class="bookshelf-book-single-title bookshelf-flex-normal bookshelf-title-wishlist-section"><?php
                                the_title('<h3>', '</h3>');
                                add_to_wishlist_form($post_id); 
                                bookshelf_add_book_to_collection_form($post_id);
                        ?></div>
                        <div class="bookshelf-book-single-content"> <?php
                            the_content(); ?>
                        </div>
                        <div class="bookshelf-book-single-terms-container ">
                            <?php $tax_array = array('collection', 'genre', 'publication_year', 'author');
                            foreach($tax_array as $tax){?>
                                <div class="bookshelf-book-single-<?php echo $tax ?>-terms bookshelf-book-single-terms-wrapper">
                                    <?php bookshelf_get_terms($post_id, $tax, true, true); ?>
                                </div>
                            <?php } ?>
                        </div>
                        
                    </div>
                </div>
            </div><?php
        
    }
} else {
    // No content found
    echo '<p>No book found.</p>';
}
?> </div> <?php
get_footer(); 
