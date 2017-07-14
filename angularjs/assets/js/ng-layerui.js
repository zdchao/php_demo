/**
 * 
 */
//服务
app_main.service("layui", function(){
	var layui = function(){
		this.arr = [];
		this.getArr = function(){
			return this.arr;
		}
		this.pushArr = function(elem){
			this.arr.push(elem);
		}
	}
	return new layui();
});

app_main.controller("layeruiController",function(layui,$rootScope,$scope,$route,$http,$location,$timeout){
	$scope.domain = "ccc.com";
	$scope.domain_op_box = false;
	$scope.add_domain_box = false;
	
	$scope.addDomain = function(){
		console.log($scope.domain);
		layui.pushArr($scope.domain);
		console.log(layui.getArr());
	};
	
	$scope.showDomainOpBox = function(){
		$scope.domain_op_box = !$scope.domain_op_box;
	};
	
	$scope.addDomainBtn = function(){
		$scope.add_domain_box = !$scope.add_domain_box;
	};
	
	$scope.closeAddDomainBox = function(){
		$scope.add_domain_box = false;
	};
	
	console.log(layui.getArr());
	
}).directive("domainDirective",function(){
	return{
		restrict:"EAC",
		templateUrl:"domain_directive.html"
	};
});