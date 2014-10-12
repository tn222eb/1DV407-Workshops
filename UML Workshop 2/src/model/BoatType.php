<?php

namespace model;

class BoatType {

	private $boatType = array("Sailboat", "Motorsailor", "Motorboat", "Canoe", "Kayak", "Other");

	public function getAllBoatType() {
		return $this->boatType;
	}
}