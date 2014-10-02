<?php

namespace view;

require_once("src/model/Member.php");
require_once("src/model/Boat.php");

class MemberView {

	private $name = "name";
	private $socialNumber = "socialNumber";
	private $submit = "submit";
	private $member;

	public function display() {
		if ($this->hasSubmit()) {
			$this->member = new \model\Member($this->getName(), $this->getSocialNumber());
		}
			return $this->showRegisterMemberForm();
	}
	
	public function showRegisterMemberForm() {
		return $html = "
		<form action='' method='post'>
		<fieldset>
		<legend>Register a member</legend>
		Enter your name:
		<input type='text' name='$this->name'>

		<br>

		Enter your socialnumber:
		<input type='text' name='$this->socialNumber'>
		<br>
		<input type='submit' name='$this->submit'>
		</fieldset>
		</form>
		";
	}

	public function getName() {
		if (isset($_POST[$this->name])) {
			return $_POST[$this->name];
		}
	}

	public function getSocialNumber() {
		if (isset($_POST[$this->socialNumber])) {
			return $_POST[$this->socialNumber];
		}
	}

	public function hasSubmit() {
		if (isset($_POST[$this->submit])) {
			return $_POST[$this->submit];
		}		
	}

}