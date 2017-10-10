var videoVolume = function () {
    var videoMuted = true;
    $('#video-volume').on('click', function () {
        var icon = $(this).find('.fa');
        var video = document.getElementById('video-container');
        if (videoMuted) {
            video.play();
            icon.removeClass('fa-volume-off');
            icon.addClass('fa-volume-up');
            videoMuted = false;
            video.volume = 1;
        } else {
            icon.removeClass('fa-volume-up');
            icon.addClass('fa-volume-off');
            videoMuted = true;
            video.volume = 0;
        }
    });
};

var youtubeInclude = function () {
    $('#slider-video').YTPlayer({
        fitToBackground: true,
        videoId: 'i-lA5nAZvII',
        mute: false,
        repeat: true
    });
};

var inGFWCheck = function () {
    /**
     * 需要优化
     */
    var image = new Image();
    image.onload = function() {
        $('.slider-video').html('');
        youtubeInclude();
    };
    image.onerror = function() {
        videoVolume();
    };
    image.src = "https://youtube.com/favicon.ico";
};

$(document).ready(function () {
    inGFWCheck();
});