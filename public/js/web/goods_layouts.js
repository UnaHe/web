/**
 * Created by tk on 2018/1/11.
 */
$(function () {
    /**
     * 登录下拉
     */
    $('#login').click(function () {
        if ($('.drop-down-content').css('display') == 'none') {
            $(this).css('background', 'white');
            $('.drop-down-content').css('display', 'block');
        } else {
            $(this).css('background', 'rgba(238,238,238,1)');
            $('.drop-down-content').css('display', 'none');
        }
    });


    /**
     * 高级筛选多选变单选
     */
    $('.screen-checkbox').click(function () {
        $('.screen-checkbox').each(function ($key, $val) {
            $($val).prop('checked', false);
        });
        $(this).prop('checked', true);
    });

})