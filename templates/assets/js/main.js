$(function () {
    var options = {
        'html': true,
        'container': 'body'
    }
    $('.city-info').popover(options);
    $('#map').bind('mousemove', function (event) {
        var mapLeft = parseInt($(this).css('left')) * -1;
        var mapTop = parseInt($(this).css('top')) * -1;
        var position = {
            top: mapTop + event.pageY,
            left: mapLeft + event.pageX
        }
        console.log(position);
    });
})