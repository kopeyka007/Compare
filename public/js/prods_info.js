(function() {
	angular.module('compareApp').controller('prodsInfoCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', prodsInfoCtrl]);
	function prodsInfoCtrl($scope, $rootScope, $http, $window, $location) {

		var url = $location.path();
		
		$http.post('/api/prods/detail', {url}).then(function(response){
			$scope.prodsInfo = response.data.data;
			console.log($scope.prodsInfo);
		});
	}
})();