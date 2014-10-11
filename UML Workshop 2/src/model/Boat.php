<?php

namespace model;

class Boat {
	private $boatLength;
	private $uniqueBoatId;
	private $boatType;
	private $member;

	public function equals(\model\Boat $other) {
		return ($this->getName() == $other->getName() && $this->getUnique() == $this->getUnique());
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