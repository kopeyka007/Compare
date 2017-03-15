(function() {
	angular.module('panelApp').controller('catsCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', catsCtrl]);
	function catsCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.add = function(id) {
			id = id || false;

			var cat = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].id == id)
					{
						cat = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalCatsContent.html",
                controller: 'ModalCatsCtrl',
				resolve: {
					items: {'cat': cat}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
				$scope.get_list();
			}, function() {

			}); 
		};

		$scope.remove = function(id) {
			if (confirm('Do you realy want to remove this item?'))
			{
				$http.delete('/api/cats/delete/' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					$scope.get_list();
				});
			}
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/cats/list').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
	}
})();

(function() {
	angular.module('panelApp').controller('ModalCatsCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', 'items', ModalCatsCtrl]);
	function ModalCatsCtrl($scope, $rootScope, $http, $uibModalInstance, items) {
		$scope.cat = {'id': 0,
					  'slug': '',
					  'name': ''};
		
		if (items.cat && items.cat.id)
		{
			for (var k in items.cat)
			{
				$scope.cat[k] = items.cat[k];
			}
		}
													
		$scope.save = function () {
			$http.post('/api/cats/save', $scope.cat).then(function(response) {
				if (response.data.data)
				{
					$uibModalInstance.close(response.data.message);
				}
			});
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();