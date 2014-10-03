<?php

namespace model;

class Member {
	private $name;
	private $socialNumber;
	private $uniqueMemberId;
	private $boats = array();

	public function __construct($nameInput, $socialNumberInput) {
		$this->name = $nameInput;
		$this->socialNumber = $socialNumberInput;
		$this->uniqueMemberId = $this->uniqueId();

	}

	public function uniqueId() {
		return uniqid();		
	}

	public function getMemberName() {
		return $this->name;
	} 

	public function getMemberSocialNumber() {
		return $this->socialNumber;
	}

	public function getUniqueId() {
		return $this->uniqueMemberId;
	}
}