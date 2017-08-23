/**
 * 
 */
$(document).ready(function(){
	rNavMenu();
});
window.onresize = responsive;
function responsive(){
	if($(window).width() >= 481){
		$(".r-nav").find("ul").show();
	}
	if($(window).width() <= 480){
		$(".r-nav").find("ul").hide();
	}
}

var rNavMenu = function(){
	$(".r-nav-menu").bind('click',function(){
		rNavMenuOff();
	});
}
var menu_off = 0;
var rNavMenuOff = function(){
	if(menu_off == 1){
		menu_off -= 1;
		$(".r-nav").find("ul").hide();
	}else{
		menu_off += 1;
		$(".r-nav").find("ul").show();
	}
}
