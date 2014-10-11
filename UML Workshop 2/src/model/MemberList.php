<?php

namespace model;

require_once("src/model/Member.php");

class MemberList {

	private $memberList;

	public function __construct() {

		$this->memberList = array();
	}

	public function add(\model\Member $Member) {
		if (!$this->exists($Member)) {
			$this->memberList[] = $Member;
		}
	}

	public function getMemberList() {
		return $this->memberList;
	}	

	public function exists(\model\Member $Member) {
		foreach($this->memberList as $key => $member) {
			if ($member->getUniqueId() == $Member->getUniqueId() && $member->getMemberName() == $Member->getMemberName() && $member->getMemberName == $Member->getMemberSocialNumber) {
				return true;
			}
		}
		return false;
	}



}