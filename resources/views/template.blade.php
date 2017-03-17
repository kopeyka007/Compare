<html lang="en" ng-app="compareApp" ng-controller="mainCtrl">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Compare.da</title>
		<link href="/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/css/font-awesome.min.css" rel="stylesheet" />
		<link href="/css/style.css" rel="stylesheet" />
	</head>
	
    <body>
		<section class="header">
			<div class="container">
				<h3>Compare</h3>
			</div>
		</section>
			
		<section class="content" ng-view>
		</section>

		<script src="/js/libs/angular.min.js"></script>
		<script src="/js/libs/angular-route.min.js"></script>
		<script src="/js/compareapp.js"></script>
		<script src="/js/compare.js"></script>
		
    </body>
</html>
