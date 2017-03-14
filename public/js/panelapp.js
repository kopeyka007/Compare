(function(){
	angular.module('panelApp', ['ngRoute', 'ngSanitize', 'ngAnimate', 'ui.bootstrap']);
	angular.module('panelApp').config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		
		$locationProvider.html5Mode({
			enabled: true,
			requireBase: false
		});
		var routes, setRoutes;

		routes = [
			'panel/:controller/:id/',
			'panel/:controller/',
			'panel'
		];

		setRoutes = function(route) {
			var config, url;
			url = '/' + route;
			config = {
				templateUrl: function(params)
				{
					if (params.controller && params.id)
					{
						return '/pages/panel/' + params.controller + '/' + params.id;
					}
					else if (params.controller)
					{
						return '/pages/panel/' + params.controller;
					}
					else if (params)
					{
						return  '/pages/panel/dashboard';
					}	
				}
			};
			
			$routeProvider.when(url, config);
			return $routeProvider;
		};

		routes.forEach(function(route) {
			return setRoutes(route);
		});

	   $routeProvider
			.when('/', {templateUrl: '/pages/panel/dashboard'});
	}]);
})();

(function(){
	angular.module('panelApp').controller('panelCtrl', ['$scope', '$http', '$window', '$uibModal', panelCtrl]);
	
	function panelCtrl($scope, $http, $window, $uibModal){
		$scope.errors = [];
		$scope.user = false;
		$http.get("/api/users/info").then(function(response) {
			$scope.user = response.data.data;
		});
		
		$scope.logout = function() {
			$http.post("/api/signout", {}).then(function(response){
				$window.location.reload(true);
			});
		}
		
		$scope.add_users = function () {
			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "myModalContent.html",
                controller: 'ModalUserCtrl'

			});	
		}
	}
})();


(function(){
	angular.module('panelApp').controller('ModalUserCtrl', ['$scope', '$http', '$uibModalInstance', ModalUserCtrl]);
		function ModalUserCtrl($scope, $http, $uibModalInstance) {
			
			$scope.ok = function () {
				
				$uibModalInstance.close();
			};

			$scope.cancel = function () {
				$uibModalInstance.dismiss('cancel');
			};
		}
})();
