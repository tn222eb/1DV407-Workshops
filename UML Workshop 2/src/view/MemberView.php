<?php

namespace view;

require_once("src/model/Member.php");
require_once("src/model/Boat.php");
require_once("src/model/MemberRepository.php");
require_once("src/model/MemberModel.php");
require_once("src/model/MemberList.php");
require_once("src/model/BoatType.php");
require_once("src/model/BoatModel.php");

class MemberView {

	private $name = "name";
	private $boatType = "boatType";
	private $boatLength = "boatLength";	
	private $socialNumber = "socialNumber";
	private $submitRegister = "submitRegister";
	private $submitGetMember = "submitGetMember";
	private $memberList;
	private $memberModel;
	private $memberRepository;
	private $boatModel;
	private $boatTypeObject;

	public function __construct() {
		$this->memberModel = new \model\MemberModel();
		$this->memberList = new \model\MemberList();
		$this->boatModel = new \model\BoatModel();
		$this->memberRepository = new \model\MemberRepository();
	    $this->boatTypeObject = new \model\BoatType();
	}

	public function doControll() {
		if ($this->hasChosenAddMember()) {
			return $this->doAddMember();
		}

		else if ($this->hasSubmitSaveEditBoat()) {
			$this->doSaveEditBoat();
		}

		else if ($this->hasSubmitRemoveMember()) {
			$this->doRemoveMember();
		}

		else if ($this->hasSubmitEditBoat()) {
			return $this->doEditBoat();
		}		

		else if ($this->hasRemoveBoat()) {
			$this->doRemoveBoat();
		}

		else if ($this->hasSubmitAddBoat() || $this->hasSaveBoat()) {
			if ($this->hasSaveBoat()) {
				$this->doAddBoat();
			}
			else {
				return $this->doShowAddBoat($this->memberModel->getMember($this->getSocialNumber()));
			}
		}

		else if ($this->hasSubmitSaveEdit()) {
			$this->doSaveEditMember();
		}

		else if ($this->hasSubmitEditMember()) {
			return $this->doEditMember();
		}

		else if ($this->hasChosenShowMember()) {
			return $this->doShowMember();
		}

		else if ($this->hasChosenShowCompleteList()) {
			return $this->doShowCompleteList($this->memberRepository->GetMemberList());
		}

		else if ($this->hasChosenShowCompactList()) {
			return $this->doShowCompactList($this->memberRepository->GetMemberList());
		}

		else {
			return $this->showMenu();
		}	
	}

