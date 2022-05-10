<?php 


class RegisterController extends Controller{
	public function __construct($controller, $action){
		parent::__construct($controller, $action);
		$this->load_model('Users');
		$this->view->setLayout('default');
	}

	public function loginAction(){
		if ($_POST) {
			$validate = new Validate();
			$validation = $validate->check($_POST, [
				'username' => [
					'name' => 'Přihlašovací jméno',
					'required' => true,
				],
				'password' =>[
					'name' => 'Heslo',
					'required' => true
				]
			]);
			if ($validation->passed()) {

				$user = $this->UsersModel->find(Input::get('username'));
				if ($user) {

					$remember = (isset($_POST['remember_me']) && Input::get('remember_me'))? true : false;
					$this->UsersModel->login($remember, Input::get('username'), Input::get('password'));
					Router::redirect('');

				}
			}
		}
		$this->view->render('register/login');
	}

	public function logoutAction(){
		if ($this->UsersModel->isLoggedIn()) {
			$this->UsersModel->logout();
		}	
		Router::redirect('');
	}

	public function registerAction(){

		$validation = new Validate();
		$posted_values = ['fname'=>'', 'lname'=>'', 'email'=>'', 'username' => '' ];
		if ($_POST) {
			$posted_values = posted_values($_POST);
			
			$validation->check($_POST, [
				'fname' => [
					'name' => 'Jméno',
					'requred' => true
				],
				'lname' => [
					'name' =>'Příjmení',
					'requred' => true
				],
				'email' => [
					'name' => 'E-mail',
					'requred' => true
				],
				'username' => [
					'name' => 'Přihlašovací jméno',
					'requred' => true
				],
				'password' => [
					'name' => 'Heslo',
					'requred' => true
				],
				'confirm' => [
					'name' => 'Heslo znovu',
					'requred' => true
				]
			]);
			if ($validation->passed()) {
				$newUser = new Users();
				$password = passwordHash($posted_values['password']);
				$this->UsersModel->create('username, email, password, fname, lname',
				[$posted_values['username'],
				$posted_values['email'],
				$password,
				$posted_values['fname'],
				$posted_values['lname']]);
				$this->UsersModel->login(false, $posted_values['username'], $posted_values['password']);
				Router::redirect('');
			}

		}

		$this->view->post = $posted_values;
		$this->view->render('register/register');
	}
}