<div ng-controller="prodsInfoCtrl">
	<div class="container">
		<div class="products-preview">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="products-img">
						<img src="@{{prodsInfo.prods_foto}}" alt="#" />
					</div>
					<div class="products-name">
						<div class="products-brand">
							@{{prodsInfo.brands_id.brands_name}}
						</div>
						<div class="products-model">
							@{{prodsInfo.prods_name}}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="products-body">
			<div class="row">
				<div class="col-md-9">
					<div class="products-spec">
						<div class="products-spec-head text-success" ng-if="prodsInfo.features.valid.length">
							<h3>Advantages</h3>
						</div>
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr ng-repeat="feat in prodsInfo.features.valid">
										<td class="features-head">
											<div class="features-img"><img src="@{{feat.features_icon}}" alt="#" /></div>
											<div class="features-desc">
												<div class="features-name">@{{feat.features_name}}</div>
												<div class="features-value">@{{feat.features_value}}<span> @{{feat.features_units}}</span></div>
											</div>
										</td>
										<td class="features-comment">
											@{{feat.features_desc}}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="products-spec-head text-danger">
							<h3>Disadvantages</h3>
						</div>
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr ng-repeat="feat in prodsInfo.features.notvalid">
										<td class="features-head">
											<div class="features-img"><img src="@{{feat.features_icon}}" alt="#" /></div>
											<div class="features-desc">
												<div class="features-name">@{{feat.features_name}}</div>
												<div class="features-value">@{{feat.features_value}}<span> @{{feat.features_units}}</span></div>
											</div>
										</td>
										<td class="features-comment">
											@{{feat.features_desc}}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="products-related">
						<div class="related-head">
							Related Products
						</div>
						<div class="related-inner">
							<div class="row">
								<div class="col-md-4">
									<div class="related-img">
										<img src="https://img2.smartprix.com/mobiles/1101z581e0c/v-1/lenovo_k6_power.v2.jpg" alt="#" />
									</div>
								</div>
								<div class="col-md-8">
									<div class="related-name">
										Lenovo K6 Power
									</div>
									<div class="related-price">
										RS 9.999
									</div>
									<div class="related-btn">
										<button class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add To Compare</button>
									</div>
								</div>
							</div>
						</div>
						<div class="related-inner">
							<div class="row">
								<div class="col-md-4">
									<div class="related-img">
										<img src="https://img2.smartprix.com/mobiles/1101z581e0c/v-1/lenovo_k6_power.v2.jpg" alt="#" />
									</div>
								</div>
								<div class="col-md-8">
									<div class="related-name">
										Lenovo K6 Power
									</div>
									<div class="related-price">
										RS 9.999
									</div>
									<div class="related-btn">
										<button class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add To Compare</button>
									</div>
								</div>
							</div>
						</div>
						<div class="related-inner">
							<div class="row">
								<div class="col-md-4">
									<div class="related-img">
										<img src="https://img2.smartprix.com/mobiles/1101z581e0c/v-1/lenovo_k6_power.v2.jpg" alt="#" />
									</div>
								</div>
								<div class="col-md-8">
									<div class="related-name">
										Lenovo K6 Power
									</div>
									<div class="related-price">
										RS 9.999
									</div>
									<div class="related-btn">
										<button class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add To Compare</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="products-full-spec">
				<div class="products-spec-head">
					<h3>Full specifications</h3>
				</div>
				<div class="row">
					<div class="col-md-6"  ng-repeat="group in prodsInfo.groups">
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<td>
											<div class="spec-group">
												<h3><strong>@{{group.groups_name}}</strong></h3>
											</div>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="filter in group.groups_filters">
										<td class="spec-head">
											<div class="features-name">@{{filter.filters_name}}</div>	
										</td>
										<td class="spec-comment">
											@{{filter.filters_value}}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>