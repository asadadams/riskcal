<?php
	require_once('dbConnection.class.php');
	class BIA{
		public $link;
		
		public function __construct(){
			$dbConnection = new dbConnection();
			$this->link = $dbConnection->connect();	
			return $this->link;
		}
		
		public function getAlphaFactor(){
			try {	
				$query = $this->link->query("SELECT alpha FROM bia");
				$row =  $query->rowCount();
				if($row != 0){
					return $query->fetch(PDO::FETCH_ASSOC);
				}else{
					return 0;
				}
			}catch(Exception $ex) {
				return $ex->getMessage();
			}
		}
		
		public function updateAlphaFactor($alpha){
			try {
				$query = $this->link->prepare("UPDATE bia SET `alpha`=:alpha WHERE id='1'");
				$query->bindValue(":alpha", $alpha);
				$query->execute();
				$row = $query->rowcount();
				return $row;
			}catch(Exception $ex) {
				return $ex->getMessage();
			}
		}
	
		
	}	
?>