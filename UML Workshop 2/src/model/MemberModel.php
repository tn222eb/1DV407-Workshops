<?php

namespace model;

class MemberModel {

	private $memberRepository;

	public function __construct() {
		$this->memberRepository = new \MemberRepository();
	}

	public function getMember($socialNumber) {
		return $this->memberRepository->getMember($socialNumber);
	}

	public function addMember(\model\Member $member) {	
		$this->memberRepository->addMember($member);
	}

	public function removeMember(\model\Member $member) {
		$this->memberRepository->removeMember($member);
	}

	public function saveEditMember(\model\Member $member) {
		$this->memberRepository->saveEditMember($member);
	}
}