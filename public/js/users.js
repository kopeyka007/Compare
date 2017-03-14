(function(){
	angular.module('panelApp').controller('usersCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', usersCtrl]);
	
	function usersCtrl($scope, $rootScope, $http, $window, $uibModal, validate){
		$scope.types = [];
		
		$http.get('/api/users/types').then(function(response){
			$scope.types = response.data.data;
		});
		
		$scope.add_users = function () {
			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "myModalContent.html",
                controller: 'ModalUserCtrl',
				resolve: {
					items: {'types': $scope.types}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
			}); 
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/users/list').then(function(response){
				$scope.list = response.data.data;
			});
		};
	}
})();

(function(){
	angular.module('panelApp').controller('ModalUserCtrl', ['$scope', '$http', '$uibModalInstance', 'items', ModalUserCtrl]);
		function ModalUserCtrl($scope, $http, $uibModalInstance, items) {
			$scope.user_type = items.types[0];
			$scope.type_users = items.types;
														
			$scope.ok = function () {
				
				var user_data = {
					user_email: $scope.email,
					user_password: $scope.password,
					user_type: $scope.user_type.id
				}
				
				$http.post('/api/users/save', user_data).then(function(response){
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