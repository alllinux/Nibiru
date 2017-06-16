$( document ).ready(function() {
    console.log( "Nibiru Debugbar loaded!" );
    $("#nibiru-bar-open").click(function() {
        if($('#nibiru-debug').hasClass('up')) {
            $('#nibiru-debug').addClass('down', 1000, 'easeOutElastic');
            $('#nibiru-debug').removeClass('up');
            $('#nibiru-bar-open').addClass('closed', 1000, 'easeOutElastic');
            $('#nibiru-bar-open').removeClass('open');
        } else {
            $('#nibiru-debug').removeClass('down');
            $('#nibiru-debug').addClass('up', 1000, 'easeInElastic');
            $('#nibiru-bar-open').removeClass('closed');
            $('#nibiru-bar-open').addClass('open', 1000, 'easeInElastic');
        }
    });
});