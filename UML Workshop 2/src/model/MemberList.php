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
}