jQuery(document).ready(function($) {
    $('.bookshelf-book-loop-container').hover(function() {
        var element = $(this).find('.bookshelf-book-loop-terms-wrapper');
        $(this).addClass('bookshelf-active');
        element.addClass('bounceIn');
        element.removeClass('bookshelf-hidden');
    }, function() {
        var element = $(this).find('.bookshelf-book-loop-terms-wrapper');
        $(this).removeClass('bookshelf-active');
        element.removeClass('bounceIn');

        // Wait for the animation to finish and then remove the class
        setTimeout(function() {
            element.removeClass('bounceIn');
            
        }, 1000); // Use the same duration as the animation duration
        element.addClass('bookshelf-hidden');
    });
});
