<?php 
class Users extends Model{
	private	$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;

	public function __construct($user = null) {
		$table = 'users';
		parent::__construct($table);
		$this->_sessionName = USER_SESSION_NAME;
		$this->_cookieName = COOKIE_NAME;
		$this->_sofDelete = true;

		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				
				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				}else {
					$this->logout();
				}
			}
		} 
		else {
			$this->find($user);
		}
	}

	public function create($fields, $values =[]){
		if(!$this->insert($fields, $values)){
			throw new Exception('There was a problem creating an account.');
		}
	}

	public function findData($user = null){
		if ($user) {  
			$field = (is_numeric($user)) ? 'id' : 'username';

			$data = $this->findFirst(['conditions' => $field.' = ?', 'bind' => [$user]]);
			if ($this->_db->count()) {
				$this->_data = $data;
				return $this->_data;
			}
		}return false;
	}

	public function find($user = null){
		if ($user) {   
			$field = (is_numeric($user)) ? 'id' : 'username';

			$data = $this->findFirst(['conditions' => $field.' = ?', 'bind' => [$user]]);
			if ($this->_db->count()) {
				$this->_data = $data;
				return true;
			}
		}return false;
	}

	public static function curretUserLoggedIn(){
		if (Session::exists(USER_SESSION_NAME)) {
			$user = new Users(Session::get(USER_SESSION_NAME));
			return $user->findData(Session::get(USER_SESSION_NAME));
		}
		
	}

	public function login($rememberMe = false, $username , $password){
		$user = $this->find($username);
		if ($user) {
			//echo $this->data()->password, '<br>';
			//echo password_verify($password, $this->data()->password);
			if ($password == 'cookielogin') {
				Session::set($this->_sessionName, $this->data()->id);
			}
			if (password_verify($password, $this->data()->password)) {
				Session::set($this->_sessionName, $this->data()->id);
				if ($rememberMe) {
					$hash = md5(uniqid(rand(), true));
					$user_agent = Session::uagent_no_version();
					Cookie::set($this->_cookieName, $hash, COOKIE_EXPIRY);
					$this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->data()->id, $user_agent]);
					$this->_db->insert('user_sessions', 'session, user_agent, user_id', [$hash, $user_agent, $this->data()->id]);
				}
				return true;
			}
		}
		return false;
	}
	

	public static function acls($id){
		$user = new Users();
		$data = $user->findData($id);
		if (empty($data->acl)) {
			return [];
		}else{
			return json_decode($data->acl, true);
		}
	}

	public function logout(){
		if (Session::exists(USER_SESSION_NAME)) {
			$user = Session::get(USER_SESSION_NAME);
			Session::delete($this->_sessionName);
		}

		if (Cookie::exists(COOKIE_NAME)) {
			Cookie::delete(COOKIE_NAME);
		}
		$this->_db->query("DELETE FROM user_sessions WHERE user_id = ?", [$user]);
	}

	public static function loginFromCookie(){
		$user_session_model = new UserSessions();
		$user_session = $user_session_model->findFirst([
			'conditions' => "user_agent = ? AND session = ?",
			'bind' => [Session::uagent_no_version(), Cookie::get(COOKIE_NAME)]
		]);
		if ($user_session->user_id != '') {
			$user = new self($user_session->user_id);

		}
		$user->login(false, $user->data()->id, 'cookielogin');//dnd($user->data());
		return $user->data();
	}

	public function data(){
		return $this->_data;
	}
	public static function isLoggedIn(){
		if (Session::exists(USER_SESSION_NAME)) {
			return true;
		}
		return false;
	}
} 
