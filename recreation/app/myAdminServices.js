
recRestAdminApp.factory("servicesData", ['$http', function($http){
       
    var serviceBase = 'services/'
    var obj = {};
    obj.getEventcategories = function(){
        return $http.get(serviceBase + 'eventcategories');
    };
    obj.getCatListByID = function(catID){
        return $http.get(serviceBase + 'catListByID?catID=' + catID);
    };
    
    obj.getAdminByCredentials = function(admin){
        //debugger;
        return $http.post(serviceBase + 'getAdminByDetails', {admID: admin.AdminID, admPwd: admin.AdminPassword}).then(function (results) {
       //debugger;
        console.log(results);
        return results;
       
    });
    }
    
     obj.insertCategory = function (category) {
         
    return $http.post(serviceBase + 'insertCategory', category).then(function (results) {
       //debugger;
        console.log(results);
        return results;
       
    });
    };
        
    obj.updateCategory = function (categoryID,category) {
            //debugger;
	    return $http.post(serviceBase + 'updateCategory', {catID:categoryID, catName:category.CategoryName, catDescription:category.CategoryDescription}).then(function (status) {
                //debugger;
                console.log(status);
	        return status.data;
	    });
	}; 
    obj.getEventsListAll = function(){
        return $http.get(serviceBase + 'eventsListAll');
    };
    
    obj.getEventsListByID = function(eventID){
        return $http.get(serviceBase + 'catEventByID?eventIDSelected=' + eventID);
    };
    
    obj.insertEvent = function (event) {
    return $http.post(serviceBase + 'insertEvent', event).then(function (results) {
       //debugger;
        console.log(results);
        return results;
       
    });
    };
    
    obj.updateEvent = function (eventID, event) {
            //debugger;
	    return $http.post(serviceBase + 'updateEvent', {eveID:eventID, catName:event.CategoryNameEventData, eveDescription:event.EventDescription, CoaName:event.CoachName, CosPerson:event.CostPerPerson, DayWeek:event.DaysInWeek, Dur:event.Duration, EveName:event.EventName, LvlCrse:event.LevelOfCourse, NoAvail:event.NoOfAvailable, ShwStatus:event.ShowStaus, StrDate:event.StartDate, TimeEvent:event.TimeOfEvent }).then(function (status) {
                //debugger;
                console.log(status);
	        return status.data;
	    });
	}; 
         
    obj.getReservationListAll = function(){
        return $http.get(serviceBase + 'reservationListAll');
    }; 
        
    obj.getResByID = function(reservationID){
       
        return $http.get(serviceBase + 'getResDataByID?resIDSelected=' + reservationID);
    };
    
    return obj;
}]);
