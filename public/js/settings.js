(function() {
	angular.module('panelApp').controller('settingsCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', settingsCtrl]);
	
	function settingsCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.settingList = [];
		$scope.errors = [];
		$http.get('/api/settings/list').then(function(response) {
			$scope.settingList = response.data.data;
			console.log($scope.settingList);
		});
		
		$scope.save = function () {
			$http.post('/api/settings/save', $scope.settingList).then(function(response) {
				$scope.errors = [response.data.message];
			});
		};
	}
	
})();