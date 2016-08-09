var artistControllers = angular.module('artistControllers', []);

artistControllers.controller('ListController', ['$scope', '$http', function($scope, $http) {
	
	$http.get('js/data.json').success(function(data){
		$scope.artists = data;
		$scope.SortArtist = 'name';
	});
}]);

artistControllers.controller('DetailsController', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
	
	$http.get('js/data.json').success(function(data){
		$scope.artists = data;
		$scope.whichItem = $routeParams.itemID;
		
		if($routeParams.itemID >0) {
			$scope.prevItem = Number($routeParams.itemID)-1;
		}
		else
		{
			$scope.prevItem = $scope.artists.length-1;
		}
		
		if($routeParams.itemID < $scope.artists.length-1){
			$scope.nextItem = Number($routeParams.itemID)+1;
		}
		else{
			$scope.nextItem = 0;
		}
		
	});
}]);