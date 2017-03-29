<html lang="en" ng-app="panelApp" ng-controller="panelCtrl" ng-init="token('{{{ csrf_token() }}}')">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Compare.da</title>
		<link href="/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/css/font-awesome.min.css" rel="stylesheet" />
		<link href="/css/panel.css" rel="stylesheet" />
		<script src="/js/libs/angular.min.js"></script>
		<script src="/js/libs/angular-route.min.js"></script>
	</head>
	
    <body ng-class="loaderClass">
		<div class="loader">
			<i class="fa fa-refresh fa-spin fa-5x fa-fw"></i>
		</div>
		<section>
			<nav class="navbar navbar-default" ng-if="user != false">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<div class="collapse navbar-collapse" id="menu">
						<ul class="nav navbar-nav">
							<li ng-class="{'active': activeMenu('')}"><a href="/panel/" ng-if="access('dashboard')">Dashboard</a></li>
							<li ng-class="{'active': activeMenu('users')}"><a href="/panel/users/" ng-if="access('users')">Users</a></li>
							<li ng-class="{'active': activeMenu('cats')}"><a href="/panel/cats/" ng-if="access('cats')">Categories</a></li>
							<li ng-class="{'active': activeMenu('brands')}"><a href="/panel/brands/" ng-if="access('brands')">Brands</a></li>
							<li ng-class="{'active': activeMenu('features')}"><a href="/panel/features/" ng-if="access('features')">Features</a></li>
							<li ng-class="{'active': activeMenu('filters')}"><a href="/panel/filters/" ng-if="access('filters')">Filters</a></li>
							<li ng-class="{'active': activeMenu('prods')}"><a href="/panel/prods/" ng-if="access('prods')">Products</a></li>
							<li ng-class="{'active': activeMenu('currency')}"><a href="/panel/currencies/" ng-if="access('currency')">Currencies</a></li>
							<li ng-class="{'active': activeMenu('import')}"><a href="/panel/import/" ng-if="access('import')">Import</a></li>
							<li ng-class="{'active': activeMenu('settings')}"><a href="/panel/settings/" ng-if="access('settings')">Settings</a></li>
						</ul>

						<ul class="nav navbar-nav navbar-right">
							<li><a href="" ng-click="logout()">Sign out</a></li>
						</ul>
					</div>
				</div>
			</nav>

			<div class="container">
				<div class="error-msg" ng-show="errors.length">
					<div class="alert alert-@{{msg.type}}" ng-repeat="msg in errors" role="alert" ng-init="showme = true" ng-show="showme">@{{msg.text}}
						 <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="showme = false"><span aria-hidden="true">&times;</span></button>
					</div>
				</div>

				<div ng-view>
				</div>
			</div>
		</section>
		
		<script src="/js/libs/angular-animate.min.js"></script>
		<script src="/js/libs/angular-sanitize.min.js"></script>
		<script src="/js/libs/ui-bootstrap-tpls-2.5.0.js"></script>
		<script src="/js/libs/ng-file-upload.min.js"></script>
		<script src="/js/panelapp.js"></script>
		<script src="/js/signin.js"></script>
		<script src="/js/users.js"></script>
		<script src="/js/cats.js"></script>
		<script src="/js/brands.js"></script>
		<script src="/js/features.js"></script>
		<script src="/js/filters.js"></script>
		<script src="/js/dashboard.js"></script>
		<script src="/js/prods.js"></script>
		<script src="/js/import.js"></script>
		<script src="/js/currency.js"></script>
		<script src="/js/settings.js"></script>
		<script src="/js/validate.js"></script>
    </body>
</html>
