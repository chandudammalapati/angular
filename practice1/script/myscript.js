/// <reference path="../lib/angular/angular.js" />
/*
//creating a module.
var myApp = angular.module('myModule',[]);

//creating a controller with anonymous function
//var mycontroller = function ($scope) {
//	$scope.message = "angular js example";
//};

//register controller with the module
//myApp.controller("myController", mycontroller);

//creating and registering at the same time

myApp.controller("myController", function ($scope) {
    var empRecord = {
        firstName: 'chandu',
        lastName: 'Dammalapati',
        gender: 'Male'
    };

    $scope.emp = empRecord;
});
*/
var myApp = angular.module('myModule', []).controller("myController", function ($scope) {
    var empRecord = {
        firstName: 'chandu',
        lastName: 'Dammalapati',
        gender: 'Male'
    };

    $scope.emp = empRecord;
});

myApp.controller("myControllerImage", function($scope){
    var countryArray = {
        name: "USA",
        capital:"Washington, D.C",
        flag:"images/usa_flag.jpg"
    };

    $scope.country = countryArray;
});

myApp.controller("myTwoWayDataBind", function ($scope) {
    var empRecord = {
        firstName: 'chandu',
        lastName: 'Dammalapati',
        gender: 'Male'
    };

    $scope.emp = empRecord;
});

myApp.controller("myNgRepeatFun", function ($scope) {
    
    var employeesArray = [
        { firstName: "Ben", lastName: "Hasting", gender: "Male", salary:5000 },
        { firstName: "Pamela", lastName: "Landy", gender: "Female", salary:5500 },
        { firstName: "Bill", lastName: "Carson", gender: "Male", salary:5700 },
        { firstName: "David", lastName: "Jones", gender: "Male", salary:5800 },
        { firstName: "Emma", lastName: "Curtzman", gender: "Female", salary:5000 }

    ];

    $scope.empRecords = employeesArray;

    var countries = [
        {
            name: "UK",
            cities: [
                { name: "london" },
                { name: "Manchester" },
                { name: "Birmingham" }
            ]
        },
        {
            name: "USA",
            cities: [
                { name: "New York" },
                { name: "Chicago" },
                { name: "Kansas" }
            ]
        },
    {
        name: "INDIA",
        cities: [
            { name: "Delhi" },
            { name: "Chennai" },
            { name: "Hyderabad" }
    ]
    }
    ];
    $scope.countriesArry = countries;
});

myApp.controller("myEventHandling", function ($scope) {
    var technologies = [
        { name: "c#", likes: 0, dislikes: 0 },
        { name: "javaScript", likes: 0, dislikes: 0 },
        { name: "PHP", likes: 0, dislikes: 0 },
        { name: "Java", likes: 0, dislikes: 0 }
    ];
    $scope.techArray = technologies;
    $scope.incrementLikes = function (technology) {
        technology.likes++;
    };
    $scope.incrementDislikes = function (technology) {
        technology.dislikes++;
    }

    var employeesArray = [
     { name: "Ben", dateOfBirth: new Date("November 06, 1989"), gender: "Male", salary: 50001.243 },
     { name: "Pamela", dateOfBirth: new Date("December 06, 1988"), gender: "Female", salary: 55004.654 },
     { name: "Bill", dateOfBirth: new Date("November 12, 1987"), gender: "Male", salary: 57000.564 },
     { name: "David", dateOfBirth: new Date("July 23, 1986"), gender: "Male", salary: 58000.233 },
     { name: "Emma", dateOfBirth: new Date("August 21, 1990"), gender: "Female", salary: 50007.867 }

    ];

    $scope.empRecords = employeesArray;
    $scope.rowLimit = 3;
    $scope.sortColumn = "name";
    $scope.reverseSort = false;

    $scope.sortData = function (column) {
        $scope.reverseSort = ($scope.sortColumn == column) ? !$scope.reverseSort : false;
        $scope.sortColumn = column;
    }

    $scope.getSortClass = function (column) {
        if ($scope.sortColumn == column) {
            return $scope.reverseSort ? 'arrow-down' : 'arrow-up';
        }
        return '';
    }
});

myApp.controller("myFilterController", function ($scope) {
    var employeesArray = [
  { name: "Ben", city: "London", gender: "Male", salary: 50001.243 },
  { name: "Pamela", city: "Chicago", gender: "Female", salary: 55004.654 },
  { name: "Bill", city: "Dallas", gender: "Male", salary: 57000.564 },
  { name: "David", city: "Kansas", gender: "Male", salary: 58000.233 },
  { name: "Emma", city: "NewJersey", gender: "Female", salary: 50007.867 }

    ];
    
    $scope.empArry = employeesArray;
    $scope.search = function (item) {
      
        if ($scope.searchText == undefined) {
            return true;
        }
        else {
            if (item.name.toLowerCase().indexOf($scope.searchText.toLowerCase()) != -1 ||
                item.city.toLowerCase().indexOf($scope.searchText.toLowerCase()) != -1) {
                
                return true;
            }
        }
        return false;
    }
    var empCustom = [
            { name: "Ben", gender: 1, salary: 50001.243 },
            { name: "Pamela", gender: 2, salary: 55004.654 },
            { name: "Bill", gender: 1, salary: 57000.564 },
            { name: "David", gender: 2, salary: 58000.233 },
            { name: "Emma", gender: 3, salary: 50007.867 }
    ]
    $scope.empCusArry = empCustom;
});

myApp.controller("myNgShowNgHide", function ($scope) {
    var employeesArray = [
  { name: "Ben", city: "London", gender: "Male", salary: 50001.243 },
  { name: "Pamela", city: "Chicago", gender: "Female", salary: 55004.654 },
  { name: "Bill", city: "Dallas", gender: "Male", salary: 57000.564 },
  { name: "David", city: "Kansas", gender: "Male", salary: 58000.233 },
  { name: "Emma", city: "NewJersey", gender: "Female", salary: 50007.867 }

    ];

    $scope.empArry = employeesArray;
});

myApp.controller("myNgInclude", function ($scope) {
    var employeesArray = [
  { name: "Ben", gender: "Male", salary: 50001.243 },
  { name: "Pamela", gender: "Female", salary: 55004.654 },
  { name: "Bill", gender: "Male", salary: 57000.564 },
  { name: "David", gender: "Male", salary: 58000.233 },
  { name: "Emma", gender: "Female", salary: 50007.867 }

    ];

    $scope.empArry = employeesArray;
    $scope.employeeView = "EmpTable.html";
});

myApp.controller("myCustomServiceCon", function ($scope, stringService) {
    $scope.transformString = function (input) {

        $scope.finalOutput = stringService.processString(input);
    }
});

var demoApp = angular.module("demoAppModule", [])
                      .controller("demoAnchorScroll", function ($scope, $location, $anchorScroll) {
                          $scope.scrollTo = function (scrollLocation) {
                              $location.hash(scrollLocation);
                              $anchorScroll.yOffset = 20;
                              $anchorScroll();
                          }
                      });