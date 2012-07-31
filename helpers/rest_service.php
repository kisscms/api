<?php

class REST_Service extends Controller {

	public $model;
	
	// this method displays a specific Task
	function crud( $params ) {
		
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
	
	function create( $params ) {
		
	}
	
	function read( $params ) {
		
	}
	
	function update( $params ) {
		
	}
	
	function delete( $params ) {
		
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