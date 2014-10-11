<?php

class BoatRepository {
	private $BoatId = 'BoatId';
	private $BoatLength = 'BoatLength';
	private $BoatType = 'BoatType';
	private $MemberId = "MemberId";
	private $BoatUniqueId = 'BoatUniqueId';


	public function __construct() {
		$this->dbTable = 'Boat';
		$this->db = $this->connection();
	}

	public function addBoat(\model\Boat $boat) {
		try {
			$sql = "INSERT INTO $this->dbTable (". $this->BoatLength .", ". $this->MemberId  . ", " . $this->getBoatUniqueId . ", " . $this->BoatType . " ) VALUES (?,?,?,?)";
			$params = array($boat->getBoatLength(), $boat->getMember(), $boat->getBoatUniqueId(),$boat->getBoatType());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function removeBoat(\model\Boat $boat) {
		try {
			$sql = "DELETE FROM $this->dbTable WHERE $this->BoatUniqueId = ?";
			$params = array($boat->getBoatUniqueId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function saveEditMember(\model\Boat $boat) {
		try {
			$sql = "UPDATE $this->dbTable SET " . $this->BoatLength . " = ? ," . $this->BoatType . " = ? WHERE $this->BoatUniqueId = ?";
			$params = array($boat->getBoatLength(), $boat->getBoatType(), $boat->getBoatUniqueId());
			$query = $this->db->prepare($sql);
			$query->execute($params);
		}
		catch (\Exception $e) {
			echo $e;
		}
	}

	public function getBoat($memberId) {
		try {
			$sql = "SELECT * FROM $this->dbTable WHERE (". $this->MemberId .") = ?";
			$params = array($memberId);
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$result = $query->fetch();

			if ($result) {
				return $boat = new \model\Boat($result[$this->BoatLength], $result[$this->BoatType], $result[$this->getBoatUniqueId]);
			}

			return NULL;
		}
		catch (\Exception $e) {
			echo $e;
		}
	}


	// public function GetMemberList() {
	// 	try {
	// 		$sql = "SELECT * FROM $this->dbTable";
	// 		$query = $this->db->prepare($sql);
	// 		$query->execute();
	// 		foreach ($query->fetchAll() as $member) {
	// 			$name = $member['Name'];
	// 			$socialnumber = $member['SocialNumber'];
	// 			$unique = $member['UniqueMemberId'];
	// 			$member = new \model\Member($name, $socialnumber, $unique);
	// 			$this->memberList->add($member);
	// 		}
	// 		return $this->memberList;
	// 	} 
	// 	catch (\Exception $e) {
	// 		echo $e;
	// 	}
	// }



}