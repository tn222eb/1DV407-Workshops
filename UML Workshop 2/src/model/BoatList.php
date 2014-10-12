<?php

namespace model;

require_once("src/model/Boat.php");

class BoatList {
	private $boats;

	public function __construct(){
		$this->boats = array();
	}

	public function getBoats() {
		return $this->boats;
	}

	public function add(\model\Boat $boat) {
			$this->boats[] = $boat;
	}
}