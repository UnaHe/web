<!--显示二级菜单-->
var radioclick1=1;
$(".dropdown1").on('click',function(){
    var menu2=document.getElementById('menu2');
    console.log(menu2)
    menu2.style.display='block'
    if (radioclick1 % 2 == 0) {
        menu2.style.display='none'
    }
    radioclick1++
})
//智能导购
$(".solve_single_box1").hover(function(){
    $(".checked_box1").addClass('active_bar1');
},function(){
    $(".checked_box1").removeClass('active_bar1');
});
//推客助手
$(".solve_single_box2").hover(function(){
    $(".checked_box2").addClass('active_bar2');
},function(){
    $(".checked_box2").removeClass('active_bar2');
});
// 推客生态
$(".solve_single_box3").hover(function(){
    $(".checked_box3").addClass('active_bar3');
},function(){
    $(".checked_box3").removeClass('active_bar3');
});
// 优质品库
$(".solve_single_box4").hover(function(){
    $(".checked_box4").addClass('active_bar4');
},function(){
    $(".checked_box4").removeClass('active_bar4');
});
   // 主打栏目阴影延迟加载
$('.column_single_box').hover(function(){
    var $this=$(this)
    setTimeout(function () {
        // $this.removeClass('active_leave');
        $this.addClass('active_hover');
    },100)
},function(){
    var $this=$(this)
    setTimeout(function () {
        $this.removeClass('active_hover');
        // $this.addClass('active_leave');
    },200)
})
//    获取顶部位置
$(window).scroll(function(){
    var scroll=$(window).scrollTop();
    console.log(scroll);
    if(scroll>280){
        var show_allBox=document.getElementById('column_all_box');
        show_allBox.style.display='block'
        $("#main_column").addClass('show_fadeinUp');
        $('#column_all_box').addClass('show1');
    }
    if(scroll>1050){
        var show_allBox=document.getElementById('product_all_box');
        show_allBox.style.display='block'
        $("#pruduct_column_title").addClass('show_fadeinUp')
        $('#product_all_box').addClass('show');
    }
    if(scroll>1650){
        var show_allBox=document.getElementById('none_matrix');
        show_allBox.style.display='block'
        $("#list_column_title").addClass('show_fadeinUp')
        $('#matrix').addClass('show2');
    }
    if(scroll>2450){
        // var show_allBox=document.getElementById('solve_all_box');
        // show_allBox.style.display='block'
        $("#solve_title").addClass('show_fadeinUp')
        $('#inner').addClass('show3');
    }
})
//    滚动条
var oBox=document.getElementById("box");
var oBar=document.getElementById("scrollbtn");
var oscrollline=document.getElementById("scrollline");
// var solves=document.getElementById('solve_all_box')
var disX = 0;
var maxL = 110;
var iScale = 0;
var oInner=document.getElementById("solve_all_box");
var oContent=document.getElementById("test");
oBar.onmousedown = function (event)
{
    var event = event || window.event;
    disX = event.clientX - oBar.offsetLeft;
    document.onmousemove = function (event)
    {
        var event = event || window.event;
        var iL = event.clientX - disX;
        iL <= 0 && (iL = 0);
        iL >= maxL && (iL = maxL);
        oBar.style.left = iL + "px";
        oInner.style.marginLeft=-(oInner.offsetWidth-oContent.offsetWidth)*iScale+"px";
        iScale = iL / maxL;
        return false
    };
    document.onmouseup = function ()
    {

        document.onmousemove = null;
        document.onmouseup = null
    };
    return false
};
//齿轮滚动
// oBox.onmouseover = function (event)
// {
//     event = event || window.event;
//     function mouseWheel(event)
//     {
//         var delta = event.wheelDelta ? event.wheelDelta : -event.detail * 40
//         var iTarget = delta > 0 ? -30 : 30;
//
//
//
//         //console.log(oBar.offsetLeft + iTarget)
//         togetherMove(oBar.offsetLeft + iTarget)
//         stopEventBubble(event);
//     }
//     addHandler(this, "mousewheel", mouseWheel);
//     addHandler(this, "DOMMouseScroll", mouseWheel);
// };
oscrollline.onclick = function (event)
{
    var iTarget = (event || window.event).clientX - oBox.offsetLeft - this.offsetLeft - oBar.offsetWidth / 2;
    togetherMove(iTarget)
};
function togetherMove(iTarget)
{
    if (iTarget <= 0)
    {
        iTarget = 0
    }
    else if (iTarget >= maxL)
    {
        iTarget	= maxL
    }
    iScale = iTarget / maxL;
    oInner.style.marginLeft=-(oInner.offsetWidth-oContent.offsetWidth)*iScale+"px";
    oBar.style.left = iTarget + "px";
}
function addHandler(element, type, handler)
{
    return element.addEventListener ? element.addEventListener(type, handler, false) : element.attachEvent("on" + type, handler)
};
function stopEventBubble(event){
    var e=event || window.event;

    if (e && e.stopPropagation){
        e.stopPropagation();
    }
    else{
        e.cancelBubble=true;
    }
};


//轮播
$(function(){
    var i=0;
    var timer=null;
    // var firstimg=$('.solve_single_box').first().clone(); //复制第一张图片
    var width=$('.solve_single_box').length;
    $('#solve_all_box').width((width-2)*($('.solve_single_box').width())); //将第一张图片放到最后一张图片后，设置ul的宽度为图片张数*图片宽度

//定时器自动播放
    timer=setInterval(function(){
        i++;
        if (i==$('.solve_single_box').length-3) {
            i=1;
            $('#solve_all_box').css({left:0});
        };
        console.log($('.solve_single_box').length)
        $('#solve_all_box').stop().animate({left:-i*560},2900);
        // var firstimg=$('.solve_single_box').first().hide();
    },3000)
//鼠标移入，暂停自动播放，移出，开始自动播放
    $('.solve_single_box').hover(function(){
        console.log(1111111111111111111)
        clearInterval(timer);
    },function(){
        timer=setInterval(function(){
            i++;
            if (i==$('.solve_single_box').length-3) {
                i=1;
                $('#solve_all_box').css({left:0});
            };
            console.log($('.solve_single_box').length)
            $('#solve_all_box').stop().animate({left:-i*560},2900);
        },3000)
    })

    //光圈
    setTimeout(function () {
        $("#pulse1").addClass('pulse1')
    },700)

})
//    头部选中
$("#nav_pro li").hover(function () {
    var active_li=$("#nav_pro li");
    for(var i=0;i<active_li.length;i++){
        active_li[i].className='';
        active_li[active_li.length-1].className='open_terrace'
    }
    $(this).addClass('active_index')
},function () {
    var active_li=$("#nav_pro li");
    $(this).removeClass('active_index');
    active_li[0].className='active_index'
})