<div ng-controller="dashboardCtrl">
	<div class="container">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Comparison count Timeline</strong></div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
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
				<div class="panel panel-default">
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
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Amazon redirects timeline</strong></div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
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
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Total Products Count categorywise</strong></div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Day wise comparison</strong></div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>