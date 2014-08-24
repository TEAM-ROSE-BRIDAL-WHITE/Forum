<?php
/*
 * 
 */

/**
 * 
 * @author Team-Mnementh
 * 
 */
class Router {
	
	private static $_instance=null;
	//the directory of index.php relative to root
	private static $_base = "su/TeamProject/";
	
	private static $_controller = 'home';
	private static $_action = "";
	private static $_params = array();
	
	
	/**
	 * 
	 * @return string controller name
	 * 
	 */
	public function getController() {
		return self::$_controller;
	}
	
	/**
	 * @return string action name
	 */
	public function getAction() {
		return self::$_action;
	}
	
	/**
	 * @return array of parameters
	 */
	public function getParams() {
		return self::$_params;
	}
	
		
	public function __set($name, $value) { }
	public function __get($name) { }

	private function __construct() {		
		self::_parseSegments();
	}
	
	public static function getInstance() {
		if (self::$_instance==null) {
			self::$_instance = new Router();
		}
		return self::$_instance;
	}
	
	private function _parseSegments() {
		//get the uri data
		if (isset($_SERVER['REQUEST_URI'])) {			
			$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/");
			if (substr($uri, 0, strlen(self::$_base)) == self::$_base) {
				$uri = substr($uri, strlen(self::$_base));
			}
		} else {
			$uri = '';
		}

		//split the uri to segments
		$segment = explode("/", $uri);
		
		if (isset($segment[0]) && $segment[0]!="") {
			self::$_controller = $segment[0];
		}
		
		if (isset($segment[1]) && $segment[1]!="") {
			self::$_action = $segment[1];
		}
		
		for ($i=2; $i<count($segment); $i++) {
			array_push(self::$_params, $segment[$i]);
		}
	}
	
}