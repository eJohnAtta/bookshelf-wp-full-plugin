jQuery(document).ready(function($) {
    $('.bookshelf-add-to-wishlist').on('click', function(event) {
        event.preventDefault();
        var $this = $(this);
        var postId = $this.data('post-id');
        var formData = {
            action: 'add_to_wishlist',
            post_id: postId
        };
        $.ajax({
            type: 'POST',
            url: my_ajax_object.ajax_url, // Use the localized ajax_url
            data: formData,
            success: function(response) {
                $this.toggleClass('active');
                
            },
            error: function() {
                alert('Error occurred while adding book to wishlist.');
            }
        });
    });

    // $('a.bookshelf-add-to-wishlist').tooltip({
    //     placement: 'top', // Change this to adjust the tooltip placement (top, bottom, left, right)
    //     delay: { show: 100, hide: 100 }, // Adjust the delay for showing and hiding the tooltip (in milliseconds)
    // });
});
