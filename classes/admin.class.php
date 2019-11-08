<?php
	require_once('dbConnection.class.php');
	class Admin{
		public $link;
		
		public function __construct(){
			$dbConnection = new dbConnection();
			$this->link = $dbConnection->connect();	
			return $this->link;
		}
		
		//Loging user in 
		public function getUserLogin($username){
			try {
				$query = $this->link->query("SELECT id,password FROM admin WHERE username = '$username'");
				$row = $query->rowCount();
				if($row){
					return $query->fetchAll(PDO::FETCH_ASSOC);
				}else{
					return 0;
				}
			} catch(Exception $ex) {
				return $ex->getMessage();
			}	
		}
		
	}	
?>