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
				$this->response($this->json($result), 200); // send user details
			}
                    $this->response('',204);	// If no records "No Content" status
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