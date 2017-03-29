(function() {
	angular.module('panelApp').controller('settingsCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', settingsCtrl]);
	
	function settingsCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$http.get('/api/settings/list').then(function(response) {
			console.log(response);
		})
	}
	
})();