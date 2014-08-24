<?php
class Config {
	private static $_instance=null;
	
	private function __construct() {
		
	}
	
	public function getInstance() {
		if (self::$_instance==null) {
			self::$_instance = new Config();
		}
		return self::$_instance;
	}
}