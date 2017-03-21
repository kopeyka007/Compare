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
		
		$scope.statAmazon = function(prod){
			$http.post('api/history/amazon', {'prods_amazon': prod.prods_amazon, 'prods_id': prod.prods_id}).then(function(response){
				$window.location.href = prod.prods_amazon;
			});
		};
	}
})();