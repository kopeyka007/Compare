<div ng-controller="importCtrl">
	<h1>Import</h1>
	<div class="form-horizontal">
		<div class="form-group">
			<div class="col-md-2">
				<select class="form-control" required="required" ng-model="cats_id" ng-options="cat.cats_name for cat in cats track by cat.cats_id">
				</select>
			</div>
			<a href="javascript:void(0);" type="button" class="btn btn-info btn-file">
				<span>Browse file...</span>
				<input type="file" accept=".csv" name="file" ngf-select />
			</a>
		</div>
	</div>
</div>