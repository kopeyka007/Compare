<h1>Show</h1>

<div class="modal-demo">
    <script type="text/ng-template" id="myModalContent.html">
		<div class="modal-header">
			<h3>Add User</h3>
		</div>
		<div class="modal-body  coverletter-modal">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" placeholder="Name" required="required" />
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" placeholder="email" required="required" />
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Type of user</label>
						<select class="form-control">
							<option>Admin</option>
							<option>Admin</option>
							<option>User</option>
							<option>User</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="ok()">OK</button>
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>
    <button type="button" class="btn btn-default" ng-click="add_users()">Open me!</button>
</div>