<?php 
/*
*************************Základní Validator be sessionflash***********************
class Validate{
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				
				$value = trim($source[$item]);
				$item = escape($item);
				if ($rule === "required" && empty($value)) {
					$this->addError("{$item} is Required!");

				}else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be a minimum of {$rule_value} characters!");
							}
							break;
						
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} must be a maximum of {$rule_value} characters!");
							}
							break;

						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item}");
							}
							break;

						case 'unique':
							$check =  $this->_db->get($rule_value, array('username', '=', $value ));
							if ($check->count()) {
								$this->addError("{$item} already exists."); 
							}
							break;
					}
				}
			}
		}
		if (empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}

	private function addError($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}

}
*/
class Validate{
	private $_passed = false, $_errors = array(), $_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()){
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				
				$value = trim($source[$item]); 
				$item = escape($item);
				if ($rule === 'required' && empty($value)) {
					$this->addError("<div class='p-1 bg-danger text-white' id='error_msg'><b>{$rules['name']} je potřeba vyplnit!</b></div>"); 

					if ($rules['name'] == 'E-mail') {
						Session::flash('reg_email', '&nbsp;*E-mailová adresa musí být vyplněna');
					}

					if ($rules['name'] == 'Username') {
						Session::flash('reg_username', '&nbsp;*Username (uživatelské jméno) musí být vyplněno');
					}
					if ($rules['name'] == 'Jméno') {
						Session::flash('reg_name', '&nbsp;*Jméno musí být vyplněno');
					}if ($rules['name'] == 'Příjmení') {
						Session::flash('reg_surname', '&nbsp;*Příjmení musí být vyplněno');
					}
					if ($rules['name'] == 'Heslo') {
						Session::flash('reg_pass', '&nbsp;*Heslo musí být vyplněno');
					}
					if ($rules['name'] == 'Heslo znovu') {
						Session::flash('reg_pass_a', '&nbsp;*Heslo znovu musí být vyplněno');
					}
					if ($rules['name'] == 'Město') {
						Session::flash('reg_ad1', '&nbsp;*Město musí být vyplněno');
					}
					if ($rules['name'] == 'Ulice a číslo popisné') {
						Session::flash('reg_ad2', '&nbsp;*Ulice a číslo popisné musí být vyplněny');
					}
					if ($rules['name'] == 'PSČ') {
						Session::flash('reg_zip', '&nbsp;*PSČ musí být vyplněno');
					}
					if ($rules['name'] == 'Přihlašovací jméno') {
						Session::flash('log_username', '&nbsp;*Přihlašovací jméno a heslo musí být vyplněno');
					}
				
				}else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if (strlen($value) < $rule_value) {
								if ($rule_value < 5) {
									$this->addError("<div class='p-1 bg-danger text-white' id='error_msg'><b>{$rules['name']} musí mít nejméně {$rule_value} písmena!</b></div>");


									if ($rules['name'] == 'Username') {
										Session::flash('reg_username', '&nbsp;*Username (uživatelské jméno) musí mít nejméně 2 písmena');
									}
									if ($rules['name'] == 'Jméno') {
										Session::flash('reg_name', '&nbsp;*Jméno musí mít nejméně 2 písmena');
									}
									if ($rules['name'] == 'Příjmení') {
										Session::flash('reg_surname', '&nbsp;*Příjmení musí mít minimálně 2 písmena');
									}
								}else {
									$this->addError("<div class='p-1 bg-danger text-white' id='error_msg'><b>{$rules['name']} musí mít nejméně {$rule_value} písmen!</b></div>");
									if ($rules['name'] == 'Heslo') {
										Session::flash('reg_pass', '&nbsp;*Heslo musí mít nejméně 6 písmen');
									}
								}
								
							}
						break;
						case 'max':
							if (strlen($value) > $rule_value) {
								if ($rule_value < 5) {
									$this->addError("<div class='p-1 bg-danger text-white' id='error_msg'><b>{$rules['name']} musí mít maximálně {$rule_value} písmena!</b></div>");
								}else {
									$this->addError("<div class='p-1 bg-danger text-white' id='error_msg'><b>{$rules['name']} musí mít maximálně {$rule_value} písmen!</b></div>");


									if ($rules['name'] == 'Username') {
										Session::flash('reg_username', '&nbsp;*Username (uživatelské jméno) může mít maximálně 50 písmen');
									}
									if ($rules['name'] == 'Jméno') {
										Session::flash('reg_name', '&nbsp;*Jméno může mít maximálně 50 písmen');
									}
									if ($rules['name'] == 'Příjmení') {
										Session::flash('reg_surname', '&nbsp;*Příjmení může mít maximálně 50 písmen');
									}
									if ($rules['name'] == 'PSČ') {
										Session::flash('reg_zip', '*PSČ může mit max 6 písmen');
									}
								}

							}
						break;
						case 'pwd_matches':
							if ($value != $source[$rule_value]) {
								$this->addError("<div class='p-1 bg-danger text-white' id='error_msg'><b>Hesla se musí shodovat!</b></div>");
								if ($rules['name'] == 'Heslo znovu') {
									Session::flash('reg_pass_a', '&nbsp;*Hesla se musí shodovat');
								}
							}
						break;
						case 'unique':
							$check =  $this->_db->get($rule_value, array($rules['db_field_name'], '=', $value ));
							if ($check->count()) {
								$this->addError("<div class='p-1 bg-danger text-white' id='error_msg'><b>{$rules['name']} již existuje.</b></div>"); 
								if ($rules['name'] == 'E-mail') {
									Session::flash('reg_email', '&nbsp;*Pro tuto E-mailovou adresu již účet existuje');
								}
								if ($rules['name'] == 'Username') {
										Session::flash('reg_username', '&nbsp;*Toto uživatelské jméno již někdo používá');
								}
								
							}

						break;
						case 'not_numeric':
							if (!preg_match('/[A-Za-z]/', $value)) {
								$this->addError("<div class='p-1 bg-danger text-white' id='error_msg'><b>{$rules['name']} nesmějí být pouze čísla!</b></div>"); 
								if ($rules['name'] == 'Username') {
									Session::flash('reg_username_n', '&nbsp;*Username (uživatelské jméno) nesmějí být pouze čísla');
								}
								if ($rules['name'] == 'Jméno') {
										Session::flash('reg_name_n', '&nbsp;*Jméno nesmějí být pouze čísla');
								}
								if ($rules['name'] == 'Příjmení') {
									Session::flash('reg_surname_n', '&nbsp;*Příjmení nesmějí být pouze čísla');
								}
								if ($rules['name'] == 'Město') {
									Session::flash('reg_ad1_n', '&nbsp;*Město nesmějí být pouze čísla');
								}
							}
						break;
						

					}
				}
			}
		}
		if (empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	} 

	public function addError($error){
		$this->_errors[] = $error;
	}
	public function errors(){
		return $this->_errors;
	}
	public function passed(){
		return $this->_passed;
	}

}