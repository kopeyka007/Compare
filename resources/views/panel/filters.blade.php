<div ng-controller="filtersCtrl">
	<h1>Filters</h1>
	<div class="form-group">
		<button type="button" class="btn btn-primary" ng-click="add()">Create Filters</button>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped table-hover" ng-show="list.length">
			<thead>
				<tr>
					<th class="td-id">ID</th>
					<th>Name</th>
					<th class="td-icon">Edit</th>
					<th class="td-icon">Remove</th>
				</tr>
			</thead>

			<tbody>
				<tr ng-repeat="filter in list">
					<td class="td-id">@{{filter.filters_id}}</td>
					<td>@{{filter.filters_name}}</td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="add(filter.filters_id)"><i class="fa fa-pencil-square-o text-success"></i></button></td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="remove(filter.filters_id)"><i class="fa fa-trash-o text-danger"></i></button></td>
				</tr>
			</tbody>
		</table>

		<div class="alert alert-info text-center" role="alert" ng-show=" ! list.length">
			There is no any data
		</div>
	</div>
</div>