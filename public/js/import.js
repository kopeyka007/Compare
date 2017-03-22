(function() {
	angular.module('panelApp').controller('importCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', 'Upload', importCtrl]);
	function importCtrl($scope, $rootScope, $http, $window, $uibModal, validate, Upload) {
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
							 
		$scope.save = function(file){
			file.upload = Upload.upload({
						url: '/api/import/save',
						file: file,
						data: $scope.importData
				    }).then(function (response){
						console.log('good');
					})
		}
	}
})();