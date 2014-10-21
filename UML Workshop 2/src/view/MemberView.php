<?php

namespace view;

require_once("src/model/Member.php");
require_once("src/model/MemberRepository.php");
require_once("src/model/MemberModel.php");
require_once("src/model/MemberList.php");
require_once("src/view/BoatView.php");
require_once("src/view/ListView.php");
require_once("src/model/BoatType.php");

class MemberView {

	private $name = "name";
	private $socialNumber = "socialNumber";
	private $submitRegister = "submitRegister";
	private $submitGetMember = "submitGetMember";
	private $memberList;
	private $memberModel;
	private $memberRepository;
	private $boatView;
	private $listView;
	private $boatTypeObject;

	public function __construct() {
		$this->memberModel = new \model\MemberModel();
		$this->memberList = new \model\MemberList();
		$this->memberRepository = new \model\MemberRepository();
	    $this->boatView = new\view\BoatView();
	    $this->listView = new \view\ListView();
	    $this->boatTypeObject = new \model\BoatType();
	}

	public function doControll() {
		if ($this->hasChosenAddMember()) {
			return $this->doAddMember();
		}

		else if ($this->boatView->hasSubmitSaveEditBoat()) {
			$this->boatView->doSaveEditBoat();
		}

		else if ($this->hasSubmitRemoveMember()) {
			$this->doRemoveMember();
		}

		else if ($this->boatView->hasSubmitEditBoat()) {
			return $this->boatView->doEditBoat();
		}		

		else if ($this->boatView->hasRemoveBoat()) {
			$this->boatView->doRemoveBoat();
		}

		else if ($this->boatView->hasSubmitAddBoat() || $this->boatView->hasSaveBoat()) {
			if ($this->boatView->hasSaveBoat()) {
				$this->boatView->doAddBoat();
			}
			else {
				return $this->boatView->doShowAddBoat($this->memberModel->getMember($this->getSocialNumber()));
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

		else if ($this->listView->hasChosenShowCompleteList()) {
			return $this->listView->doShowCompleteList($this->memberRepository->GetMemberList());
		}

		else if ($this->listView->hasChosenShowCompactList()) {
			return $this->listView->doShowCompactList($this->memberRepository->GetMemberList());
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

		header("Location:" .$_SERVER['PHP_SELF']);
	}

	public function doSaveEditMember() {
		$member = new \model\Member($this->getName(), $this->getSocialNumber(), $this->getUniqueMemberId());
		$this->memberModel->saveEditMember($member);

		header("Location: " .$_SERVER['PHP_SELF']);
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

	public function getHiddenBoatId() {
		return $_POST['hiddenBoatId'];
	}


}