	public function showMenu() {
		return $html = "<a href='?addMember' name='addMember'>Add Member</a>
		</br>
		<a href='?showMember' name='showMember'>Show Member</a>
		</br>
		<a href='?showCompactList' name='showCompactList'>Show CompactList</a>
		</br>
		<a href='?showCompleteList' name='showCompleteList'>Show CompleteList</a>
		";
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

	public function hasChosenAddMember() {
		if (isset($_GET['addMember'])) {
			return true;
		}
		return false;
	}

 
	public function hasChosenShowMember() {
		if (isset($_GET['showMember'])) {
			return true;
		}
		return false;
	}

	public function hasSubmitRemoveMember() {
		if (isset($_POST['removeMember'])) {
			return true;
		}
		return false;
	}

	public function hasSubmitEditMember() {
		if (isset($_POST['editMember'])) {
			return true;
		}
		return false;
	}

	public function hasSubmitEditBoat() {
		if (isset($_POST['editBoat'])) {
			return true;
		}
		return false;
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

	public function doAddMember() {
		if ($this->hasSubmitRegisterForm()) {
			$member = new \model\Member($this->getName(), $this->getSocialNumber());
			$this->memberModel->addMember($member);
		}
			return $this->showForm();
	}

	public function doRemoveMember() {
		$member = $this->memberModel->getMember($this->getSocialNumber());
		$this->memberModel->removeMember($member);

		header("Location: ");
	}

	public function doSaveEditMember() {
		$member = new \model\Member($this->getName(), $this->getSocialNumber(), $this->getUniqueMemberId());
		$this->memberModel->saveEditMember($member);

		header("Location: ");
	}

	public function doEditBoat() {
		$boat = $this->boatModel->getBoat($this->getHiddenBoatId());

		return $this->doShowEditBoat($boat);
	}
	public function doEditMember() {
		$member = $this->memberModel->getMember($this->getSocialNumber());

		return $this->doShowEditMember($member);
	}

	public function doShowEditMember($member) {
		return $html = "
		<a href='?showMember' name='returnToPage'>Go back</a>
		</br>
		</br>
		<form action='' method='post'>
		<h1>Edit ". $member->getMemberName() . "</h1>
		Name:
		<input type='text' name='$this->name' value='". $member->getMemberName() ."'>
		SocialNumber:
		<input type='text' name='$this->socialNumber' value='". $member->getMemberSocialNumber() ."'>
		<input type='hidden' name='uniqueMemberId' value='" . $member->getUniqueId() ."' />
		<input type='submit' name='saveEdit' value='Save'>
		";
	}

	public function doShowMember() {
		if ($this->hasSubmitGetMember()) {
			$member = $this->memberModel->getMember($this->getSocialNumber());
			$boatTypes = $this->boatTypeObject->getAllBoatType();
			$foo = "";

			if ($member != NULL) {
				$boatList = $member->getBoatList();
				$boats = $boatList->getBoats();

			foreach ($boats as $boat) {
				$foo .= "
				BoatId: " . $boat->getBoatUniqueId() . " </br>
				BoatLength: " . $boat->getBoatLength() . " </br> BoatType: " . $boatTypes[$boat->getBoatType()] . "
				</br>
				</br>
				<form action='' method='post'>
				<input type='hidden' name='hiddenBoatId' value='" . $boat->getBoatUniqueId() . "' />
				<input type='submit' name='removeBoat' value='Remove boat'>
				<input type='submit' name='editBoat' value='Edit boat'> </br> </br>
				</form>
				";
			}

				$html = "
				<form action='' method='post'>
				<a href='?showMember' name='returnToPage'>Go back</a>
				</br>
				</br>
				Name: " . $member->getMemberName() .  "</br> SocialNumber: " . $member->getMemberSocialNumber() . " </br> MemberId: " . $member->getUniqueId() . " 
				</br>
				</br>
				<input type='hidden' name='$this->socialNumber' value='" . $member->getMemberSocialNumber() ."' />
				<input type='submit' name='removeMember' value='Remove " . $member->getMemberName() . "'>
				<input type='submit' name='editMember' value='Edit " . $member->getMemberName() . "'>
				<input type='submit' name='addBoat' value='Add Boat'>

				</br>
				</br>
				<h2>Boats</h2>
				$foo
				</form>
				";

				return $html;
			}
		}	
		return $this->showGetMemberForm();
	}

	public function getHiddenBoatId() {
		return $_POST['hiddenBoatId'];
	}

	public function hasSubmitAddBoat() {
		if (isset($_POST['addBoat'])) {
			return true;
		}
		return false;
	}

	public function hasSubmitGetMember() {
		if (isset($_POST[$this->submitGetMember])) {
			return true;
		}
		return false;
	}

	public function showGetMemberForm() {
		return $html = "
		<a href='?' name='returnToPage'>Go to menu</a>
		</br>
		</br>
		<form action='' method='post'>
		<fieldset>
		<legend>Show a member to edit</legend>
		Enter socialnumber:
		<input type='text' name='$this->socialNumber'>

		<input type='submit' name='$this->submitGetMember' value='Submit'>
		</fieldset>
		</form>		
		";
	}

	public function showForm() {
		return $html = "
		<a href='?' name='returnPage'>Go to menu</a>
		</br>
		</br>
		<form action='' method='post'>
		<fieldset>
		<legend>Register a member</legend>
		Enter your name:
		<input type='text' name='$this->name'>

		<br>

		Enter your socialnumber:
		<input type='text' name='$this->socialNumber'>
		<br>
		<input type='submit' name='$this->submitRegister' value='Submit'>
		</fieldset>
		</form>
		";
	}

	public function getName() {
		if (isset($_POST[$this->name])) {
			return $_POST[$this->name];
		}
	}

	public function getSocialNumber() {
		if (isset($_POST[$this->socialNumber])) {
			return $_POST[$this->socialNumber];
		}
	}

	public function hasSubmitRegisterForm() {
		if (isset($_POST[$this->submitRegister])) {
			return $_POST[$this->submitRegister];
		}		
	}

	public function hasSubmitSaveEdit() {
		if (isset($_POST['saveEdit'])) {
			return true;
		}
		return false;
	}

	public function getUniqueMemberId() {
		return $_POST['uniqueMemberId'];
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

	public function doAddBoat() {
			$boat = new \model\Boat($this->getBoatLength(), $this->getBoatType());
			$boat->setMember($this->memberModel->getMember($this->getSocialNumber()));
			$member = $boat->getMember();

			$this->boatModel->addBoat($boat);
			header("Location: ");
	}

	public function doRemoveBoat() {
		$boat = $this->boatModel->getBoat($this->getHiddenBoatId());
		$this->boatModel->removeBoat($boat);

		header("Location: ");
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

	public function hasSubmitSaveEditBoat() {
		if (isset($_POST['saveEditBoat'])) {
			return true;
		}
		return false;
	}

	public function doSaveEditBoat() {
		$boat = new \model\Boat($this->getBoatLength(), $this->getBoatType(), $this->getHiddenBoatId());
		$this->boatModel->saveEditBoat($boat);

		header("Location: ");
	}	
}
