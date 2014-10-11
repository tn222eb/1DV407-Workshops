<?php

namespace model;

class BoatType {

	private $boatType = array("Segelbåt", "Motorseglare", "Motorbåt", "Kanot", "Kajak", "Övrigt");

	public function getAllBoatType() {
		return $this->boatType;
	}
}