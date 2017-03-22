(function() {
	angular.module('panelApp').controller('importCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', 'Upload', importCtrl]);
	function importCtrl($scope, $rootScope, $http, $window, $uibModal, validate, Upload) {
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/cats/list').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
		
		$scope.cats = [{'cats_id': 0, 'cats_name': 'Choose Category'}].concat($scope.list);
	}
})();