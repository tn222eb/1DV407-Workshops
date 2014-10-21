<?php
	namespace view;

	require_once("src/model/Boat.php");
	require_once("src/model/BoatType.php");
	require_once("src/model/BoatModel.php");
	require_once("src/model/Member.php");
	require_once("src/model/MemberRepository.php");
	require_once("src/model/MemberModel.php");
	require_once("src/model/MemberList.php");


	class ListView {
		private $boatTypeObject;

		public function __construct() {
			$this->boatTypeObject = new \model\BoatType();
		}

		public function doShowCompactList(\model\MemberList $memberList) {

			$ret = "
			<a href='?' name='returnPage'>Go to menu</a>
			<h1>CompactList</h1>";
			$ret .= "<ol>";
			foreach ($memberList->getMemberList() as $member) {
				$ret .= "<li>
				Name: " . $member->getMemberName() . "</br> MemberId: " .  $member->getUniqueId() . "</br> Boats: " . $member->countBoat() . "
				</br>
				</br>
				</<li>";
			}
			$ret .= "</ol>";
			return $ret;
		}

		public function doShowCompleteList(\model\MemberList $memberList) {
			$boatTypes = $this->boatTypeObject->getAllBoatType();

			$ret = "
			<a href='?' name='returnPage'>Go to menu</a>
			<h1>CompleteList</h1>";
			$ret .= "<ol>";
			foreach ($memberList->getMemberList() as $member) {
				$boatList = $member->getBoatList();
				$boats = $boatList->getBoats();

				$ret .= "<li>Name: " . $member->getMemberName() . "</br> SocialNumber: " .  $member->getMemberSocialNumber() . "</br> MemberId: " . $member->getUniqueId() . "</br><h4>Boats:</h4>";

				foreach ($boats as $boat) {
					$ret .= "
					BoatId: " . $boat->getBoatUniqueId() . " </br>
					BoatLength: " . $boat->getBoatLength() . " </br> BoatType: " . $boatTypes[$boat->getBoatType()] . "
					</br>
					</br>
					</<li>";
				}
			}
			$ret .= "</ol>";
			return $ret;
		}	


		public function hasChosenShowCompactList() {
			if (isset($_GET['showCompactList'])) {
				return true;
			}
			return false;
		}

		public function hasChosenShowCompleteList() {
			if (isset($_GET['showCompleteList'])) {
				return true;
			}
			return false;
		}

	}