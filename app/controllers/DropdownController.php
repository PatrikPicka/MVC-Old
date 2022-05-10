<?php 

class DropdownController extends Controller {

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
	}

	public function indexAction(){
		$this->view->render('dropdown/index');
	}
	public function firstAction(){
		$this->view->render('dropdown/first');
	}
	public function secondAction(){
		$this->view->render('dropdown/second');
	}
	public function thirdAction(){
		$this->view->render('dropdown/third');
	}
}
