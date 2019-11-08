<?php
	require_once('dbConnection.class.php');
	class BusinessLine{
		public $link;
		
		public function __construct(){
			$dbConnection = new dbConnection();
			$this->link = $dbConnection->connect();	
			return $this->link;
		}
		
		/*Adding a business line*/
		public function addBusinessLine($name){
			try {
				$query = $this->link->prepare("INSERT INTO businessline(name) VALUES(?)");
				$values = array($name);
				$query->execute($values);
				return $this->link->lastInsertId();
			} catch(Exception $ex) {
				return $ex->getMessage();
			}
		}
		
		/*Checking duplicate business line name*/
		public function checkDuplicateBusinessLineName($name){	
			try {	
				$query = $this->link->query("SELECT * FROM businessline WHERE name = '$name'");
				$row =  $query->rowCount();
				if($row == 0){
					return false;
				}else{
					return true;
				}
			}catch(Exception $ex) {
				return $ex->getMessage();
			}
		}
		
		
		/*Getting business line*/
		public function getBusinessLine($business_line_id){	
			try {	
				$query = $this->link->query("SELECT * FROM businessline WHERE id = '$business_line_id'");
				$row = $query->rowCount();
				if($row != 0){
					return $query->fetchAll();
				}else{
					return 0;
				}
			}catch(Exception $ex) {
				return $ex->getMessage();
			}
		}
		
		
		
		/*Getting all businesses */
		public function getBusinesLines(){
			try {	
				$query = $this->link->query("SELECT * FROM businessline");
				$row = $query->rowCount();
				if($row != 0){
					return $query->fetchAll();
				}else{
					return 0;
				}
			}catch(Exception $ex) {
				return $ex->getMessage();
			}
		}
		
		/*Delete business line*/
		public function deleteBusinessLine($id){
			try {	
				$query = $this->link->query("DELETE FROM businessline WHERE `id`='$id'");
			}catch(Exception $ex) {
				return $ex->getMessage();
			}
		}
		
	}	
?>