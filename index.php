<?php
/*
Plugin Name:  Bookshelf
Plugin URI:   https://johnatta.com
Description:  Bookshelf Plugin
Version:      1.0
Author:       John Atta
Author URI:   https://johnatta.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  bookshelf-td
Domain Path:  /languages
*/

include( plugin_dir_path( __FILE__ ) . 'bookshelf.php' );
include( plugin_dir_path( __FILE__ ) . 'includes/declarations.php' );
include( plugin_dir_path( __FILE__ ) . 'includes/endpoints.php' ); 
include( plugin_dir_path( __FILE__ ) . 'includes/add-book.php' );
include( plugin_dir_path( __FILE__ ) . 'includes/wishlist.php' );
include( plugin_dir_path( __FILE__ ) . 'includes/collection.php' );
include( plugin_dir_path( __FILE__ ) . 'includes/nav-menu.php' );


