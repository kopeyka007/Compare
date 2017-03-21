<div ng-controller="featuresCtrl">
	<h1>Features</h1>
	<div class="form-group">
		<button type="button" class="btn btn-primary" ng-click="add()">Create Feature</button>
	</div>

	<div class="table-responsive">
		<table class="table table-striped table-hover" ng-show="list.length">
			<thead>
				<tr>
					<th class="td-id">ID</th>
					<th class="td-preview-small">Icon</th>
					<th>Category</th>
					<th>Name</th>
					<th>Description</th>
					<th>Optimal value</th>
					<th>Units</th>
					<th>Around</th>
					<th class="td-icon">Edit</th>
					<th class="td-icon">Remove</th>
				</tr>
			</thead>

			<tbody>
				<tr ng-repeat="feature in list">
					<td class="td-id">@{{feature.features_id}}</td>
					<td class="td-preview-small"><img src="@{{feature.features_icon}}" alt="#" /></td>
					<td>@{{feature.cats_id[0].cats_name}}</td>
					<td>@{{feature.features_name}}</td>
					<td>@{{feature.features_desc}}</td>
					<td>@{{feature.features_norm}}</td>
					<td>@{{feature.features_units}}</td>
					<td>@{{feature.features_around}}</td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="add(feature.features_id)"><i class="fa fa-pencil-square-o text-success"></i></button></td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="remove(feature.features_id)"><i class="fa fa-trash-o text-danger"></i></button></td>
				</tr>
			</tbody>
		</table>

		<div class="alert alert-info text-center" role="alert" ng-show=" ! list.length">
			There is no any data
		</div>
	</div>
</div>

<script type="text/ng-template" id="ModalFeaturesContent.html">
	<div class="modal-header">
		<h3 ng-show=" ! feature.features_id">Create Feature</h3>
		<h3 ng-show="feature.features_id">Edit Feature</h3>
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
					<select class="form-control" name="cats_id" ng-model="feature.cats_id" required="required" ng-options="cat.cats_name for cat in cats track by cat.cats_id">
					</select>
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Icon</label>
					<div>
						<a href="javascript:void(0);" type="button" class="btn btn-info btn-file">
							<span>Browse file...</span>
							<input type="file" accept="image/*" name="file" ng-model="features_icon" ngf-select />
						</a>
						<img ngf-thumbnail="features_icon" class="img-preview" ng-show="features_icon" alt="" />
						<a href="javascript:void(0);" ng-show="features_icon" ng-click="removeFile()">Remove</a>
						<img src="@{{feature.features_icon}}" class="img-preview" ng-show="feature.features_icon && ! features_icon" alt="" />
						<a href="javascript:void(0);" ng-show="feature.features_icon && ! features_icon" ng-click="removePreview()">Remove</a>
					</div>
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="name" ng-model="feature.features_name" required="required" />
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Description</label>
					<input type="text" class="form-control" name="desc" ng-model="feature.features_desc" />
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Optimal Value <span class="help-icon text-info" uib-popover-html="'Here you should enter optimal value for this feature. So if the product has a lower value than optimal value for this feature then this feature will be Disadvantage, if product has higher value then feature will be Advantage.<br />For example: <b>5.5</b>, <b>800</b>'"><i class="fa fa-question-circle"></i></span></label>
					<input type="text" class="form-control" name="norm" ng-model="feature.features_norm" />
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Units <span class="help-icon text-info" uib-popover-html="'Just units for this feature. So when you will fill the value for this feature at the Products secion you should enter only value, for example is you have 5.5 inch display you should enter <b>inch</b> here and <b>5.5</b> at the Products section.<br />For example: <b>inch</b>, <b>Mhz</b>'"><i class="fa fa-question-circle"></i></span></label>
					<input type="text" class="form-control" name="units" ng-model="feature.features_units" />
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Around... <span class="help-icon text-info" uib-popover-html="'This is special field to show in Feature Only section at the compare page. We have such sentence &laquo;Around 44% <b>more RAM</b> than Xiaomi Mi5s&raquo; - so you need to enter only green words in this field.<br />For example: <b>more RAM</b>, <b>faster CPU</b>'"><i class="fa fa-question-circle"></i></span></label>
					<input type="text" class="form-control" name="around" ng-model="feature.features_around" />
				</div>
			</div>
		</div>
	</form>

	<div class="modal-footer">
		<button class="btn btn-primary" type="button" ng-click="save(features_icon)">Save</button>
		<button class="btn btn-default" type="button" ng-click="cancel()">Cancel</button>
	</div>
</script>