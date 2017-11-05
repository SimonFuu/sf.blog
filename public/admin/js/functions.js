
var leftSideBarActive = function () {
    var treeViewMenu = $('.treeview-menu');
    if (treeViewMenu.length > 0) {
        treeViewMenu.each(function (index, element) {
            if ($(element).find('.active').length > 0) {
                $(element).parents('.treeview').addClass('menu-open active');
            }
        });
    }
};

var chunk = function (array, size) {
    var temp = [];
    for (var i = 0; i< array.length; i = i + size) {
        var tempArr = array;
        temp.push(tempArr.slice(i, i + size))
    }
    return temp;
};

var searchIconsArray =  function(str, container) {
    var nPos;
    var vResult = [];

    for(var i in container){
        var sTxt=container[i]||'';
        nPos=sTxt.indexOf(str);
        if(nPos>=0){
            vResult[vResult.length] = sTxt;
        }
    }
    return vResult;
};

var setActionIcons = function () {
    var icons = [];
    var maxIconsCountInLine = 0;
    var maxIconsDisplayLines = 6;
    var currentPage = 0;
    var lastPage = 0;
    var modalWidth = 0;
    if (typeof actionIcons !== 'undefined') {
        icons = JSON.parse(actionIcons);
        $('#setActionIconModal').on('shown.bs.modal', function () {
            $('.set-actions-icon-name').val('');
            modalWidth = $('.set-actions-icons-list-modal').width();
            maxIconsCountInLine = Math.floor(modalWidth / 38);
            pageIconsCount = maxIconsDisplayLines * (maxIconsCountInLine === 0 ? 8 : maxIconsCountInLine);
            actionIcons = chunk(icons, pageIconsCount);
            lastPage = actionIcons.length;
            appendActionIconsListHtml(actionIcons[currentPage], maxIconsCountInLine, maxIconsDisplayLines, currentPage, lastPage);
        });

        $('.set-actions-previous').on('click', function () {
            if (!$(this).hasClass('disabled')) {
                var previousPage = $(this).data('previous');
                appendActionIconsListHtml(actionIcons[previousPage], maxIconsCountInLine, maxIconsDisplayLines, previousPage, lastPage);
            }
        });

        $('.set-actions-next').on('click', function () {
            if (!$(this).hasClass('disabled')) {
                var nextPage = $(this).data('next');
                appendActionIconsListHtml(actionIcons[nextPage], maxIconsCountInLine, maxIconsDisplayLines, nextPage, lastPage);
            }
        });

        $('.set-actions-icon-name').on('input propertychange', function () {
            var words = $(this).val();
            var resultIcons = searchIconsArray(words, icons);
            if (resultIcons.length > 0) {
                actionIcons = chunk(resultIcons, pageIconsCount);
                lastPage = actionIcons.length;
                appendActionIconsListHtml(actionIcons[currentPage], maxIconsCountInLine, maxIconsDisplayLines, currentPage, lastPage);
            } else {
                appendActionIconsListHtml([], maxIconsCountInLine, maxIconsDisplayLines, -1, 0);
            }
        });
    }
};

