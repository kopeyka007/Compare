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
					<th>Name</th>
					<th class="td-icon">Edit</th>
					<th class="td-icon">Remove</th>
				</tr>
			</thead>

			<tbody>
				<tr ng-repeat="prod in list">
					<td class="td-id">@{{prod.prods_id}}</td>
					<td>@{{prod.prods_name}}</td>
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
			<div class="col-sm-12">
				<div class="form-group">
					<label>Category</label>
					<select class="form-control" name="cats_id" ng-model="prod.cats_id" required="required" ng-options="cat.cats_name for cat in cats track by cat.cats_id" ng-change="initFilters()">
					</select>
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Brands</label>
					<select class="form-control" name="brands_id" ng-model="prod.brands_id" required="required" ng-options="brand.brands_name for brand in brands track by brand.brands_id">
					</select>
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="prods_name" ng-model="prod.prods_name" ng-change="slug()" required="required" />
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Slug</label>
					<input type="text" class="form-control" name="slug" ng-model="prod.prods_alias" required="required" />
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Link to Amazon</label>
					<input type="text" class="form-control" name="prods_amazon" ng-model="prod.prods_amazon" required="required" />
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Price</label>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="text" class="form-control" name="prods_price" ng-model="prod.prods_price" required="required" />
					</div>
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="checkbox">
					<label>
						<input type="checkbox" ng-model="prod.prods_active" ng-init="prod.prods_active = true" ng-checked="prod.prods_active == 1" />
						Active
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