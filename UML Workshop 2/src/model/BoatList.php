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
		if (!$this->exists($boat)) {
			$this->boats[] = $boat;
		}
	}

	public function exists(\model\Boat $boat) {
		foreach($this->boats as $key => $value) {
			if ($boat->exists($value)) {
				return true;
			}
		}
		return false;
	}
}