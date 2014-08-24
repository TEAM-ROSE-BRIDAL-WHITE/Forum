<?php
/**
 *
 * @author Team-Mnementh
 *
 */
class Dispatcher {
	private $pageContainer = array();
	
	private function setPageContainer($pageSegment, $key, $val) {
		$this->pageContainer[$pageSegment][$key] = $val;
	}
	
	public function getPageContainer($pageSegment) {	
		if (!$this->pageContainer[$pageSegment]) {
			return false;
		}
		return $this->pageContainer[$pageSegment];
	}
	
	public function __construct($router) {
		if (!$router instanceof Router) {
			return null;
		}		
		$this->dispatch($router);
	}
	
	private function dispatch($router) {
		$controller = $router->getController();
		$action = $router->getAction();
		$params = $router->getParams();
		$controller_file = "controllers/".$controller.".php";
		
		//set default content page
		if (!file_exists($controller_file)) {
			$this->_loadDefault($controller);
		}		
		//TODO
	}
	
	//TODO
	private function _loadDefault($controller="home") {
		$viewPath = View::getPath();
		$content = $controller.".php";

		if (!file_exists($viewPath.DIRECTORY_SEPARATOR.$content)) {
			$controller = "home";
			$content = $controller.".php";
		}
		$header_params = $this->getHeaderParams($controller);
		
		$this->setPageContainer("header", "page", "header.php");
		$this->setPageContainer("header", "params", $header_params);
		$this->setPageContainer("content", "page", $content);
		$this->setPageContainer("content", "params", "");
		$this->setPageContainer("footer", "page", "footer.php");
		$this->setPageContainer("footer", "params", "");
	} 
	
	//TODO
	private function getHeaderParams($controller) {
		$title = "";
		$selected = $controller;		
		switch ($controller) {
			case "tales":
				$title = "Приказки";
				break;
			case "jokes":
				$title = "Вицове";
				break;
			case "poems":
				$title = "Хумористична поезия";
				break;
                        case "quiz":
				$title = "SoftUni тест";
				break;
			case "dreamer":
				$title = "SoftUni съновник";
				break;
                        case "pictures":
				$title = "Галерия";
				break;
                        case "clips":
				$title = "Видео клипове";
				break;
                        case "lectures":
				$title = "Lekcii";
				break;       
                        default:
				$title = "Начало";
			break;
		}
		
		$result = array(
			'title'=>$title,
			'selected'=>$selected
		);
		
		return $result;		
	}
	
}