var recRestApp = angular.module('MyRecApp', []);



recRestApp.controller('listEventCategory' , ['$scope', 'servicesData', function($scope, servicesData){
        servicesData.getEventcategories().then(function (data){
            
            $scope.catDetailsData = data.data;
            
        })
        
}]);