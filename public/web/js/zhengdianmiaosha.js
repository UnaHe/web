//整点购轮播
$(function () {
    lazyload.init();
    var $content = $(".rush_point");
    var i = 5;  //已知显示的<li>元素的个数
    var m = 5;  //用于计算的变量
    var count = $content.find("li").length;//总共的<li>元素的个数

    $(".next").click(function () {
        if (!$content.is(":animated")) {  //判断元素是否正处于动画，如果不处于动画状态，则追加动画。
            if (m < count) {  //判断 i 是否小于总的个数
                m++;

                $content.animate({left: "-=226px"}, 600);
            }
        }
    });
    $(".prev").click(function () {
        if (!$content.is(":animated")) {
            if (m > i) { //判断 i 是否小于总的个数
                m--;
                $content.animate({left: "+=226px"}, 600);
            }
        }
    });
   var time_active=$(".time_active");
    if(time_active.find('p')[1].innerHTML=='即将开始'){
      var btnText=document.getElementsByClassName('replace');
      for(var i=0;i<btnText.length;i++){
          btnText[i].innerText='即将开始'
      }
    //  按钮添加颜色
    var disableBtn=document.getElementsByClassName('sale_quick');
        for(var j=0;j<disableBtn.length;j++){
            disableBtn[j].className += ' disable'
        }
        //  边框添加颜色
        var border=document.getElementsByClassName('quick');
        for(var k=0;k< border.length;k++){
            border[k].className += ' quick_border'
        }
    }
})