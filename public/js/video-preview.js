$(document).ready(function() {
    $('input[name="urlAddress"]').on('change', function() {
        console.log("HI");
        var url = $(this).val();
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
    });

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