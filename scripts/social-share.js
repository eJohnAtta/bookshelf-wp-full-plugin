jQuery(document).ready(function($) {
    // Function to handle the copy-to-clipboard functionality
    function copyToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
    }

    // Share on Facebook
    $('.bookshelf-facebook-share').on('click', function(e) {
        e.preventDefault();
        console.log('walad');
        const urlToShare = window.location.href;
        const facebookShareURL = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(urlToShare);
        window.open(facebookShareURL, '_blank');
    });

    // Share on Twitter
    $('.bookshelf-twitter-share').on('click', function(e) {
        e.preventDefault();
        const urlToShare = window.location.href;
        const twitterShareURL = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(urlToShare);
        window.open(twitterShareURL, '_blank');
    });

    // Copy URL to clipboard
    $('.bookshelf-copy-url').on('click', function(e) {
        e.preventDefault();
        const urlToCopy = window.location.href;
        copyToClipboard(urlToCopy);
        alert("URL copied to clipboard!");
    });
});
