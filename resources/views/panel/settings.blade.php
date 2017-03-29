<div ng-controller="settingsCtrl">
	<h1>Settings</h1>
	
	<form>
		<div class="row">
			<div class="col-sm-7">
				<div class="form-group">
					<label>S3 Bucket</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_bucket" />
				</div>
			</div>
			<div class="col-sm-7">
				<div class="form-group">
					<label>S3 Key</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_key" />
				</div>
			</div>
			<div class="col-sm-7">
				<div class="form-group">
					<label>S3 Region</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_region" />
				</div>
			</div>
			<div class="col-sm-7">
				<div class="form-group">
					<label>S3 Secret</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_secret" />
				</div>
			</div>
			<div class="col-sm-7">
				<div class="form-group">
					<label>S3 Pprods Folder</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_prods_folder" />
				</div>
			</div>
			<div class="col-sm-7">
				<button class="btn btn-primary" type="button" ng-click="save()">Save</button>
			</div>
		</div>
	</form>
</div>