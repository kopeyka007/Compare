(function () {
    'use strict';

        angular.module('panelApp')
			.factory('validate', [validate])
		
		function validate() {		
			return {
				check: function(scope, field, name, object_field) {
					object_field = object_field || false;
					if (object_field && typeof(field.$viewValue) == 'object')
					{
						if (field.$viewValue[object_field] == '0')
						{
							scope.errors.push({'text': (name + ' is required'), 'type': 'danger'});
							return false;
						}
					}

					if (field.$valid)
					{
						return true;
					}
					else
					{
						if (field.$$attr.type == 'number') 
						{
							scope.errors.push({'text': (name + ' is incorrect'), 'type': 'danger'});
						}
						else 
						{
							if (field.$viewValue == '' || field.$viewValue)
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
				}
			};
		}
		
})();