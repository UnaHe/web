/**
 * Created by tk on 2018/1/26.
 */

    <!-- 头部登录下拉菜单-->
    // 模态框
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })


    $("#cc").on("click", function () {
        var mtk = document.getElementById('myModal');
        mtk.style.display = 'none'
    })
