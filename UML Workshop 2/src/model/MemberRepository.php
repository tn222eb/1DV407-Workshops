<?php

require_once("src/model/Member.php");
require_once("src/model/Repository.php");
require_once("src/model/MemberList.php");


class MemberRepository extends Repository {
	private $name = 'Name';
	private $socialNumber = 'SocialNumber';
	private $uniqueMemberId = 'UniqueMemberId';
	private $db;
	private $memberList;

	public function __construct() {
		$this->dbTable = 'member';
		$this->db = $this->connection();
		$this->memberList = new \model\MemberList();
	}

	public function addMember(\model\Member $member) {
		try {
			$sql = "INSERT INTO $this->dbTable (". $this->name .", ". $this->socialNumber . ", " . $this->uniqueMemberId .") VALUES (?,?,?)";
			$params = array($member->getMemberName(), $member->getMemberSocialNumber(), $member->getUniqueId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function removeMember(\model\Member $member) {
		try {
			$sql = "DELETE FROM $this->dbTable WHERE $this->socialNumber = ?";
			$params = array($member->getMemberSocialNumber());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function saveEditMember(\model\Member $member) {
		try {
			$sql = "UPDATE $this->dbTable SET " . $this->name . " = ? ," . $this->socialNumber . " = ? WHERE $this->uniqueMemberId = ?";
			$params = array($member->getMemberName(), $member->getMemberSocialNumber(), $member->getUniqueId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function getMember($socialNumber) {
		try {
			$sql = "SELECT * FROM $this->dbTable WHERE (". $this->socialNumber .") = ?";
			$params = array($socialNumber);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$result = $query->fetch();

			if ($result) {
				return $member = new \model\Member($result[$this->name], $result[$this->socialNumber], $result[$this->uniqueMemberId]);
			}

			return NULL;
		}
		catch (\Exception $e) {
			echo $e;
		}
	}


	public function GetMemberList() {
		try {
			$sql = "SELECT * FROM $this->dbTable";
			$query = $this->db->prepare($sql);
			$query->execute();
			foreach ($query->fetchAll() as $member) {
				$name = $member['Name'];
				$socialnumber = $member['SocialNumber'];
				$unique = $member['UniqueMemberId'];
				$member = new \model\Member($name, $socialnumber, $unique);
				$this->memberList->add($member);
			}
			return $this->memberList;
		} 
		catch (\Exception $e) {
			echo $e;
		}
	}






}