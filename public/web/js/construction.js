// 头部选中
$("#nav_pro li").hover(function () {
    var active_li=$("#nav_pro li");
    for(var i=0;i<active_li.length;i++){
        active_li[i].className='';
        active_li[active_li.length-1].className='open_terrace'
    }
    $(this).addClass('active_index1')
},function () {
    var active_li=$("#nav_pro li");
    $(this).removeClass('active_index1');
    active_li[0].className='active_index'
})