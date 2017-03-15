(function(){
	angular.module('panelApp').controller('usersCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', usersCtrl]);
	
	function usersCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.types = [];
		$http.get('/api/users/types').then(function(response) {
			$scope.types = response.data.data;
		});
		
		$scope.add_users = function(id) {
			id = id || false;

			var user = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].id == id)
					{
						user = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "myModalContent.html",
                controller: 'ModalUserCtrl',
				resolve: {
					items: {'types': $scope.types, 'user': user}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
				$scope.get_list();
			}, function() {

			}); 
		};

		$scope.remove_users = function(id) {
			if (confirm('Do you realy want to remove this item?'))
			{
				$http.delete('/api/users/delete/' + id).then(function(response) {
					$rootScope.errors = response.data.message;
					$scope.get_list();
				});
			}
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
			$scope.types = items.types;
			$scope.user = {'id': 0,
						   'email': '',
						   'password': '',
						   'type': items.types[0]};
			
			if (items.user && items.user.id)
			{
				$scope.user = items.user;
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