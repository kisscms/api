<?php 
// Remote API for KISSCMS
// Location: APP/helpers/

if (!class_exists('Remote_API')) {

class Remote_API {
	
	private $cache;
	
	function getCache( $request=false, $params=array(), $offset=0 ){
		
		// variables
		$api = $this->api;
		$key = $this->getCacheKey( $request, $params );
		
		// set up the parent container, the first time
		if( !array_key_exists($api, $_SESSION) ) $_SESSION[$api]= array();
		
		
		// lookup the relevant data, if available
		if( !empty($key) ){
			
			$cache = ( !empty($_SESSION[$api][$key]) ) ? $_SESSION[$api][$key] : array();
			
		} else {
			
			$cache = $_SESSION[$api];
		} 


		// optionally add checkCache
		
		// offset the array
		if( $offset ){ 
			$cache = array_slice($cache, $offset);
		}
		
		return $cache; 
		
	}
	
	// save the data in the session
	function setCache( $request="", $params=array(), $data=NULL, $id=false ){
		
		// variables
		$api = $this->api;
		$key = $this->getCacheKey( $request, $params );
		
		// FIX: data is returned as a JSON object - need to convert it to PHP array with keys as the ids of the posts
		$data = (array) $data;
		
		// FIX: create the session container if not available
		if( empty($_SESSION[ $api][$key]) ) $_SESSION[$api][$key] = array();
		
		if( $id ){
			// we need to dig into each item to get the id 
			$cursor = explode('->', $id);
			
			foreach( $data as $k => $item ){
				
				// might be a better way of doing this...
				$id = $item;
				foreach($cursor as $i){
					$id = $id->{$i};
				} 
				// change the keys to the ids of the posts
				$_SESSION[$api][$key][$id] = $item;
			}
		} else {
			// we have a container to put the data
			$_SESSION[$api][$key] = $data;
		}
		
		//timestamp session data
		$_SESSION['timestamp'][$api][$key] = time();
		
		// update the local variable
		//$this->cache = $_SESSION[$api][$key];
	}
	
	function deleteCache( $key=false ){
		if( $key ){ 
			unset($_SESSION[$this->api][$key]);
		} else {
			unset($_SESSION[$this->api]);
		}
	}
	
	// invalidate the data every few minutes
	function checkCache( $request, $params=array() ){
		//variables
		$valid = false;
		$api = $this->api;
		$key = $this->getCacheKey( $request, $params );
		
		// always discard cache on debug mode
		//if( DEBUG ) return false; 
		$cache = 		( !empty($_SESSION[$api][$key]) ) 				? $_SESSION[$api][$key] : false;
		$timestamp = 	( !empty($_SESSION['timestamp'][$api][$key]) ) 	? $_SESSION['timestamp'][$api][$key] : false;
		
		
		// timeout varies from 4-5 minutes
		$timeout = 240 + round( rand(0, 60) ); 
		
		if( $cache && $timestamp && time()-$timestamp < $timeout) {
			// check the date 
			$valid = true;
		}
		
		return ( $valid ) ? true : false;
	}
	
	function getCacheKey( $request, $params ){
		$hash = ( !empty( $params ) ) ? $this->hashRequest( $params ) : false;
		$key = ( $hash ) ? $request ."|". $hash : $request;
		return $key;
	}
	
	function hashRequest( $params ){
		
		return base_convert( hash("md5",  http_build_query( $params )  ), 16, 10);
		
	}
	
	
}

}
?>