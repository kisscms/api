<?php
// 
// KISSCMS API Constroller
// 
// Twitter API used as an example
// Source: https://github.com/kisscms/twitter
// 
class API extends REST_Service {
	
	function __construct($controller_path,$web_folder,$default_controller,$default_function)  {
		
		// main objects
		$this->api['twitter'] = new Twitter();
		
		// continue to the default setup
		parent::__construct($controller_path,$web_folder,$default_controller,$default_function);
		
	}
	
	function index( $params ) {
		// no index available
		exit;
	}
	
	function twitter( $params ) {
		$this->crud( $params );
	}
	
	function read( $params ){
		
		// FIX: remove first elements (service)
		array_shift($params);
		
		$service = str_replace( array("/api/twitter/", "?". $_SERVER['QUERY_STRING']), "", $_SERVER['REQUEST_URI'] );
		
		$this->data = $this->api['twitter']->get($service, $params);
	}
	
}

?>