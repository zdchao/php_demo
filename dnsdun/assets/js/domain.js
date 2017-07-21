/**
 * 
 */
//服务

app_main.service("domain", function(){
	var domain = function(){
	}
	return new domain();
});


app_main.controller("domainController",function(domain,$rootScope,$scope,$route,$http,$location,$timeout){
	$scope.add_domain_box = false;
	
	$scope.addDomainBtn = function(){
		$scope.add_domain_box = !$scope.add_domain_box;
	};
	
}).directive("domainDirective",function(){
	return{
		restrict:"EAC",
		templateUrl:"domain_directive.html"
	};
});