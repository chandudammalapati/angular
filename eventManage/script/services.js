/// <reference path="myCustom.js" />
myApp.factory("retrieveJson", ['$http', function ($http) {
    var retrieveJson = {
        itemDetails: function () {
            return $http(
                {
                    url:"data.json",
            method: "GET",
            })
    .then(function(response){
        return response.data;
    });
}
};
return retrieveJson;
}]);