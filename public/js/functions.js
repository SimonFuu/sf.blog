/**
 * 绑定音量按钮点击事件
 * @param gfwBlock
 */
var videoVolume = function (gfwBlock) {
    var videoMuted = true;
    var volumeBtn = $('#video-volume');
    if (gfwBlock) {
        volumeBtn.on('click', function () {
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
    } else {
        var player = $('#player').data('ytPlayer').player;
        volumeBtn.on('click', function () {
            var icon = $(this).find('.fa');
            if (videoMuted) {
                debugger;
                icon.removeClass('fa-volume-off');
                icon.addClass('fa-volume-up');
                videoMuted = false;
                player.unMute();
                player.setVolume(100);
            } else {
                icon.removeClass('fa-volume-up');
                icon.addClass('fa-volume-off');
                videoMuted = true;
                player.mute();
                player.setVolume(0);
            }
        });
    }
};

/**
 * 引用youtube视频
 */
var youtubeInclude = function () {
    var player = $('#player');
    player.html('');
    player.YTPlayer({
        fitToBackground: true,
        videoId: 'i-lA5nAZvII',
        mute: true,
        repeat: true,
        pauseOnScroll: false,
        playerVars: {
            modestbranding: 0,
            autoplay: 1,
            controls: 0,
            showinfo: 0,
            wmode: 'transparent',
            branding: 0,
            rel: 0,
            autohide: 0,
            origin: window.location.origin
        },
        callback: function () {
            videoVolume(false)
        }
    });
};

/**
 * GFW检测
 * @param cb
 */
var gfwBlockCheck = function (cb) {
    var url = '//graph.facebook.com/feed?callback=h';
    var xhr = new XMLHttpRequest();
    var called = false;
    xhr.open('GET', url);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            called = true;
            cb(false);
        }
    };
    xhr.send();
    setTimeout(function() {
        if (!called) {
            xhr.abort();
            cb(true);
        }
    }, 1000);
};

/**
 * 加载首页的Video
 */
var indexVideoLoader = function () {
    if ($('.gfwBlockCheck').length > 0) {
        gfwBlockCheck(function(blocked) {
            if (blocked) {
                videoVolume(blocked);
            } else {
                youtubeInclude();
            }
        });
    }
};

/**
 * 调整blog-right的最低高度
 */
var adjustRightSectionHeight = function () {
    var calculator = function (blogMain) {
        if (blogMain.length > 0) {
            var footer = $('footer');
            footerHeight = footer.length > 0 ? footer.height() + parseInt(footer.css('padding-bottom')) + 10 : 0;
            $('.blog-right-section').css('min-height', $(window).height() - parseInt(blogMain.css('margin-top')) - footerHeight);
        }
    };
    var blogMain = $('.blog-main');
    calculator(blogMain);
    $(window).on('resize', calculator(blogMain));
};

$(document).ready(function () {
    indexVideoLoader();
    adjustRightSectionHeight();
});