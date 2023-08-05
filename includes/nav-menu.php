<?php


function my_register_menu_metabox() {
	$custom_param = array( 0 => 'This param will be passed to my_render_menu_metabox' );
	
	add_meta_box( 'bookshelf-nav-metabox', 'Bookshelf Endpoints', 'bookshelf_render_menu_metabox', 'nav-menus', 'side', 'default', $custom_param );
}
add_action( 'admin_head-nav-menus.php', 'my_register_menu_metabox' );

function bookshelf_render_menu_metabox( $object, $args ) {
    global $nav_menu_selected_id;

    $wishlist_item = (object) array(
        'ID' => -1,
        'db_id' => 0,
        'menu_item_parent' => 0,
        'object_id' => 1,
        'post_parent' => 0,
        'type' => 'custom',
        'object' => 'custom',
        'type_label' => 'My Bookshelf Plugin',
        'title' => 'Wishlist',
        'url' => home_url( '/bookshelf-wishlist/' ),
        'target' => '',
        'attr_title' => '',
        'description' => '',
        'classes' => array(),
        'xfn' => '',
    );

    $collection_item = (object) array(
        'ID' => -2,
        'db_id' => 0,
        'menu_item_parent' => 0,
        'object_id' => 2,
        'post_parent' => 0,
        'type' => 'custom',
        'object' => 'custom',
        'type_label' => 'My Bookshelf Plugin',
        'title' => 'Collections',
        'url' => home_url( '/bookshelf-collections/' ),
        'target' => '',
        'attr_title' => '',
        'description' => '',
        'classes' => array(),
        'xfn' => '',
    );

    $menu_items = wp_get_nav_menu_items( $nav_menu_selected_id );
    $menu_items = is_array( $menu_items ) ? $menu_items : array();

    // Filter out the existing menu items with post_type 'page' and 'post'
    $menu_items = array_filter( $menu_items, function( $item ) {
        return ! in_array( $item->object, array( 'page', 'post', 'custom' ) );
    });

    array_unshift( $menu_items, $wishlist_item, $collection_item );

    $db_fields = false;
    $walker = new Walker_Nav_Menu_Checklist( $db_fields );

    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    ); ?>

    <div id="my-plugin-div">
        <div id="tabs-panel-my-plugin-all" class="tabs-panel tabs-panel-active">
            <ul id="my-plugin-checklist-pop" class="categorychecklist form-no-clear" >
                <?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $menu_items ), 0, (object) array( 'walker' => $walker ) ); ?>
            </ul>

            <p class="button-controls">
                <span class="list-controls">
                    <a href="<?php
                        echo esc_url(add_query_arg(
                            array(
                                'my-plugin-all' => 'all',
                                'selectall' => 1,
                            ),
                            remove_query_arg( $removed_args )
                        ));
                    ?>#bookshelf-nav-metabox" class="select-all"><?php _e( 'Select All' ); ?></a>
                </span>

                <span class="add-to-menu">
                    <input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-my-plugin-menu-item" id="submit-my-plugin-div" />
                    <span class="spinner"></span>
                </span>
            </p>
        </div>
    </div>
    <?php
}

?>