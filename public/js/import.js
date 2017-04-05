(function() {
	angular.module('panelApp').controller('importCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', '$timeout', 'validate', 'Upload', importCtrl]);
	function importCtrl($scope, $rootScope, $http, $window, $uibModal, $timeout, validate, Upload) {
		$rootScope.errors = [];
		$scope.list = [];
		$scope.cats = [];
		$scope.importData = {'cats_id': '',
							 'import_file': ''};
		
		$scope.get_list = function() {
			$http.get('/api/cats/list').then(function(response) {
				$scope.list = response.data.data;
				$scope.cats = [{'cats_id': 0, 'cats_name': 'Choose Category'}].concat($scope.list);
				$scope.importData.cats_id = $scope.cats[0];
			});
		};
		$scope.get_list();
		$scope.progress = 0;

		$scope.timeoutBar = function() {
			$timeout(function() {
				if ($scope.progress < 95)
				{
					$scope.progress += 3;
					$scope.timeoutBar();
				}
			}, 500)
		};

		$scope.save = function(file){
			$scope.dynamic = 0;
			file.upload = Upload.upload({
				url: '/api/import/save',
				file: file,
				data: $scope.importData
			}).then(function (response){
					$rootScope.errors = [response.data.message];
					$scope.progress = 100;
			}, function (response) {

            }, function (evt) {
                $scope.progress = Math.min(100, parseInt(30 * evt.loaded / evt.total));
                if (evt.loaded == evt.total)
                {
                	$scope.timeoutBar();
                }
            });
		}

	}
})();