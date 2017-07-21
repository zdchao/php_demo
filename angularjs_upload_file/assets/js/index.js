/**
 * 
 */
var app_main = angular.module("m",["ngFileUpload","chieffancypants.loadingBar","ngAnimate"]);

app_main.config(function($httpProvider){
	
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

app_main.controller("uploadFileController",function($rootScope,$scope,$http,Upload,cfpLoadingBar){
	$scope.file = null;
	
	$scope.upfileSubmit = function(){
		angular.forEach($scope.file, function(file, index){
            $scope.upload(file, index);
        });
	};
	
	$scope.upload = function(file,index){
		cfpLoadingBar.start();
		Upload.upload({
            url: '/php/index.php',
            file: file
        }).progress(function(evt){
        	console.log(evt);
        }).success(function(a){
            $scope.file = null;
            cfpLoadingBar.complete();
        }).error(function(data, status, headers, config){
            $scope.file = null;
        })
	};
	cfpLoadingBar.start();
	$http.get("/php/index.php").success(function(a){
		cfpLoadingBar.complete();
	});
});