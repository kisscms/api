<?php

class Me extends REST_Service {
	
	function __construct($controller_path,$web_folder,$default_controller,$default_function)  {
		
		// main objects
		$this->model['user'] = new Model_User();
		
		// continue to the default setup
		parent::__construct($controller_path,$web_folder,$default_controller,$default_function);
		
	}
	
	function index( $params ) {
		// exit if there's no session 
		if( empty( $_SESSION['user'])  ) exit;
		
		// data structure
		$params = array(
			'user' => array( 'fields' => 'username, name, first_name, last_name, link', 'filters' => array('id' => $_SESSION['user']['id']) )
		);
		
		parent::crud( $params );
	}
	
	// Data methods
	function read( $params ){
		
		$data = array();
		
		foreach($params as $name=>$vars){
			$data[$name] = $this->model[$name]->query($vars);
		}
		
		// remove the parent array if only one dataset
		$this->data = ( count($params) > 1 ) ? $data: array_shift($data);
		
	}
	
}

?>