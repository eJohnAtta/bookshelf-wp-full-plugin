<?php 

function bookshelf_activate() {
    add_rewrite_endpoint('bookshelf-collections', EP_ROOT);
    add_rewrite_endpoint('bookshelf-wishlist', EP_ROOT);
    add_rewrite_endpoint('bookshelf-add-book', EP_ROOT);
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'bookshelf_activate');

function bookshelf_add_rewrite_rule() {
    add_rewrite_rule('^bookshelf-collections/?$', 'index.php?bookshelf-collections=1', 'top');
    add_rewrite_rule('^bookshelf-wishlist/?$', 'index.php?bookshelf-wishlist=1', 'top');
    add_rewrite_rule('^bookshelf-add-book/?$', 'index.php?bookshelf-add-book=1', 'top');
}
add_action('init', 'bookshelf_add_rewrite_rule');

function bookshelf_query_vars($vars) {
    $vars[] = 'bookshelf-collections';
    $vars[] = 'bookshelf-wishlist';
    $vars[] = 'bookshelf-add-book';
    return $vars;
}
add_filter('query_vars', 'bookshelf_query_vars');


?>