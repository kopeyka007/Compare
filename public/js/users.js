(function(){
	angular.module('panelApp').controller('usersCtrl', ['$scope', '$http', '$window', '$uibModal', 'validate', usersCtrl]);
	
	function usersCtrl($scope, $http, $window, $uibModal, validate){
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
					user_type: $scope.user_type
				}
				
				$http.post('/api/users/save', user_data).then(function(response){
					$scope.type_users = response.data.data;
				});
				
				$uibModalInstance.close();
				console.log(user_data);
			};

			$scope.cancel = function () {
				$uibModalInstance.dismiss('cancel');
			};
		}
		
		
})();