<?php
require_once("Rest.inc.php");
    class API extends REST{
        public $data = "";
        const DB_SERVER = "127.0.0.1";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB = "recreation";
        
        private $db = NULL;
		private $mysqli = NULL;
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}
                
                /*
		 *  Connect to Database
		*/
		private function dbConnect(){
			$this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
		}
                
                /*
		 * Dynmically call the method based on the query string
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404); // If the method not exist with in this class "Page not found".
		}
                

                private function eventcategories(){
                    if($this->get_request_method() != "GET"){
				$this->response('',406);
                    }
                    $query = "SELECT distinct evenc.CategoryID, evenc.CategoryName, evenc.CategoryDescription FROM eventcategory evenc order by evenc.CategoryID desc";
                    $resultSetData   =  $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
                    
                    if($resultSetData->num_rows > 0){
				$result = array();
                                $i=0;
				while($row = $resultSetData->fetch_assoc()){
					//$result[] = $row;
                                    $row_array['CategoryID'] = $row['CategoryID'];
                                    $row_array['CategoryName'] = $row['CategoryName'];
                                    $row_array['CategoryDescription'] = $row['CategoryDescription'];
                                    
                                    array_push($result, $row_array);
				}
				$this->response($this->json($result), 200); // send event catogery details
			}
                    $this->response('',204);	// If no records "No Content" status
                } 
                
                
              
                
                private function catListByID(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$catID = (int) $this->_request['catID'];
			if($catID > 0){	
				$query = "SELECT distinct evenc.CategoryID, evenc.CategoryName, evenc.CategoryDescription FROM eventcategory evenc where evenc.CategoryID='$catID'";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();	
					$this->response($this->json($result), 200); // send category details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}
                
                 
                private function getAdminByDetails(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			$admin = json_decode(file_get_contents("php://input"),true);
			$AdminID = (int)$admin['admID'];
                        $AdminPassword = $admin['admPwd'];

                        $query = "SELECT `AdminID`, `AdminName`, `AdminPassword` FROM `adminprofile` WHERE `AdminID` = '$AdminID' and `AdminPassword` = '$AdminPassword'";
			if(!empty($AdminID) and !empty($AdminPassword)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
                                if($r->num_rows>0){
                                    $result = $r->fetch_assoc();
                                    $this->response($this->json($result),200);
                                }
				$this->response('',204);	// "No Content" status				
			}
                        $error = array('status' => "Failed", "msg" => "Invalid admin ID or Password");
			$this->response($this->json($error), 400);                        
		}
                
                
                
                private function insertCategory(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$category = json_decode(file_get_contents("php://input"),true);
			$column_names = array('CategoryName', 'CategoryDescription');
			$keys = array_keys($category);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the category received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $category[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO eventcategory(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($category)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Category Created Successfully.", "data" => $category);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status
		}
                
                 private function updateCategory(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			$category = json_decode(file_get_contents("php://input"),true);
			$id = (int)$category['catID'];
                        $CategoryName = $category['catName'];
                        $CategoryDescription = $category['catDescription'];
			
			
                        $query = "UPDATE `eventcategory` SET `CategoryName` = '$CategoryName', `CategoryDescription` = '$CategoryDescription' WHERE `eventcategory`.`CategoryID` = '$id'";
			if(!empty($category)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "category ".$id." Updated Successfully.", "data" => $category);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	// "No Content" status
		}
                
                
                private function eventsListAll(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct ed.EventID, ed.EventName, ed.EventDescription, ed.CoachName, ed.Duration, ed.CostPerPerson, ed.DaysInWeek, ed.LevelOfCourse, ed.NoOfAvailable, ed.StartDate, ed.TimeOfEvent, ed.ShowStaus, ed.CategoryNameEventData FROM eventdata ed order BY ed.EventName desc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}
                
                
                
                private function eventsList(){
                    if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
                        $nameCat = $this->_request['nameCat'];
                        if($nameCat!=""){
                            $query = "SELECT distinct ed.EventID, ed.EventName, ed.EventDescription, ed.CoachName, ed.Duration, ed.CostPerPerson, ed.DaysInWeek, ed.LevelOfCourse, ed.NoOfAvailable, ed.StartDate, ed.TimeOfEvent, ed.ShowStaus, ed.CategoryNameEventData FROM eventdata ed WHERE ed.CategoryNameEventData= '$nameCat' order BY ed.EventName desc";
                        }
                        $resultSetData = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
                        if($resultSetData->num_rows > 0) {
                            $result = array();
                                    $i=0;
				while($row = $resultSetData->fetch_assoc()){
					//$result[] = $row;
                                    $row_array['EventID'] = $row['EventID'];
                                    $row_array['EventName'] = $row['EventName'];
                                    $row_array['EventDescription'] = $row['EventDescription'];
                                    $row_array['CoachName'] = $row['CoachName'];
                                    $row_array['Duration'] = $row['Duration'];
                                    $row_array['CostPerPerson'] = $row['CostPerPerson'];
                                    $row_array['DaysInWeek'] = $row['DaysInWeek'];
                                    $row_array['LevelOfCourse'] = $row['LevelOfCourse'];
                                    $row_array['NoOfAvailable'] = $row['NoOfAvailable'];
                                    $row_array['StartDate'] = $row['StartDate'];
                                    $row_array['TimeOfEvent'] = $row['TimeOfEvent'];
                                    $row_array['ShowStaus'] = $row['ShowStaus'];
                                    $row_array['CategoryNameEventData'] = $row['CategoryNameEventData'];
                                    
                                    array_push($result, $row_array);
				}
				$this->response($this->json($result), 200); // send event catogery details
                                
					//$result = $r->fetch_assoc();	
					//$this->response($this->json($result), 200); // send user details
				}
                        $this->response('',204);	// If no records "No Content" status                    
                }
                
                
                private function catEventByID(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$eventID = (int) $this->_request['eventIDSelected'];
			if($eventID > 0){	
				$query = "SELECT distinct ed.EventID, ed.EventName, ed.EventDescription, ed.CoachName, ed.Duration, ed.CostPerPerson, ed.DaysInWeek, ed.LevelOfCourse, ed.NoOfAvailable, ed.StartDate, ed.TimeOfEvent, ed.ShowStaus, ed.CategoryNameEventData FROM eventdata ed WHERE ed.EventID=$eventID";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();	
					$this->response($this->json($result), 200); // send category details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}
                

                private function eventsDetails(){
                    if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
                    $eventID = (int)$this->_request['eventIDSelected'];
                    if($eventID!=""){
                            $query = "SELECT distinct ed.EventID, ed.EventName, ed.EventDescription, ed.CoachName, ed.Duration, ed.CostPerPerson, ed.DaysInWeek, ed.LevelOfCourse, ed.NoOfAvailable, ed.StartDate, ed.TimeOfEvent, ed.ShowStaus, ed.CategoryNameEventData FROM eventdata ed WHERE ed.EventID=$eventID ";
                        }
                    $resultSetData = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
                    if($resultSetData->num_rows > 0) {
                            $result = array();
                                    $i=0;
				while($row = $resultSetData->fetch_assoc()){
					//$result[] = $row;
                                    $row_array['EventID'] = $row['EventID'];
                                    $row_array['EventName'] = $row['EventName'];
                                    $row_array['EventDescription'] = $row['EventDescription'];
                                    $row_array['CoachName'] = $row['CoachName'];
                                    $row_array['Duration'] = $row['Duration'];
                                    $row_array['CostPerPerson'] = $row['CostPerPerson'];
                                    $row_array['DaysInWeek'] = $row['DaysInWeek'];
                                    $row_array['LevelOfCourse'] = $row['LevelOfCourse'];
                                    $row_array['NoOfAvailable'] = $row['NoOfAvailable'];
                                    $row_array['StartDate'] = $row['StartDate'];
                                    $row_array['TimeOfEvent'] = $row['TimeOfEvent'];
                                    $row_array['ShowStaus'] = $row['ShowStaus'];
                                    $row_array['CategoryNameEventData'] = $row['CategoryNameEventData'];
                                    
                                    array_push($result, $row_array);
				}
				$this->response($this->json($result), 200); // send event catogery details
                                
					//$result = $r->fetch_assoc();	
					//$this->response($this->json($result), 200); // send user details
				}
                    $this->response('',204);	// If no records "No Content" status 
                }

                
                private function insertEvent(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$event = json_decode(file_get_contents("php://input"),true);
			$column_names = array('CategoryNameEventData', 'CoachName', 'CostPerPerson', 'DaysInWeek','Duration', 'EventDescription', 'EventName','LevelOfCourse', 'NoOfAvailable','ShowStaus', 'StartDate', 'TimeOfEvent');
			$keys = array_keys($event);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the category received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $event[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO eventdata(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($event)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Event Created Successfully.", "data" => $event);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status
		}
 
                 private function updateEvent(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			$event = json_decode(file_get_contents("php://input"),true);
			$eventID = (int)$event['eveID'];
                        $Duration = (int)$event['Dur'];
                        $CostPerPerson = (int)$event['CosPerson'];
                        $NoOfAvailable = (int)$event['NoAvail'];
                        $EventName = $event['EveName'];
                        $EventDescription = $event['eveDescription'];
			$CoachName = $event['CoaName'];
                        $DaysInWeek = $event['DayWeek'];
			$LevelOfCourse = $event['LvlCrse'];
                        $StartDate = $event['StrDate'];			
                        $TimeOfEvent = $event['TimeEvent'];			
                        $ShowStaus = $event['ShwStatus'];
                        $CategoryNameEventData = $event['catName'];
                        
                        $query = "UPDATE `eventdata` SET `EventName` = '$EventName', `EventDescription` = '$EventDescription', `CoachName` = '$CoachName', `Duration` = '$Duration', `CostPerPerson` = '$CostPerPerson', `DaysInWeek` = '$DaysInWeek', `LevelOfCourse` = '$LevelOfCourse', `NoOfAvailable` = '$NoOfAvailable', `StartDate` = '$StartDate', `TimeOfEvent` = '$TimeOfEvent', `ShowStaus` = '$ShowStaus', `CategoryNameEventData` = '$CategoryNameEventData' WHERE `eventdata`.`EventID` = '$eventID'";
			if(!empty($event)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Event ".$eventID." Updated Successfully.", "data" => $event);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	// "No Content" status
		}
                
                
                
             private function reservationListAll(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
                        
			$query="SELECT distinct rd.ReservationID, rd.CandidateName, rd.Gender, rd.Age, rd.Email, rd.GuardianName, rd.GuardianRelation, rd.ConfirmationStatus, rd.EventIDReservationData, rd.AdminIDReservationData , rd.Remarks, rd.CardNumber, rd.cvv, rd.expiryMonth, rd.expiryYear, rd.BillingAddress FROM reservationdata rd order BY rd.CandidateName desc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}
                
                private function getResDataByID(){	
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$resID = $this->_request['resIDSelected'];
			if($resID!=""){	
				$query = "SELECT distinct rd.ReservationID, rd.CandidateName, rd.Gender, rd.Age, rd.Email, rd.GuardianName, rd.GuardianRelation, rd.ConfirmationStatus, rd.EventIDReservationData, rd.AdminIDReservationData , rd.Remarks, rd.CardNumber, rd.cvv, rd.expiryMonth, rd.expiryYear, rd.BillingAddress FROM reservationdata rd where rd.ReservationID = '$resID'";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();	
					$this->response($this->json($result), 200); // send category details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}
                
                private function updateReservation(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}
			$event = json_decode(file_get_contents("php://input"),true);
			$eventID = (int)$event['eveID'];
                        $Duration = (int)$event['Dur'];
                        $CostPerPerson = (int)$event['CosPerson'];
                        $NoOfAvailable = (int)$event['NoAvail'];
                        $EventName = $event['EveName'];
                        $EventDescription = $event['eveDescription'];
			$CoachName = $event['CoaName'];
                        $DaysInWeek = $event['DayWeek'];
			$LevelOfCourse = $event['LvlCrse'];
                        $StartDate = $event['StrDate'];			
                        $TimeOfEvent = $event['TimeEvent'];			
                        $ShowStaus = $event['ShwStatus'];
                        $CategoryNameEventData = $event['catName'];
                        
                        $query = "UPDATE `eventdata` SET `EventName` = '$EventName', `EventDescription` = '$EventDescription', `CoachName` = '$CoachName', `Duration` = '$Duration', `CostPerPerson` = '$CostPerPerson', `DaysInWeek` = '$DaysInWeek', `LevelOfCourse` = '$LevelOfCourse', `NoOfAvailable` = '$NoOfAvailable', `StartDate` = '$StartDate', `TimeOfEvent` = '$TimeOfEvent', `ShowStaus` = '$ShowStaus', `CategoryNameEventData` = '$CategoryNameEventData' WHERE `eventdata`.`EventID` = '$eventID'";
			if(!empty($event)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Event ".$eventID." Updated Successfully.", "data" => $event);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	// "No Content" status
		}
                
                
                private function registerCandidate(){
                    if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
                        
                    $CandidateName=$this->_request['CandidateName'];
                    $Age = (int) $this->_request['Age'];
                    $ReservationID =$this->_request['ReservationID'];
                   
                   $Gender = $this->_request['Gender']; 
                   $Email = $this->_request['Email'];
                   $GuardianName = $this->_request['GuardianName'];
                   $GuardianRelation = $this->_request['GuardianRelation'];
                   $ConfirmationStatus = $this->_request['ConfirmationStatus'];
                   $EventID = (int) $this->_request['EventIDReservationData'];
                   $CardNumber = $this->_request['CardNumber'];
                   $cvv = $this->_request['cvv'];
                   $expiryMonth = $this->_request['expiryMonth'];
                   $expiryYear = $this->_request['expiryYear'];
                   $BillingAddress = $this->_request['BillingAddress'];
                   
                  $query = "INSERT INTO `reservationdata` (`ReservationID`, `CandidateName`, `Gender`, `Age`, `Email`, `GuardianName`, `GuardianRelation`, `ConfirmationStatus`, `EventIDReservationData`, `AdminIDReservationData`, `Remarks`, `CardNumber`, `cvv`, `expiryMonth`, `expiryYear`, `BillingAddress`) VALUES ('$ReservationID', '$CandidateName', '$Gender', '$Age', '$Email', '$GuardianName', '$GuardianRelation', '$ConfirmationStatus', '$EventID', NULL, NULL, '$CardNumber', '$cvv', '$expiryMonth', '$expiryYear', '$BillingAddress')";
                  $resultData = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
                   $result = array('ReservationID' => $ReservationID);
                    $this ->response($this -> json($result), 200);
                   
			
                }

                private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
    }
    
    	// Initiiate Library
	
	$api = new API;
	$api->processApi();
?>