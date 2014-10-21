<?php
	namespace view;

	require_once("src/model/Boat.php");
	require_once("src/model/BoatType.php");
	require_once("src/model/BoatModel.php");
	require_once("src/model/MemberModel.php");

	class BoatView {
		private $boatType = "boatType";
		private $boatLength = "boatLength";
		private $boatModel;
		private $boatTypeObject;
		private $socialNumber = "socialNumber";
		private $memberModel;

		public function __construct() {
			$this->boatModel = new \model\BoatModel();
			$this->boatTypeObject = new \model\BoatType();
			$this->memberModel = new \model\MemberModel();
		}


		public function doShowAddBoat(\model\Member $member) {
		
			$boatTypes = $this->boatTypeObject->getAllBoatType();
			$boatTypeLocation = "";
			foreach ($boatTypes as $key =>$boatType) {
				$boatTypeLocation .= "<input type='radio' name='boatType' value='$key'> <label for='boatType'>$boatType</label>";
			}

			return $html = "
			<a href='?showMember' name='returnToPage'>Go back</a>
			</br>
			</br>
			<form action='' method='post'>
			<input type='hidden' name='$this->socialNumber' value='" . $member->getMemberSocialNumber() . "'>
			<h1>Add Boat for " . $member->getMemberName() . "</h1>
			Boat Type:
			</br>
			$boatTypeLocation
			</br>
			</br>
			Boat Length:
			</br>
			<input type='text' name='" . $this->boatLength . "'>
			</br>
			</br>
			<input type='submit' name='saveBoat' value='Add Boat'>
			</form>
			";
		}	

		public function getSocialNumber() {
			if (isset($_POST[$this->socialNumber])) {
				return $_POST[$this->socialNumber];
			}
		}

		public function doSaveEditBoat() {
			$boat = new \model\Boat($this->getBoatLength(), $this->getBoatType(), $this->getHiddenBoatId());
			$this->boatModel->saveEditBoat($boat);

			header("Location:" .$_SERVER['PHP_SELF']);
		}	
		
		public function doAddBoat() {
				$boat = new \model\Boat($this->getBoatLength(), $this->getBoatType());
				$boat->setMember($this->memberModel->getMember($this->getSocialNumber()));
				$member = $boat->getMember();

				$this->boatModel->addBoat($boat);
				header("Location:" .$_SERVER['PHP_SELF']);
		}

		public function doRemoveBoat() {
			$boat = $this->boatModel->getBoat($this->getHiddenBoatId());
			$this->boatModel->removeBoat($boat);

			header("Location:" .$_SERVER['PHP_SELF']);
		}

		public function doShowEditBoat($boat) {
			$boatTypes = $this->boatTypeObject->getAllBoatType();
			$boatTypeLocation = "";
			foreach ($boatTypes as $key =>$boatType) {
				if ($boat->getBoatType() == $key) {
					$boatTypeLocation .= "<input type='radio' name='$this->boatType' value='$key' checked> <label for='boatType'>$boatType</label>";				
				}
				else {
					$boatTypeLocation .= "<input type='radio' name='$this->boatType' value='$key'> <label for='boatType'>$boatType</label>";
				}
			}

			return $html = "
			<form action ='' method='post'>
			<a href='?showMember' name='returnToPage'>Go back</a>
			</br>
			</br>
			<form action='' method='post'>
			<h1>Edit Boat</h1>
			BoatType:
			</br>
			$boatTypeLocation
			</br>
			</br>

			BoatLength:
			<input type='text' name='$this->boatLength' value='". $boat->getBoatLength() ."'>
			<input type='hidden' name='hiddenBoatId' value='" . $boat->getBoatUniqueId() . "' />
			<input type='submit' name='saveEditBoat' value='Save'>
			</form>
			";
		}

		public function doEditBoat() {
			$boat = $this->boatModel->getBoat($this->getHiddenBoatId());

			return $this->doShowEditBoat($boat);
		}

		public function getHiddenBoatId() {
			return $_POST['hiddenBoatId'];
		}

		public function getBoatLength() {
			if(isset($_POST[$this->boatLength])) {
				return $_POST[$this->boatLength];
			}
		}


		public function getBoatType() {
			if(isset($_POST['boatType'])) {
				return $_POST['boatType'];
			}
		}

		public function hasSubmitEditBoat() {
			if (isset($_POST['editBoat'])) {
				return true;
			}
			return false;
		}	


		public function hasSubmitAddBoat() {
			if (isset($_POST['addBoat'])) {
				return true;
			}
			return false;
		}


		public function hasSaveBoat() {
			if (isset($_POST['saveBoat'])) {
				return true;
			}
			return false;
		}


		public function hasRemoveBoat() {
			if (isset($_POST['removeBoat'])) {
				return true;
			}
			return false;
		}	


		public function hasSubmitSaveEditBoat() {
			if (isset($_POST['saveEditBoat'])) {
				return true;
			}
			return false;
		}





	}