(function() {
	angular.module('compareApp').controller('compareCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', compareCtrl]);
	function compareCtrl($scope, $rootScope, $http, $window, $location) {
		
		$scope.compareList = [];
		var url = $location.path();
		
		$http.post('/api/compare/list', {url}).then(function(response){
			$scope.compareList = response.data;
		});
	}
})();