/// <reference path="../lib/angular/angular.js" />
var myApp = angular.module('myModule', []);
myApp.controller('myJsonData', ['$scope', 'retrieveJson', function($scope, retrieveJson){
    var jsonRetrieved = retrieveJson.itemDetails();
    jsonRetrieved.then(function (data) {
        $scope.itemDetails = data;
         
    });
    $scope.retrieveData = function (input) {
         
        var selectedEvent;
        $scope.showValue = false;
       
        if (!input) {
            return input;
            $scope.showValue = false;
        } else {
            for (var index = 0 ; index < $scope.itemDetails.length ; index++) {

                if (input == $scope.itemDetails[index].eventName) {
                    // input = $scope.myDataEvent[index];
                    $scope.selectedEvent = $scope.itemDetails[index];
                    $scope.showValue = true;
                }
                
                
            }
        }


        }
    
    }]);