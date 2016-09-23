
<!DOCTYPE html>
<html ng-app="myRecreation">
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Management System</title>
	<script src="lib/angular/angular.js"></script>
	<script src="lib/angular/angular-route.js"></script>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/MyStyle.css" rel="stylesheet" type="text/css"/>
        
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.js" type="text/javascript"></script>
        <script src="js/MyCustom.js" type="text/javascript"></script>
        <script src="js/MyServices.js" type="text/javascript"></script>
        
</head>

<body>
    
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="images/logo1.png" alt="View/Book Event">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">View Status</a>
                    </li>
                    <li>
                        <a href="#">Announcements</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /navbar-collapse -->
        </div>
        <!-- /container -->
    </nav>
    
        <div class="container">
     
            <h1>Lee's Summit Recreation Center</h1>
                 <li class="h-divider"></li>
                 <div class="row" ng-controller="retrieveEventCat">
                    <div class="col-md-6">
                        <form id="searchbox" action="" >
                            <div class="col-lg-6 col-md-offset-3">
                                <div class="input-group">
                                  <input type="text" class="form-control" list="categoryList" placeholder="Search for...">
                                  <datalist id="categoryList">
                                    <option ng-repeat="catData in catDetailsData" value="{{catData.CategoryName}}">
                                </datalist>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go!</button>
                                  </span>
                                </div><!-- /input-group -->
                             </div>
                        </form>
                            
                    </div>
                     <div class="col-md-6 v-divider">I was right</div>
		</div>
        
        </div>
    
</body>
</html>