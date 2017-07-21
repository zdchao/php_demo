/**
 * 公共路由
 */
var app_main = angular.module("main",["ngRoute"]);

//配置路由
app_main.config(function($routeProvider,$locationProvider,$httpProvider){
	$routeProvider.when("/domain",{
		templateUrl:"/domain.html",
		controller:"domainController"
	}).otherwise({
		redirectTo: '/domain'
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

app_main.service("init", function(){
	var init = function(){
		this.groups = ["全部","未分组","ddd"];
		this.getGroups = function(){
			return this.groups;
		}
	}
	return new init();
});

app_main.controller("initController",function(init,$rootScope,$scope,$route,$http,$location,$timeout){
	$rootScope.groups = init.getGroups();
});

