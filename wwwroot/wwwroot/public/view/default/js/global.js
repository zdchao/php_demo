$(function(){
//公用
//最后一个li
$('ul.last_list').each(function() {
$(this).children('li:last').addClass('last');
});
//经过效果
$('ul.hover_list li').hover(function(){
$(this).addClass('hover').siblings().removeClass('hover');	
});
//表格的最后一个th
$('table.last_table tr').each(function() {
$(this).children('th:last').addClass('last');
});
//开始标签，需点击才有变化的
var $tab_dd = $("div.tab_c_nav dl dd")
$tab_dd.click(function(){
$(this).addClass("tab_light").siblings().removeClass("tab_light");
var index = $tab_dd.index(this);
$("div.tab_c_box > div").eq(index).show().siblings().hide();
}).hover(function(){
$(this).addClass("tab_hover");
},function(){
$(this).removeClass("tab_hover");
});


	$('ul.online li').hover(function(){
	  $(this).children(".ts").show();
	},function(){
	  $(this).children(".ts").hide();
	});

	$('ul.online li .o_3t ,ul.online li .o_3').click(function(){
	  $('.yd-feedback-suggestion').show();
	});

	$('.fb-close').click(function(){
	  $('.yd-feedback-suggestion').hide();
	});
	
	
});

$(document).ready(function () {
	$('.mains').height((document.documentElement.clientHeight)-($('.header').height())-($('.header_c').height())-($('.footer_d').height())-40);
	
	if( ($(window).width()-1000)/2 > 70 )
		$('div.online').css({'left':($(window).width()-1000)/2+1004});
	else{
		$('div.online').css({'left':'auto'});
	}
});
	  
$(window).resize(function () {
	$('.mains').height((document.documentElement.clientHeight)-($('.header').height())-($('.header_c').height())-($('.footer_d').height())-40);
	
	if( ($(window).width()-1000)/2 > 70 )
		$('div.online').css({'left':($(window).width()-1000)/2+1004});
	else{
		$('div.online').css({'left':'auto'});
	}
}).resize();



$(document).ready(function(){
$(window).scroll(function(){
if ($(window).scrollTop()>256){
$(".tab_top").css({position: "fixed", top: 0, left:50+"%",marginLeft:-500+"px"});
$(".tab_con").css({paddingTop: 195+"px"});
} else {
$(".tab_top").css({position: "relative"});
$(".tab_con").css({paddingTop: 0});
}});
});