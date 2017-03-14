(function(){
	angular.module('panelApp').controller('signinCtrl', ['$scope', '$rootScope', '$http', '$window', 'validate', signinCtrl]);
	
	function signinCtrl($scope, $rootScope, $http, $window, validate){
		$scope.signin = function() {
			var error = 1;
			error *= validate.check($rootScope, $scope.form.email, 'Email');
			error *= validate.check($rootScope, $scope.form.password, 'Password');

			if (error) 
			{
				var post_mas = {
					users_email: $scope.email,
					users_password: $scope.password
				};
			
				$http.post('/api/signin', post_mas).then(function(response) {
					
					$rootScope.errors = [response.data.message];
					if (response.data.data)
					{
						$window.location.reload(true);
					}
				});
			}
		};
	}
})();