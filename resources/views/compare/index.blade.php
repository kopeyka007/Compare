<div ng-controller="mainCtrl">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="filter-section">
					<h2>Filter</h2>
					
					<div ng-repeat="prod in cat.prods">
						<div class="checkbox">
							<label>
								<input type="checkbox">@{{prod.brands_id.brands_name}}
							</label>
						</div>
					</div>
					<div ng-repeat="filter in list_filters">
						<div class="checkbox">
							<label>
								<input type="checkbox">@{{filter.filters_name}}
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="content-section" ng-repeat="cat in cats | filter:cats_filters" ng-if="cat.prods.length">
					<div class="wrap-categories">	
						<div class="categories">
							<h2>@{{cat.cats_name}}</h2>
						</div>
						<div class="row">
							<div ng-repeat="prod in cat.prods">
								<div class="col-md-3">
									<div class="content-border" ng-class="{'selected': prod.selected == 1, 'limit': limitClass}" ng-mousedown="selectedCount == selectedMax ? limitClass = 'limit' : ''" ng-mouseup="limitClass = ''" ng-click="chooseProd(prod, cat.cats_alias)" ng-init="prod.selected = 0; limitClass = ''">
										<div class="content-inner">
											<div class="content-img">
												<div class="content-img-check">
													<i class="fa fa-check-square fa-2x" aria-hidden="true"></i>
												</div>
												<img src="@{{prod.prods_foto}}" alt="#" />
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="content-brand">
														@{{prod.brands_id.brands_name}}
													</div>
												</div>
												<div class="col-md-6">
													<div class="content-price pull-right">
														$@{{prod.prods_price}}
													</div>
												</div>
											</div>
											<div class="content-name text-center">
												<a href="@{{cat.cats_alias}}/@{{prod.prods_alias}}">@{{prod.prods_name}}</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="btn-compare">
					<a href="@{{compareAlias}}" type="button" class="btn btn-info btn-block btn-lg" ng-click="">COMPARE <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>