var appendActionIconsListHtml = function (icons, iconsCountInLine, maxIconsDisplayLines, currentPage, lastPage) {
    var html = '<tr>';
    var maxDisplayIcons = maxIconsDisplayLines * iconsCountInLine;
    var maxIconsCountInLine = iconsCountInLine === 0 ? 8 : iconsCountInLine;
    var displayCount = icons.length > maxDisplayIcons ? maxDisplayIcons : icons.length;
    var lastIconIndex = displayCount - 1;
    var selectedIcon = $('.set-action-icon-value').val();
    for (var i = 0; i < displayCount; i++) {
        if (selectedIcon === icons[i]) {
            html += '<td><button class="btn btn-warning set-actions-icon-button" data-dismiss="modal" aria-label="Close" data-icon="' + icons[i] + '" onclick="selectActionIcon($(this));">';
        } else {
            html += '<td><button class="btn btn-default set-actions-icon-button" data-dismiss="modal" aria-label="Close" data-icon="' + icons[i] + '" onclick="selectActionIcon($(this));">';
        }
        html += '<i class="fa ' + icons[i] + '" aria-hidden="true"></i></button></td>';
        if (((i+1) % maxIconsCountInLine === 0) || i === lastIconIndex) {
            html += '</tr>';
            if (i !== lastIconIndex) {
                html += '<tr>';
            }
        }
    }
    var addOn = maxIconsCountInLine - (i % maxIconsCountInLine);
    if (addOn !== 0 && (addOn !== maxIconsCountInLine || i === 0)) {
        if (i !== 0) {
            html = html.substring(0, html.length - 5);
        }
        for (var j = 0; j < addOn; j++) {
            html += '<td></td>';
        }
        html += '</tr>';
    }
    $('.set-actions-icons-list > tbody').html(html);
    var paginate = $('.set-actions-page-info');
    paginate.attr('colspan', maxIconsCountInLine - 2);
    $('.set-actions-icon-label').parent('td').attr('colspan', maxIconsCountInLine);
    var previousBtn = $('.set-actions-previous');
    var nextBtn = $('.set-actions-next');
    if (currentPage <= 0) {
        if (!previousBtn.hasClass('disabled')) {
            previousBtn.addClass('disabled')
        }
    } else {
        if (previousBtn.hasClass('disabled')) {
            previousBtn.removeClass('disabled')
        }
    }
    if (currentPage >= (lastPage - 1)) {
        if (!nextBtn.hasClass('disabled')) {
            nextBtn.addClass('disabled')
        }
    } else {
        if (nextBtn.hasClass('disabled')) {
            nextBtn.removeClass('disabled')
        }
    }
    paginate.html((currentPage + 1) + ' / ' + lastPage);
    previousBtn.data('previous', currentPage - 1);
    nextBtn.data('next', currentPage + 1);
};

var selectActionIcon = function (e) {
    $('.set-action-icon').html('<i class="fa ' + e.data('icon') + '" aria-hidden="true"></i>');
    $('.set-action-icon-value').val(e.data('icon'));
    if (!e.hasClass('btn-warning')) {
        e.removeClass('btn-default');
        e.parents('tbody').find('.btn').each(function (index, element) {
            if ($(element).hasClass('btn-warning')) {
                $(element).removeClass('btn-warning');
                $(element).addClass('btn-default');
            }
        });
        e.addClass('btn-warning');
    }
};

var roleActionsCheckboxRelate = function () {
    $('.parentRoleAction').on('click', function () {
        if ($(this).is(':checked')) {
            // 勾选，将所有子菜单勾选
            $(this).parents('table').find('.childRoleAction').each(function (index, element) {
                $(element).prop('checked', true);
            });
        } else {
            // 移除勾选，移除所有子菜单的勾选状态
            $(this).parents('table').find('.childRoleAction').each(function (index, element) {
                $(element).prop('checked', false);
            });
        }
    });

    $('.childRoleAction').on('click', function () {
        if ($(this).is(':checked')) {
            // 子菜单勾选，则触发父级菜单勾选
            $(this).parents('table').find('.parentRoleAction').prop('checked', true);
        } else {
            // 子菜单移除勾选，判断当前子菜单勾选数量，如果为0，则移除父级菜单的勾选
            var table = $(this).parents('table');
            if (table.find('.childRoleAction:checked').length === 0) {
                table.find('.parentRoleAction').prop('checked', false);
            }
        }
    });
};

