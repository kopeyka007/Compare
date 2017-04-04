(function() {
	angular.module('panelApp').controller('prodsCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', 'Upload', prodsCtrl]);
	function prodsCtrl($scope, $rootScope, $http, $window, $uibModal, validate, Upload) {
		$rootScope.errors = [];
		$scope.cats = [];
		$http.get('/api/cats/list').then(function(response) {
			$scope.cats = response.data.data;
		});
		
		$scope.brands = [];
		$http.get('/api/brands/list').then(function(response) {
			$scope.brands = response.data.data;
		});
		
		$scope.currList = [];
			$http.get('/api/currencies/list').then(function(response) {
				$scope.currList = response.data.data;
			});
		
		$scope.add = function(id) {
			id = id || false;

			var prod = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].prods_id == id)
					{
						prod = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalProdsContent.html",
                controller: 'ModalProdsCtrl',
                size: 'lg',
				resolve: {
					items: {'cats': $scope.cats, 'prod': prod, 'brands': $scope.brands, 'currency': $scope.currList, 'list': $scope.list}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
				$scope.get_list();
			}, function() {

			}); 
		};

		$scope.remove = function(id) {
			if (confirm('Do you realy want to remove this item?'))
			{
				$http.delete('/api/prods/delete/' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					$scope.get_list();
				});
			}
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/prods/list').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();

		$scope.stat = function(prod) {
			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalProdsInfo.html",
                controller: 'ModalProdsInfoCtrl',
                resolve: {
                	items: {'prod': prod}
                }
			});	
		};
	}
})();

(function() {
	angular.module('panelApp').controller('ModalProdsCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', '$timeout', 'validate', 'items', 'Upload', ModalProdsCtrl]);
	function ModalProdsCtrl($scope, $rootScope, $http, $uibModalInstance, $timeout, validate, items, Upload) {
		$scope.errors = [];
		$scope.filters = [];
		$scope.features = [];
		$scope.brands = [];
		$scope.currList = items.currency;
		$scope.cats = [{'cats_id': 0, 'cats_name': 'Choose Category'}].concat(items.cats);
		$scope.brands = [{'brands_id': 0, 'brands_name': 'Choose category first'}];
		$scope.prod = {'prods_id': 0,
					   'cats_id': {'cats_id': 0, 'cats_name': 'Choose Category'},
					   'brands_id': {'brands_id': 0, 'brands_name': 'Choose Brand'},
				  	   'filters_id': {'filters_id': 0, 'filters_name': 'Choose Filter'},
					   'features_id': {'features_id': 0, 'features_name': 'Choose Feature'},
					   'currencies_id': {},
					   'prods_name': '',
				  	   'prods_alias': '',
					   'prods_amazon': '',
					   'prods_price': '',
					   'prods_active': 1,
					   'prods_foto': ''};
		
		if (items.prod && items.prod.prods_id)
		{
			for (var k in items.prod)
			{
				if (k == 'prods_foto')
				{
					if ( ! (items.prod[k].indexOf('nofoto') + 1))
					{
						$scope.prod[k] = items.prod[k];
					}
				}
				else
				{
					if (k == 'filters_filter')
					{
						$scope.prod[k] = items.prod[k] == 1 ? true : false;
					}
					else
					{
						$scope.prod[k] = items.prod[k];
					}
				}
			}
		}
		else
		{
			for (var k in $scope.currList)
			{
				if ($scope.currList[k].currencies_default == '1')
				{
					$scope.prod.currencies_id = $scope.currList[k];
				}
			}
		}

		
		$scope.slug = function() {
			if ( ! $scope.prod.prods_id && $scope.form.slug.$pristine)
			{
				$scope.prod.prods_alias = $scope.prod.prods_name.replace(/ /gi, '-').toLowerCase();
			}
		};
		
		$scope.initFilters = function() {
			$http.get('/api/cats/filters/' + $scope.prod.cats_id.cats_id).then(function(response) {
				$scope.filters = response.data.data;
			});
			
			$http.get('/api/cats/features/' + $scope.prod.cats_id.cats_id).then(function(response) {
				$scope.features = response.data.data;
			});
			
			$http.get('/api/cats/brands/' + $scope.prod.cats_id.cats_id).then(function(response) {
				$scope.brands = [{'brands_id': 0, 'brands_name': 'Choose Brand'}].concat(response.data.data);
				if ($scope.prod.brands_id.brands_id == '0')
				{
					$scope.prod.brands_id = $scope.brands[0];
				}
				
			});
		};
		
		$scope.countFilters = function(filter) {
			var i = 0;
			for (var k in filter)
			{
				i++;
			}
			return i;
		};

		if ($scope.prod.cats_id.cats_id > 0)
		{
			$scope.initFilters();
		}
		
		$scope.save = function (file) {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.cats_id, 'Category', 'cats_id');
			error *= validate.check($scope, $scope.form.brands_id, 'Brand', 'brands_id');
			error *= validate.check($scope, $scope.form.prods_name, 'Name');
			error *= validate.check($scope, $scope.form.slug, 'Slug');
			error *= validate.check($scope, $scope.form.prods_price, 'Price')
			
			for (var k in items.list)
			{
				if ($scope.prod.prods_alias.toLowerCase() == items.list[k].prods_alias.toLowerCase() && $scope.prod.prods_id != items.list[k].prods_id)
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
						url: '/api/prods/save',
						file: file,
						data: $scope.prod,
				    }).then(function (response) {
				    	if (response.data.data)
						{
							$uibModalInstance.close(response.data.message);
						}
				    });
				}
				else
				{
					$http.post('/api/prods/save', $scope.prod).then(function(response) {
						if (response.data.data)
						{
							$uibModalInstance.close(response.data.message);
						}
					});
				}
			}
		};

		$scope.removeFile = function() {
			$scope.prods_foto = false;
		};

		$scope.removePreview = function() {
			$scope.prod.prods_foto = '';
		};
		
		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();

(function() {
	angular.module('panelApp').controller('ModalProdsInfoCtrl', ['$scope', '$http', '$uibModalInstance', 'items', ModalProdsInfoCtrl]);
	function ModalProdsInfoCtrl($scope, $http, $uibModalInstance, items) {
		$http.get('/api/prods/historyfilters/' + items.prod.prods_id).then(function(response){
			$scope.filterCount = response.data;
			
		});

		$scope.prod = items.prod;

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();