<?php 

class HomeController extends Controller {

	public $user = [];

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
		$this->load_model('Users');
		if (Session::exists(USER_SESSION_NAME)) {
			$this->user = $this->UsersModel->findData(Session::get(USER_SESSION_NAME));
		}
		
	}

	public function indexAction(){
		
		$this->view->render('home/index');
	}


}