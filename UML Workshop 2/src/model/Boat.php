<?php

namespace model;

class Boat {
	private $boatLength;
	private $uniqueBoatId;
	private $boatType;
	private $member;

	public function __construct($boatLength, $boatType , $uniqueBoatId = NULL) {

		$this->boatLength = $boatLength;
		$this->boatType = $boatType;

		if (empty($uniqueBoatId)) {
			$this->uniqueBoatId = $this->uniqueId();	
		}
		else {
			$this->uniqueBoatId = $uniqueBoatId;
		}
	}

	public function uniqueId() {
		return uniqid();
	}

	public function getBoatLength() {
		return $this->boatLength;
	}

	public function getBoatUniqueId() {
		return $this->uniqueBoatId;
	}

	public function setMember(\model\Member $member) {
		$this->member = $member;
	}

	public function getMember() {
		return $this->member;
	}

	public function getBoatType() {
		return $this->boatType;
	}
}