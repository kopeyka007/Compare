(function(){
	angular.module('panelApp').controller('usersCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', usersCtrl]);
	
	function usersCtrl($scope, $rootScope, $http, $window, $uibModal, validate){
		$scope.types = [];
		
		$http.get('/api/users/types').then(function(response){
			$scope.types = response.data.data;
		});
		
		$scope.add_users = function(id) {
			id = id || false;
			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "myModalContent.html",
                controller: 'ModalUserCtrl',
				resolve: {
					items: {'types': $scope.types, 'id': id}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
				$scope.get_list();
			}); 
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/users/list').then(function(response){
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
	}
})();

(function(){
	angular.module('panelApp').controller('ModalUserCtrl', ['$scope', '$http', '$uibModalInstance', 'items', ModalUserCtrl]);
		function ModalUserCtrl($scope, $http, $uibModalInstance, items) {
			$scope.user_type = items.types[0];
			$scope.user = {'email': '',
						   'password': '',
						   'type': items.types};
			
			if (items.id)
			{
				$http.get('/api/users/list').then(function(response){
					$scope.user = response.data.data;
				});
			}
														
			$scope.ok = function () {
				$http.post('/api/users/save', $scope.user).then(function(response){
					if (response.data.data) {
						$uibModalInstance.close(response.data.message);
					}
				});
			};

			$scope.cancel = function () {
				$uibModalInstance.dismiss('cancel');
			};
		}
		
		
})();