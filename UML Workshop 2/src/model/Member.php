<?php

namespace model;

require_once("src/model/BoatList.php");

class Member {
	private $name;
	private $socialNumber;
	private $uniqueMemberId;
	private $boats;

	public function __construct($nameInput, $socialNumberInput, $uniqueMemberId = NULL) {

		$this->name = $nameInput;
		$this->socialNumber = $socialNumberInput;

		if (empty($uniqueMemberId)) {
			$this->uniqueMemberId = $this->uniqueId();	
		}
		else {
			$this->uniqueMemberId = $uniqueMemberId;
		}

		$this->boats = new \model\BoatList();
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

	public function add(\model\Boat $boat) {
		$this->boats->add($boat);
	}

	public function getBoatList() {
		return $this->boats;
	}

	public function countBoat() {
		return count($this->boats->getBoats());
	}
}