/**
 * 
 */
var app_main = angular.module("main",["ngRoute"]);
app_main.controller("init",function($scope,$route,$http){
	console.log("初始化");
	$scope.hello ="初始化";
	$scope.user = null;
	$http.post("php/index.php/?",{
		c:"bbq"
	}).success(function(a){
		console.log(a);
	});
	
});
app_main.controller("aController",function($scope,$route,$http){
	$scope.msg = "";
	$http.post("php/index.php/?",{
		c:"我是a啊"
	}).success(function(a){
		console.log(a);
		$scope.hello = a.c;
	});
	$scope.hh = function(){
		alert($scope.msg);
	}
});
app_main.controller("bController",function($scope,$route,$routeParams){
	$scope.hello = "b";
	$scope.hello = $routeParams.dd;
	console.log($routeParams);
});
app_main.config(function($routeProvider,$locationProvider,$httpProvider){
	$routeProvider.when("/a",{
		templateUrl:"a.html",
		controller:"aController"
	}).when("/b/:dd",{
		templateUrl:"b.html",
		controller:"bController"
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
