/**
 * 响应式js文件
 */
$(document).ready(function(){
	if($(window).width() > 768 && $(window).width() < 979){
		responsiveRecordNav();
		
		$("#responsive-record-search").addClass("zhdc-record-search");
		$("#responsive-record-operat").find("div").removeAttr('class');
		$("#responsive-record-operat").addClass("zhdc-record-operat");
		
	}
	if($(window).width() <= 767){
		responsiveRecordNav();
		
		$("#responsive-record-search").addClass("zhdc-record-search");
		$("#responsive-record-operat").find("div").removeAttr('class');
		$("#responsive-record-operat").addClass("zhdc-record-operat");
		
	}
});
window.onresize = windowWidth;
function windowWidth(){
	if($(window).width() <= 767){
		responsiveRecordNav();
		
		$("#responsive-record-search").addClass("zhdc-record-search");
		$("#responsive-record-operat").addClass("zhdc-record-operat");
	}
	if($(window).width() > 768 && $(window).width() < 979){
		responsiveRecordNav();
		
		$("#responsive-record-search").addClass("zhdc-record-search");
		
	}
	if($(window).width() > 1200 && $(window).width() < 1570){
		$("#responsive-record-nav").removeAttr('class');
		$("#record-operat").removeAttr('class');
		$("#responsive-operat-span").removeAttr("class");
		$("#responsive-record-nav").addClass("tabbable");
		$("#record-operat").addClass("nav nav-tabs");
		$("#responsive-operat-span").addClass("span3");
	}
	if($(window).width() > 1570){
		$("#responsive-record-nav").removeAttr('class');
		$("#record-operat").removeAttr('class');
		$("#responsive-operat-span").removeAttr("class");
		$("#responsive-record-nav").addClass("tabbable");
		$("#record-operat").addClass("nav nav-tabs");
		$("#responsive-operat-span").addClass("span3");
	}
}


function responsiveRecordNav(){
	var nav = 0;
	$("#responsive-record-nav").removeAttr("class");
	$("#responsive-operat-span").removeAttr('class');
	$("#record-operat").removeAttr("class");
	$("#record-operat").find("li").removeAttr("class");
	$("#responsive-record-nav").addClass("responsive-record-nav");
	$("#record-operat").bind("click",function(){
		if(nav == 1){
			$("#record-operat").find("li").css("display","none");
			$("#record-operat").css("height","30px");
			nav = nav -1;
		}else{
			$("#record-operat").find("li").css("display","block");
			$("#record-operat").css("height","auto");
			nav = nav + 1;
		}
	});
}