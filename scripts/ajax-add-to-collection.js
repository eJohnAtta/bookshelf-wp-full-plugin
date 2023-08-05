jQuery(document).ready(function($) {
    $('.bookshelf-add-to-taxonomy').on('click', function(e) {
        e.preventDefault();
        var targetElement = $(this);
        var postID = targetElement.data('book-id');

        $.ajax({
            url: my_book_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'add_book_to_taxonomy',
                post_id: postID,
            },
            success: function(response) {
                // Use the reference to targetElement to toggle the 'active' class
                targetElement.toggleClass('active');
                console.log(response);
            },
        });
    });
});
