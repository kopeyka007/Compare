<div ng-controller="compareCtrl">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="filter-section">
					Filter
				</div>
			</div>
			<div class="col-md-8">
				<div class="content-section" ng-repeat="cat in cats" ng-if="cat.prods.length">
					<div class="categories">
						<h2>@{{cat.cats_name}}</h2>
					</div>
					<div class="row">
						<div ng-repeat="prod in cat.prods">
							<div class="col-md-3">
								<div class="content-border" ng-class="{'selected': prod.selected == 1, 'limit': limitClass}" ng-mousedown="selectedCount == selectedMax ? limitClass = 'limit' : ''" ng-mouseup="limitClass = ''" ng-click="chooseProd(prod)" ng-init="prod.selected = 0; limitClass = ''">
									<div class="content-inner">
										<div class="content-img">
											<div class="content-img-check">
												<i class="fa fa-check-square fa-2x" aria-hidden="true"></i>
											</div>
											<img src="http://comparewear.com/images/products/asus-zenwatch-3.jpg" alt="#" />
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
				<div class="btn-compare">
					<a href="@{{compareAlias}}" type="button" class="btn btn-info btn-block" ng-click="">COMPARE <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>