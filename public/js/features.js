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
	angular.module('panelApp').controller('ModalFeaturesCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', '$timeout', 'validate', 'items', ModalFeaturesCtrl]);
	function ModalFeaturesCtrl($scope, $rootScope, $http, $uibModalInstance, $timeout, validate, items) {
		$scope.errors = [];
		$scope.cats = [{'cats_id': 0, 'cats_name': 'Chose Category'}].concat(items.cats);
		$scope.feature = {'features_id': 0,
						  'cats_id': {'cats_id': 0, 'cats_name': 'Chose Category'},
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
								
		$scope.fd = new FormData();
		$scope.xhr = new XMLHttpRequest;
		$scope.fr = new FileReader();					
		$scope.save = function () {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.name, 'Name');
			error *= validate.check($scope, $scope.form.cats_id, 'Category');

			if (error)
			{
				for (var key in $scope.feature)
				{
					$scope.fd.append(key, $scope.feature[key]);
				}

				$scope.xhr.onload = function() {
					if ($scope.xhr.readyState == 4)
					{
						console.log(JSON.parse($scope.xhr.responseText));
						//$uibModalInstance.close(response.data.message);
					}
				};

				$scope.xhr.open("post", "/api/features/save");
				$scope.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				$scope.xhr.setRequestHeader("X-CSRF-Token", $rootScope.token);
				$scope.xhr.send($scope.fd);
				/*$http.post('/api/features/save', $scope.feature).then(function(response) {
					if (response.data.data)
					{
						$uibModalInstance.close(response.data.message);
					}
				});*/
			}
		};

		$scope.preview = false;
		$scope.load = function(file) {
			$scope.preview = false;
			if (file.files.length)
			{
				$scope.fr.readAsDataURL(file.files[0]);
				$scope.fd.append('features_icon', file.files[0]);

				$scope.fr.onload = function() {
					$scope.$apply(function () {
						$scope.preview = $scope.fr.result;
			        });
				};
			}
		};

		$scope.remove_file = function() {
			$scope.preview = false;
			$scope.fd.delete('features_icon');
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();