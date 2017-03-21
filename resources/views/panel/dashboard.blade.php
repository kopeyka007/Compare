<div ng-controller="dashboardCtrl">
	<div class="container">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default panel-dashboard">
					<div class="panel-heading"><strong>Comparison count Timeline</strong></div>
					<table class="table table-striped">
						<tbody>
							<tr ng-repeat="(date, count) in statDashboard.count_all_compare_last10days_days">
								<td>@{{date}}</td>
								<td class="td-counter">@{{count}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default panel-dashboard">
					<div class="panel-heading"><strong>Top 10 Most Compared products (Single)</strong></div>
					<table class="table table-striped">
						<tbody>
							<tr ng-repeat="(i, singleTop) in statDashboard.single_compare_top10">
								<td class="td-number">@{{i + 1}}.</td>
								<td>@{{singleTop.prods.brands_id.brands_name}} @{{singleTop.prods.prods_name}}</td>
								<td class="td-counter">@{{singleTop.prods_count}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default panel-dashboard">
					<div class="panel-heading"><strong>Top 10 Most Compared products (Pair)</strong></div>
					<table class="table table-striped">
						<tbody>
							<tr ng-repeat="(i, pairTop) in statDashboard.pair_compare_top10">
								<td class="td-number">@{{i + 1}}.</td>
								<td>@{{pairTop.prods1_id.brands_id.brands_name}} @{{pairTop.prods2_id.prods_name}} <span>vs</span> @{{pairTop.prods2_id.brands_id.brands_name}} @{{pairTop.prods1_id.prods_name}}</td>
								<td class="td-counter">@{{pairTop.prods1_count}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default panel-dashboard">
					<div class="panel-heading"><strong>Amazon redirects timeline</strong></div>
					<table class="table table-striped">
						<tbody>
							<tr ng-repeat="(date, count) in statDashboard.amazon_last10days">
								<td>@{{date}}</td>
								<td class="td-counter">@{{count}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default panel-dashboard">
					<div class="panel-heading"><strong>Top 10 Products with Most Amazon Clicks</strong></div>
					<table class="table table-striped">
						<tbody>
							<tr ng-repeat="(i, amazonTop) in statDashboard.amazon_top10">
								<td class="td-number">@{{i + 1}}.</td>
								<td>@{{amazonTop.prods.brands_id.brands_name}} @{{amazonTop.prods.prods_name}}</td>
								<td class="td-counter">@{{amazonTop.prods_count}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default panel-dashboard">
					<div class="panel-heading"><strong>Total Products Count categorywise</strong></div>
					<table class="table table-striped">
						<tbody>
							<tr ng-repeat="(i, cats) in statDashboard.count_all_compare_cats_top10">
								<td class="td-number">@{{i + 1}}.</td>
								<td>@{{cats.cats_id.cats_name}}</td>
								<td class="td-counter">@{{cats.cats_count}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default panel-dashboard">
					<div class="panel-heading"><strong>Day wise comparison</strong></div>
					<table class="table table-striped">
						<tbody>
							<tr ng-repeat="(i, count) in statDashboard.count_all_compare_last10days">
								<td>@{{dayOfWeek(i)}}</td>
								<td class="td-counter">@{{count}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>