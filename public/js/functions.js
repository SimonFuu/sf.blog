var videoVolume = function () {
    var videoMuted = true;
    $('#video-volume').on('click', function () {
        var icon = $(this).find('.fa');
        var video = $('.slider-video > video');
        if (videoMuted) {
            icon.removeClass('fa-volume-off');
            icon.addClass('fa-volume-up');
            videoMuted = false;
            video.prop('muted', false);
            video.volume = 1;
        } else {
            icon.removeClass('fa-volume-up');
            icon.addClass('fa-volume-off');
            videoMuted = true;
            video.prop('muted', true);
            video.volume = 0;
        }
    });
};
$(document).ready(function () {
    videoVolume();
});