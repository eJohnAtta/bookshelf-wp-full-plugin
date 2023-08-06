<?php
/*
* Template Name: Collection Taxonomy Template
* Description: A custom template for displaying all terms of the "collection" taxonomy.
*/

get_header(); ?>
<div class="bookshelf-main-container"><?php
    if(is_user_logged_in(  )){
        $current_user = wp_get_current_user(  );
        echo '<h4>' . __('Hi, ') . $current_user->display_name .'</h4>';
        echo '<h5>' . __('Use this form to add a new book for your collection') . '</h5>';
        
        echo book_submission_form();
    }
    else _e('Please login or Register');

?></div> <?php 
get_footer(); ?>