(function() {
	angular.module('compareApp').controller('prodsInfoCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', prodsInfoCtrl]);
	function prodsInfoCtrl($scope, $rootScope, $http, $window, $location) {

		$scope.prodUrl = $location.absUrl();
		
		var url = $location.path();
		$http.post('/api/prods/detail', {url}).then(function(response){
			$scope.prodsInfo = response.data.data;
		});		
		
		var disurl = $location.absUrl();
		$scope.disqusConfig = {
			disqus_shortname: 'compare-da-1',
			disqus_identifier: disurl,
			disqus_url: disurl
		};
	}
})();