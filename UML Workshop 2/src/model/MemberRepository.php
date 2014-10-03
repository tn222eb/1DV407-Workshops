<?php

require_once("src/model/Member.php");
require_once("src/model/Repository.php");

class MemberRepository extends Repository {
	private $name = 'name';
	private $socialnumber = 'socialnumber';
	private $uniqueMemberId = 'uniqueMemberId';
	private $db;

	public function __construct() {
		$this->dbTable = 'member';
		$this->db = $this->connection();
	}

	public function add(\model\Member $member) {
		try {
			$sql = "INSERT INTO $this->dbTable (". $this->name .", ". $this->socialnumber . ", " . $this->uniqueMemberId .") VALUES (?,?,?)";
			$params = array($member->getMemberName(), $member->getMemberSocialNumber(), $member->getUniqueId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (PDOException $e) {
			echo $e;
		}
	}
}