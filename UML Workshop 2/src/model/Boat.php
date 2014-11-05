<?php

namespace model;

class Boat {
	private $boatLength;
	private $uniqueBoatId;
	private $boatType;
	private $uniqueMemberId;

	public function __construct($boatLength, $boatType, $uniqueMemberId , $uniqueBoatId = NULL) {

		$this->boatLength = $boatLength;
		$this->boatType = $boatType;
		$this->uniqueMemberId = $uniqueMemberId;

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

	public function getUniqueMemberId() {
		return $this->uniqueMemberId;
	}

	public function getBoatType() {
		return $this->boatType;
	}
}