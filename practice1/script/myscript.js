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
});