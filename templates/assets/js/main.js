$(function () {
    var options = {
        'html': true,
        'container': 'body'
    }
    $('.city-info').popover(options);
    var iso = new Isometric(128, 74, 100, 100);

    var spanX = $('span.x');
    var spanY = $('span.y');
    $('#viewport').bind('mousemove', function (event) {
        console.log(event);
        var map = $(this).find('#map');
        var mapLeft = parseInt(map.css('left')) * -1;
        var mapTop = parseInt(map.css('top')) * -1;
        var left = mapLeft + event.clientX;
        var top = mapTop + event.clientY;
        var location = iso.px2pos(left, top);
        // spanX.text(location.posX);
        // spanY.text(location.posY);
        spanX.text(event.screenX);
        spanY.text(event.screenY);
    });
});
