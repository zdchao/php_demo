/**
 * 公共路由
 */
var app_main = angular.module("main",["ngRoute"]);

//配置路由
app_main.config(function($routeProvider,$locationProvider,$httpProvider){
	$routeProvider.when("/layerui",{
		templateUrl:"/layerui.html",
		controller:"layeruiController"
	}).otherwise({
		redirectTo: '/layerui'
	});
	
	$httpProvider.defaults.transformRequest=function(obj){
	    var str=[];
	    for(var p in obj){
	       str.push(encodeURIComponent(p)+"="+encodeURIComponent(obj[p]));
	    }
	    return str.join("&");
	};
	$httpProvider.defaults.headers.post={
	    'Content-Type':'application/x-www-form-urlencoded'
	};
});

app_main.controller("initController",function($rootScope,$scope,$route,$http,$location,$timeout){
	
});

