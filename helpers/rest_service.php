<?php

class REST_Service extends Controller {

	protected $api;
	protected $model;
	
	function index( $params ) {
		// by default no index available
		exit;
	}
	
	// this method displays a specific Task
	protected function crud( $params ) {
		// reset data
		$this->data = array();
		
		// redirect to the proper method
		switch($_SERVER['REQUEST_METHOD']){
			case "POST": 
				$this->create( $params );
			break;
			case "GET": 
				$this->read( $params );
			break;
			case "PUT": 
				$this->update( $params );
			break;
			case "DELETE": 
				$this->delete( $params );
			break;
			default:
				header('HTTP/1.1 405 Method Not Allowed');
		}
		
		// in any case, render the output
		$this->render();
	}
	
	protected function create( $params ) {
		// method is off limits for not logged in users...
		if( empty( $_SESSION['user'])  ) exit;
		
		$data = array();
		//for each db initiated...
		foreach( $this->db as $name => $db){
			$action = "create".ucfirst($name);
			if( method_exists($this, $action) ) { 
				$result = $this->$action($params);
				// remove the parent array if only one dataset
				$data[$type] = ( count($result) == 1 ) ? array_shift($result) : $result;
			}
		}
		// remove the parent array if only one dataset
		$this->data = ( count($this->db) > 1 ) ? $data: array_shift($data);
		// debug
		//error_log( print_r($this->data,1) , 3, "log.txt");
	}
	
	protected function read( $params ) {
		
		$data = array();
		//for each db initiated...
		foreach( $this->db as $name => $db){
			$action = "read".ucfirst($name);
			if( method_exists($this, $action) ) { 
				$result = $this->$action($params);
				// remove the parent array if only one dataset
				$data[$type] = ( count($result) == 1 ) ? array_shift($result) : $result;
			}
		}
		// remove the parent array if only one dataset
		$this->data = ( count($this->db) > 1 ) ? $data: array_shift($data);
		// debug
		//error_log( print_r($this->data,1) , 3, "log.txt");
	}
	
	protected function update( $params ) {
		// method is off limits for not logged in users...
		if( empty( $_SESSION['user'])  ) exit;
		
		$data = array();
		//for each db initiated...
		foreach( $this->db as $name => $db){
			$action = "update".ucfirst($name);
			if( method_exists($this, $action) ) { 
				$result = $this->$action($params);
				// remove the parent array if only one dataset
				$data[$type] = ( count($result) == 1 ) ? array_shift($result) : $result;
			}
		}
		// remove the parent array if only one dataset
		$this->data = ( count($this->db) > 1 ) ? $data: array_shift($data);
		// debug
		//error_log( print_r($this->data,1) , 3, "log.txt");
	}
	
	protected function delete( $params ) {
		// method is off limits for not logged in users...
		if( empty( $_SESSION['user'])  ) exit;
		
		$data = array();
		//for each db initiated...
		foreach( $this->db as $name => $db){
			$action = "delete".ucfirst($name);
			if( method_exists($this, $action) ) { 
				$result = $this->$action($params);
				// remove the parent array if only one dataset
				$data[$type] = ( count($result) == 1 ) ? array_shift($result) : $result;
			}
		}
		// remove the parent array if only one dataset
		$this->data = ( count($this->db) > 1 ) ? $data: array_shift($data);
		// debug
		//error_log( print_r($this->data,1) , 3, "log.txt");
	}
	
	
	function render() {
		
		// set the right header
		if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        
		// display the data in json format
		View::do_dump( getPath('views/json.php'), $this->data );
	}


}

?>