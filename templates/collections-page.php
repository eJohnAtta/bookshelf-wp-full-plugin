<?php
/**
 * Template Name: Collection Page
 * Description: A custom template for the specific page.
 */

get_header(); ?>
<div class="bookshelf-main-container">
    <?php the_title('<h1>', '</h1>');

    $taxonomy = 'collection';

    // Set the number of terms per page
    $per_page_option = get_option('bookshelf_collection_per_page');
    $per_page = $per_page_option ? $per_page_option : 10 ;
    $page = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $offset = ( $page - 1 ) * $per_page;
    $args = array( 'number' => $per_page, 'offset' => $offset, 'hide_empty' => 0 );
    $tax_terms = get_terms( $taxonomy, $args );

    // Output terms
    echo '<ul>';
    foreach ($tax_terms as $tax_term) {
        echo '<li><a href="' . esc_url( get_term_link($tax_term, $taxonomy) ) . '">' . $tax_term->name . '</a></li>';
    }
    echo '</ul>';

    // Pagination
    $total_terms = wp_count_terms($taxonomy);
    $pages = ceil($total_terms / $per_page);

    if ($pages > 1) {
        $pagination_output = '<ul>';
        for ($pagecount = 1; $pagecount <= $pages; $pagecount++) {
            $pagination_output .= '<li><a href="' . esc_url( get_permalink() . 'page/' . $pagecount . '/' ) . '">' . $pagecount . '</a></li>';
        }
        $pagination_output .= '</ul>';

        if (!isset($_GET['showall'])) {
            // Link to show all
            $pagination_output .= '<a href="' . esc_url( get_permalink() ) . '?showall=true">show all</a>';
        } else {
            // Link to show paged
            $pagination_output .= '<a href="' . esc_url( get_permalink() ) . '">show paged</a>';
        }

        echo $pagination_output;
    }

    the_content();

    // Reset post data
    wp_reset_postdata();
?></div>
get_footer();
?>
