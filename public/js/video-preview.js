$(document).ready(function() {

    // Event listener for page load
    $(window).on('load', function() {
        var url = $('input[name="urlAddress"]').val();
        if (url) {
            setVideoPreview(url);
        }
    });
    
    $('input[name="urlAddress"]').on('change', function() {
        var url = $(this).val();
        setVideoPreview(url);
    });

    function setVideoPreview(url) {
        var videoId = extractVideoID(url);
        if (videoId) {
            var embedUrl = 'https://www.youtube.com/embed/' + videoId;
            if ($('#video-preview').length) {
                $('#video-preview').attr('src', embedUrl);
            } else {
                $('.videoPreviewContainer').html($('<iframe id="video-preview" width="400" height="200" class="mt-3" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen src="' + embedUrl + '"></iframe>'));
            }
            $('#tutorial_youtube').val(embedUrl);  
        } else {
            alert('Invalid YouTube URL');
        }
    }
    function extractVideoID(url) {
        var videoId = null;
        var regex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/;
        var matches = url.match(regex);
        if (matches) {
            videoId = matches[1];
        }
        return videoId;
    }
});