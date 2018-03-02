// 选中变色
$(".contact_us_box").hover(function () {
    $(this).children(".font_size28").addClass('color_gold');
    $(this).children(".circle").addClass('bg_color');
},function () {
    $(this).children(".font_size28").removeClass('color_gold');
    $(this).children(".circle").removeClass('bg_color');
});