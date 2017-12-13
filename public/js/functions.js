var resizeIndexHeight = function () {
    var displayTable = $('.display-table');
    if (displayTable.length > 0) {
        var height = $(window).height();
        displayTable.css('height', height);
        $('.player').css('height', height);
    }
    $(window).on('resize', function () {
        height = $(window).height();
        displayTable.css('height', height);
        $('.player').css('height', height);
    });
};
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
            footerHeight = footer.length > 0 ? footer.height() + parseInt(footer.css('padding-bottom')) + 41 : 0;
            $('.blog-right-section').css('min-height', $(window).height() - parseInt($('.login-user-info').height()) - parseInt(blogMain.css('margin-top')) - footerHeight);
        }
    };
    var blogMain = $('.blog-main');
    calculator(blogMain);
    $(window).on('resize', calculator(blogMain));
};

/**
 * reword
 */
var rewordMe = function () {
   $('.page-reword-button').on('click', function () {
       $('#rewordModal').modal('show');
   });
};

var changyanCommentLoader = function () {
    if ($('.comments').length > 0) {
        var appid = CHANGYAN_APP_ID;
        var conf = CHANGYAN_CONF;
        var width = window.innerWidth || document.documentElement.clientWidth;
        if (width < 768) {
            $('script').after('<script id="changyan_mobile_js" charset="utf-8" type="text/javascript" src="https://changyan.sohu.com/upload/mobile/wap-js/changyan_mobile.js?client_id=' + appid + '&conf=' + conf + '"></script>');
        } else {
            var loadJs = function(d,a) {
                var c=document.getElementsByTagName("head")[0]||document.head||document.documentElement;
                var b=document.createElement("script");
                b.setAttribute("type","text/javascript");
                b.setAttribute("charset","UTF-8");b.setAttribute("src",d);
                if(typeof a==="function"){
                    if(window.attachEvent){
                        b.onreadystatechange=function(){
                            var e=b.readyState;
                            if(e==="loaded"||e==="complete"){
                                b.onreadystatechange=null;
                                a()
                            }
                        }
                    }else{
                        b.onload=a
                    }
                }
                c.appendChild(b)
            };
            loadJs("https://changyan.sohu.com/upload/changyan.js",function(){
                window.changyan.api.config({appid:appid,conf:conf})
            });
        }
        var notice = $('.module-cmt-notice');
        if (notice.length > 0) {
            notice.html('');
        }
    }
};

var baiduZhanzhang = function () {
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https'){
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else{
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
};

var archiveStatistic = function () {
    var archiveBody = $('.markdown-body');
    if (archiveBody.length > 0 && typeof sid !== 'undefined') {
        new Fingerprint2().get(function(client){
            setTimeout(function () {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: archiveStatisticUrl,
                    data: {'sid': sid, 'client': client}
                });
            }, 2000);
        });

    }


};
$(document).ready(function () {
    archiveStatistic();
    resizeIndexHeight();
    changyanCommentLoader();
    indexVideoLoader();
    adjustRightSectionHeight();
    rewordMe();
    baiduZhanzhang();
});