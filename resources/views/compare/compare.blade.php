<div ng-controller="compareCtrl">
	<div class="container">
		<div class="table-responsive">
			<table class="table table-striped compare-table">
				<thead>
					<tr>
						<th><h4>Features</h4></th>
						<th ng-repeat="prod in compareList"><h4>@{{prod.brands_id.brands_name}} @{{prod.prods_name}}</h4></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<h3>Show:</h3>
							<div>
								<label class="btn btn-success btn-block">
									<input type="checkbox" />
									<span>All Features</span>
								</label>
							</div>
							<div>
								<label class="btn btn-success btn-block">
									<input type="checkbox" />
									<span>Differences</span>
								</label>
							</div>
						</td>
						<td class="td-header" ng-repeat="photo in compareList">
							<div class="compare-head" ng-class="{'inactive': ! photo}">
								<div class="compare-img text-center">
									<img src="@{{photo.prods_foto}}" alt="#" />
								</div>
								<div class="compare-price text-danger">
									$@{{photo.prods_price}}
								</div>
								<div class="compare-close">
									<i class="fa fa-times-circle" aria-hidden="true" ng-click=""></i>
								</div>
								<div class="wrap-add-btn">
									<button class="btn btn-info add-btn">Add Another Products</button>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td><h3>Overview</h3></td>
						<td colspan="4"><h3>Advantages (Factors To Decide Which Device You Should Buy)</h3></td>
					</tr>
					<tr>
						<td>Features Present In Only One Device(Unique Features)</td>
						<td></td>
						<td>
							<div class="features-block">
								<div class="features-head">
									<img src="#" alt="#" />
									<span>Light Weight</span>
								</div>
								<div class="features-content">
									<div class="oponents">
										<span>Xiaomi Redmi Note 4</span>
										<span>165 grams</span>
									</div>
									<div class="oponents">
										<span>Xiaomi Redmi Note 4</span>
										<span>165 grams</span>
									</div>
									<div class="oponents">
										<span>Xiaomi Redmi Note 4</span>
										<span>165 grams</span>
									</div>
									<p>Around 12% lighter than Xiaomi Redmi Note 4. Light weight devices are easier to hold without tiring your arms.</p>
								</div>
							</div>
						</td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			
			<div class="groups-box" ng-repeat="">
				<h3>@{{}}</h3>
				<table>
					<tbody>
						<tr>
							<td></td>
							<td colspan="4"></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><h4>Dual Sim</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
						<tr>
							<td><h4>Sim Size</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
						<tr>
							<td><h4>Device Type</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
						<tr>
							<td><h4>Release Date</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
						<tr>
							<td><h3>Design</h3></td>
							<td colspan="4"></td>
						</tr>
						<tr>
							<td><h4>Dimensions</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
						<tr>
							<td><h4>Weight</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
						<tr>
							<td><h3>Display</h3></td>
							<td colspan="4"></td>
						</tr>
						<tr>
							<td><h4>Weight</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
						<tr>
							<td><h4>Weight</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
						<tr>
							<td><h4>Weight</h4></td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
							<td>GSM+GSM (Hybrid Slot)</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>