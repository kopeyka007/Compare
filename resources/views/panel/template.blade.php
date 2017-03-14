<html lang="en" ng-app="panelApp" ng-controller="panelCtrl">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Compare.da</title>
		<link href="/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/css/font-awesome.min.css" rel="stylesheet" />
		<link href="/css/style.css" rel="stylesheet" />
		<script src="/js/angular.min.js"></script>
		<script src="/js/angular-route.min.js"></script>
	</head>
	
    <body>
		<section>
			<nav class="navbar navbar-default">
				<div class="container">
					<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Brand</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						<li><a href="#">Link</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
						<li><a href="" ng-click="logout()">Signout</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<div class="container">
				<div ng-view>
				</div>
			</div>
		</section>
		
		<script src="/js/panelapp.js"></script>
		<script src="/js/signin.js"></script>
		<script src="/js/validate.js"></script>
		
    </body>
</html>
