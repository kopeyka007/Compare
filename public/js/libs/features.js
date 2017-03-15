(function() {
	angular.module('panelApp').controller('featuresCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', featuresCtrl]);
	function featuresCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.cats = [];
		$http.get('/api/cats/list').then(function(response) {
			$scope.cats = response.data.data;
		});

		$scope.add = function(id) {
			id = id || false;

			var feature = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].features_id == id)
					{
						feature = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalFeaturesContent.html",
                controller: 'ModalFeaturesCtrl',
				resolve: {
					items: {'cats': $scope.cats, 'feature': feature, 'list': $scope.list}
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
				$http.delete('/api/features/delete/' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					$scope.get_list();
				});
			}
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/features/list').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
	}
})();

(function() {
	angular.module('panelApp').controller('ModalFeaturesCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', 'validate', 'items', ModalFeaturesCtrl]);
	function ModalFeaturesCtrl($scope, $rootScope, $http, $uibModalInstance, validate, items) {
		$scope.errors = [];
		$scope.feature = {'features_id': 0,
						  'cats_id': 0,
					  	  'features_name': '',
					  	  'features_icon': '',
					  	  'features_desc': '',
					  	  'features_units': '',
					  	  'features_around': '',
					  	  'features_norm': ''};
		
		if (items.feature && items.feature.features_id)
		{
			for (var k in items.feature)
			{
				$scope.feature[k] = items.feature[k];
			}
		}
													
		$scope.save = function () {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.name, 'Name');
			error *= validate.check($scope, $scope.form.cats_id, 'Category');

			if (error)
			{
				$http.post('/api/features/save', $scope.feature).then(function(response) {
					if (response.data.data)
					{
						$uibModalInstance.close(response.data.message);
					}
				});
			}
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();