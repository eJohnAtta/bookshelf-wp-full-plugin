
<?php 

function book_submission_form() {
    ob_start();
    if(!is_user_logged_in(  )){
        echo 'you should login';
        return ob_get_clean();
    }
    wp_enqueue_media();
    display_book_submission_message(); ?>

    <form id="book-submission-form" method="post" enctype="multipart/form-data">
        <label for="bookshelf_book_title">Title:</label>
        <input type="text" name="bookshelf_book_title" id="title" required>

        <label for="bookshelf_book_description">Description:</label>
        <textarea name="bookshelf_book_description" id="description" rows="4"></textarea>

        <label for="bookshelf_book_author">Author:</label>
        <select name="bookshelf_book_author[]" multiple="multiple" required>
            <option value="">-- Select Author --</option>
            <?php
            $authors = get_terms(array(
                'taxonomy' => 'author',
                'hide_empty' => false,
            ));
            foreach ($authors as $author) {
                echo '<option value="' . $author->term_id . '">' . $author->name . '</option>';
            }
            ?>
        </select>

        <label for="bookshelf_book_genre">Genre:</label>
        <select name="bookshelf_book_genre[]" multiple="multiple" required>
            <option value="">-- Select Genre --</option>
            <?php
            $genres = get_terms(array(
                'taxonomy' => 'genre',
                'hide_empty' => false,
            ));
            foreach ($genres as $genre) {
                echo '<option value="' . $genre->term_id . '">' . $genre->name . '</option>';
            }
            ?>
        </select>

        <label for="bookshelf_book_publication_year">Publication Year:</label>
        <select name="bookshelf_book_publication_year" required>
            <option value="">-- Select Publication Year --</option>
            <?php
            $publication_years = get_terms(array(
                'taxonomy' => 'publication_year',
                'hide_empty' => false,
            ));
            foreach ($publication_years as $year) {
                echo '<option value="' . $year->term_id . '">' . $year->name . '</option>';
            }
            ?>
        </select>

        <label for="bookshelf_book_cover_image">Cover Image:</label>
        <input type="hidden" name="bookshelf_book_cover_image_id" id="bookshelf_book_cover_image_id" value="">
        <button id="bookshelf_upload_cover_image_button" class="button">Select Image</button>
        <div id="bookshelf_cover_image_preview"></div>

        <input type="submit" name="bookshelf_book_submit_book" value="Submit">
    </form>
    <script>
    jQuery(document).ready(function($) {
        $('#bookshelf_upload_cover_image_button').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Select Cover Image',
                button: {
                    text: 'Set as Cover Image'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#bookshelf_book_cover_image_id').val(attachment.id);
                $('#bookshelf_cover_image_preview').html('<img src="' + attachment.url + '" alt="Cover Image" style="max-width: 150px;">');
            });

            frame.open();
        });
    });
    </script>
    <?php var_dump($_POST);
    return ob_get_clean();
    // var_dump($_POST);
}
add_shortcode('book_submission_form', 'book_submission_form');


function process_book_submission_form() {
    if (isset($_POST['bookshelf_book_submit_book']) && isset($_POST['bookshelf_book_title'])) {
        $title = sanitize_text_field($_POST['bookshelf_book_title']);
        $author = !empty($_POST['bookshelf_book_author']) ? array_map('intval', $_POST['bookshelf_book_author']) : array();
        $genre = !empty($_POST['bookshelf_book_genre']) ? array_map('intval', $_POST['bookshelf_book_genre']) : array();
        $publication_year = !empty($_POST['bookshelf_book_publication_year']) ?  intval($_POST['bookshelf_book_publication_year']) :'';
        $description = wp_kses_post($_POST['bookshelf_book_description'] ?? '');

        $new_book = array(
            'post_title' => $title,
            'post_content' => $description,
            'post_status' => 'publish',
            'post_type' => 'book'
        );

        $book_id = wp_insert_post($new_book);
        $current_url = remove_query_arg('success', home_url( $_SERVER['REQUEST_URI'] ));
        
        
        var_dump( $_SERVER['QUERY_STRING']);
        if ($book_id) {
            
            $current_user = wp_get_current_user();
            $collection_term_name = $current_user->user_login;

            //check if the collection of this user already exists
            $collection_term = term_exists($collection_term_name, 'collection');

            if (!$collection_term) {
                $collection_term = wp_insert_term($collection_term_name, 'collection');
                update_user_meta($current_user->ID , 'bookshelf-collection-id', $collection_term['term_id']);
            }
            // // Add the book to user's collection
            if (!is_wp_error($collection_term) && isset($collection_term['term_id'])) {
                $term = get_term($collection_term['term_id'], 'collection');
                if($term) {
                    wp_set_post_terms($book_id, $term->name, 'collection');
                }
            }
            
            if (!empty($author)) {
                wp_set_object_terms($book_id, $author, 'author');
            }
            if (!empty($genre)) {
                wp_set_object_terms($book_id, $genre, 'genre');
            }
            if (!empty($publication_year)) {
                wp_set_object_terms($book_id, $publication_year, 'publication_year');
            }

            if (isset($_POST['bookshelf_book_cover_image_id'])) {
                $cover_image_id = intval($_POST['bookshelf_book_cover_image_id']);
                if ($cover_image_id > 0) {
                    set_post_thumbnail($book_id, $cover_image_id);
                }
            }
            wp_redirect($current_url . '?success=1'); // Redirect after successful submission
            
        }
        else{
            wp_redirect($current_url . '?success=0'); // Redirect after successful submission
        }
        
        exit;
    }
}
add_action('template_redirect', 'process_book_submission_form');

function display_book_submission_message() {
    if (isset($_GET['success']) && $_GET['success'] === '1') {
        echo '<div class="book-success-message">Book submitted successfully!</div>';
    } elseif (isset($_GET['success']) && $_GET['success'] === '0') {
        echo '<div class="book-error-message">Book submission failed. Please try again.</div>';
    }
}


function add_upload_capability_to_subscriber_role() {
    $subscriber_role = get_role('subscriber');
    if ($subscriber_role && !$subscriber_role->has_cap('upload_files')) {
        $subscriber_role->add_cap('upload_files');
    }
}
add_action('admin_init', 'add_upload_capability_to_subscriber_role');

?>