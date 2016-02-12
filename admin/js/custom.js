// JavaScript Document
$(document).bind("mobileinit", function() {
    $.extend($.mobile, {
        loadingMessage: '로딩 중...'
            //,metaViewportContent : 'width=device-width, minimum-scale=0.5, maximum-scale=0.5'
    });
});

//If you want to use it globally to refresh all previous pages on "back" you can use "div" instead of "#PageId".
//$(document).on("pagehide", "div[data-role=page]", function(event){
$(document).on("pagehide", "#[list]", function(event) {
    $(event.target).remove();
}); // page refreshing forcely




