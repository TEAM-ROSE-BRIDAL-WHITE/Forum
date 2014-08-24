<?php
include 'config.php';
include 'dispatcher.php';
include 'router.php';
include 'view.php';

/**
 *
 * @author Team-Mnementh
 *
 */
class Fc {
	
	function run () {		
		$router = Router::getInstance();
		$dispatch = new Dispatcher($router);
		
		$this->display($dispatch);
	}
	
	
	private function display($dispatch) {
		$header = $dispatch->getPageContainer("header");
		$content = $dispatch->getPageContainer("content");
		$footer = $dispatch->getPageContainer("footer");

		//display page
		$view = new View();
		if ($header) {
			$view->display($header['page'], $header['params']);
		}
		if ($content) {
			$view->display($content['page'], $content['params']);
		}
		if ($footer) {
			$view->display($footer['page'], $footer['params']);
		}		
	}
	
}