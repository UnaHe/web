$(function(){
    //提交表单事件
    $(".pyt_sub").on('click', function (e) {
        var sex = $(".pyt_sex");
        var birthday = $(".birthday").val();
        var address = $(".address").val();
        var pyt_workType = $(".pyt_workType");
        var pyt_nature = $(".pyt_nature").val();
        var department = $(".department").val();
        var earnings = $(".earnings").val();
        var organization = $(".organization").val();
        var QQnum = $(".QQnum").val()
        var checkbox = $(".checkbox");
        var checked_val, pyt_workType_one;
        var checkbox_choice = [];
        for (var i = 0; i < sex.length; i++) {
            if ($(sex[i]).prop('checked')) {
                checked_val = $(sex[i]).val()
            }
        }
        for (var i = 0; i < pyt_workType.length; i++) {
            if ($(pyt_workType[i]).prop('checked')) {
                pyt_workType_one = $(pyt_workType[i]).val()
            }
        }
        for (var i = 0; i < checkbox.length; i++) {
            if ($(checkbox[i]).prop('checked')) {
                checkbox_choice.push($(checkbox[i]).val())
            }
        }

        if (birthday != '' && address != '' && pyt_nature != '' != department && earnings != '' && organization != '' && QQnum != '') {
            //    发请求

            $.ajax({
                type: "POST",
                url: formPost,
                data: $('.user_info').serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.code == 200) {
                        if (data.data.message) {
                            layer.alert(data.data.message, {
                                skin: 'layui-layer-lan' //样式类名
                                , closeBtn: 0
                            }, function () {
                                window.location.reload()
                            });
                        }
                    } else {
                        layer.alert(data.msg.msg, {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        });
                        $(e).attr('disabled', false);
                    }
                }
            });


        }
    })
//表单验证
    $(function () {
        $('form').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                qq_id: {
                    message: '请输入正确的QQ号',
                    validators: {
                        notEmpty: {
                            message: 'QQ号不能为空'
                        },
                        stringLength: {
                            min: 8,
                            max: 11,
                            message: 'QQ号的长度为8—11位'
                        },
                        regexp: {
                            regexp: /^[0-9_\.]+$/,
                            message: 'QQ只能是数字'
                        },
                    },
                },
                birthday: {
                    validators: {
                        notEmpty: {
                            message: '请选择出生日期'
                        }
                    }
                },
                //单位验证
                company: {
                    validators: {
                        notEmpty: {
                            message: '单位名称不能为空'
                        }
                    }
                },
                //部门验证
                department: {
                    validators: {
                        notEmpty: {
                            message: '部门或职位不能为空'
                        }
                    }
                },
            }
        });
    });

//兼容placeholder----------------------IE版
    $(function () {
        jQuery('[placeholder]').focus(function () {
            var input = jQuery(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function () {
            var input = jQuery(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.addClass('placeholder');
                input.val(input.attr('placeholder'));
            }
        }).blur().parents('form').submit(function () {
            jQuery(this).find('[placeholder]').each(function () {
                var input = jQuery(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    })


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })


});


