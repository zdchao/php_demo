/**
 * 
 */
var nav_ope = 0;
$(document).ready(function(){
	$("#record-operat").find("#close").bind('click',function(){
		if(nav_ope == 0){
			$("#record-operat").find("#close").html('关闭');
			$("#record-operat").find("li").show();
			nav_ope = nav_ope + 1;
			return;
		}
		if(nav_ope == 1){
			$("#record-operat").find("li").hide();
			$("#record-operat").find("li").eq(0).show();
			$("#record-operat").find("#close").html('打开');
			nav_ope = nav_ope - 1;
			return;
		}
	});
	
	/************************************************************/
	window.onresize = responseWidth;
	
});
function responseWidth(){
	if($(window).width() > 1199){
		$("#record-operat").find("li").show();
		$("#record-operat").find("li").eq(0).hide();
	}
	if($(window).width() <1199 && $(window).width() > 768){
		$("#record-operat").find("li").hide();
		$("#record-operat").find("li").eq(0).show();
	}
	if($(window).width() < 768){
		$("#record-operat").find("li").hide();
		$("#record-operat").find("li").eq(0).show();
	}
}
