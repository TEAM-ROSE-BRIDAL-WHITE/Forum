<?php
/*
 * 
 */

/**
 * 
 * @author Team-Mnementh
 *
 */
class View {
	
	
	private static $_viewDir = "views";	
	private static $_path = null;
	
	public function __get($property) { }
	public function __set($property, $value) {}
	
	/**
	 * @return string path to the view direcctory
	 */
	public static function getPath() {
		if (self::$_path==null) {
			new View();
		}		
		return self::$_path;
	}
	
	public function __construct() {
		if (self::$_path==null) {
			self::$_path = dirname(__DIR__).DIRECTORY_SEPARATOR.self::$_viewDir;
		}
	}
	
	public function display ($page, $data=false) {	
		if (!$page) {
			return null;
		}	
		
		if (is_dir(self::$_path) && is_readable(self::$_path)) {
			$path = self::$_path;
			$page = realpath($path.DIRECTORY_SEPARATOR.$page);
		} else {
			throw new Exception('Unknown directory path');
		}

		$page = $page;

		include $page;
	}
}