/**
 * Created by tk on 2018/1/11.
 */
$('.step_back').click(function () {
    var left = parseInt($('.big_step').css('left')) - 220;
    if (left < -660) {
        return false;
    }
    $('.big_step').css('left', left + 'px');
});

$('.step_go').click(function () {
    var left = parseInt($('.big_step').css('left')) + 220;
    if (left >= 220) {
        return false;
    }
    $('.big_step').css('left', left + 'px');
});

$(".step-time-div").click(function () {
    $(".step-time-div").each(function ($key, $val) {
        $($val).css('background', 'rgba(225, 176, 90, 1)');
    })
    $(this).css('background', '#CA9E51');
})