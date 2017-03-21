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
						<div class="products-spec-head text-danger" ng-if="prodsInfo.features.notvalid.length">
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
						<div class="related-inner" ng-repeat="related in prodsInfo.liked">
							<div class="row">
								<div class="col-md-4">
									<div class="related-img">
										<img src="@{{related.prods_foto}}" alt="#" />
									</div>
								</div>
								<div class="col-md-8">
									<div class="related-name">
										@{{related.prods_name}}
									</div>
									<div class="related-price">
										$ @{{related.prods_price}}
									</div>
									<div class="related-btn">
										<a href="http://compare.da/compare/@{{prodsInfo.prods_alias}}-vs-@{{}}" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add To Compare</a>
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
												<h3>@{{group.groups_name}}</h3>
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
											<i class="fa fa-check-circle text-success" ng-show="filter.filters_type == 'check' && filter.filters_value"></i>
											<i class="fa fa-times-circle text-danger" ng-show="filter.filters_type == 'check' && ! filter.filters_value"></i>
											<span ng-show="filter.filters_type != 'check'">@{{filter.filters_value}}</span>
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