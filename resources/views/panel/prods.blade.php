<div ng-controller="prodsCtrl">
	<h1>Products</h1>
	<div class="form-group">
		<button type="button" class="btn btn-primary" ng-click="add()">Create Products</button>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped table-hover" ng-show="list.length">
			<thead>
				<tr>
					<th class="td-id">ID</th>
					<th class="td-preview">Photo</th>
					<th>Category</th>
					<th>Brand</th>
					<th>Name</th>
					<th>Slug</th>
					<th>Price</th>
					<th>Active</th>
					<th class="td-icon">Edit</th>
					<th class="td-icon">Remove</th>
				</tr>
			</thead>

			<tbody>
				<tr ng-repeat="prod in list">
					<td class="td-id">@{{prod.prods_id}}</td>
					<td class="td-preview"><img src="@{{prod.prods_foto}}" alt="" ng-show="prod.prods_foto" /></td>
					<td>@{{prod.cats_id.cats_name}}</td>
					<td>@{{prod.brands_id.brands_name}}</td>
					<td>@{{prod.prods_name}}</td>
					<td><a href="/@{{prod.cats_id.cats_alias + '/' + prod.prods_alias}}" target="_blank">@{{prod.prods_alias}}</a></td>
					<td>$@{{prod.prods_price}}</td>
					<td>@{{prod.prods_active | checkmark}}</td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="add(prod.prods_id)"><i class="fa fa-pencil-square-o text-success"></i></button></td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="remove(prod.prods_id)"><i class="fa fa-trash-o text-danger"></i></button></td>
				</tr>
			</tbody>
		</table>

		<div class="alert alert-info text-center" role="alert" ng-show=" ! list.length">
			There is no any data
		</div>
	</div>
</div>

<script type="text/ng-template" id="ModalProdsContent.html">
	<div class="modal-header">
		<h3 ng-show=" ! prod.prods_id">Create Product</h3>
		<h3 ng-show="prod.prods_id">Edit Product</h3>
	</div>

	<form name="form" class="modal-body coverletter-modal" novalidate="novalidate" enctype="multipart/form-data">
		<div ng-show="errors.length">
			<div class="alert alert-@{{msg.type}}" ng-repeat="msg in errors" role="alert" ng-init="showme = true" ng-show="showme">@{{msg.text}}
				 <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="showme = false"><span aria-hidden="true">&times;</span></button>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Category</label>
					<select class="form-control" name="cats_id" ng-model="prod.cats_id" required="required" ng-options="cat.cats_name for cat in cats track by cat.cats_id" ng-change="initFilters()">
					</select>
				</div>

				<div class="form-group">
					<label>Brand</label>
					<select class="form-control" name="brands_id" ng-model="prod.brands_id" required="required" ng-options="brand.brands_name for brand in brands track by brand.brands_id">
					</select>
				</div>

				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="prods_name" ng-model="prod.prods_name" ng-change="slug()" required="required" />
				</div>

				<div class="form-group">
					<label>Slug</label>
					<input type="text" class="form-control" name="slug" ng-model="prod.prods_alias" required="required" />
				</div>

				<div class="checkbox">
					<label>
						<input type="checkbox" ng-model="prod.prods_active" ng-init="prod.prods_active = true" ng-checked="prod.prods_active == 1" />
						Show on website
					</label>
				</div>
			</div>

			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Photo</label>
					<div>
						<a href="javascript:void(0);" type="button" class="btn btn-info btn-file">
							<span>Browse file...</span>
							<input type="file" accept="image/*" name="file" ngf-select />
						</a>
						<img ngf-thumbnail="prods_foto" class="img-preview" ng-show="prods_foto" alt="" />
						<a href="javascript:void(0);" ng-show="prods_foto" ng-click="removeFile()">Remove</a>
						<img src="@{{prod.prods_foto}}" class="img-preview" ng-show="prod.prods_foto && ! prods_foto" alt="" />
						<a href="javascript:void(0);" ng-show="prod.prods_foto && ! prods_foto" ng-click="removePreview()">Remove</a>
					</div>
				</div>

				<div class="form-group">
					<label>Link to Amazon</label>
					<input type="text" class="form-control" name="prods_amazon" ng-model="prod.prods_amazon" required="required" />
				</div>

				<div class="form-group">
					<label>Price</label>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" class="form-control" name="prods_price" ng-model="prod.prods_price" required="required" />
					</div>
				</div>
			</div>
		</div>

		<br />

		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<h4>Filters</h4>
				<div class="filter-groups panel panel-default" ng-repeat="group in filters.groups">
					<div class="panel-heading">
						@{{group.groups_name}}
					</div>
					<div class="panel-body">
						<div class="form-horizontal" ng-repeat="(filters_id, filter) in group.groups_filters">
							<div class="form-group">
								<label class="col-md-3 col-xs-12">@{{filter.filters_name}}</label>
								<div class="col-md-7 col-xs-8">
									<input type="text" class="form-control" ng-if="filter.filters_type == 'text'"  ng-model="prod.filters[filters_id]" />
									<select class="form-control" ng-if="filter.filters_type == 'check'" ng-model="prod.filters[filters_id]" ng-init=" ! prod.filters[filters_id] ? prod.filters[filters_id] = 'No' : prod.filters[filters_id]">
										<option value="No">No</option>
										<option value="Yes">Yes</option>
									</select>
								</div>
								<div class="col-md-2 col-xs-4">
									@{{filter.filters_units}}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="alert alert-info text-center" role="alert" ng-show="countFilters() && prod.cats_id.cats_id > 0">
					There are no filters in this category
				</div>

				<div class="alert alert-info text-center" role="alert" ng-show="countFilters() && prod.cats_id.cats_id == 0">
					Choose category first
				</div>
			</div>

			<div class="col-sm-6 col-xs-12">
				<h4>Features</h4>
				<div class="form-horizontal" ng-repeat="feature in features">
					<div class="form-group">
						<label class="col-md-3 col-xs-12">@{{feature.features_name}}</label>
						<div class="col-md-7 col-xs-8">
							<input type="text" class="form-control" ng-model="prod.features[feature.features_id]" />
						</div>
						<div class="col-md-2 col-xs-4">
							@{{feature.features_units}}
						</div>
					</div>
				</div>

				<div class="alert alert-info text-center" role="alert" ng-show=" ! features.length && prod.cats_id.cats_id > 0">
					There are no features in this category
				</div>

				<div class="alert alert-info text-center" role="alert" ng-show=" ! features.length && prod.cats_id.cats_id == 0">
					Choose category first
				</div>
			</div>
		</div>
	</form>

	<div class="modal-footer">
		<button class="btn btn-primary" type="button" ng-click="save(prods_foto)">Save</button>
		<button class="btn btn-default" type="button" ng-click="cancel()">Cancel</button>
	</div>
</script>