<?php

namespace model;

require_once("src/model/BoatRepository.php");

class BoatModel {

	private $boatRepository;

	public function __construct() {
		$this->boatRepository = new \model\BoatRepository();
	}

	public function addBoat(\model\Boat $boat) {	
		$this->boatRepository->addBoat($boat);
	}

	public function removeBoat(\model\Boat $boat) {
		$this->boatRepository->removeBoat($boat);
	}

	public function saveEditBoat(\model\Boat $boat) {
		$this->boatRepository->saveEditBoat($boat);
	}

	public function getBoat($uniqueBoatId) {
		return $this->boatRepository->getBoat($uniqueBoatId);
	}
}