var addActionsPrefix = function () {
    var url = '';
    var menuUrl = $('.menu-url');
    if (menuUrl.length > 0 && menuUrl.val().length > 0) {
        url = menuUrl.val();
        if (url.substr(0,1) === '/') {
            url = url.substr(1, url.length-1)
        }
        if (url.substr(url.length-1, 1) !== '/') {
            url += '/';
        }
        $('.actionsPrefix').html(url)
    }

    menuUrl.on('change', function () {
        url = $(this).val();
        if (url.substr(0,1) === '/') {
            url = url.substr(1, url.length-1)
        }
        if (url.substr(url.length-1, 1) !== '/') {
            url += '/';
        }
        $('.actionsPrefix').html(url)
    });

    $('.add-action').on('click', function () {
        var html = '<div class="input-group actions-list">';
        html += $('.actions-list-template').html();
        html += '</div>';
        $('.add-drop-action-buttons').before(html);
    });

    $('.drop-action').on('click', function () {
        var actionsList = $('.actions-list');
        if (actionsList.length > 1) {
            $(this).parent('.add-drop-action-buttons').prev('.actions-list').remove();
        }
    });
};

var uploadFile = function () {
    var progressBar = $('.progress-bar.progress-bar-striped');
    var fileNameContainer = $('#file-name-container');

    $('.fileinput-button').on('click', function () {
        progressBar.removeClass('progress-bar-success');
        progressBar.removeClass('progress-bar-danger');
        progressBar.css('width', '0%');
        progressBar.attr('aria-valuenow', 0);
        progressBar.html('');
    });

    $('#file').fileupload({
        dataType: 'json',
        done: function (e, data) {
            $('.fileinput-button').removeClass('disabled');
            $('.fileinput-button>#file').prop('disabled', false);
            if (data.result.result) {
                progressBar.removeClass('progress-bar-success');
                progressBar.addClass('progress-bar-success');
                fileNameContainer.html('');
                $.each(data.result.files, function (index, file) {
                    progressBar.css('width', '100%');
                    progressBar.attr('aria-valuenow', 100);
                    progressBar.html('success');
                    $('input[name="customizationFile"]').val(file.relativePath);
                    var html = '<div class="self-alert alert alert-success alert-mini" style="margin-top: 10px;">';
                    html += '<button type="button" class="close btn btn-sm" onclick="removeCustomizationFileByClick();" data-dismiss="alert" aria-hidden="true"></button>';
                    html += '<a href="' + file.url + '" class="customization-file-a-tag" target="_blank"><strong>Click to check the customization file: ' + file.name + '</strong></a></div>';
                    fileNameContainer.html('');
                    fileNameContainer.append(html);
                    $('.remove-customization-file').removeClass('hide')
                });
            } else {
                progressBar.removeClass('progress-bar-danger');
                progressBar.addClass('progress-bar-danger');
                fileNameContainer.html('');
                progressBar.css('width', '100%');
                progressBar.attr('aria-valuenow', 100);
                progressBar.html('failed');
                var error = '<div class="self-alert alert alert-danger alert-mini" style="margin-top: 10px;">';
                error += '<button type="button" class="close btn btn-sm" data-dismiss="alert" aria-hidden="true"></button>';
                error += '<small>' + data.result.message + '</small></div>';
                fileNameContainer.html(error);
            }
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.fileinput-button').addClass('disabled');
            $('.fileinput-button>#file').prop('disabled', true);
            progress = progress === 100 ? 99 : progress;
            progressBar.css('width', progress + '%');
            progressBar.attr('aria-valuenow', progress);
            progressBar.html(progress + '%');
        },
        fail: function () {
            $('.fileinput-button').removeClass('disabled');
            $('.fileinput-button>#file').prop('disabled', false);
            progressBar.removeClass('progress-bar-danger');
            progressBar.addClass('progress-bar-danger');
            fileNameContainer.html('');
            progressBar.css('width', '100%');
            progressBar.attr('aria-valuenow', 100);
            progressBar.html('Oops,there is something wrong,pls try again later!');
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

};


$(document).ready(function () {
    leftSideBarActive();
    setActionIcons();
    roleActionsCheckboxRelate();
    addActionsPrefix();
    uploadFile();
});