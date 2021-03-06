(function() {
	angular.module('panelApp').controller('catsCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', catsCtrl]);
	function catsCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$rootScope.errors = [];
		$scope.add = function(id) {
			id = id || false;

			var cat = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].cats_id == id)
					{
						cat = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalCatsContent.html",
                controller: 'ModalCatsCtrl',
				resolve: {
					items: {'cat': cat, 'list': $scope.list}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
				$scope.get_list();
			}, function() {

			}); 
		};

		$scope.remove = function(id) {
			if (confirm('Do you realy want to remove this category?\nAlso all brands, features, filters and products will be removed too.'))
			{
				$http.delete('/api/cats/delete/' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					$scope.get_list();
				});
			}
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/cats/showlist').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
	}
})();

(function() {
	angular.module('panelApp').controller('ModalCatsCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', 'validate', 'items', 'Upload', ModalCatsCtrl]);
	function ModalCatsCtrl($scope, $rootScope, $http, $uibModalInstance, validate, items, Upload) {
		$scope.errors = [];
		$scope.cat = {'cats_id': 0,
					  'cats_alias': '',
					  'cats_default': false,
					  'cats_name': '',
					  'cats_foto': ''};
		
		if (items.cat && items.cat.cats_id)
		{	
			for (var k in items.cat)
			{
				if (k == 'cats_default')
				{
					$scope.cat[k] = items.cat[k] == '1';
				}
				else
				{	
					$scope.cat[k] = items.cat[k];
				}
			}
		}

		$scope.slug = function() {
			if ( ! $scope.cat.cats_id && $scope.form.slug.$pristine)
			{
				$scope.cat.cats_alias = $scope.cat.cats_name.replace(/ /gi, '-').toLowerCase();
			}
		};
													
		$scope.save = function (file) {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.name, 'Name');
			error *= validate.check($scope, $scope.form.slug, 'Slug');
			
			for (var k in items.list)
			{
				if ($scope.cat.cats_alias.toLowerCase() == items.list[k].cats_alias.toLowerCase() && $scope.cat.cats_id != items.list[k].cats_id)
				{
					error *= 0;
					$scope.errors.push({'text': ('This slug is already in database'), 'type': 'danger'});
				}
			}

			if (error)
			{
				if (file)
				{
					file.upload = Upload.upload({
						url: '/api/cats/save',
						file: file,
						data: $scope.cat,
				    }).then(function (response) {
				    	if (response.data.data)
						{
							$uibModalInstance.close(response.data.message);
						}
				    });
				}
				else
				{
					$http.post('/api/cats/save', $scope.cat).then(function(response) {
						if (response.data.data)
						{
							$uibModalInstance.close(response.data.message);
						}
					});
				}
			}
		};

		$scope.removeFile = function() {
			$scope.cats_foto = false;
		};

		$scope.removePreview = function() {
			$scope.prod.cats_foto = '';
		};
		
		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();