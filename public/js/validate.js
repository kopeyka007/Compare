(function () {
    'use strict';

        angular.module('panelApp')
			.factory('validate', [validate])
		
		function validate() {		
			return {
				check: function(scope, field, name) {
					if (field.$valid)
					{
						return true;
					}
					else
					{
						if (field.$viewValue == "" || field.$viewValue)
						{
							scope.errors.push({'text': (name + ' is required'), 'type': 'danger'});
						}
						else
						{
							scope.errors.push({'text': (name + ' is incorrect'), 'type': 'danger'});
						}
						return false;
					}
				}
			};
		}
		
})();