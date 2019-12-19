$(function() {
    $(window).setBreakpoints({
        distinct: true,
        breakpoints: [ 1, 640 ]
    });
    $(window).bind('enterBreakpoint640',function() {
        $('.sp-img').each(function() {
            $(this).attr('src', $(this).attr('src').replace('_sp', '_pc'));
        });
    });
    $(window).bind('enterBreakpoint1',function() {
        $('.sp-img').each(function() {
            $(this).attr('src', $(this).attr('src').replace('_pc', '_sp'));
        });
    });
});