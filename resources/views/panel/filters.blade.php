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
					<th>Category</th>
					<th>Group</th>
					<th>Filter Type</th>
					<th>Filter Units</th>
					<th>Show as filter</th>
					<th class="td-icon">Edit</th>
					<th class="td-icon">Remove</th>
				</tr>
			</thead>

			<tbody>
				<tr ng-repeat="filter in list">
					<td class="td-id">@{{filter.filters_id}}</td>
					<td>@{{filter.filters_name}}</td>
					<td>@{{filter.cats_id[0].cats_name}}</td>
					<td>@{{filter.groups_id.groups_name}}</td>
					<td>@{{filter.filters_type == 'check' ? 'Yes/No' : 'Text'}}</td>
					<td>@{{filter.filters_units}}</td>
					<td>@{{filter.filters_filter | checkmark}}</td>
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

<script type="text/ng-template" id="ModalFiltersContent.html">
	<div class="modal-header">
		<h3 ng-show=" ! filter.filters_id">Create Filter</h3>
		<h3 ng-show="filter.filters_id">Edit Filter</h3>
	</div>

	<form name="form" class="modal-body coverletter-modal" novalidate="novalidate" enctype="multipart/form-data">
		<div ng-show="errors.length">
			<div class="alert alert-@{{msg.type}}" ng-repeat="msg in errors" role="alert" ng-init="showme = true" ng-show="showme">@{{msg.text}}
				 <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="showme = false"><span aria-hidden="true">&times;</span></button>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Category</label>
					<select class="form-control" name="cats_id" ng-model="filter.cats_id" required="required" ng-options="cat.cats_name for cat in cats track by cat.cats_id">
					</select>
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Group</label>
					<select class="form-control" name="groups_id" ng-model="filter.groups_id" ng-change="changeGroup();" required="required" ng-options="group.groups_name for group in groups track by group.groups_id">
					</select>
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Group Name</label>
					<input type="text" class="form-control" name="groups_name" ng-model="filter.groups_name" ng-required="required" />
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="filters_name" ng-model="filter.filters_name" required="required" />
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Filter Type <span class="help-icon text-info" uib-popover-html="'&laquo;Yes/No&raquo; - filters of this type will be shown as green/red icons. &laquo;Text&raquo; - filters of this type will be shown as text'"><i class="fa fa-question-circle"></i></span></label>
					<select class="form-control" ng-model="filter.filters_type">
						<option value="check">Yes/No</option>
						<option value="text">Text</option>
					</select>
				</div>
			</div>
			
			<div class="col-sm-12" ng-show="filter.filters_type == 'text'">
				<div class="form-group">
					<label>Filter Units</label>
					<input type="text" class="form-control" name="filters_units" ng-model="filter.filters_units" required="required" />
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="checkbox">
					<label>
						<input type="checkbox" ng-model="filter.filters_filter" />
						Show as filter <span class="help-icon text-info" uib-popover-html="'When this option is active this filter will be display at the Filter section at the home page'"><i class="fa fa-question-circle"></i></span>
					</label>
				</div>
			</div>

		</div>
	</form>

	<div class="modal-footer">
		<button class="btn btn-primary" type="button" ng-click="save()">Save</button>
		<button class="btn btn-default" type="button" ng-click="cancel()">Cancel</button>
	</div>
</script>