<?php

class REST_Service extends Controller {

	// this method displays a specific Task
	function index( $params ) {
		
		// redirect to the proper method
		switch($_SERVER['REQUEST_METHOD']){
			case "POST": 
				$this->create( $params );
			break;
			case "GET": 
				$this->retrieve( $params );
			break;
			case "PUT": 
				$this->update( $params );
			break;
			case "DELETE": 
				$this->delete( $params );
			break;
		}
		
		// in any case, render the output
		$this->render();
	}
	
	function create( $params ) {
		
	}
	
	function retrieve( $params ) {
		
	}
	
	function update( $params ) {
		
	}
	
	function delete( $params ) {
		
	}
	
	
	function render() {
		
		// display the data in json format
		View::do_dump( getPath('views/json.php'), $this->data );
	}


}

?>