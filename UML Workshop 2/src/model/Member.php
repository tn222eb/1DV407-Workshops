<?php

namespace model;

class Member {
	private $name;
	private $socialNumber;
	private $uniqueMemberId;
	private $boats = array();

	public function __construct($nameInput, $socialNumberInput) {
		$name = $nameInput;
		$socialNumber = $socialNumberInput;
		$uniqueMemberId = uniqid();

	}
}