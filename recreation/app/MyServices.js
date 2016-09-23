recRestApp.factory("servicesData", ['$http', function($http){
       
    var serviceBase = 'services/'
    var obj = {};
        obj.getEventcategories = function(){
        return $http.get(serviceBase + 'eventcategories');
    }
    
    return obj;  
}]);